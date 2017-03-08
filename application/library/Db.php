<?php

class Db {
               
    protected $type = null;
    protected $prefix;
    protected $config = [];
    protected $logs = [];
    protected $debug_mode = false;
    protected $params = [
        PDO::ATTR_CASE => PDO::CASE_NATURAL,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
        PDO::ATTR_STRINGIFY_FETCHES => false,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    /** @var PDO[] 数据库连接ID 支持多个连接 */
    protected $links = [];

    /** @var PDO 当前连接ID */
    protected $linkID;
    protected $linkRead;
    protected $linkWrite;

    /**
     * 初始化
     * @param array $options 参数可选
     * @param type $write 是否连接写数据库
     */
    public function __construct(array $options = [],$write=false) {
        $this->config = \Yaf\Registry::get('config')->db->toArray();
        if (!empty($options)) {
            $this->config = array_merge($this->config, $options);
        }
        $this->initConnect($write); 
    }
    
    /**
     * 初始化数据库连接
     * @access protected
     * @param boolean $write 是否为写
     * @return void
     */
    protected function initConnect($write=false) { 
        if (!empty($this->config['deploy'])) { //开启分布式数据库
            if ($write) { //开启了读写分离
                if (!$this->linkWrite) {
                    $this->linkWrite = $this->writeConnect();
                }
                $this->linkID = $this->linkWrite;
            } else {
                if (!$this->linkRead) {
                    $this->linkRead = $this->readConnect(false);
                }
                $this->linkID = $this->linkRead;
            }
        } elseif (!$this->linkID) { 
            $this->linkID = $this->connect();
        }
    }
    
    private function writeConnect(){ 
        $writeHost = $this->config['write']['dsn']; 
        if(is_null($writeHost)){
            return false;
        }
        $config = $this->parseDsn($writeHost);
        $this->type = $config['type']; 
        return $this->connect($config,'w0');
    }

    /**
     * 连接分布式读数据库
     * @access protected 
     * @return PDO
     */
    protected function readConnect($linkNum=null) { 
        $readHost = $this->config['read']['dsn']; 
        if(is_null($readHost)){
            return false;
        }
        $r = 0; 
        if(is_string($readHost)){
            $config = $this->parseDsn($readHost);
            $this->type = $config['type']; 
        }elseif(is_array($readHost)){
            $r = floor(mt_rand(0, count($readHost) - 1));  
            $config = $this->parseDsn($readHost[$r]); 
            $this->type = $config['type']; 
        }
        return $this->connect($config,'r'.$r); 
    }
                    
    /**
     * dsn解析
     * @param type $dsnStr
     * @return array
     */
    private function parseDsn($dsnStr){ 
        $info = parse_url($dsnStr); 
        if (!$info) {
            return [];
        }  
        $dsn = [
            'type'     => $info['scheme'],
            'user' => isset($info['user']) ? $info['user'] : '',
            'pass' => isset($info['pass']) ? $info['pass'] : '',
            'host' => isset($info['host']) ? $info['host'] : '',
            'port' => isset($info['port']) ? $info['port'] : '',
            'dbname' => !empty($info['path']) ? ltrim($info['path'], '/') : '',
            'charset'  => isset($info['fragment']) ? $info['fragment'] : 'utf8',
        ]; 
        if (isset($info['query'])) {
            parse_str($info['query'], $dsn['params']);
        } else {
            $dsn['params'] = [];
        }
        return $dsn;
    }
                    
    /**
     * 获取数据库的配置参数
     * @access public
     * @param string $config 配置名称
     * @return mixed
     */
    public function getConfig($config = '') {
        return $config ? $this->config[$config] : $this->config;
    }

    /**
     * 设置数据库的配置参数
     * @access public
     * @param string|array      $config 配置名称
     * @param mixed             $value 配置值
     * @return void
     */
    public function setConfig($config, $value = '') {
        if (is_array($config)) {
            $this->config = array_merge($this->config, $config);
        } else {
            $this->config[$config] = $value;
        }
    }

    private function connect(array $options = [], $linkNum = 0, $autoConnection = false) {  
        if (isset($this->links[$linkNum])) { 
            return $this->links[$linkNum];
        }
        if (empty($options)) { 
            $options = $this->parseDsn($this->config['dsn']); 
        }  
        try {
            if (isset($options['prefix']) && $options['prefix']) {
                $this->prefix = $options['prefix'];
            }
            // 连接参数
            if (isset($options['params']) && is_array($options['params'])) {
                $params = $options['params'] + $this->params;
            } else {
                $params = $this->params;
            } 
            if (isset($options['command']) && is_array($options['command'])) {
                $commands = $options['command'];
            } else {
                $commands = [];
            } 
            if (isset($options['port']) && is_int($options['port'] * 1)) {
                $port = $options['port'];
            }
            $is_port = isset($port);
            switch ($this->type) {
                case 'mariadb':
                case 'mysql':
                    $attr = [
                        'driver' => 'mysql',
                        'dbname' => $options['dbname']
                    ];
                    if (isset($options['socket']) && $options['socket']) {
                        $attr['unix_socket'] = $options['socket'];
                    } else {
                        $attr['host'] = $options['host'];
                        if ($is_port) {
                            $attr['port'] = $port;
                        }
                    }
                    // Make MySQL using standard quoted identifier
                    $commands[] = 'SET SQL_MODE=ANSI_QUOTES';
                    break;
                case 'pgsql':
                    $attr = [
                        'driver' => 'pgsql',
                        'host' => $options['host'],
                        'dbname' => $options['dbname']
                    ];
                    if ($is_port) {
                        $attr['port'] = $port;
                    }
                    break;
                case 'sybase':
                    $attr = [
                        'driver' => 'dblib',
                        'host' => $options['host'],
                        'dbname' => $options['dbname']
                    ];
                    if ($is_port) {
                        $attr['port'] = $port;
                    }
                    break;
                case 'oracle':
                    $attr = [
                        'driver' => 'oci',
                        'dbname' => $options['host'] ?
                                '//' . $options['host'] . ($is_port ? ':' . $port : ':1521') . '/' . $options['dbname'] :
                                $options['dbname']
                    ];

                    if (isset($options['charset'])) {
                        $attr['charset'] = $options['charset'];
                    }
                    break;

                case 'mssql':
                    if (strstr(PHP_OS, 'WIN')) {
                        $attr = [
                            'driver' => 'sqlsrv',
                            'server' => $options['host'],
                            'database' => $options['dbname']
                        ];
                    } else {
                        $attr = [
                            'driver' => 'dblib',
                            'host' => $options['host'],
                            'dbname' => $options['dbname']
                        ];
                    }
                    if ($is_port) {
                        $attr['port'] = $port;
                    }

                    // Keep MSSQL QUOTED_IDENTIFIER is ON for standard quoting
                    $commands[] = 'SET QUOTED_IDENTIFIER ON';

                    // Make ANSI_NULLS is ON for NULL value
                    $commands[] = 'SET ANSI_NULLS ON';
                    break;

                case 'sqlite':
                    $this->links[$linkNum] = new PDO('sqlite:' . $options['database_file'], null, null, $params);
                    return $this;
                
            }
            $driver = $attr['driver'];
            unset($attr['driver']);
            $stack = [];
            foreach ($attr as $key => $value) {
                if (is_int($key)) {
                    $stack[] = $value;
                } else {
                    $stack[] = $key . '=' . $value;
                }
            } 
            $dsn = $driver . ':' . implode($stack, ';');  
            if (in_array($this->type, ['mariadb', 'mysql', 'pgsql', 'sybase', 'mssql']) && $options['charset']) {
                $commands[] = "SET NAMES '" . $options['charset'] . "'";
            }
            $this->links[$linkNum] = new PDO($dsn, $options['user'], $options['pass'], $params);
            if($commands){
                foreach ($commands as $value) {
                    $this->links[$linkNum]->exec($value);
                }
            }
        } catch (PDOException $e) {
            if ($autoConnection) {
                return $this->connect($linkNum, $autoConnection);
            } else {
                throw new \Yaf\Exception($e->getMessage());
            }
        } 
        return $this->links[$linkNum];
    }

    private function reconnect() {
        $this->linkID = null;
        $this->linkRead = null;
        $this->linkWrite = null;
        $this->links = [];
    }

    
    
    /**
     * 关闭数据库
     * @access public
     */
    public function close() {
        $this->linkID = null;
    }

    /**
     * 析构方法
     * @access public
     */
    public function __destruct() {
        // 关闭连接
        $this->close();
    }

    /**
     * 获取PDO对象
     * @access public
     * @return \PDO|false
     */
    public function getPdo() {
        if (!$this->linkID) {
            return false;
        } else {
            return $this->linkID;
        }
    }

    public function query($query) {
        $this->initConnect(false);
        if(!$this->linkID){
            return false;
        }
        if ($this->debug_mode) {
            echo $query;

            $this->debug_mode = false;

            return false;
        }

        $this->logs[] = $query;
        return $this->linkID->query($query);
    }

    public function exec($query) {
        $this->initConnect(true);
        if(!$this->linkID){
            return false;
        }
        if ($this->debug_mode) {
            echo $query;

            $this->debug_mode = false;

            return false;
        }

        $this->logs[] = $query;
        return $this->linkID->exec($query);
    }

    public function quote($string) {
        return $this->linkID->quote($string);
    }

    protected function tableQuote($table) {
        return '"' . $this->prefix . $table . '"';
    }

    protected function columnQuote($string) {
        preg_match('/(\(JSON\)\s*|^#)?([a-zA-Z0-9_]*)\.([a-zA-Z0-9_]*)/', $string, $column_match);

        if (isset($column_match[2], $column_match[3])) {
            return '"' . $this->prefix . $column_match[2] . '"."' . $column_match[3] . '"';
        }

        return '"' . $string . '"';
    }

    protected function columnPush(&$columns) {
        if ($columns == '*') {
            return $columns;
        }

        if (is_string($columns)) {
            $columns = [$columns];
        }

        $stack = [];

        foreach ($columns as $key => $value) {
            if (is_array($value)) {
                $stack[] = $this->columnPush($value);
            } else {
                preg_match('/([a-zA-Z0-9_\-\.]*)\s*\(([a-zA-Z0-9_\-]*)\)/i', $value, $match);

                if (isset($match[1], $match[2])) {
                    $stack[] = $this->columnQuote($match[1]) . ' AS ' . $this->columnQuote($match[2]);

                    $columns[$key] = $match[2];
                } else {
                    $stack[] = $this->columnQuote($value);
                }
            }
        }

        return implode($stack, ',');
    }

    protected function arrayQuote($array) {
        $temp = [];

        foreach ($array as $value) {
            $temp[] = is_int($value) ? $value : $this->linkID->quote($value);
        }

        return implode($temp, ',');
    }

    protected function innerConjunct($data, $conjunctor, $outer_conjunctor) {
        $haystack = [];

        foreach ($data as $value) {
            $haystack[] = '(' . $this->dataImplode($value, $conjunctor) . ')';
        }

        return implode($outer_conjunctor . ' ', $haystack);
    }

    protected function fnQuote($column, $string) {
        return (strpos($column, '#') === 0 && preg_match('/^[A-Z0-9\_]*\([^)]*\)$/', $string)) ?
                $string :
                $this->quote($string);
    }

    protected function dataImplode($data, $conjunctor, $outer_conjunctor = null) {
        $wheres = [];

        foreach ($data as $key => $value) {
            $type = gettype($value);

            if (
                    preg_match("/^(AND|OR)(\s+#.*)?$/i", $key, $relation_match) &&
                    $type == 'array'
            ) {
                $wheres[] = 0 !== count(array_diff_key($value, array_keys(array_keys($value)))) ?
                        '(' . $this->dataImplode($value, ' ' . $relation_match[1]) . ')' :
                        '(' . $this->innerConjunct($value, ' ' . $relation_match[1], $conjunctor) . ')';
            } else {
                if (
                        is_int($key) &&
                        preg_match('/([\w\.\-]+)\[(\>|\>\=|\<|\<\=|\!|\=)\]([\w\.\-]+)/i', $value, $match)
                ) {
                    $operator = $match[2];

                    $wheres[] = $this->columnQuote($match[1]) . ' ' . $operator . ' ' . $this->columnQuote($match[3]);
                } else {
                    preg_match('/(#?)([\w\.\-]+)(\[(\>|\>\=|\<|\<\=|\!|\<\>|\>\<|\!?~)\])?/i', $key, $match);
                    $column = $this->columnQuote($match[2]);

                    if (isset($match[4])) {
                        $operator = $match[4];

                        if ($operator == '!') {
                            switch ($type) {
                                case 'NULL':
                                    $wheres[] = $column . ' IS NOT NULL';
                                    break;

                                case 'array':
                                    $wheres[] = $column . ' NOT IN (' . $this->arrayQuote($value) . ')';
                                    break;

                                case 'integer':
                                case 'double':
                                    $wheres[] = $column . ' != ' . $value;
                                    break;

                                case 'boolean':
                                    $wheres[] = $column . ' != ' . ($value ? '1' : '0');
                                    break;

                                case 'string':
                                    $wheres[] = $column . ' != ' . $this->fnQuote($key, $value);
                                    break;
                            }
                        }

                        if ($operator == '<>' || $operator == '><') {
                            if ($type == 'array') {
                                if ($operator == '><') {
                                    $column .= ' NOT';
                                }

                                if (is_numeric($value[0]) && is_numeric($value[1])) {
                                    $wheres[] = '(' . $column . ' BETWEEN ' . $value[0] . ' AND ' . $value[1] . ')';
                                } else {
                                    $wheres[] = '(' . $column . ' BETWEEN ' . $this->quote($value[0]) . ' AND ' . $this->quote($value[1]) . ')';
                                }
                            }
                        }

                        if ($operator == '~' || $operator == '!~') {
                            if ($type != 'array') {
                                $value = [$value];
                            }

                            $connector = ' OR ';
                            $stack = array_values($value);

                            if (is_array($stack[0])) {
                                if (isset($value['AND']) || isset($value['OR'])) {
                                    $connector = ' ' . array_keys($value)[0] . ' ';
                                    $value = $stack[0];
                                }
                            }

                            $like_clauses = [];

                            foreach ($value as $item) {
                                $item = strval($item);

                                if (!preg_match('/(\[.+\]|_|%.+|.+%)/', $item)) {
                                    $item = '%' . $item . '%';
                                }

                                $like_clauses[] = $column . ($operator === '!~' ? ' NOT' : '') . ' LIKE ' . $this->fnQuote($key, $item);
                            }

                            $wheres[] = '(' . implode($connector, $like_clauses) . ')';
                        }

                        if (in_array($operator, ['>', '>=', '<', '<='])) {
                            $condition = $column . ' ' . $operator . ' ';

                            if (is_numeric($value)) {
                                $condition .= $value;
                            } elseif (strpos($key, '#') === 0) {
                                $condition .= $this->fnQuote($key, $value);
                            } else {
                                $condition .= $this->quote($value);
                            }

                            $wheres[] = $condition;
                        }
                    } else {
                        switch ($type) {
                            case 'NULL':
                                $wheres[] = $column . ' IS NULL';
                                break;

                            case 'array':
                                $wheres[] = $column . ' IN (' . $this->arrayQuote($value) . ')';
                                break;

                            case 'integer':
                            case 'double':
                                $wheres[] = $column . ' = ' . $value;
                                break;

                            case 'boolean':
                                $wheres[] = $column . ' = ' . ($value ? '1' : '0');
                                break;

                            case 'string':
                                $wheres[] = $column . ' = ' . $this->fnQuote($key, $value);
                                break;
                        }
                    }
                }
            }
        }

        return implode($conjunctor . ' ', $wheres);
    }

    protected function whereClause($where) {
        $where_clause = '';

        if (is_array($where)) {
            $where_keys = array_keys($where);
            $where_AND = preg_grep("/^AND\s*#?$/i", $where_keys);
            $where_OR = preg_grep("/^OR\s*#?$/i", $where_keys);

            $single_condition = array_diff_key($where, array_flip(
                            ['AND', 'OR', 'GROUP', 'ORDER', 'HAVING', 'LIMIT', 'LIKE', 'MATCH']
            ));

            if ($single_condition != []) {
                $condition = $this->dataImplode($single_condition, ' AND');

                if ($condition != '') {
                    $where_clause = ' WHERE ' . $condition;
                }
            }

            if (!empty($where_AND)) {
                $value = array_values($where_AND);
                $where_clause = ' WHERE ' . $this->dataImplode($where[$value[0]], ' AND');
            }

            if (!empty($where_OR)) {
                $value = array_values($where_OR);
                $where_clause = ' WHERE ' . $this->dataImplode($where[$value[0]], ' OR');
            }

            if (isset($where['MATCH'])) {
                $MATCH = $where['MATCH'];

                if (is_array($MATCH) && isset($MATCH['columns'], $MATCH['keyword'])) {
                    $columns = str_replace('.', '"."', implode($MATCH['columns'], '", "'));
                    $keywords = $this->quote($MATCH['keyword']);

                    $where_clause .= ($where_clause != '' ? ' AND ' : ' WHERE ') . ' MATCH ("' . $columns . '") AGAINST (' . $keywords . ')';
                }
            }

            if (isset($where['GROUP'])) {
                $where_clause .= ' GROUP BY ' . $this->columnQuote($where['GROUP']);

                if (isset($where['HAVING'])) {
                    $where_clause .= ' HAVING ' . $this->dataImplode($where['HAVING'], ' AND');
                }
            }

            if (isset($where['ORDER'])) {
                $ORDER = $where['ORDER'];

                if (is_array($ORDER)) {
                    $stack = [];

                    foreach ($ORDER as $column => $value) {
                        if (is_array($value)) {
                            $stack[] = 'FIELD(' . $this->columnQuote($column) . ', ' . $this->arrayQuote($value) . ')';
                        } else if ($value === 'ASC' || $value === 'DESC') {
                            $stack[] = $this->columnQuote($column) . ' ' . $value;
                        } else if (is_int($column)) {
                            $stack[] = $this->columnQuote($value);
                        }
                    }

                    $where_clause .= ' ORDER BY ' . implode($stack, ',');
                } else {
                    $where_clause .= ' ORDER BY ' . $this->columnQuote($ORDER);
                }
            }

            if (isset($where['LIMIT'])) {
                $LIMIT = $where['LIMIT'];

                if (is_numeric($LIMIT)) {
                    $where_clause .= ' LIMIT ' . $LIMIT;
                }

                if (
                        is_array($LIMIT) &&
                        is_numeric($LIMIT[0]) &&
                        is_numeric($LIMIT[1])
                ) {
                    if ($this->type === 'pgsql') {
                        $where_clause .= ' OFFSET ' . $LIMIT[0] . ' LIMIT ' . $LIMIT[1];
                    } else {
                        $where_clause .= ' LIMIT ' . $LIMIT[0] . ',' . $LIMIT[1];
                    }
                }
            }
        } else {
            if ($where != null) {
                $where_clause .= ' ' . $where;
            }
        }

        return $where_clause;
    }

    protected function selectContext($table, $join, &$columns = null, $where = null, $column_fn = null) {
        preg_match('/([a-zA-Z0-9_\-]*)\s*\(([a-zA-Z0-9_\-]*)\)/i', $table, $table_match);

        if (isset($table_match[1], $table_match[2])) {
            $table = $this->tableQuote($table_match[1]);

            $table_query = $table . ' AS ' . $this->tableQuote($table_match[2]);
        } else {
            $table = $this->tableQuote($table);

            $table_query = $table;
        }

        $join_key = is_array($join) ? array_keys($join) : null;

        if (
                isset($join_key[0]) &&
                strpos($join_key[0], '[') === 0
        ) {
            $table_join = [];

            $join_array = [
                '>' => 'LEFT',
                '<' => 'RIGHT',
                '<>' => 'FULL',
                '><' => 'INNER'
            ];

            foreach ($join as $sub_table => $relation) {
                preg_match('/(\[(\<|\>|\>\<|\<\>)\])?([a-zA-Z0-9_\-]*)\s?(\(([a-zA-Z0-9_\-]*)\))?/', $sub_table, $match);

                if ($match[2] != '' && $match[3] != '') {
                    if (is_string($relation)) {
                        $relation = 'USING ("' . $relation . '")';
                    }

                    if (is_array($relation)) {
                        // For ['column1', 'column2']
                        if (isset($relation[0])) {
                            $relation = 'USING ("' . implode($relation, '", "') . '")';
                        } else {
                            $joins = [];

                            foreach ($relation as $key => $value) {
                                $joins[] = (
                                        strpos($key, '.') > 0 ?
                                                // For ['tableB.column' => 'column']
                                                $this->columnQuote($key) :
                                                // For ['column1' => 'column2']
                                                $table . '."' . $key . '"'
                                        ) .
                                        ' = ' .
                                        $this->tableQuote(isset($match[5]) ? $match[5] : $match[3]) . '."' . $value . '"';
                            }

                            $relation = 'ON ' . implode($joins, ' AND ');
                        }
                    }

                    $table_name = $this->tableQuote($match[3]) . ' ';

                    if (isset($match[5])) {
                        $table_name .= 'AS ' . $this->tableQuote($match[5]) . ' ';
                    }

                    $table_join[] = $join_array[$match[2]] . ' JOIN ' . $table_name . $relation;
                }
            }

            $table_query .= ' ' . implode($table_join, ' ');
        } else {
            if (is_null($columns)) {
                if (is_null($where)) {
                    if (
                            is_array($join) &&
                            isset($column_fn)
                    ) {
                        $where = $join;
                        $columns = null;
                    } else {
                        $where = null;
                        $columns = $join;
                    }
                } else {
                    $where = $join;
                    $columns = null;
                }
            } else {
                $where = $columns;
                $columns = $join;
            }
        }

        if (isset($column_fn)) {
            if ($column_fn == 1) {
                $column = '1';

                if (is_null($where)) {
                    $where = $columns;
                }
            } else {
                if (empty($columns)) {
                    $columns = '*';
                    $where = $join;
                }

                $column = $column_fn . '(' . $this->columnPush($columns) . ')';
            }
        } else {
            $column = $this->columnPush($columns);
        }

        return 'SELECT ' . $column . ' FROM ' . $table_query . $this->whereClause($where);
    }

    protected function dataMap($index, $key, $value, $data, &$stack) {
        if (is_array($value)) {
            $sub_stack = [];

            foreach ($value as $sub_key => $sub_value) {
                if (is_array($sub_value)) {
                    $current_stack = $stack[$index][$key];

                    $this->dataMap(false, $sub_key, $sub_value, $data, $current_stack);

                    $stack[$index][$key][$sub_key] = $current_stack[0][$sub_key];
                } else {
                    $this->dataMap(false, preg_replace('/^[\w]*\./i', "", $sub_value), $sub_key, $data, $sub_stack);

                    $stack[$index][$key] = $sub_stack;
                }
            }
        } else {
            if ($index !== false) {
                $stack[$index][$value] = $data[$value];
            } else {
                if (preg_match('/[a-zA-Z0-9_\-\.]*\s*\(([a-zA-Z0-9_\-]*)\)/i', $key, $key_match)) {
                    $key = $key_match[1];
                }

                $stack[$key] = $data[$key];
            }
        }
    }

    public function select($table, $join, $columns = null, $where = null) {
        $column = $where == null ? $join : $columns;

        $is_single_column = (is_string($column) && $column !== '*');

        $query = $this->query($this->selectContext($table, $join, $columns, $where));

        $stack = [];

        $index = 0;

        if (!$query) {
            return false;
        }

        if ($columns === '*') {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        if ($is_single_column) {
            return $query->fetchAll(PDO::FETCH_COLUMN);
        }

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            foreach ($columns as $key => $value) {
                if (!is_array($value)) {
                    $value = preg_replace('/^[\w]*\./i', "", $value);
                }

                $this->dataMap($index, $key, $value, $row, $stack);
            }

            $index++;
        }

        return $stack;
    }

    public function insert($table, $datas) {
        $this->initConnect(true);
        if(!$this->linkID){
            return false;
        }
        
        $stack = [];
        $columns = [];
        $fields = [];

        // Check indexed or associative array
        if (!isset($datas[0])) {
            $datas = [$datas];
        }

        foreach ($datas as $data) {
            foreach ($data as $key => $value) {
                $columns[] = $key;
            }
        }

        $columns = array_unique($columns);

        foreach ($datas as $data) {
            $values = [];

            foreach ($columns as $key) {
                if (!isset($data[$key])) {
                    $values[] = 'NULL';
                } else {
                    $value = $data[$key];

                    switch (gettype($value)) {
                        case 'NULL':
                            $values[] = 'NULL';
                            break;

                        case 'array':
                            preg_match("/\(JSON\)\s*([\w]+)/i", $key, $column_match);

                            $values[] = isset($column_match[0]) ?
                                    $this->quote(json_encode($value)) :
                                    $this->quote(serialize($value));
                            break;

                        case 'boolean':
                            $values[] = ($value ? '1' : '0');
                            break;

                        case 'integer':
                        case 'double':
                        case 'string':
                            $values[] = $this->fnQuote($key, $value);
                            break;
                    }
                }
            }

            $stack[] = '(' . implode($values, ', ') . ')';
        }

        foreach ($columns as $key) {
            $fields[] = $this->columnQuote(preg_replace("/^(\(JSON\)\s*|#)/i", "", $key));
        }

        return $this->exec('INSERT INTO ' . $this->tableQuote($table) . ' (' . implode(', ', $fields) . ') VALUES ' . implode(', ', $stack));
    }

    public function update($table, $data, $where = null) {
        $fields = [];

        foreach ($data as $key => $value) {
            preg_match('/([\w]+)(\[(\+|\-|\*|\/)\])?/i', $key, $match);

            if (isset($match[3])) {
                if (is_numeric($value)) {
                    $fields[] = $this->columnQuote($match[1]) . ' = ' . $this->columnQuote($match[1]) . ' ' . $match[3] . ' ' . $value;
                }
            } else {
                $column = $this->columnQuote(preg_replace("/^(\(JSON\)\s*|#)/i", "", $key));

                switch (gettype($value)) {
                    case 'NULL':
                        $fields[] = $column . ' = NULL';
                        break;

                    case 'array':
                        preg_match("/\(JSON\)\s*([\w]+)/i", $key, $column_match);

                        $fields[] = $column . ' = ' . $this->quote(
                                        isset($column_match[0]) ? json_encode($value) : serialize($value)
                        );
                        break;

                    case 'boolean':
                        $fields[] = $column . ' = ' . ($value ? '1' : '0');
                        break;

                    case 'integer':
                    case 'double':
                    case 'string':
                        $fields[] = $column . ' = ' . $this->fnQuote($key, $value);
                        break;
                }
            }
        }

        return $this->exec('UPDATE ' . $this->tableQuote($table) . ' SET ' . implode(', ', $fields) . $this->whereClause($where));
    }

    public function delete($table, $where) {
        return $this->exec('DELETE FROM ' . $this->tableQuote($table) . $this->whereClause($where));
    }

    public function replace($table, $columns, $search = null, $replace = null, $where = null) {
        if (is_array($columns)) {
            $replace_query = [];

            foreach ($columns as $column => $replacements) {
                foreach ($replacements as $replace_search => $replace_replacement) {
                    $replace_query[] = $column . ' = REPLACE(' . $this->columnQuote($column) . ', ' . $this->quote($replace_search) . ', ' . $this->quote($replace_replacement) . ')';
                }
            }

            $replace_query = implode(', ', $replace_query);
            $where = $search;
        } else {
            if (is_array($search)) {
                $replace_query = [];

                foreach ($search as $replace_search => $replace_replacement) {
                    $replace_query[] = $columns . ' = REPLACE(' . $this->columnQuote($columns) . ', ' . $this->quote($replace_search) . ', ' . $this->quote($replace_replacement) . ')';
                }

                $replace_query = implode(', ', $replace_query);
                $where = $replace;
            } else {
                $replace_query = $columns . ' = REPLACE(' . $this->columnQuote($columns) . ', ' . $this->quote($search) . ', ' . $this->quote($replace) . ')';
            }
        }

        return $this->exec('UPDATE ' . $this->tableQuote($table) . ' SET ' . $replace_query . $this->whereClause($where));
    }

    public function get($table, $join = null, $columns = null, $where = null) {
        $column = $where == null ? $join : $columns;

        $is_single_column = (is_string($column) && $column !== '*');

        $query = $this->query($this->selectContext($table, $join, $columns, $where) . ' LIMIT 1');

        if ($query) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);

            if (isset($data[0])) {
                if ($is_single_column) {
                    return $data[0][preg_replace('/^[\w]*\./i', "", $column)];
                }

                if ($column === '*') {
                    return $data[0];
                }

                $stack = [];

                foreach ($columns as $key => $value) {
                    if (!is_array($value)) {
                        $value = preg_replace('/^[\w]*\./i', "", $value);
                    }

                    $this->dataMap(0, $key, $value, $data[0], $stack);
                }

                return $stack[0];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function has($table, $join, $where = null) {
        $column = null;

        $query = $this->query('SELECT EXISTS(' . $this->selectContext($table, $join, $column, $where, 1) . ')');

        if ($query) {
            return $query->fetchColumn() === '1';
        } else {
            return false;
        }
    }

    public function count($table, $join = null, $column = null, $where = null) {
        $query = $this->query($this->selectContext($table, $join, $column, $where, 'COUNT'));

        return $query ? 0 + $query->fetchColumn() : false;
    }

    public function max($table, $join, $column = null, $where = null) {
        $query = $this->query($this->selectContext($table, $join, $column, $where, 'MAX'));

        if ($query) {
            $max = $query->fetchColumn();

            return is_numeric($max) ? $max + 0 : $max;
        } else {
            return false;
        }
    }

    public function min($table, $join, $column = null, $where = null) {
        $query = $this->query($this->selectContext($table, $join, $column, $where, 'MIN'));

        if ($query) {
            $min = $query->fetchColumn();

            return is_numeric($min) ? $min + 0 : $min;
        } else {
            return false;
        }
    }

    public function avg($table, $join, $column = null, $where = null) {
        $query = $this->query($this->selectContext($table, $join, $column, $where, 'AVG'));

        return $query ? 0 + $query->fetchColumn() : false;
    }

    public function sum($table, $join, $column = null, $where = null) {
        $query = $this->query($this->selectContext($table, $join, $column, $where, 'SUM'));

        return $query ? 0 + $query->fetchColumn() : false;
    }

    public function action($actions) {
        if (is_callable($actions)) {
            $this->linkID->beginTransaction();

            $result = $actions($this);

            if ($result === false) {
                $this->linkID->rollBack();
            } else {
                $this->linkID->commit();
            }
        } else {
            return false;
        }
    }

    public function id() {
        if ($this->type == 'oracle') {
            return 0;
        } elseif ($this->type == 'mssql') {
            return $this->linkID->query('SELECT SCOPE_IDENTITY()')->fetchColumn();
        }

        return $this->linkID->lastInsertId();
    }

    public function debug() {
        $this->debug_mode = true;

        return $this;
    }

    public function error() {
        return $this->linkID->errorInfo();
    }

    public function last() {
        return end($this->logs);
    }

    public function log() {
        return $this->logs;
    }

    public function info() {
        $output = [
            'server' => 'SERVER_INFO',
            'driver' => 'DRIVER_NAME',
            'client' => 'CLIENT_VERSION',
            'version' => 'SERVER_VERSION',
            'connection' => 'CONNECTION_STATUS'
        ];

        foreach ($output as $key => $value) {
            $output[$key] = @$this->linkID->getAttribute(constant('PDO::ATTR_' . $value));
        }

        return $output;
    }

}

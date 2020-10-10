(function(){
    var xz = window.xz = window.xz || {};
    
    xz.api = {
        'getCode':'/index/ajax/getCode',   
        'getArticleNum':'/index/ajax/getArticleNum',  
        'countArticleView':'/index/tongji/countArticleView',
        'good':'/index/ajax/good',
        'fav':'/member/ajax/fav',
        'feedback':'/index/ajax/feedback',
        'link':'/index/ajax/link',
        'wxcode':'/index/ajax/wxcode',
        'adv':'/index/ajax/adv',
        'reg':'/index/ajax/reg',
        'login':'/index/ajax/login',
        'logout':'/index/ajax/logout',
        'reset':'/index/ajax/reset',
        'follow':'/member/ajax/follow',
        'upload':'/index/ajax/upload',
        'assetslog':'/member/assets/logs',
        'getUserData':'/member/ajax/getUserData'
    };

    xz.ajaxGet = function(api,callback){
    	$.ajax({
            type:"POST",
            url:api,
            dataType:"json",
            success:function(json){
            	callback && callback(json);
            }
        });
    } 
    xz.ajaxPost = function(api,data,callback,err){
    	$.ajax({
            type:"POST",
            url:api,
            data: data,
            dataType:"json",
            success:function(json){
            	callback && callback(json);
            },
            complete:function(json){
                err && err(json);
            }
        });
    },
    xz.listenTimer = function(el,callback){
        var listen = {
            _timer: false,
            start: function () {
                if (listen._timer) clearTimeout(listen._timer);
                listen._timer = setTimeout(function () {
                    if (el.seconds) {
                        el.seconds -= 1;
                        listen.start();
                    }else {
                        callback && callback();
                    }
                }, 1000);
            }
        };
        listen.start();
    }

    //广告加载
    xz.adv = function(id, key){
        xz.ajaxGet(xz.api.adv+'?key='+key,function(json){
             $(id).html(json.data);
        });
    };
 

    //上传
    xz.upload = function(id){
        layui.use('upload', function(){
              var upload = layui.upload;
              var uploadInst = upload.render({
                elem: "#uploadbtn" //绑定元素
                ,field:"picture"
                ,url: xz.api.upload //上传接口
                ,done: function(res){
                   if(res.status==0){
                        $(id).val(res.data.key);
                        $("#uploadbtn").attr('src',res.data.src);
                   }else{
                        layer.msg(res.info);
                   }
                }
                ,error: function(){
                  //请求异常回调
                }
              });
        });
    };

    xz.success = function(msg,callback){
        layui.use('layer', function(){
            var layer = layui.layer;
            layer.msg((msg || "操作成功"), {
                icon: 6,
                time:2000
            },callback);
        }); 
    };

    xz.error = function(msg,callback){
        layui.use('layer', function(){
            var layer = layui.layer;
            layer.msg(msg,{
                time:1000
            },callback);
        }); 
    };

    //保存更新
    xz.save = function(id){
        var layer;
        layui.use('layer', function(){
              layer = layui.layer;
        });            
        $(id).click(function() {
            var flag = 1;
            var obj = this;
            var text = $(obj).attr('data-txt');
            var url = $("#form").attr('action');
            var inputs = $("input[required='true'],input[required='required']");
            $.each(inputs, function(k, v) {
                var txt = $(this).attr('placeholder');
                txt = txt ? txt : '必填项';
                if (!$.trim($(this).val())) {
                    layer.msg('请填写' + txt);
                    flag = 0;
                    return false;
                }
            });
            if (!flag) {
                return false;
            }
            if (url.length == 0) {
                 layer.msg('没有指定添加操作处理url');
                 return false;
            }
            $.ajax({
                url:url,
                type:'post',
                data:$("#form").serialize(),
                dataType:'json',
                beforeSend:function () {
                    layer.load(1,{
                        shade: [0.5,'#fff']
                    });
                },
                success:function (json) {
                    layer.closeAll('loading');
                    if (json.status === 0) {
                        layer.msg('操作成功', {
                            icon: 6,
                            time:2000
                        },function(){
                            window.location.reload();
                        });
                    } else {
                        layer.msg(json.info);
                        xz.unDisable(obj, text);
                    }
                },
                error:function () {
                    layer.closeAll('loading');
                    layer.msg('系统请求出现错误');
                }
            })
        });
    };

    xz.unDisable = function(obj, text) {
        text = text ? text : '更新';
        $(obj).removeClass('disabled');
        $(obj).removeAttr('disable');
        $(obj).text(text);
    };

})();

 

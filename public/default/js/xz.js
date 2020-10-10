(function(){
    var xz = window.xz = window.xz || {};
    
    xz.api = {
        'getCode':'/index/ajax/getCode',   
        'getArticleNum':'/index/ajax/getArticleNum',  
        'countArticleView':'/index/tongji/countArticleView',
        'good':'/index/ajax/good',
        'fav':'/index/ajax/fav',
        'feedback':'/index/ajax/feedback',
        'link':'/index/ajax/link',
        'wxcode':'/index/ajax/wxcode'
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
    xz.ajaxPost = function(api,data,callback){
    	$.ajax({
            type:"POST",
            url:api,
            data: data,
            dataType:"json",
            success:function(json){
            	callback && callback(json);
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
})();

 

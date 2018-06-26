$(function() {
    $(".delete_product").click(function(evt) {
        var id = $(this).data('id');
        var url = $('#delete-product-form').attr('action') + '/' + id;
        $('#delete-product-form').attr('action', url);
        $('#delete-product-form').submit();
    });

    // 删除商品类型
    $(".delete-type").click(function(event) {
        var id = $(this).data("id");
        var parentTag = $(this).parent().parent();
        var reg = /^\d+$/;
        if (reg.test(id)) {
            var url = $('#delete-type-url').data('url') + '/' + id;
            var token = $('#delete-type-url').data('token');
            layer.confirm('确定删除该商品类型吗？', {
                btn: ['确认','取消'] //按钮
            }, function(){
                $.post( url, {'_token': token, '_method':'delete'}, function(data) {
                    if (data.code==1) {
                        parentTag.remove();
                        layer.msg(data.msg, {time: 1000, icon: 6});
                    } else {
                        layer.msg(data.msg, {time: 1000, icon: 5});
                    }
                });
            }, function(){
                // 点击取消
            });
        }
    });

    // 删除属性
    $(".delete-type-attribute").click(function(event) {
        var id = $(this).data("id");
        var parentTag = $(this).parent().parent();
        var reg = /^\d+$/;
        if (reg.test(id)) {
            var url = $('#delete-attribute-url').data('url') + '/' + id;
            var token = $('#delete-attribute-url').data('token');
            layer.confirm('确定删除该属性吗？', {
                btn: ['确认','取消'] //按钮
            }, function(){
                $.post( url, {'_token': token, '_method':'delete'}, function(data) {
                    if (data.code == 200) {
                        parentTag.remove();
                        layer.msg(data.msg, {time: 1000, icon: 6});
                    } else {
                        layer.msg(data.msg, {time: 1000, icon: 5});
                    }
                });
            }, function(){
                // 点击取消
            });
        }
    });

    // 删除商品
    $(".delete_product").click(function(evt) {
        var id = $(this).data('id');
        var url = $('#delete-product-form').attr('action') + '/' + id;
        $('#delete-product-form').attr('action', url);
        $('#delete-product-form').submit();
    });

});


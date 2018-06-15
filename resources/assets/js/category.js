$(function() {
    // AJAX 删除分类
    $('.delete_category').click(function(){
        var cat_id = $(this).data('id');
        var del_cat_url = $(this).data('url') +'/'+ cat_id;
        layer.confirm('您确定要删除该分类吗？', {
            btn: ['确定', '取消']
        }, function() {
            $.post( del_cat_url, {'_method': 'delete'}, function(data) {
                if (data.status == 1) {
                    layer.msg(data.msg, {icon: 6});
                } else {
                    layer.msg(data.msg, {icon: 5});
                }
            })
        }, function() {
        });
    });

});


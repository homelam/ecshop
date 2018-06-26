$(function() {
    // 删除对应的记录
    $('.delete_brand').click(function(){
        var id = $(this).data('id');

        var url = $('#delete_brand_form').attr('action') + '/' + id;
        $('#delete_brand_form').attr('action', url);

        $('#delete_brand_form').submit();
    });
});


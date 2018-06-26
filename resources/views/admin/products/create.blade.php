@extends('layouts.admin')

@section('main')
    <div class="page-container">

        @if (session()->has('status'))
            <div class="Huialert Huialert-info"><i class="Hui-iconfont">&#xe6a6;</i>{{ session('status') }}</div>
        @endif

        <form action='{{ route("products.store") }}' method="post" class="form form-horizontal" id="form-product-create">
            {{ csrf_field() }}
            <div id="tab-product" class="HuiTab">
                <div class="tabBar cl">
                    <span>通用信息</span>
                    <span>详细描述</span>
                    <span>其他信息</span>
                    <span>商品属性</span>
                    <span>商品相册</span>
                </div>
                <!-- 通用信息 -->
                <div class="tabCon">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">
                            <span class="c-red">*</span>商品名称：</label>
                        <div class="formControls col-xs-8 col-sm-6">
                            <input type="text" name="goods_name" id="goods_name" class="input-text" aria-required="true" aria-invalid="true">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">商品货号：</label>
                        <div class="formControls col-xs-8 col-sm-6">
                            <input type="text" id="goods_sn" class="input-text" name="goods_sn">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">
                            <span class="c-red">*</span>商品分类：</label>
                        <div class="formControls col-xs-6 col-sm-6">
                            <span class="select-box">
                                <select name="cat_id" class="select">
                                    <option value="0">请选择...</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->cat_id }}">{!! $category->_cat_name !!}</option>
                                    @endforeach
                                </select>
                            </span>
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">
                            <span class="c-red">*</span>商品品牌：</label>
                        <div class="formControls col-xs-6 col-sm-6">
                            <span class="select-box">
                                {!! buildSelect('brands', 'brand_id', 'brand_id', 'brand_name', 'brand-list') !!}
                            </span>
                        </div>
                    </div>
                    <div class="row cl {{ $errors->has('original_img') ? 'has-error' : '' }}">
                        <label class="form-label col-xs-4 col-sm-2">商品图片：</label>
                        <div class="formControls col-xs-6 col-sm-6">
                            <span class="btn-upload form-group">
                                <input type="hidden" name="original_img">
                                <input type="file" class="input-file" id="file_upload" multiple="true">
                                <a style="position: relative; top: 8px;" href="javascript:$('#file_upload').uploadifive('upload')">Upload Files</a>
                                <link rel="stylesheet" type="text/css" href="{{ asset('uploadifive/uploadifive.css') }}">
                            </span>
                        </div>
                    </div>
                    <div class="row cl" style="display: none;">
                        <label class="form-label col-xs-4 col-sm-2"></label>
                        <div class="formControls col-xs-6 col-sm-6">
                            <img src="" id="goods_img" class="thumbnail" style="width:150px;height:auto">
                        </div>
                    </div>

                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">
                            <span class="c-red">*</span>本店售价：</label>
                        <div class="formControls col-xs-8 col-sm-3">
                            <input type="text" id="shop_price" name="shop_price" class="input-text">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">
                            <span class="c-red">*</span>市场售价：</label>
                        <div class="formControls col-xs-8 col-sm-3">
                            <input type="text" id="market_price" name="market_price" class="input-text">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">
                            <span class="c-red">*</span>虚拟销量：</label>
                        <div class="formControls col-xs-8 col-sm-3">
                            <input type="text" id="virtual_sales" name="virtual_sales" class="input-text">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">赠送消费积分数：</label>
                        <div class="formControls col-xs-8 col-sm-3">
                            <input type="text" id="give_integral"   name="give_integral" value="-1" class="input-text">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">赠送等级积分数：</label>
                        <div class="formControls col-xs-8 col-sm-3">
                            <input type="text" id="rank_integral"  name="rank_integral" value="-1" class="input-text">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">积分购买金额：</label>
                        <div class="formControls col-xs-8 col-sm-3">
                            <input type="text" id="integral" name="integral" class="input-text">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">促销价格：</label>
                        <div class="formControls col-xs-8 col-sm-3">
                            <input type="text" id="promote_price" name="promote_price" class="input-text">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">促销开始时间：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" onfocus="WdatePicker({ dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" name="promote_start_date" class="input-text Wdate" style="width:180px;">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">促销结束时间：</label>
                        <div class="formControls col-xs-8 col-sm-9">
                            <input type="text" onfocus="WdatePicker({ dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'datemin\')}' })" id="datemax" name="promote_end_date" class="input-text Wdate" style="width:180px;">
                        </div>
                    </div>
                </div>
                <!-- 详细描述 -->
                <div class="tabCon">
                    <div class="row cl">
                        <div class="formControls col-xs-12 col-sm-14">
                            <script id="editor" type="text/plain" name="description" style="width:100%;height:400px;"></script>
                        </div>
                    </div>
                </div>
                <!-- 其他信息 -->
                <div class="tabCon">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">
                            <span class="c-red">*</span>商品重量：</label>
                        <div class="formControls col-xs-8 col-sm-3">
                            <input type="text" name="goods_weight" id="goods_weight" class="input-text">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">商品库存数量：</label>
                        <div class="formControls col-xs-8 col-sm-3">
                            <input type="text" name="goods_qty" id="goods_qty" class="input-text">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">低库存警告数量：</label>
                        <div class="formControls col-xs-8 col-sm-3">
                            <input type="text" name="warn_number" id="warn_number" value="1" class="input-text">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">显示排序：</label>
                        <div class="formControls col-xs-8 col-sm-3">
                            <input type="text" name="sort_order" id="goods-sort-order" value="50" class="input-text">
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">加入推荐：</label>
                        <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                            <div class="check-box">
                                <input type="checkbox" id="checkbox-1" value="1" name="is_best" checked>
                                <label for="checkbox-1">精品</label>
                            </div>
                            <div class="check-box">
                                <input type="checkbox" id="checkbox-2" value="1" name="is_hot" checked>
                                <label for="checkbox-2">热销</label>
                            </div>
                            <div class="check-box">
                                <input type="checkbox" id="checkbox-3" value="1" name="is_new" checked>
                                <label for="checkbox-3">新品</label>
                            </div>
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">是否上架：</label>
                        <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                            <div class="check-box">
                                <input type="checkbox" id="checkbox-4" value="1" name="is_on_sale" checked>
                                <label for="checkbox-4">打勾表示允许销售，否则不允许销售。</label>
                            </div>
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">是否为免运费商品：</label>
                        <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                            <div class="check-box">
                                <input type="checkbox" id="checkbox-5" value="1" name="is_shipping">
                                <label for="checkbox-5">打勾表示此商品不会产生运费花销，否则按照正常运费计算。</label>
                            </div>
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">商品简短描述：</label>
                        <div class="formControls col-xs-4 col-sm-6">
                            <script id="short-desc-editor" name="short_desc" type="text/plain" style="width:100%;height:200px;"></script>
                        </div>
                    </div>
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">商家寄语：</label>
                        <div class="formControls col-xs-8 col-sm-6">
                            <input type="text" name="seller_note" id="seller_note" class="input-text">
                        </div>
                    </div>
                </div>
                <!-- 商品属性 -->
                <div class="tabCon">
                    <div class="row cl">
                        <label class="form-label col-xs-4 col-sm-2">商品类型：</label>
                        <div class="formControls col-xs-6 col-sm-6">
                            <span class="select-box">
                                {!! buildSelect('goods_type', 'type_id', 'type_id', 'type_name', 'get-attr-list') !!}
                            </span>
                        </div>
                    </div>
                    <div id="attr_list"></div>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                    <button class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 确定</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
<!-- 百度编辑器 -->
<script type="text/javascript" src="{{ asset('admin/lib/ueditor/1.4.3/ueditor.config.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/lib/ueditor/1.4.3/ueditor.all.min.js') }}"> </script>
<script type="text/javascript" src="{{ asset('admin/lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js') }}"></script>
<script src="{{ asset('uploadifive/jquery.uploadifive.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/product.js') }}"></script>
<script>
$(function(){
	$("#tab-product").Huitab({
		index:0
    });
    var ue = UE.getEditor('editor');
    var ueshortdesc = UE.getEditor('short-desc-editor');
});
</script>

<script>
    $("select[name='type_id']").change(function() {
        var type_id = $(this).val(); // 获取选中的值
        // 如果选中的一个类型就执行AJAX去属性
        if (type_id >0) {
            var url = "{{ url('admin/attributes') }}/" + type_id;
            $.get( url, function(data) {
                if (data.length > 0) {
                    var html = '';
                    // 把返回的属性循环拼接成字符串显示
                    $(data).each(function(k, v) {
                        //console.log(v);
                        html += ' <div class="row cl"><label class="form-label col-xs-4 col-sm-2">';

                        if (v.attr_input_type == 1) {
                            html += '<a  onclick="addNewAttr(this);" href="#">[ + ]</a>'
                        }
                        html += v.attr_name + '：</label>';
                        html += '<div class="formControls col-xs-8 col-sm-6">';

                        // 如果属性有可选值就做成下拉框，否则做成文本框
                        if (v.attr_input_type == 0) {
                            html += '<input type="text"  class="input-text" name="attr_value['+ v.attr_id +'][]">';
                            html += '</div>';
                        } else {
                            // 做成下拉框
                            html += '<span class="select-box">';
                            html += '<select class="select" name="attr_value['+ v.attr_id +'][]"><option value="">请选择...</option>';
                            var attrs = v.attr_values.split(',');
                            for (var i=0; i<attrs.length; i++) {
                                html += '<option value="'+ attrs[i] +'">';
                                html += attrs[i];
                                html += '</option>';
                            }
                            html += '</select></span></div>';
                        }
                        html += '</div>';
                    });
                    $("#attr_list").html(html);
                } else {
                    // 如果选择id 没有属性列表 则清空
                    $("#attr_list").html("");
                }
            });
        }
    });

    function addNewAttr(obj)
    {
        var html = $(obj).parent().parent();
        if ($(obj).text() == '[ + ]') {
            var newHtml = html.clone();

            // 把 + 变成 -
            newHtml.find('a').text('[ - ]');
            html.after(newHtml);
        } else {
            // 如果不是 [ + ] 则移除该元素
            html.remove();
        }
    }
</script>

<script type="text/javascript">
    <?php $timestamp = time();?>
    $(function() {
        $('#file_upload').uploadifive({
            'auto'  : true,
            'buttonText'   : '商品图片',
            'formData'     : {
                'timestamp' : '<?php echo $timestamp;?>',
                '_token'     : '{{ csrf_token() }}'
            },
            'uploadScript' : "{{ url('admin/upload' )}}",
            'onUploadComplete' : function(file, data, response) {
                var obj = JSON.parse(data);
                var disks = "{{ config('image.upload.disks') }}" + '/';
                $('input[name=original_img]').val(obj.data.src);
                $('#goods_img').attr('src', '/' + disks + obj.data.src);
                $('#goods_img').parent().parent().css('display', 'block');
            }
        });
    });
</script>
@endsection

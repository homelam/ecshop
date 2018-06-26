@extends('layouts.admin')
@section('main')
	<div class="page-container">
        @if (session()->has('status'))
            <div class="Huialert Huialert-info"><i class="Hui-iconfont">&#xe6a6;</i>{{ session('status') }}</div>
        @endif

		<div  class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l" style="margin-left: 10px;">
                <a class="btn btn-success radius r"  href="javascript:location.reload();" title="刷新" >
                    <i class="Hui-iconfont">&#xe68f;</i> 刷新
                </a>
            </span>
            <span class="r" style="margin-left: 10px;">
                <a class="btn btn-primary radius r"  href="{{ route('attributes.create', ['id' => $type_id]) }}" title="添加属性" >
                    <i class="Hui-iconfont Hui-iconfont-add"></i> 添加属性
                </a>
            </span>
            <span class="r">
                <a class="btn btn-primary radius r"  href="{{ route('types.index') }}" title="添加属性" >
                    <i class="Hui-iconfont Hui-iconfont-arrow1-left"></i> 返回
                </a>
            </span>
        </div>
		<div class="mt-20">
			<table class="table table-border table-bordered table-bg table-hover table-sort">
				<thead>
				<tr class="text-c">
                    <!-- <th width="40"><input name="" type="checkbox" value=""></th> -->
                    <th width="50">属性名称</th>
                    <th width="100">商品类型</th>
					<th width="100">属性值录入方式</th>
					<th width="200">可选值列表</th>
					<th width="50">排序</th>
					<th width="50">操作</th>
				</tr>
				</thead>
				<tbody>
                    @inject('attributePresenter', 'App\Presenters\AttributePresenter')
				    @foreach ($attributes as $attribute)
                        <tr class="text-c">
                            <td class="text-c">{{ $attribute->attr_name}}</td>
							<td class="text-c">{{ $attribute->type_name }}</td>
							<td class="text-c">{{ $attributePresenter->translateInputType($attribute->attr_input_type) }}</td>
							<td class="text-c">{{ $attribute->attr_values }}</td>
                            <td class="text-c" >{{ $attribute->sort_order }}</td>
							<td class="td-manage">
                                <a style="text-decoration:none" class="ml-5" href="{{ route('attributes.edit', ['id' => $attribute->attr_id]) }}" title="编辑"><i class="Hui-iconfont Hui-iconfont-edit"></i></a>
                                <a href="javascript:;" class="ml-5 delete-type-attribute" data-id="{{ $attribute->attr_id }}" title="删除"><i class="Hui-iconfont Hui-iconfont-del2"></i></a>
                            </td>
						</tr>
                    @endforeach
                    <input type="hidden" id="delete-attribute-url" data-token="{{csrf_token()}}" data-url="{{ url('admin/attributes') }}" />
				</tbody>
			</table>
		</div>
	</div>
@endsection
@section('script')
<script src="{{ asset('js/product.js') }}"></script>
@endsection

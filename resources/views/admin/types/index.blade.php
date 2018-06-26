@extends('layouts.admin')
@section('main')
	<div class="page-container">
        @if (session()->has('status'))
            <div class="Huialert Huialert-info"><i class="Hui-iconfont">&#xe6a6;</i>{{ session('status') }}</div>
        @endif

		<div  class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                <a href="javascript:;" id="batch_delete_btn" class="btn btn-danger radius">
                    <i class="Hui-iconfont">&#xe6e2;</i> 批量删除
                </a>
            </span>
            <span class="l" style="margin-left: 10px;">
                <a class="btn btn-success radius r"  href="javascript:location.reload();" title="刷新" >
                    <i class="Hui-iconfont">&#xe68f;</i> 刷新
                </a>
            </span>
            <span class="r">
                <a class="btn btn-primary radius r"  href="{{ route('types.create') }}" title="添加商品类型" >
                    <i class="Hui-iconfont Hui-iconfont-add"></i> 添加商品类型
                </a>
            </span>
        </div>
		<div class="mt-20">
			<table class="table table-border table-bordered table-bg table-hover table-sort">
				<thead>
				<tr class="text-c">
                    <!-- <th width="40"><input name="" type="checkbox" value=""></th> -->
                    <th width="50">商品类型名称</th>
                    <th width="200">属性分组</th>
					<th width="100">属性数</th>
					<th width="100">状态</th>
					<th width="50">操作</th>
				</tr>
				</thead>
				<tbody>
				    @foreach ($types as $type)
						<tr class="text-c">
                            <td class="text-l">{{ $type->type_name}}</td>
							<td class="text-l">{{ $type->attr_group }}</td>
							<td class="text-l">0</td>
							<td class="text-c" >{!! isShowLabel($type->is_enabled) !!}</td>
							<td class="td-manage">
                                <a style="text-decoration:none" class="ml-5" href='{{ route("attributes.goods_type.list", ["id" => $type->type_id]) }}' title="属性列表"><i class="Hui-iconfont Hui-iconfont-menu"></i></a>
                                <a style="text-decoration:none" class="ml-5" href='{{ route("types.edit", ["id" => $type->type_id]) }}' title="编辑"><i class="Hui-iconfont Hui-iconfont-edit"></i></a>
                                <a href="javascript:;" class="ml-5 delete-type" data-id="{{ $type->type_id }}" title="删除"><i class="Hui-iconfont Hui-iconfont-del2"></i></a>
                            </td>
						</tr>
                    @endforeach
                    <input type="hidden" id="delete-type-url" data-token="{{csrf_token()}}" data-url="{{ url('admin/types') }}" />
				</tbody>
			</table>
		</div>
	</div>
@endsection
@section('script')
<script src="{{ asset('js/product.js') }}"></script>
@endsection



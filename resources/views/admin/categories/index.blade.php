@extends('layouts.admin')
@section('main')
	<div class="page-container">
        @if (session()->has('status'))
            <div class="Huialert Huialert-info"><i class="Hui-iconfont">&#xe6a6;</i>{{ session('status') }}</div>
        @endif

		<div class="cl pd-5 bg-1 bk-gray mt-20">
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
                <a class="btn btn-primary radius r"  href="{{ route('categories.create') }}" title="添加分类" >
                    <i class="Hui-iconfont Hui-iconfont-add"></i> 添加分类
                </a>
            </span>
        </div>
		<div class="mt-20">
			<table class="table table-border table-bordered table-bg table-hover table-sort">
				<thead>
				<tr class="text-c">
					<th width="100">分类名称</th>
					<th width="50">是否显示</th>
					<th width="50">导航栏</th>
                    <th width="50">排序</th>
					<th width="100">操作</th>
				</tr>
				</thead>
				<tbody>
				    @foreach ($categories as $category)
						<tr class="text-c">
							<td class="text-l">
                                {!! $category->_cat_name !!}
                            </td>
							<td class="text-c" ><span>{!! isShowLabel($category->is_show) !!}</span></td>
							<td class="text-c" ><span>{!! isShowLabel($category->show_in_nav) !!}<span></td>
                            <td class="text-c" ><span>{{ $category->sort_order }}<span></td>
							<td class="td-manage">
                                <a style="text-decoration:none" class="ml-5" href='{{ route("categories.edit", ["id" => $category->cat_id]) }}' title="编辑"><i class="Hui-iconfont Hui-iconfont-edit"></i></a>
                                <a href="javascript:;" class="ml-5 delete_category" data-url="" data-id="{{ $category->cat_id }}" title="删除"><i class="Hui-iconfont Hui-iconfont-del2"></i></a>
                            </td>
						</tr>
                    @endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection
@section('script')
<script src="{{ asset('js/category.js') }}"></script>
@endsection



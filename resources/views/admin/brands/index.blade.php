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
                <a class="btn btn-primary radius r"  href="{{ route('brands.create') }}" title="添加品牌" >
                    <i class="Hui-iconfont Hui-iconfont-add"></i> 添加品牌
                </a>
            </span>
        </div>
		<div class="mt-20">
			<table class="table table-border table-bordered table-bg table-hover table-sort">
				<thead>
				<tr class="text-c">
                    <th width="40"><input name="" type="checkbox" value=""></th>
                    <th width="50">品牌名称</th>
                    <th width="100">品牌logo</th>
					<th width="100">品牌网址</th>
					<th width="200">品牌描述</th>
                    <th width="30">排序</th>
                    <th width="30">是否显示</th>
					<th width="50">操作</th>
				</tr>
				</thead>
				<tbody>
                    @inject('brandPresenter', 'App\Presenters\BrandPresenter')
				    @foreach ($brands as $brand)
						<tr class="text-c">
                            <td><input name="brand_id" type="checkbox" value="{{ $brand->brand_id }}"></td>
                            <td class="text-l">{{ $brand->brand_name}}</td>
							<td class="text-c"><img style="height: 80px;width:auto;" title="{{ $brand->brand_name }}" src="{{ $brandPresenter->getBrandLogoLink($brand->brand_logo) }}" /></td>
							<td class="text-l">{{ $brand->site_url }}</td>
							<td class="text-c" >{{ $brand->brand_desc }}</td>
							<td class="text-c" >{{ $brand->sort_order }}</td>
                            <td class="text-c" >{!! isShowLabel($brand->is_show) !!}</td>
							<td class="td-manage">
                                <a style="text-decoration:none" class="ml-5" href='{{ route("brands.edit", ["id" => $brand->brand_id]) }}' title="编辑"><i class="Hui-iconfont Hui-iconfont-edit"></i></a>
                                <a href="javascript:;" class="ml-5 delete_brand" data-id="{{ $brand->brand_id }}" title="删除"><i class="Hui-iconfont Hui-iconfont-del2"></i></a>
                            </td>
						</tr>
                    @endforeach
                    <form id="delete_brand_form" action="{{ url('admin/brands') }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                    </form>
				</tbody>
			</table>
		</div>
	</div>
@endsection
@section('script')
<script src="{{ asset('js/brand.js') }}"></script>
@endsection



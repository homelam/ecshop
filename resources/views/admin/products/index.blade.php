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
                <a class="btn btn-primary radius r"  href="{{ route('products.create') }}" title="添加品牌" >
                    <i class="Hui-iconfont Hui-iconfont-add"></i> 添加新商品
                </a>
            </span>
        </div>
		<div class="mt-20">
			<table class="table table-border table-bordered table-bg table-hover table-sort">
				<thead>
				<tr class="text-c">
                    <th width="40"><input name="" type="checkbox" value=""></th>
                    <th width="80">商品名称</th>
                    <th width="60">商品图片</th>
					<th width="100">商品货号</th>
					<th width="80">商品价格</th>
                    <th width="30">上架</th>
                    <th width="30">精品</th>
					<th width="30">新品</th>
					<th width="30">热销</th>
					<th width="50">库存量</th>
					<th width="100">操作</th>
				</tr>
				</thead>
				<tbody>
                    @inject('productPresenter', 'App\Presenters\ProductPresenter')
                    @foreach ($data as $product)
						<tr class="text-c">
                            <td><input name="goods_id[]" type="checkbox" value="{{ $product->goods_id }}"></td>
                            <td class="text-l">{{ $product->goods_name}}</td>
							<td class="text-c"><img style="height: 80px;width:auto;" title="{{ $product->goods_name }}" src="{{ $productPresenter->getImageLink($product->original_img) }}" /></td>
							<td class="text-c">{{ $product->goods_sn }}</td>
							<td class="text-c">{{ $product->shop_price }}</td>
							<td class="text-c" >{!! isShowLabel($product->is_on_sale) !!}</td>
							<td class="text-c" >{!! isShowLabel($product->is_best) !!}</td>
							<td class="text-c" >{!! isShowLabel($product->is_new) !!}</td>
							<td class="text-c" >{!! isShowLabel($product->is_hot) !!}</td>
                            <td class="text-c" >{{ $product->goods_qty }}</td>
							<td class="td-manage">
                                <a style="text-decoration:none" class="ml-5" href="{{ route('products.inventories.create', ['id' => $product->goods_id]) }}" title="编辑">库存量</a>
                                <a style="text-decoration:none" class="ml-5" href="{{ route('products.edit', ['id' => $product->goods_id]) }}" title="编辑">编辑</a>
                                <a href="javascript:;" class="ml-5 delete_product" data-id="{{ $product->goods_id }}" title="删除">删除</a>
                            </td>
						</tr>
                    @endforeach
                    <form id="delete-product-form" action="{{ url('admin/products') }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                    </form>
				</tbody>
			</table>
            <div class="page_list">
               {{$data->links()}}
            </div>
		</div>
	</div>
@endsection
@section('script')
@endsection



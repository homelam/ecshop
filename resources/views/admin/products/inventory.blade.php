@extends('layouts.admin')
@section('main')
	<div class="page-container">
        @if (session()->has('status'))
            <div class="Huialert Huialert-info"><i class="Hui-iconfont">&#xe6a6;</i>{{ session('status') }}</div>
        @endif

		<div  class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="r" style="margin-left: 10px;">
                <a class="btn btn-success radius r"  href="javascript:location.reload();" title="刷新" >
                    <i class="Hui-iconfont">&#xe68f;</i> 刷新
                </a>
            </span>
        </div>
		<div class="mt-20">
            <form action="{{ route('products.inventories.store') }}" method="post">
            {{ csrf_field() }}
			<table class="table table-border table-bordered table-bg table-sort">
				<thead>
				<tr class="text-c">
                    @foreach ($gaAttrs as $k => $v)
                        <th width="100">{{ $k }}</th>
                    @endforeach
                    <th width="50">库存量</th>
                    <th width="80">操作</th>
				</tr>
				</thead>
				<tbody>
                    <!--  TODO: 自动排列组合好 -->
                    @if(count($gnData))
                        @inject('productPresenter', 'App\Presenters\ProductPresenter')
                        @foreach ($gnData as $k0 => $v0)
                        <tr class="text-c">
                            @foreach ($gaAttrs as $k => $v)
                            <td class="text-c">
                                <div class="formControls">
                                    <span class="select-box">
                                        <select name="goods_attr_id[]" class="select">
                                            <option value="">请选择...</option>
                                            @foreach ($v as $k1 => $v1)
                                                <option value="{{ $v1->id }}" {{ $productPresenter->getSelected($v0->goods_attr_id, $v1->id) }}>{{ $v1->attr_value }}</option>
                                            @endforeach
                                        </select>
                                    </span>
                                </div>
                            </td>
                            @endforeach
                            <td class="text-c">
                                <div class="formControls">
                                    <input type="text" class="input-text" name="goods_number[]" value="{{ $v0->goods_number }}">
                                </div>
                            </td>
                            <td class="text-c">
                                <div class="formControls">
                                    <input type="button" class="add-new-quantity-tr" @if($k0 == 0) value=" + " @else value=" - " @endif/>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                    <tr class="text-c">
                            @foreach ($gaAttrs as $k => $v)
                            <td class="text-c">
                                <div class="formControls">
                                    <span class="select-box">
                                        <select name="goods_attr_id[]" class="select">
                                            <option value="">请选择...</option>
                                            @foreach ($v as $k1 => $v1)
                                                <option value="{{ $v1->id }}">{{ $v1->attr_value }}</option>
                                            @endforeach
                                        </select>
                                    </span>
                                </div>
                            </td>
                            @endforeach
                            <td class="text-c">
                                <div class="formControls">
                                    <input type="text" class="input-text" name="goods_number[]">
                                </div>
                            </td>
                            <td class="text-c">
                                <div class="formControls">
                                    <input type="button" class="add-new-quantity-tr" value=" + "/>
                                </div>
                            </td>
                        </tr>
                    @endif
                    @php
                        $trCopspan = count($gaAttrs) + 2;
                    @endphp
                    <tr class="text-c" id="submit-inventory">
                        <td class="text-c" colspan="{{ $trCopspan }}">
                            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                                <input class="btn btn-primary radius" type="submit" value="提交" />
                            </div>
                        </td>
                    <tr>
				</tbody>
			</table>
            <input type="hidden" name="goods_id" value="{{ $id }}">
            </form>
		</div>
	</div>
@endsection
@section('script')
<script>
    $(document).on("click", "input.add-new-quantity-tr", function(event) {
        // console.log($(this));
        var tr = $(this).parent().parent().parent();
        if ($(this).val() == " + ") {
            var newTr = tr.clone();
            newTr.find(":button").val(" - ");
            $("#submit-inventory").before(newTr);
        } else {
            tr.remove();
        }
    });
</script>
@endsection



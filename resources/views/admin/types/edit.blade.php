@extends('layouts.admin')

@section('main')
    <div class="page-container">
        @if (session()->has('status'))
            <div class="Huialert Huialert-info"><i class="Hui-iconfont">&#xe6a6;</i>{{ session('status') }}</div>
        @endif

        <form action='{{ route("types.update", ["id" => $type->type_id]) }}' method="post" class="form form-horizontal" id="form-goods-types-create">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="row cl {{ $errors->has('type_name') ? ' has-error' : '' }}">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品类型名称：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <input type="text" class="input-text" name="type_name" value="{{ $type->type_name }}" />
                    @if ($errors->has('type_name'))
                        <span class="help-block">
                            <strong>{!! $errors->first('type_name') !!}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <!-- 属性分组-->
            <div class="row cl" hidden>
                <label class="form-label col-xs-4 col-sm-2">属性分组：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <textarea name="attr_group" cols="" rows="" class="textarea"></textarea>
                </div>
            </div>
            <div class="row cl">
                <div class="col-9 col-offset-2">
                    <input class="btn btn-primary size-M radius" type="submit" value="提交">
                </div>
            </div>
        </form>
    </div>
@endsection

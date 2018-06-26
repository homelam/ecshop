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
            <span class="r">
                <a class="btn btn-primary radius r"  href='{{ route("attributes.goods_type.list", ["id" => $attribute->type_id]) }}' title="属性列表" >
                    <i class="Hui-iconfont Hui-iconfont-chexiao"></i> 属性列表
                </a>
            </span>
        </div>
        <form action='{{ route("attributes.update", ["id" => $attribute->attr_id]) }}' method="post" class="form form-horizontal" id="form-attribute-create">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="put">
            <div class="row cl {{ $errors->has('attr_name') ? ' has-error' : '' }}">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>属性名称：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <input type="text" class="input-text" name="attr_name" value="{{ $attribute->attr_name }}">
                    @if ($errors->has('attr_name'))
                        <span class="help-block">
                            <strong>{!! $errors->first('attr_name') !!}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="row cl  {{ $errors->has('type_id') ? ' has-error' : '' }}">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>所属商品类型：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <span class="select-box">
                        <select name="type_id" class="select">
                            <option value="0"> 请选择... </option>
                            @foreach ($goods_types as $type)
                                <option value="{{ $type->type_id }}" @if($type->type_id == $attribute->type_id) selected='selected' @endif>{!! $type->type_name !!}</option>
                            @endforeach
                        </select>
                    </span>
                    @if ($errors->has('type_id'))
                        <span class="help-block">
                            <strong>{!! $errors->first('type_id') !!}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="row cl {{ $errors->has('sort_order') ? ' has-error' : '' }}">
                <label class="form-label col-xs-4 col-sm-2">显示排序：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <input type="text" class="input-text"  name="sort_order" value="{{ $attribute->sort_order }}">
                    @if ($errors->has('sort_order'))
                        <span class="help-block">
                            <strong>{!! $errors->first('sort_order') !!}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <!-- 属性是否可选 -->
            <div class="row cl {{ $errors->has('attr_type') ? ' has-error' : '' }}">
                <label class="form-label col-xs-4 col-sm-2">属性是否可选：</label>
                <div class="mt-20 skin-minimal">
                    <div class="radio-box">
                        <input type="radio" id="attr-type-1" name="attr_type"  value="0" @if($attribute->attr_type == 0) checked='checked' @endif>
                        <label for="radio-1">唯一属性</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio" id="attr-type-2" name="attr_type" value="1" @if($attribute->attr_type == 1) checked='checked' @endif>
                        <label for="radio-2">单一属性</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio" id="attr-type-3" name="attr_type" value="2" @if($attribute->attr_type == 2) checked='checked' @endif>
                        <label for="radio-3">复选属性</label>
                    </div>
                </div>
            </div>
            <!-- 该属性值的录入方式 -->
            <div class="row cl {{ $errors->has('attr_input_type') ? ' has-error' : '' }}">
                <label class="form-label col-xs-4 col-sm-2">该属性值的录入方式：</label>
                <div class="mt-20 skin-minimal">
                    <div class="radio-box">
                        <input type="radio" id="attr-input-type-0" name="attr_input_type" value="0"  @if($attribute->attr_input_type == 0) checked='checked' @endif >
                        <label for="radio-1">手工录入</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio" id="attr-input-type-1" name="attr_input_type" value="1" @if($attribute->attr_input_type == 1) checked='checked' @endif>
                        <label for="radio-2">从下面的列表中选择（一行代表一个可选值）</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio" id="attr-input-type-2" name="attr_input_type" value="2" @if($attribute->attr_input_type == 2) checked='checked' @endif>
                        <label for="radio-2">多行文本框</label>
                    </div>
                </div>
            </div>
            <!-- 可选值列表 -->
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>可选值列表：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <textarea name="attr_values" cols="" rows="5" class="textarea">{{ $attribute->attr_values }}</textarea>
                </div>
            </div>
            <div class="row cl">
                <div class="col-9 col-offset-2">
                    <input class="btn btn-primary  size-M radius" type="submit" value="提交">
                </div>
            </div>
        </form>
    </div>
@endsection

@extends('layouts.admin')

@section('main')
    <div class="page-container">

        @if (session()->has('status'))
            <div class="Huialert Huialert-info"><i class="Hui-iconfont">&#xe6a6;</i>{{ session('status') }}</div>
        @endif

        <form action='{{ route("categories.update", ["cat_id" => $category->cat_id]) }}' method="post" class="form form-horizontal" id="form-user-add">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="put">
            <div class="row cl  {{ $errors->has('parent_id') ? ' has-error' : '' }}">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>父级分类：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <span class="select-box">
                        <select name="parent_id" class="select">
                            <option value="0">顶级分类</option>
                            @foreach ($data as $cate)
                                <option {{ $category->parent_id == $cate->cat_id ? 'selected=\"selected\"' : ''}} value="{{ $cate->cat_id }}">
                                {!! $cate->_cat_name !!}
                                </option>
                            @endforeach
                        </select>
                    </span>
                    @if ($errors->has('parent_id'))
                        <span class="help-block">
                            <strong>{!! $errors->first('parent_id') !!}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="row cl {{ $errors->has('cat_name') ? ' has-error' : '' }}">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>分类名称：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <input type="text" class="input-text" value="{{ $category->cat_name }}" placeholder="分类名称" name="cat_name">
                    @if ($errors->has('cat_name'))
                        <span class="help-block">
                            <strong>{!! $errors->first('cat_name') !!}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="row cl {{ $errors->has('sort_order') ? ' has-error' : '' }}">
                <label class="form-label col-xs-4 col-sm-2">显示排序：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <input type="text" class="input-text" value="{{ $category->sort_order }}" placeholder="排序" name="sort_order">
                    @if ($errors->has('sort_order'))
                        <span class="help-block">
                            <strong>{!! $errors->first('sort_order') !!}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <!-- 是否显示 -->
            <div class="row cl {{ $errors->has('is_show') ? ' has-error' : '' }}">
                <label class="form-label col-xs-4 col-sm-2">是否显示：</label>
                <div class="mt-20 skin-minimal">
                    <div class="radio-box">
                        <input type="radio" id="is-show-1" name="is_show"  value="1" @if($category->is_show == 1) checked='checked' @endif >
                        <label for="radio-1">是</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio" id="is-show-2" name="is_show" value="0" @if($category->is_show == 0) checked='checked' @endif >
                        <label for="radio-2">否</label>
                    </div>
                </div>
            </div>
            <!-- 是否显示在导航栏 -->
            <div class="row cl {{ $errors->has('show_in_nav') ? ' has-error' : '' }}">
                <label class="form-label col-xs-4 col-sm-2">是否显示在导航栏：</label>
                <div class="mt-20 skin-minimal">
                    <div class="radio-box">
                        <input type="radio" id="radio-1" name="show_in_nav" value="1" @if($category->show_in_nav == 1) checked='checked' @endif >
                        <label for="radio-1">是</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio" id="radio-2" name="show_in_nav" value="0" @if($category->show_in_nav == 0) checked='checked' @endif >
                        <label for="radio-2">否</label>
                    </div>
                </div>
            </div>
            <!-- 分类描述 -->
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>分类描述：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <textarea name="cat_desc" cols="" rows="" class="textarea"  placeholder="分类描述">{{ $category->cat_desc }}</textarea>
                    <p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
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

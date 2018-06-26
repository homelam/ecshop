@extends('layouts.admin')

@section('main')
    <div class="page-container">
        @if (session()->has('status'))
            <div class="Huialert Huialert-info"><i class="Hui-iconfont">&#xe6a6;</i>{{ session('status') }}</div>
        @endif

        <form action='{{ route("brands.update", ["brand_id" => $brand->brand_id]) }}' method="post" class="form form-horizontal" id="form-brand-update" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="put">
            <div class="row cl {{ $errors->has('brand_name') ? ' has-error' : '' }}">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>品牌名称：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <input type="text" class="input-text" value="{{ $brand->brand_name }}" name="brand_name">
                    @if ($errors->has('brand_name'))
                        <span class="help-block">
                            <strong>{!! $errors->first('brand_name') !!}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="row cl {{ $errors->has('site_url') ? ' has-error' : '' }}">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>品牌网址：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <input type="text" class="input-text" value="{{ $brand->site_url }}" name="site_url">
                    @if ($errors->has('site_url'))
                        <span class="help-block">
                            <strong>{!! $errors->first('site_url') !!}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="row cl {{ $errors->has('brand_logo') ? 'has-error' : '' }}">
                <label class="form-label col-xs-4 col-sm-2">品牌LOGO：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <span class="btn-upload form-group">
                        <input class="input-text upload-url" type="text" id="uploadfile" readonly placeholder="选择品牌LOGO图！" style="width:200px">
                        <a href="javascript:;" class="btn btn-primary radius upload-btn"><i class="Hui-iconfont">&#xe642;</i> 浏览文件</a>
                        <input type="file" name="brand_logo" class="input-file">
                    </span>
                </div>
            </div>
            @inject('brandPresenter', 'App\Presenters\BrandPresenter')
            @if($brand->brand_logo)
            <div class="row cl {{ $errors->has('brand_logo') ? 'has-error' : '' }}">
                <label class="form-label col-xs-4 col-sm-2">品牌LOGO：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <img style="height: 100px;width:auto;" src="{{ $brandPresenter->getBrandLogoLink($brand->brand_logo) }}" alt="{{ $brand->brand_name }}" class="thumbnail">
                </div>
            </div>
            @endif
            <div class="row cl {{ $errors->has('sort_order') ? ' has-error' : '' }}">
                <label class="form-label col-xs-4 col-sm-2">显示排序：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <input type="text" class="input-text"  value="{{ $brand->sort_order }}" name="sort_order">
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
                        <input type="radio" id="is-show-1" name="is_show"  value="1" @if($brand->is_show == 1) checked='checked' @endif>
                        <label for="radio-1">是</label>
                    </div>
                    <div class="radio-box">
                        <input type="radio" id="is-show-2" name="is_show" value="0" @if($brand->is_show == 0) checked='checked' @endif>
                        <label for="radio-2">否</label>
                    </div>
                </div>
            </div>
            <!-- 品牌描述 -->
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>品牌描述：</label>
                <div class="formControls col-xs-6 col-sm-6">
                    <textarea name="brand_desc" cols="" rows="" class="textarea"  placeholder="品牌描述">{{ $brand->brand_desc }}</textarea>
                    <p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
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

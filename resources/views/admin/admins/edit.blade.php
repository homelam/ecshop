@extends('layouts.admin')


@section('style')
    <link rel="stylesheet" href="{{ asset('admin/lib/layui/css/layui.css') }}">
@endsection

@section('main')
	<article class="page-container">
        @if (session()->has('status'))
            <div class="Huialert Huialert-error"><i class="Hui-iconfont">&#xe6a6;</i>{{ session('status') }}</div>
        @endif

		<form class="form form-horizontal layui-form" id="form-admin-add" method="post" action='{{ url("/admin/admins/{$admin->id}") }}'>

			{{ csrf_field() }}
			{{ method_field('PUT') }}

			<div class="row cl {{ $errors->has('name') ? 'has-error' : '' }}">
				<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>管理员：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="{{ $admin->name }}" placeholder="" id="adminName" name="name">
					@if ($errors->has('name'))
						<span class="help-block">
                            <strong>{!! $errors->first('name') !!}</strong>
                        </span>
					@endif
				</div>
			</div>
			<div class="row cl {{ $errors->has('o_password') ? 'has-error' : '' }}">
				<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>原密码：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="password" class="input-text" placeholder="原密码" id="o_password" name="o_password">
                    @if ($errors->has('o_password'))
						<span class="help-block">
                            <strong>{!! $errors->first('o_password') !!}</strong>
                        </span>
					@endif
				</div>
			</div>
            <div class="row cl {{ $errors->has('password') ? 'has-error' : '' }}">
				<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>新密码：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="password" class="input-text" placeholder="新密码" id="password" name="password">
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{!! $errors->first('password') !!}</strong>
                        </span>
                    @endif
                </div>
			</div>
			<div class="row cl {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
				<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>确认密码：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="password" class="input-text" autocomplete="off"  placeholder="确认新密码" id="password2" name="password_confirmation">
                    @if ($errors->has('password_confirmation'))
						<span class="help-block">
                            <strong>{!! $errors->first('password_confirmation') !!}</strong>
                        </span>
					@endif
				</div>
			</div>
			<div class="row cl {{ $errors->has('role') ? 'has-error' : '' }}">
				<label class="form-label col-xs-4 col-sm-3">角色：</label>
				<div class="formControls col-xs-8 col-sm-9">
                    <!-- multiple="multiple" -->
                    <div class="layui-form-item">
                            @foreach ($roles as $role)
                                <input type="radio" name="roles[][role]" value="{{ $role->name }}" title="{{ $role->name }}" {{ $admin->hasRole($role->name) ? 'checked' : '' }}>
                            @endforeach

                    </div>

                    @if ($errors->has('role'))
                        <span class="help-block">
                            <strong>{!! $errors->first('role') !!}</strong>
                        </span>
                    @endif
                </div>
			</div>
			<div class="row cl">
				<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
					<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
				</div>
			</div>
		</form>
	</article>
@endsection

@section('script')
	<script src="{{ asset('admin/lib/layui/layui.js') }}"></script>
	<script>
        layui.use(['form'], function() {
            var form = layui.form;
        });
	</script>
@endsection

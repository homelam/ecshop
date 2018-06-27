<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    @include('common.home.meta')

    @yield('style')
</head>
<body>
	<!-- 顶部导航 start -->
	@include('common.home.header')
	<!-- 顶部导航 end -->
	<div style="clear:both;"></div>

	@yield('main')

	<div style="clear:both;"></div>
	<!-- 底部版权 start -->
    @include('common.home.footer')
	<!-- 底部版权 end -->

    @yield('script')
</body>
</html>

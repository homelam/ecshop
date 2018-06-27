<aside class="Hui-aside">
	<div class="menu_dropdown bk_2">
		<dl id="menu-product">
			<dt><i class="Hui-iconfont">&#xe620;</i> 商品管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd>
				<ul>
					<li><a data-href="{{ route('products.index') }}" data-title="商品列表" href="javascript:void(0)">商品列表</a></li>
					<li><a data-href="{{ route('products.create') }}" data-title="添加新商品" href="javascript:void(0)">添加新商品</a></li>
                    <li><a data-href="{{ route('categories.index') }}" data-title="商品分类" href="javascript:void(0)">商品分类</a></li>
                    <li><a data-href="{{ route('brands.index') }}" data-title="商品品牌" href="javascript:void(0)">商品品牌</a></li>
                    <li><a data-href="{{ route('types.index') }}" data-title="商品属性" href="javascript:void(0)">商品类型</a></li>
				</ul>
			</dd>
		</dl>
		<dl id="menu-picture">
			<dt><i class="Hui-iconfont">&#xe613;</i> 图片管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd>
				<ul>
					<li><a data-href="{{ url('/admin/productImages') }}" data-title="图片管理" href="javascript:void(0)">图片管理</a></li>
				</ul>
			</dd>
		</dl>
		<dl id="menu-member">
			<dt><i class="Hui-iconfont">&#xe60d;</i> 会员管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd>
				<ul>
					<li><a data-href="{{ url('/admin/users') }}" data-title="会员列表" href="javascript:;">会员列表</a></li>
				</ul>
			</dd>
		</dl>
		<dl id="menu-admin">
			<dt><i class="Hui-iconfont">&#xe62d;</i> 管理员管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
			<dd>
				<ul>
					<li><a data-href="{{ route('admins.index') }}" data-title="管理员列表" href="javascript:void(0)">管理员列表</a></li>
					<li><a data-href="{{ url('/admin/admins/create') }}" data-title="添加管理员" href="javascript:void(0)">添加管理员</a></li>
					<li><a data-href="{{ url('/admin/roles') }}" data-title="角色管理" href="javascript:void(0)">角色管理</a></li>
				</ul>
			</dd>
		</dl>
	</div>
</aside>
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>

<!-- 导航 -->
<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container">
		<!--小屏幕导航按钮和logo-->
		<div class="navbar-header">
			<button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="<?php echo URL::site('/');?>" class="navbar-brand"> Sphinx Admin 服务</a>
		</div>
		<!--小屏幕导航按钮和logo-->
		<!--导航-->
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<?php if(isset($menus) && count($menus)) {
					$controller = Request::$current->controller() ? strtolower(Request::$current->controller()) : 'index';
					foreach ($menus as $key => $menu) { ?>
						<li class="<?php echo ($controller == strtolower($key)) ? 'active' : '';?>">
							<a href="<?php echo $menu['url']; ?>"><span class="<?php echo $menu['icon']; ?>"></span>&nbsp;&nbsp;<?php echo $menu['name']; ?></a>
						</li>
					<?php }
				}?>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo Author::accountName();?><span class="caret"></span></a>
					<ul class="dropdown-menu" aria-labelledby="dLabel">
						<li><a href="<?php echo URL::site('profile/index');?>"><span class="glyphicon glyphicon-cog"></span>&nbsp;&nbsp;个人设置</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo URL::site('profile/editpass');?>"><span class="glyphicon glyphicon-lock"></span>&nbsp;&nbsp;修改密码</a></li>
					</ul>
				</li>
				<li><a href="<?php echo URL::site('author/logout');?>"><span class="glyphicon glyphicon-off"></span>&nbsp;&nbsp;退出</a></li>
			</ul>
		</div>
		<!--导航-->
	</div>
</nav>
<!-- /导航 -->
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel-body" style="padding: 15px 0;">
				<ul class="nav nav-tabs">
					<li><a href="<?php echo URL::site('machine/list');?>" >机器列表</a></li>
					<li class="active"><a href="<?php echo URL::site('machine/add');?>">添加机器</a></li>
				</ul>
			</div>
			<div class="panel-body">
				<form class="form-horizontal" method="post" action="<?php echo URL::site('machine/save');?>" onsubmit="return false">
					<div class="form-group">
						<label class="col-sm-1 control-label"><span class="text-danger"></span>域名</label>
						<div class="col-sm-4">
							<input type="text" name="domain" class="form-control" placeholder="机器域名" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-1 control-label"><span class="text-danger"> * </span>IP</label>
						<div class="col-sm-4">
							<input type="email" name="ip" class="form-control" placeholder="机器ip" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-1 control-label"><span class="text-danger"> * </span>Sphinx<br>安装目录</label>
						<div class="col-sm-4">
							<input type="text" name="sphinx_path" class="form-control" placeholder="sphinx安装目录">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-1 control-label"><span class="text-danger"></span>备注信息</label>
						<div class="col-sm-4">
							<input type="text" name="comment" class="form-control" placeholder="备注" required>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-1 col-sm-10">
							<button type="button" name="submit" onclick="Form.ajaxSubmit(this.form, false)" class="btn btn-success">保存</button>
						</div>
					</div>
				</form>
				<hr>
			</div>
		</div>
	</div>
</div>
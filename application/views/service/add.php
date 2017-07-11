<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel-body" style="padding: 15px 0;">
				<ul class="nav nav-tabs">
					<li><a href="<?php echo URL::site('service/list');?>">实例列表</a></li>
					<li class="active"><a href="<?php echo URL::site('service/add');?>">添加实例</a></li>
				</ul>
			</div>

			<div class="panel-body">
				<form class="form-horizontal" action="<?php echo URL::site('service/save');?>" method="post" onsubmit="return false">
					<div class="form-group">
						<label class="col-sm-1 control-label"><span class="text-danger"> * </span>实例名称</label>
						<div class="col-sm-4">
							<input type="text" name="name" class="form-control" placeholder="实例名称" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-1 control-label"><span class="text-danger"> * </span>部署机器</label>
						<div class="col-sm-4">
							<select class="form-control" name="machine_id">
								<?php if(isset($machines) && $machines->count() > 0) {
									foreach ($machines as $machine) { ?>
										<option value="<?php echo $machine->machine_id;?>"><?php echo $machine->domain. "({$machine->ip})";?></option>
									<?php	}
								}?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-1 control-label"><span class="text-danger"> * </span>数据源名</label>
						<div class="col-sm-4">
							<input type="text" name="source_name" class="form-control" placeholder="数据源名称(英文字符)" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-1 control-label"><span class="text-danger"> * </span>数据源类型</label>
						<div class="col-sm-4">
							<select class="form-control" name="source_type">
								<option value="mysql">mysql</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-1 control-label"><span class="text-danger"> * </span>主机</label>
						<div class="col-sm-4">
							<input type="text" name="sql_host" class="form-control" placeholder="sql 主机" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-1 control-label"><span class="text-danger"> * </span>端口</label>
						<div class="col-sm-4">
							<input type="text" name="sql_port" class="form-control" placeholder="sql 端口" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-1 control-label"><span class="text-danger"> * </span>用户名</label>
						<div class="col-sm-4">
							<input type="text" name="sql_user" class="form-control" placeholder="sql 用户名" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-1 control-label"><span class="text-danger"> * </span>密码</label>
						<div class="col-sm-4">
							<input type="text" name="sql_pass" class="form-control" placeholder="sql 密码" value="">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-1 control-label"><span class="text-danger"> * </span>数据库</label>
						<div class="col-sm-4">
							<input type="text" name="sql_db" class="form-control" placeholder="sql 数据库" value="">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-1 control-label"><span class="text-danger"> * </span>表名称</label>
						<div class="col-sm-4">
							<input type="text" name="sql_table" class="form-control" placeholder="sql 数据表" value="">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-1 control-label"><span class="text-danger"> * </span>字符集</label>
						<div class="col-sm-4">
							<input type="text" name="sql_charset" class="form-control" value="utf8" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-1 control-label"><span class="text-danger"> * </span>数据源个数</label>
						<div class="col-sm-4">
							<input type="text" name="sql_number" class="form-control" placeholder="数据源个数(数据库分表数)" value="">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-1 col-sm-10">
							<button type="button" name="submit" onclick="Form.ajaxSubmit(this.form, false)" class="btn btn-success">保存</button>
						</div>
					</div>
				</form>
			</div>
			<hr>
		</div>
	</div>
</div>
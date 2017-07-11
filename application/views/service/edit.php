<div class="panel panel-default">
<div class="panel-body">
	<form class="form-horizontal" action="<?php echo URL::site('service/modify');?>" method="post" onsubmit="return false">
		<input type="hidden" name="service_id" value="<?php echo is_object($service) ? $service->service_id : 0;?>">
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="text-danger"> * </span>实例名称</label>
			<div class="col-sm-4">
				<input type="text" name="name" class="form-control" placeholder="实例名称" value="<?php echo is_object($service) ? $service->name : '';?>" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="text-danger"> * </span>部署机器</label>
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
			<label class="col-sm-2 control-label"><span class="text-danger"> * </span>数据源名</label>
			<div class="col-sm-4">
				<input type="text" name="source_name" class="form-control" value="<?php echo is_object($service) ? $service->source_name : '';?>" placeholder="数据源名称(英文字符)" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="text-danger"> * </span>数据源类型</label>
			<div class="col-sm-4">
				<select class="form-control" name="source_type">
					<option value="mysql">mysql</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="text-danger"> * </span>主机</label>
			<div class="col-sm-4">
				<input type="text" name="sql_host" class="form-control" value="<?php echo is_object($service) ? $service->sql_host : '';?>" placeholder="sql 主机" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="text-danger"> * </span>端口</label>
			<div class="col-sm-4">
				<input type="text" name="sql_port" class="form-control" value="<?php echo is_object($service) ? $service->sql_port : '';?>" placeholder="sql 端口" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="text-danger"> * </span>用户名</label>
			<div class="col-sm-4">
				<input type="text" name="sql_user" class="form-control" value="<?php echo is_object($service) ? $service->sql_user : '';?>" placeholder="sql 用户名" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="text-danger"> * </span>密码</label>
			<div class="col-sm-4">
				<input type="text" name="sql_pass" class="form-control" value="<?php echo is_object($service) ? $service->sql_pass : '';?>" placeholder="sql 密码">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="text-danger"> * </span>数据库</label>
			<div class="col-sm-4">
				<input type="text" name="sql_db" class="form-control" value="<?php echo is_object($service) ? $service->sql_db : '';?>" placeholder="sql 数据库">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="text-danger"> * </span>表名称</label>
			<div class="col-sm-4">
				<input type="text" name="sql_table" class="form-control" value="<?php echo is_object($service) ? $service->sql_table : '';?>" placeholder="sql 数据表">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="text-danger"> * </span>字符集</label>
			<div class="col-sm-4">
				<input type="text" name="sql_charset" class="form-control" value="utf8" readonly>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"><span class="text-danger"> * </span>数据源个数</label>
			<div class="col-sm-4">
				<input type="text" name="source_number" class="form-control" value="<?php echo is_object($service) ? $service->source_number : '';?>" placeholder="数据源个数(数据库分表数)">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="button" name="submit" onclick="Form.ajaxSubmit(this.form, true)" class="btn btn-success">保存</button>
			</div>
		</div>
	</form>
</div>
</div>
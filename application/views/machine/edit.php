<div class="panel panel-default">
	<div class="panel-body">
		<br>
		<form class="form-horizontal" method="post" action="<?php echo URL::site('machine/modify');?>" onsubmit="return false">
			<input type="hidden" name="machine_id" value="<?php echo isset($machine) && is_object($machine) ? $machine->machine_id : ''; ?>">
			<div class="form-group">
				<label class="col-sm-2 control-label"><span class="text-danger"></span>域名</label>
				<div class="col-sm-4">
					<input type="text" name="domain" class="form-control" placeholder="机器域名" value="<?php echo isset($machine) && is_object($machine) ? $machine->domain : '';?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label"><span class="text-danger"> * </span>IP</label>
				<div class="col-sm-4">
					<input type="email" name="ip" class="form-control" placeholder="机器ip" value="<?php echo isset($machine) && is_object($machine) ? $machine->ip : ''; ?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label"><span class="text-danger"> * </span>Sphinx<br>安装目录</label>
				<div class="col-sm-4">
					<input type="text" name="sphinx_path" class="form-control" placeholder="sphinx安装目录" value="<?php echo isset($machine) && is_object($machine) ? $machine->sphinx_path : ''; ?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label"><span class="text-danger"></span>备注信息</label>
				<div class="col-sm-4">
					<input type="text" name="comment" class="form-control" placeholder="备注" value="<?php echo isset($machine) && is_object($machine) ? $machine->comment : ''; ?>">
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
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel-body">
				<form class="form-horizontal" method="post" action="<?php echo URL::site('profile/modifypass'); ?>">
					<div class="form-group">
						<label class="col-md-1 control-label"><span class="text-danger"> * </span> 当前密码 </label>
						<div class="col-md-4">
							<input class="form-control" type="hidden" name="account_id"
							       value="<?php echo $accountId ? $accountId : ''; ?>"/>
							<input class="form-control" type="password" name="old_password" value=""
							       placeholder="输入当前密码"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-1 control-label"><span class="text-danger"> * </span> 新密码 </label>
						<div class="col-md-4">
							<input class="form-control" type="password" name="new_password" value=""
							       placeholder="输入新密码"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-1 control-label"><span class="text-danger"> * </span> 确认密码 </label>
						<div class="col-md-4">
							<input class="form-control" type="password" name="renew_password" value=""
							       placeholder="重新输入新密码"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-1 col-md-10">
							<button type="button" value="保存" name="submit" class="btn btn-success" onclick="Form.ajaxSubmit(this.form)">保存</button>
						</div>
					</div>
				</form>
			</div>
			<hr>
		</div>
	</div>
</div>
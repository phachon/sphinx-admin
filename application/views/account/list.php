<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel-body" style="padding: 15px 0;">
				<ul class="nav nav-tabs">
					<li class="active"><a href="<?php echo URL::site('account/list');?>">用户列表</a></li>
					<li><a href="<?php echo URL::site('account/add');?>">添加用户</a></li>
				</ul>
			</div>
			<div class="panel-body">
				<div class="row">
					<form>
						<div class="col-md-3 col-lg-offset-9">
							<div class="input-group">
								<input class="form-control" type="text" value="<?php echo Arr::get($_GET, 'keyword', '');?>" placeholder="用户名/account_id" name="keyword">
                  <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i></button>
                  </span>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
						<tr>
							<th class="w8p">id</th>
							<th class="w18p">用户名</th>
							<th class="w18p">邮箱</th>
							<th class="w13p">手机</th>
							<th class="w10p">角色</th>
							<th class="w15p">创建时间</th>
							<th class="w15p">操作</th>
						</tr>
						</thead>
						<tbody>
						<?php foreach ($accounts as $account) { ?>
							<tr>
							<td class="center"><?php echo $account->account_id;?></td>
							<td><?php echo $account->name;?></td>
							<td><?php echo $account->email;?></td>
							<td><?php echo $account->mobile;?></td>
							<td class="center"><?php echo $account->getRoleName()?></td>
							<td class="center"><?php echo date('Y-m-d H:i:s', $account->create_time);?></td>
							<td class="center">
								<a name="edit" data-link="<?php echo URL::site('account/edit?account_id='. $account->account_id);?>"><i class="glyphicon glyphicon-pencil"> </i>修改</a>
								<?php if($account->status == Model_Account::STATUS_NORMAL) { ?>
									<a name="remove" onclick="Common.confirm('确认要屏蔽吗？', '<?php echo URL::site('account/disable?account_id='. $account->account_id);?>')"><i class="glyphicon glyphicon-remove"></i>屏蔽</a>
								<?PHP }else { ?>
									<a name="review" onclick="Common.confirm('确定要恢复吗？', '<?php echo URL::site('account/review?account_id='. $account->account_id);?>')" data-link="#" ><i class="glyphicon glyphicon-ok"> </i>恢复</a>
								<?php } ?>
							</td>
						</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="panel-footer">
					<div class="row">
						<div class="col-md-8 m-pagination" id="paginator">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var pageData = [];
	pageData.push(<?php echo $paginate->pageData();?>);
	Common.paginator("#paginator", pageData);
	Account.bindFancyBox();
</script>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel-body" style="padding: 15px 0;">
				<ul class="nav nav-tabs">
					<li class="active"><a href="<?php echo URL::site('machine/list');?>" >机器列表</a></li>
					<li><a href="<?php echo URL::site('machine/add');?>" >添加机器</a></li>
				</ul>
			</div>
			<div class="panel-body">
				<div class="row">
					<form>
						<div class="col-md-3 col-lg-offset-9">
							<div class="input-group">
								<input class="form-control" type="text" value="<?php echo Arr::get($_GET, 'keyword', '');?>" placeholder="域名/IP" name="keyword">
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
							<th class="w25p">域名</th>
							<th class="w18p">ip</th>
							<th class="w20p">sphinx路径</th>
							<th class="w20p">备注</th>
							<th class="w15p">操作</th>
						</tr>
						</thead>
						<tbody>
						<?php if($machines->count()) {
							foreach ($machines as $machine) { ?>
								<tr>
									<td class="center"><?php echo $machine->machine_id;?></td>
									<td><?php echo $machine->domain;?></td>
									<td class="center"><?php echo $machine->ip;?></td>
									<td><?php echo $machine->sphinx_path;?></td>
									<td class="center"><?php echo $machine->comment;?></td>
									<td class="center">
										<a name="edit" data-link="<?php echo URL::site('machine/edit?machine_id='. $machine->machine_id);?>"><i class="glyphicon glyphicon-pencil"> </i>修改</a>
										<a name="remove" onclick="Common.confirm('确认要删除吗？', '<?php echo URL::site('machine/delete?machine_id='. $machine->machine_id);?>')"><i class="glyphicon glyphicon-remove"></i>删除</a>
									</td>
								</tr>
							<?php }
						}?>
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
	Machine.bindFancyBox();
</script>
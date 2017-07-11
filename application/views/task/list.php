<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel-body">
				<div class="row">
					<form method="get" action="<?php echo URL::site('task/list');?>">
						<div class="col-md-9"></div>
						<div class="col-md-3">
							<div class="input-group">
								<input class="form-control" type="text" value="<?php echo Arr::get($_GET, 'keyword');?>" placeholder="实例/service_id" name="keyword">
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
							<th class="w8p">task_id</th>
							<th class="w10p">ip</th>
							<th class="w10p">实例id</th>
							<th class="w10p">执行</th>
							<th class="w10p">结果</th>
							<th>回调信息</th>
							<th class="w13p">时间</th>
						</tr>
						</thead>
						<tbody>
						<?php if(is_object($tasks) && $tasks->count()) {
							foreach ($tasks as $task) { ?>
							<tr>
								<td class="center"><?php echo $task->task_id;?></td>
								<td class="center"><?php echo $task->ip;?></td>
								<td class="center"><?php echo $task->service_id;?></td>
								<td class="center"><?php echo $task->getTypeText();?></td>
								<td class="center"><?php echo $task->getExecStatusSpan();?></td>
								<td class="center"><?php echo $task->exec_results;?></td>
								<td class="center"><?php echo date('Y-m-d H:i:s', $task->create_time);?></td>
							</tr>
						<?php
							}
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
</script>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel-body" style="padding: 15px 0;">
				<ul class="nav nav-tabs">
					<li class="active"><a href="<?php echo URL::site('log/list');?>">系统日志</a></li>
					<li><a href="<?php echo URL::site('log/crash');?>">异常日志</a></li>
				</ul>
			</div>
			<div class="panel-body">
				<div class="row">
					<form method="get" action="<?php echo URL::site('log/list');?>">
						<div class="col-md-4">
<!--							<div class="input-group">-->
<!--								<div class="btn-group">-->
<!--									<a type="button" class="btn btn-default disabled" href="javascript:;">日志条数</a>-->
<!--									<button type="button" class="btn btn-default active">20</button>-->
<!--									<button type="button" class="btn btn-default">50</button>-->
<!--									<button type="button" class="btn btn-default">80</button>-->
<!--									<button type="button" class="btn btn-default">100</button>-->
<!--									<a type="button" class="btn btn-default disabled" href="javascript:;">条</a>-->
<!--								</div>-->
<!--							</div>-->
						</div>
						<div class="col-md-5"></div>
						<div class="col-md-3">
							<div class="input-group">
								<input class="form-control" name="keyword" type="text" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>" placeholder="日志描述/用户名"/>
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
				<table class="table table-bordered table-hover">
					<thead>
					<tr>
						<th class="w5p">ID</th>
						<th class="w10p">帐号</th>
						<th class="w40p">描述</th>
						<th class="w10p">IP</th>
						<th class="w15p">时间</th>
					</tr>
					</thead>
					<tbody>
					<?php
					if(is_object($logs) && $logs->count()) {
						foreach($logs as $log) {
							?>
							<tr class="gradeX">
								<td class="center"><?php echo $log->getLogSystemId(); ?></td>
								<td class="center"><?php echo $log->getAccountName(); ?></td>
								<td><?php echo $log->getMessage(); ?></td>
								<td class="center"><?php echo $log->getIp(); ?></td>
								<td class="center"><?php echo date('Y-m-d H:i:s', $log->getCreateTime()); ?></td>
							</tr>
							<?php
						}
					}
					?>
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
	pageData.push(<?php echo $pagination->pageData();?>);
	Common.paginator("#paginator", pageData);
</script>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel-body" style="padding: 15px 0;">
				<ul class="nav nav-tabs">
					<li><a href="<?php echo URL::site('log/list');?>">系统日志</a></li>
					<li class="active"><a href="<?php echo URL::site('log/crash');?>">异常日志</a></li>
				</ul>
			</div>
			<div class="panel-body">
				<div class="row">
					<form action="<?php echo URL::site('log/crash');?>" method="get">
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
								<input class="form-control" name="keyword" type="text" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>" placeholder="文件名/IP/主机"/>
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
							<th class="w10p">等级</th>
							<th class="w50p">文件</th>
							<th class="w20p">主机</th>
							<th class="w15p">时间</th>
						</tr>
						</thead>
						<tbody>
						<?php
						if(is_object($crashLogs)) {
							foreach($crashLogs as $crashLog) {
								?>
								<tr class="gradeX">
									<td class="center"><?php echo $crashLog->getLogCrashId(); ?></td>
									<td><?php echo $crashLog->getLevel(); ?></td>
									<td>
										<a data-toggle="collapse" data-target="#<?php echo $crashLog->getLogCrashId();?>"><?php echo $crashLog->getFile(); ?></a>
										<div id="<?php echo $crashLog->getLogCrashId();?>" class="collapse"><strong><?php echo $crashLog->getMessage(); ?></strong></div>
									</td>
									<td class="center">
										<a data-toggle="collapse" data-target="#host_<?php echo $crashLog->getLogCrashId();?>"><?php echo $crashLog->getHostname(); ?></a>
										<div id="host_<?php echo $crashLog->getLogCrashId();?>" class="collapse"><strong><?php echo $crashLog->getIp();?>
									</td>
									<td class="center"><?php echo date('Y-m-d H:i:s', $crashLog->getCreateTime()); ?></td>
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
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel-body" style="padding: 15px 0;">
				<ul class="nav nav-tabs">
					<li class="active"><a href="<?php echo URL::site('service/list');?>">实例列表</a></li>
					<li><a href="<?php echo URL::site('service/add');?>">添加实例</a></li>
				</ul>
			</div>
			<div class="panel-body">
				<div class="row">
					<form>
<!--						<div class="col-md-2">-->
<!--							<div class="form-group text-left">-->
<!--								<button type="button" class="btn btn-primary"><i class="glyphicon glyphicon-refresh"></i> 重载服务</button>-->
<!--							</div>-->
<!--						</div>-->
						<div class="col-md-9"></div>
						<div class="col-md-3">
							<div class="input-group">
								<input class="form-control" type="text" value="" placeholder="服务名称" name="keyword">
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
							<th class="w5p">id</th>
							<th class="w10p">实例名</th>
							<th class="w20p">部署机器</th>
							<th class="w8p">数据源名</th>
							<th class="w8p">数据源类型</th>
							<th class="w8p">状态</th>
							<th class="w15p">操作</th>
						</tr>
						</thead>
						<tbody>
						<?php if(is_object($services) && $services->count()) {
							foreach ($services as $service) { ?>
								<tr>
									<td class="center"><?php echo $service->service_id;?></td>
									<td class="center"><?php echo $service->name;?></td>
									<td><?php echo $service->getMachineName();?></td>
									<td class="center"><a data-link="<?php echo URL::site('service/info?service_id='.$service->service_id);?>" name="source_info"><?php echo $service->source_name;?></a></td>
									<td class="center"><a data-link="<?php echo URL::site('service/info?service_id='.$service->service_id);?>" name="source_info"><?php echo $service->source_type;?></a></td>
									<td class="center"><?php echo $service->getStatusSpan();?></td>
									<td class="center">
										<a data-link="<?php echo URL::site('service_column/config?service_id='.$service->service_id);?>" name="service_config"><i class="glyphicon glyphicon-cog"></i> 配置</a>
										<a data-link="<?php echo URL::site('service/edit?service_id='.$service->service_id);?>" name="edit"><i class="glyphicon glyphicon-pencil"></i> 修改</a>
										<?php if($service->status == Model_Service::STATUS_STOP) { ?>
											<a onclick="Common.confirm('确定要启动吗？', '<?php echo URL::site('service/start?service_id='. $service->service_id);?>')"><i class="glyphicon glyphicon-ok-circle"></i> 启动</a>
										<?php }elseif($service->status == Model_Service::STATUS_START) { ?>
											<a onclick="Common.confirm('确定要关闭吗？', '<?php echo URL::site('service/stop?service_id='. $service->service_id);?>')"><i class="glyphicon glyphicon-off"></i> 关闭</a>
										<?php } ?>
										<a onclick="Common.confirm('确定要删除吗？', '<?php echo URL::site('service/delete?service_id='. $service->service_id);?>')"><i class="glyphicon glyphicon-remove"></i> 删除</a>
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
	Service.bindFancyBox();
</script>
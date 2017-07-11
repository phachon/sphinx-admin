<div class="panel panel-default">
	<div class="panel-body">
		<ul class="nav nav-tabs">
			<li><a href="<?php echo URL::site('service_column/config?service_id='.$serviceId)?>">Column</a></li>
			<li class="active"><a href="<?php echo URL::site('service_indexer/config?service_id='.$serviceId)?>">Indexer</a></li>
			<li><a href="<?php echo URL::site('service_searchd/config?service_id='.$serviceId)?>">Searchd</a></li>
		</ul>
	</div>
	<div class="panel-body">
		<div class="panel-body">
			<div class="row">
				<form action="<?php echo URL::site('service_indexer/save')?>" method="post">
					<div class="col-md-3">
						<div class="input-group">
							<span class="input-group-addon">索引类型</span>
							<select class="form-control" name="type">
								<option value="rt">rt</option>
								<option value="distributed">distributed</option>
								<option value="plain">plain</option>
							</select>
						</div>
					</div>
					<input class="form-control" name="service_id" type="hidden" value="<?php echo isset($serviceId) ? $serviceId : 0;?>">
					<div class="col-md-4 col-lg-offset-9">
						<div class="input-group">
							<input class="form-control" name="name" type="text" value="" placeholder="索引名">
							<span class="input-group-btn">
								<button type="button" name="submit" onclick="Form.ajaxSubmit(this.form)" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> 添加</button>
							</span>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="panel panel-default">
			<table class="table table-bordered">
				<thead>
				<tr>
					<th class="w5p">#</th>
					<th class="w40p">索引名</th>
					<th>类型</th>
					<th>创建时间</th>
					<th>操作</th>
				</tr>
				</thead>
				<tbody>
				<?php if(is_object($serviceIndexer) && $serviceIndexer->count()) {
					foreach ($serviceIndexer as $serviceIndex) { ?>
					<tr>
						<td class="center"><?php echo $serviceIndex->service_indexer_id;?></td>
						<td class="center"><?php echo $serviceIndex->name;?></td>
						<td class="center"><?php echo $serviceIndex->type?></td>
						<td class="center"><?php echo date('Y-m-d H:i:s', $serviceIndex->create_time);?></td>
						<td class="center">
							<a name="edit" href="<?php echo URL::site('service_indexer/edit?service_indexer_id='. $serviceIndex->service_indexer_id);?>"><i class="glyphicon glyphicon-pencil"> </i>修改</a>
							<a name="delete" onclick="Common.confirm('确认要删除吗？', '<?php echo URL::site('service_indexer/delete?service_indexer_id='. $serviceIndex->service_indexer_id);?>')"><i class="glyphicon glyphicon-remove"></i>删除</a>
						</td>
					</tr>
				<?php
					}
				}?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	Service.Config.indexer();
</script>
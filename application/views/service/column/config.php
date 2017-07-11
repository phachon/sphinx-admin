<div class="panel panel-default">
	<div class="panel-body">
		<ul class="nav nav-tabs">
			<li class="active"><a href="<?php echo URL::site('service_column/config?service_id='.$serviceId)?>">Column</a></li>
			<li><a href="<?php echo URL::site('service_indexer/config?service_id='.$serviceId)?>">Indexer</a></li>
			<li><a href="<?php echo URL::site('service_searchd/config?service_id='.$serviceId)?>">Searchd</a></li>
		</ul>
	</div>
	<div class="panel-body">
		<div class="panel-body">
			<form class="form-horizontal" name="column_form" action="<?php echo URL::site('service_column/save');?>" method="post" onsubmit="return false">
				<input type="hidden" name="service_id" value="<?php echo isset($serviceId) ? $serviceId : 0;?>">
				<div class="form-group">
					<label class="text-danger">勾选所需要索引的字段，并选择文档 id（必选）</label>
					<div class="panel panel-default">
						<table class="table table-bordered">
							<thead>
							<tr>
								<th class="w5p">
									<input type="checkbox" name="column_all_select" value="">
								</th>
								<th class="w20p">字段</th>
								<th>属性</th>
								<th class="w8p">文档id</th>
							</tr>
							</thead>
							<tbody>
							<?php if(count($sourceColumns)) {
								foreach ($sourceColumns as $sourceColumn) { ?>
									<tr>
										<td class="center">
											<input type="checkbox" name="column_select" value="<?php echo $sourceColumn;?>">
										</td>
										<td class="center"><?php echo $sourceColumn;?></td>
										<td class="div-center">
											<div class="w50p center" style="margin: 0 auto">
												<select class="form-control input-sm" data-target="<?php echo $sourceColumn;?>">
													<option value="">-- --</option>
													<option value="sql_attr_uint">sql_attr_uint(无符号整形)</option>
													<option value="sql_attr_bigint">sql_attr_bigint(长整型)</option>
													<option value="sql_attr_string">sql_field_string(字符串)</option>
													<option value="sql_attr_bool">sql_attr_bool(布尔型)</option>
													<option value="sql_attr_timestamp">sql_attr_timestamp(时间戳)</option>
													<option value="sql_attr_float">sql_attr_float(浮点型)</option>
												</select>
											</div>
										</td>
										<td class="div-center">
											<div class="w50p center" style="margin: 0 auto">
												<input type="radio" data-target="<?php echo $sourceColumn;?>" name="is_id_column">
											</div>
										</td>
									</tr>
							<?php	}
							}?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="form-group">
					<label class="text-danger">条件语句（非必填）</label>
					<input type="text" class="form-control w80p" name="sql_condition" value="" placeholder="查询条件语句">
				</div>
				<div class="form-group">
					<button class="btn btn-success" name="column_submit" type="button">保存</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	Service.Config.column(<?php echo $serviceColumns;?>);
</script>
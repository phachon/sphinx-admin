<div class="panel panel-default">
	<div class="panel-body">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#column">Column</a></li>
			<li><a href="">Indexer</a></li>
			<li><a href="">Searchd</a></li>
		</ul>
	</div>
	<div class="panel-body">
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="column">
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
														<option value="sql_attr_string">sql_attr_string(字符串)</option>
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
						<label class="text-danger">join 语句（非必填）</label>
						<input type="text" class="form-control w80p" name="sql_joined_field" value="" placeholder="join 语句">
					</div>
					<div class="form-group">
						<button class="btn btn-success" name="column_submit" type="button">保存</button>
					</div>
				</form>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="indexer">
				<div class="panel-body">
					<div class="row">
						<form>
							<div class="col-md-3">
								<div class="input-group">
									<span class="input-group-addon">索引类型</span>
									<select class="form-control" name="type">
										<option value="">rt</option>
										<option value="">distributed</option>
										<option value="">plain</option>
									</select>
								</div>
							</div>
							<div class="col-md-4 col-lg-offset-9">
								<div class="input-group">
									<input class="form-control" type="text" value="" placeholder="索引名" name="keyword">
                  <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> 添加</button>
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
						</tr>
						</thead>
						<tbody>
						<tr>
							<td class="center">1</td>
							<td class="center">video_main</td>
							<td class="center">rt</td>
							<td class="center">2017-03-19 08:12:12</td>
						</tr>
						<tr>
							<td class="center">2</td>
							<td class="center">video_main</td>
							<td class="center">rt</td>
							<td class="center">2017-03-19 08:12:12</td>
						</tr>
						<tr>
							<td class="center">3</td>
							<td class="center">video_main</td>
							<td class="center">rt</td>
							<td class="center">2017-03-19 08:12:12</td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="searchd">
				<form class="form-horizontal">
					<div class="form-group">
						<label class="col-sm-2 control-label"><span class="text-danger"> * </span>sphinx连接端口</label>
						<div class="col-sm-4">
							<input type="text" name="sphinx_listen" class="form-control" placeholder="sphinx连接端口" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"><span class="text-danger"> * </span>mysql连接端口</label>
						<div class="col-sm-4">
							<input type="text" name="mysql_listen" class="form-control" placeholder="mysql连接端口" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"><span class="text-danger"> * </span>客户端读超时时间</label>
						<div class="col-sm-4">
							<input type="text" name="read_timeout" class="form-control" placeholder="客户端读超时时间" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"><span class="text-danger"> * </span>客户端超时时间</label>
						<div class="col-sm-4">
							<input type="text" name="client_timeout" class="form-control" placeholder="客户端读超时时间" required>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" onclick="" class="btn btn-success">保存</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	Service.Config();
</script>
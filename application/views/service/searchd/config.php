<div class="panel panel-default">
	<div class="panel-body">
		<ul class="nav nav-tabs">
			<li><a href="<?php echo URL::site('service_column/config?service_id='.$serviceId)?>">Column</a></li>
			<li><a href="<?php echo URL::site('service_indexer/config?service_id='.$serviceId)?>">Indexer</a></li>
			<li class="active"><a href="<?php echo URL::site('service_searchd/config?service_id='.$serviceId)?>">Searchd</a></li>
		</ul>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" action="<?php echo URL::site('service_searchd/save')?>" method="post">
			<input type="hidden" name="service_searchd_id" value="<?php echo is_object($serviceSearchd) ? $serviceSearchd->service_searchd_id : 0;?>"/>
			<input type="hidden" name="service_id" value="<?php echo isset($serviceId) ? $serviceId : 0;?>"/>
			<div class="form-group">
				<label class="col-sm-2 control-label"><span class="text-danger"> * </span>sphinx连接端口</label>
				<div class="col-sm-4">
					<input type="text" name="sphinx_listen" class="form-control" placeholder="sphinx连接端口" required value="<?php echo is_object($serviceSearchd) ? $serviceSearchd->sphinx_listen : '';?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label"><span class="text-danger"> * </span>mysql连接端口</label>
				<div class="col-sm-4">
					<input type="text" name="mysql_listen" class="form-control" placeholder="mysql连接端口" required value="<?php echo is_object($serviceSearchd) ? $serviceSearchd->mysql_listen : '';?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label"><span class="text-danger"> * </span>客户端读超时时间</label>
				<div class="col-sm-4">
					<input type="text" name="read_timeout" class="form-control" placeholder="客户端读超时时间" required value="<?php echo is_object($serviceSearchd) ? $serviceSearchd->read_timeout : '';?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label"><span class="text-danger"> * </span>客户端超时时间</label>
				<div class="col-sm-4">
					<input type="text" name="client_timeout" class="form-control" placeholder="客户端读超时时间" required value="<?php echo is_object($serviceSearchd) ? $serviceSearchd->client_timeout : '';?>">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="button" name="submit" onclick="Form.ajaxSubmit(this.form, true)" class="btn btn-success">保存</button>
				</div>
			</div>
		</form>
	</div>
</div>
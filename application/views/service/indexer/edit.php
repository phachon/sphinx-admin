<div class="panel panel-default">
	<div class="panel-body">
		<ul class="nav nav-tabs">
			<li><a href="<?php echo URL::site('service_column/config?service_id='.$serviceIndexer->service_id)?>">Column</a></li>
			<li class="active"><a href="<?php echo URL::site('service_indexer/config?service_id='.$serviceIndexer->service_id)?>">Indexer</a></li>
			<li><a href="<?php echo URL::site('service_searchd/config?service_id='.$serviceIndexer->service_id)?>">Searchd</a></li>
		</ul>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" action="<?php echo URL::site('service_indexer/modify')?>" method="post">
			<input type="hidden" name="service_indexer_id" class="form-control" value="<?php echo is_object($serviceIndexer) ? $serviceIndexer->service_indexer_id : 0;?>">
			<input type="hidden" name="service_id" class="form-control" value="<?php echo is_object($serviceIndexer) ? $serviceIndexer->service_id : 0;?>">
			<div class="form-group">
				<label class="col-sm-1 control-label"><span class="text-danger"> * </span>索引名</label>
				<div class="col-sm-4">
					<input type="text" name="name" class="form-control" placeholder="索引名" value="<?php echo is_object($serviceIndexer) ? $serviceIndexer->name : '';?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-1 control-label"><span class="text-danger"> * </span>索引类型</label>
				<div class="col-sm-4">
					<select class="form-control" name="type">
						<option value="rt" <?php echo (is_object($serviceIndexer) && $serviceIndexer->type == 'rt') ? 'selected' : '';?>>rt</option>
						<option value="distributed" <?php echo (is_object($serviceIndexer) && $serviceIndexer->type == 'distributed') ? 'selected' : '';?>>distributed</option>
						<option value="plain" <?php echo (is_object($serviceIndexer) && $serviceIndexer->type == 'plain') ? 'selected' : '';?>>plain</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-1 col-sm-10">
					<button type="button" name="submit" onclick="Form.ajaxSubmit(this.form)" class="btn btn-success">保存</button>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	Service.Config.indexer();
</script>
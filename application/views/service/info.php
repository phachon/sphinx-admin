<div class="panel panel-default">
	<div class="panel-body">
		<div class="table-responsive">
			<?php
			if (isset($service) && is_object($service)) {
			?>
			<table class="table table-bordered table-hover">
				<tr>
					<th class="w15p right">数据源名</th>
					<td class="left"><?php echo $service->getSourceName();?></td>
				</tr>
				<tr>
					<th class="w15p right">sql_host</th>
					<td class="left"><?php echo $service->getSqlHost();?></td>
				</tr>
				<tr>
					<th class="w15p right">sql_port</th>
					<td class="left"><?php echo $service->getSqlPort();?></td>
				</tr>
				<tr>
					<th class="w15p right">sql_user</th>
					<td class="left"><?php echo $service->getSqlUser();?></td>
				</tr>
				<tr>
					<th class="w15p right">sql_pass</th>
					<td class="left"><?php echo $service->getSqlPass(); ?></td>
				</tr>
				<tr>
					<th class="w15p right">sql_db</th>
					<td class="left"><?php echo $service->getSqlDb();?></td>
				</tr>
				<tr>
					<th class="w15p right">sql_table</th>
					<td class="left"><?php echo $service->getSqlTable();?></td>
				</tr>
				<tr>
					<th class="w15p right">sql_charset</th>
					<td class="left"><?php echo $service->getSqlCharset(); ?></td>
				</tr>
				<tr>
					<th class="w15p right">分表数</th>
					<td class="left"><?php echo $service->getSourceNumber();?></td>
				</tr>
				<tr>
					<th class="w15p right">创建时间</th>
					<td class="left"><?php echo date('Y-m-d H:i:s', $service->getCreateTime());?></td>
				</tr>
				<tr>
					<th class="w15p right">更新时间</th>
					<td class="left"><?php echo date('Y-m-d H:i:s', $service->getUpdateTime());?></td>
				</tr>
			</table>
				<?php
			}
			?>
		</div>
	</div>
</div>
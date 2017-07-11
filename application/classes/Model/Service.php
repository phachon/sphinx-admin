<?php
/**
 * 数据模型 - 实例
 * @author: panchao
 */
class Model_Service extends Model_Base {

	const STATUS_DELETE = -1;
	const STATUS_STOP = 0;
	const STATUS_START = 1;
	const STATUS_WAIT = 2;
	
	/**
	 * service name
	 * @return string
	 */
	public function getMachineName() {
		$machine = Business::factory('Machine')->getMachineByMachineId($this->machine_id);
		return $machine->current()->domain . "(".$machine->current()->ip.")";
	}

	/**
	 * 状态 span
	 */
	public function getStatusSpan() {
		if($this->status == self::STATUS_START) {
			return "<span class='label label-success'>运行</span>";
		}
		if($this->status == self::STATUS_STOP) {
			return "<span class='label label-danger'>停止</span>";
		}
		if($this->status == self::STATUS_DELETE) {
			return "<span class='label label-danger'>删除</span>";
		}
		if($this->status == self::STATUS_WAIT) {
			return "<span class='label label-info'>执行中</span>";
		}

		return $this->status;
	}
}
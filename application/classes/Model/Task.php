<?php
/**
 * 数据模型 - 任务
 * @author: phachon@163.com
 */
class Model_Task extends Model_Base {

	const EXEC_STATUS_DEFAULT = 0;
	const EXEC_STATUS_SUCCESS = 1;
	const EXEC_STATUS_FAILED = -1;

	const TYPE_DEFAULT = 0;
	const TYPE_START = 1;
	const TYPE_STOP = 2;
	const TYPE_REBUILD = 3;

	/**
	 * 状态label
	 */
	public function getExecStatusSpan() {
		if($this->exec_status == self::EXEC_STATUS_FAILED) {
			return "<span class='label label-danger'>执行失败</span>";
		}
		if($this->exec_status == self::EXEC_STATUS_SUCCESS) {
			return "<span class='label label-success'>执行成功</span>";
		}
		if($this->exec_status == self::EXEC_STATUS_DEFAULT) {
			return "<span class='label label-info'>正在执行</span>";
		}
		return $this->exec_status;
	}

	/**
	 * 执行类型 text
	 */
	public function getTypeText() {
		if($this->type == self::TYPE_DEFAULT) {
			return "<label class='text-info'>无</label>";
		}
		if($this->type == self::TYPE_REBUILD) {
			return "<label class='text-primary'>重建</label>";
		}
		if($this->type == self::TYPE_START) {
			return "<label class='text-success'>启动</label>";
		}
		if($this->type == self::TYPE_STOP) {
			return "<label class='text-danger'>停止</label>";
		}

		return $this->type;
	}
}
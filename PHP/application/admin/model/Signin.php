<?php

namespace app\admin\model;

use think\Model;

class Signin extends Model
{
	public function getYesAttr($value) {
		return unserialize($value);
	}
	public function setYesAttr($value) {
		return serialize($value);
	}
	public function setLateAttr($value) {
		return serialize($value);
	}
	public function getLateAttr($value) {
		return unserialize($value);
	}
	public function setKuangkeAttr($value) {
		return serialize($value);
	}
	public function getKuangkeAttr($value) {
		return unserialize($value);
	}
	// 开启时间戳字段
	protected $autoWriteTimestamp = true;
	// 设置数据表字段映射
	protected $createTime = 'date';
	// 不适用修改时间
	protected $updateTime = false;
	// 时间戳转化成2015-05-16这种形式
	public function getDateAttr($value) {
		return date('Y-m-d', $value);
	}
	/**
	 * 检查今天是否存在签到
	 */
	public static function checkToday(){
		return self::get(function($query){
			// 时间在今天0点到12点之间
			$today = time();
			$tomorrow = strtotime('+1 day');
			$query->where('date', 'between', [$today, $tomorrow]);
		});
	}


}

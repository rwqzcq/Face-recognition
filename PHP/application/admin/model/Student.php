<?php
namespace app\admin\model;
use think\Model;
class Student extends Model {
	/**
	 * 查询学生，可以在范围之内或者不在范围之内
	 */
	public static function getStuByIn($ids = [], $flag = true) {
		if(!is_array($ids)) {
			return false;
		}
		return self::all(function($query)use($ids, $flag){
			$in = $flag == true ? 'in' : 'not in';
			// 字段名, 表达式，查询条件
			$query->where('id', $in, $ids)->field('*');
		});
	}	
}
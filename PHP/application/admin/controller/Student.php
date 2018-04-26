<?php
namespace app\admin\controller;

use think\Request;
use think\Session;
use app\admin\controller\Base;
use app\admin\model\Student as Model;
use face\Client;
class Student extends Base {
	public function _initialize() {
		parent::_initialize();
		header("Content-type:text/html;charset=utf-8");
		$this->model = new Model;
	}
	public function index() {
		$this->view->assign('title', '学生列表');
		$students = Model::all();
		$this->view->assign('lists', $students);
		return $this->view->fetch();
	}	




	/**
	 * 下面的代码已经废弃
	 * 批量添加数据
	 * 前期准备使用
	 */
	public function insertAll() {
		die;
		$student = [
		    ['name' => '陈煌毅', 'id' => 211706702, 'img' => '211706702.jpg'],
		    ['name' => '陈柳杰', 'id' => 211706704, 'img' => '211706704.jpg'],
		    // 在这个下面写代码
		    ['name' => '陈思超', 'id' => 211706705, 'img' => '211706705.jpg'],
		    ['name' => '高成茁', 'id' => 211706706, 'img' => '211706706.jpg'],
		    ['name' => '黄天春', 'id' => 211706707, 'img' => '211706707.jpg'],
		    ['name' => '纪泽斌', 'id' => 211706708, 'img' => '211706708.jpg'],
		    ['name' => '江瑞洁', 'id' => 211706709, 'img' => '211706709.jpg'],
		    ['name' => '李博涵', 'id' => 211706710, 'img' => '211706710.jpg'],
		    ['name' => '李惠强', 'id' => 211706711, 'img' => '211706711.jpg'],
		    ['name' => '李秋菊', 'id' => 211706712, 'img' => '211706712.jpg'],
		    ['name' => '林凯亮', 'id' => 211706713, 'img' => '211706713.jpg'],
		    
		    
			];
			
		$arr = [
		    211706714 => 	'林锐旸',
		    211706715	=> '林伟',
		    211706716	=> '林泽',
		    211706717	=> '卢翔骏',
		    211706718	=> '麦熠熠',
		    211706719	=> '商天成',
		    211706720  => '宋恒杰',
		    211706721  => '王志斌',
		    211706722	 => '魏婕',
		    211706723	 => '吴敬隆',
		    211706725  => '吴志翔',
			    
			211706726	=> '肖嘉敏',
			211706727	=> '曾坚煌',

			211706728	 => '曾译新',
			211706729	=> '张璟胜',
			211706730	=> '张舒媛'
		];
		array_walk($arr, function($value, $key)use(&$student){
			$student[] = ['name' => $value, 'id' => $key, 'img' => strval($key).'.jpg'];
		});
		// dump($student);
		// 带了主键，所以用false
		if($this->model->saveAll($student, false)) {
			echo 2;
		}
	}
}
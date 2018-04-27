<?php
namespace app\admin\controller;

use think\Request;
use think\Session;
use app\admin\controller\Base;
use app\admin\model\Student as Model;
use think\Validate;
use face\Client;
class Student extends Base {
	public function _initialize() {
		parent::_initialize();
		header("Content-type:text/html;charset=utf-8");
		$this->model = new Model;
	}
	/**
	 * 显示系统的首页
	 */
	public function index() {
		$where = [];
		$request = Request::instance();
		if($request->has('name', 'get')) {
			$name = $request->param('name');
			$where['name'] = ['like', "%{$name}%"];
		}
		$this->view->assign('title', '学生列表');
		$students = Model::all(function($query)use($where){
			$query->where($where);
		});
		$count = Model::count();
		$this->view->assign('count', $count);
		$this->view->assign('lists', $students);
		return $this->view->fetch();
	}	
	/**
	 * 显示学生添加的页面
	 */
	public function create() {
		$this->view->assign('title', '学生添加');
		return $this->view->fetch();
	}
	/**
	 * 保存更新的资源
	 */
	public function save(Request $request) {
		if($request->isPost()) {
			$data = $request->param();
			$id = $data['id'];
			$student = Model::get($id);
			if($student != null) {
				return $this->error('学号已经存在');
			}
			/* 数据验证 */
			$validate = new Validate(['id' => 'number|require', 'name' => 'require', ]);
			if (!$validate->check($data)) {
				return $this->error($validate->getError());
			}
			// 处理文件上传
			$file = $request->file('img');
			if($file != null){				
				$info = $file->move(ROOT_PATH . 'public' . DS . 'static'.DS.'uploads');
				if($info) {
					$data['img'] = $info->getSaveName();
				} else {
					return $this->error('图片上传失败!');
				}
			} else {
				return $this->error('没有上传图片');
			}
			if(Model::create($data)) {
				return $this->success('新增成功', 'index');
			} else {
				return $this->error('增加失败!');
			}	 
		} else {
			return $this->error('非法请求');
		}		
	}
	public function edit($id) {
		$this->view->assign('title', '学生信息修改');
		$this->view->assign('id', $id);
		$student = Model::get(intval($id));
		if($student == null) {
			return $this->error('没有学生信息');
		}
		$this->view->assign('student', $student);
		return $this->view->fetch();
	}	
	/**
	 * 更新数据
	 */
	public function update(Request $request, $id) {
		if($request->isPost()) {
			if(!is_numeric($id)) {
				return $this->error('学号错误');
			}
			$student = Model::get($id);
			if($student == null) {
				return $this->error('没有学生信息');
			}
			$name = $request->param('name', '', 'trim');
			$student->name = $name;
			// 处理文件上传
			$file = $request->file('img');
			if($file != null){
				$info = $file->move(ROOT_PATH . 'public' . DS . 'static'.DS.'uploads');
				if($info) {
					$student->img = $info->getSaveName();
				} else {
					return $this->error('图片上传失败!');
				}
			}
			if($student->save()) {
				return $this->success('修改成功', 'index');
			} else {
				return $this->error('修改失败!');
			}	 
		} else {
			return $this->error('非法请求');
		}
	}
	/**
	 * 删除
	 */
	public function delete($id) {
		if(!is_numeric($id)) {
			return $this->error('请求错误');
		}
		$student = Model::get($id);
		if($student == null) {
			return $this->error('学生信息不存在');
		}
		if($student->delete()) {
			return $this->success('删除成功');
		} else {
			return $this->error('删除失败');
		}
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
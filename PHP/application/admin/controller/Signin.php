<?php
namespace app\admin\controller;
use think\Request;
use think\Session;
use app\admin\controller\Base;
use app\admin\model\Signin as Model;
use app\admin\model\Student;
use face\Client;
/**
 * 签到控制器
 */
class Signin extends Base {
	public function _initialize() {
		header('Content-Type:text/html; charset=utf-8');
		parent::_initialize();
		$this->model = new Model;
	}
	/**
	 * 显示签到页面
	 */
	public function index() {
		return $this->view->fetch();
	}
	/**
	 * 进行签到
	 */
	public function doSignin(Request $request) {
		// if(!$request->isPost()) {
		// 	return $this->error('非法请求');
		// }
		// // 判断签到的时间 9:00 - 9:15
		// // if(date('H') == 9) {
		// // 	if(date('m') <= 15) {
		// // 		return $this->error('未到15分，不能签到');
		// // 	}
		// // } else {
		// // 	return $this->error('请在9点到9点15之间签到');
		// // }
		// // // 今天是否已经签到
		// if(Model::checkToday() != null) {
		// 	return $this->error('今天已经签到了!');
		// }
		
		// // 获取到上传的两张图片
    	// // 获取表单上传文件
		$files = $request->file('img');
		$file_path = [];
		foreach($files as $file){
			// 移动到框架应用根目录/public/uploads/ 目录下
			$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
			if($info){
				$save_name = $info->getSaveName();
				// http://localhost/index.php/admin/signin/uploads/20180426/d1e0f4d0ee8d81d9400a33da875861b5.jpg
			//	echo "<img src='./uploads/{$save_name}' />";
				$file_path[] = $info->getSaveName();
			}else{
				// 上传失败获取错误信息
				echo $file->getError();
			}    
		}
		$result = [];
		// 云端库进行进行比较
		foreach($file_path as $k => $file) {
			$face = json_decode(Client::m2n('./uploads/'.$file), true);
			file_put_contents('./'.$k.'.json', json_encode($face));
			// 没有出现人脸
			// 110 代表token过期
			if(!array_key_exists('error_code', $face)) {
				$result[]  = $face['result'];
			}		
		}
		if(!$result) {
			return $this->error('在上传的照片中没有找到任何一个相关学生,请检查上传的图片的合理性！');
		}	
		$uids = [];
		array_walk($result, function($v)use(&$uids){
			array_walk($v, function($one)use(&$uids){
				$uids[] = $one['uid'];
			});
		});
		// die;
		// $uids = Client::m2n();
		$yes = Student::getStuByIn($uids);
		$yes_num = count($yes);
		$yes_arr = [];
		$yes_name = []; // 签到人的姓名
		foreach ($yes as $key => $value) {
			$yes_arr[] = $value->id;
			$yes_name[] = $value->name;
		}
		$yes_name = implode('-', $yes_name);
		$kuangke = Student::getStuByIn($uids, false);
		$kuangke_arr = [];
		$kuangke_name = []; // 旷课人的姓名
		foreach ($kuangke as $key => $value) {
			$kuangke_arr[] = $value->id;
			$kuangke_name[] = $value->name;
		} 
		$kuangke_num = count($kuangke);
		$kuangke_name = implode('-', $kuangke_name);
		$id = '';
		if($id = Model::create(['yes' => $yes_arr, 'kuangke' => $kuangke_arr, 'late' => []])) {
			echo '<script>alert("识别成功!")</script>';
			return $this->redirect('detail', ['id' => $id, 'yes' => $yes_name, 'kuangke' => $kuangke_name]);
		} else {
			return $this->error('数据库写入失败!');
		}

	}
	/**
	 * 查看某次签到详情
	 * 本班一共有多少人 实到学生 旷课学生 
	 * http://localhost/index.php/admin/signin/detail/id/%7B%22yes%22%3A%5B211706702%2C211706704%2C211706705%2C211706709%2C211706713%2C211706714%2C211706715%2C211706716%2C211706717%2C211706719%2C211706720%2C211706721%2C211706722%2C211706723%2C211706725%2C211706727%2C211706728%2C211706729%2C211706730%5D%2C%22kuangke%22%3A%5B211706706%2C211706707%2C211706708%2C211706710%2C211706711%2C211706712%2C211706718%2C211706726%5D%2C%22late%22%3A%5B%5D%2C%22date%22%3A%222018-04-26%22%2C%22id%22%3A%227%22%7D/yes/%E9%99%88%E7%85%8C%E6%AF%85-%E9%99%88%E6%9F%B3%E6%9D%B0-%E9%99%88%E6%80%9D%E8%B6%85-%E6%B1%9F%E7%91%9E%E6%B4%81-%E6%9E%97%E5%87%AF%E4%BA%AE-%E6%9E%97%E9%94%90%E6%97%B8-%E6%9E%97%E4%BC%9F-%E6%9E%97%E6%B3%BD-%E5%8D%A2%E7%BF%94%E9%AA%8F-%E5%95%86%E5%A4%A9%E6%88%90-%E5%AE%8B%E6%81%92%E6%9D%B0-%E7%8E%8B%E5%BF%97%E6%96%8C-%E9%AD%8F%E5%A9%95-%E5%90%B4%E6%95%AC%E9%9A%86-%E5%90%B4%E5%BF%97%E7%BF%94-%E6%9B%BE%E5%9D%9A%E7%85%8C-%E6%9B%BE%E8%AF%91%E6%96%B0-%E5%BC%A0%E7%92%9F%E8%83%9C-%E5%BC%A0%E8%88%92%E5%AA%9B/kuangke/%E9%AB%98%E6%88%90%E8%8C%81-%E9%BB%84%E5%A4%A9%E6%98%A5-%E7%BA%AA%E6%B3%BD%E6%96%8C-%E6%9D%8E%E5%8D%9A%E6%B6%B5-%E6%9D%8E%E6%83%A0%E5%BC%BA-%E6%9D%8E%E7%A7%8B%E8%8F%8A-%E9%BA%A6%E7%86%A0%E7%86%A0-%E8%82%96%E5%98%89%E6%95%8F.html
	 */
	public function detail($id, $yes = '', $kuangke = '') {
		// if($yes == null || $kuangke == null) {
		// 	return $this->error('非法请求');
		// }
		if(!$yes && !$kuangke) {
			$detail = Model::get($id);
			if(!$detail) {
				return $this->error('不存在统计数据，请检查参数');
			} 
			$yes = Student::getStuByIn($detail->yes);
			$kuangke = Student::getStuByIn($detail->kuangke);
			$kuangke_name = []; // 旷课人的姓名
			foreach ($kuangke as $key => $value) {
				$kuangke_name[] = $value->name;
			} 
			$kuangke = $kuangke_name;
			unset($kuangke_name);
			$yes_name = []; // 签到人的姓名
			foreach ($yes as $key => $value) {
				$yes_name[] = $value->name;
			}	
			$yes = $yes_name;
			unset($yes_name);	
		} else {
			$yes = explode('-', $yes);
			$kuangke = explode('-', $kuangke);
		}
		$this->view->assign('yes', $yes);
		$this->view->assign('yes_amount', count($yes));
		$this->view->assign('kuangke', $kuangke);
		$this->view->assign('kuangke_amount', count($kuangke));
		return $this->view->fetch();
	}
	/**
	 * 查看总的签到详情
	 */
	public function count() {
		$this->view->assign('title', '签到详情');
		$signs = Model::all();
		$count = Model::count();
		$this->view->assign('count', $count);
		$this->view->assign('lists', $signs);
		return $this->view->fetch();
	}
}
<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Session;
use app\admin\model\Admin;
class Base extends Controller
{
    protected $model = null;
    protected function _initialize()
    {
        parent::_initialize();  //继承父类中的初始化操作
        $admin_info = '';
        Session::set('admin_id', 1);
        Session::set('admin_info', Admin::get(1));
        if(Session::get('admin_id')) {
          define('ADMIN_ID', Session::get('admin_id'));
          $admin_info = Session::get('admin_info');      
        } else {
          define('ADMIN_ID', null);
        }
        $this->assign('admin_info', $admin_info);        
    }
  
    //判断用户是否登录，放在后台的入口：admin/index
    protected function isLogin()
    {
        if (is_null(ADMIN_ID)) {
            $this -> error('用户未登录，无权访问',url('admin/login'));
        }
    }
  
    //防止用户重复登录 user/login
    protected function alreadyLogin()
    {
        if (!is_null(ADMIN_ID)) {
            $this -> error('用户已经登录，请勿重复登录',url('admin/index'));
        }
    }
}

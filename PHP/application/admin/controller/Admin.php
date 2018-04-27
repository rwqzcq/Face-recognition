<?php

namespace app\admin\controller;

use think\Controller;
use think\Session;
use think\Request;
use app\admin\controller\Base;
use app\admin\model\Admin as Model;
class Admin extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {   
        $this->isLogin();
        $this->view->assign('title', '后台管理首页');
        return $this->view->fetch();
    }

    /**
     * 显示创建资源表单页
     *
     * @return \think\Response
     */
    public function create()
    {
        $this->view->assign('title', '添加管理员');
        return $this->view->fetch();
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $adminmame = $request->param('admin', '', 'trim');
        // 检查是否存在
        if(Model::get(['adminname' => $adminmame])) {
            return $this->error('管理员已经存在');
        }
        if( Model::create([
            'adminname' => $request->param('admin', '', 'trim'),
            'password' => $request->param('password', '', 'trim'),
            ])) {
            return $this->success('添加成功');
        }
        return $this->error('添加失败');
    }
    /**
     * 显示更改密码的页面
     */
    public function showChange() {
        // 显示用户名
        $admin = Model::get(ADMIN_ID);
        $this->view->assign('title', '密码修改');
        $this->view->assign('adminname', $admin->adminname);
        return $this->view->fetch();
    }
    /**
     * 更改
     */
    public function doChange(Request $request) {
        $this->isLogin();
        $data = $request->param();
        if($data['password'] != $data['repassword']) {
            return $this->error('两次密码输入不一致');
        }
        if($data['password'] == '') {
            return $this->error('密码为空则不修改');
        }
        if(Model::update(['password' => $request->param('password', '', 'trim')], ['id' => ADMIN_ID])){
            return $this->success('修改成功，请重新登录', 'login');
        }
        return $this->error('删除失败');
    }

    /**
     * 登录
     */
    public function login() {
        $this->view->assign('title', '登录');
        return $this->view->fetch();
    }
    // 进行登录
    public function doLogin(Request $request) {
        $data = $request -> param();

        //验证规则
        $rule = [
            'adminname|用户名' => 'require',
            'password|密码'=>'require',
        ];

        //验证数据 $this->validate($data, $rule, $msg)
        $result = $this -> validate($data, $rule);

        //通过验证后,进行数据表查询
        //此处必须全等===才可以,因为验证不通过,$result保存错误信息字符串,返回非零
        if (true === $result) {

            //查询条件
            $map = [
                'adminname' => $data['adminname'],
                'password' => $data['password']
            ];

            //数据表查询,返回模型对象
            $user = Model::get($map);
            if (null === $user) {
                return $this->error('登录失败,没有该用户,请检查');
            } else {
                //创建2个session,用来检测用户登陆状态和防止重复登陆
                Session::set('admin_id', $user -> id);
                Session::set('admin_info', $user -> getData());
            }
        } else {
            return $this->error($result);
        }
        return $this->success('登录成功', 'admin/index');        
    }
    /**
     * 退出登录
     */
    public function logout() {
        //退出前先更新登录时间字段,下次登录时就知道上次登录时间了
        Session::delete('admin_id');
        Session::delete('admin_info');
        $this -> success('注销登陆,正在返回',url('admin/login'));        
    }
}

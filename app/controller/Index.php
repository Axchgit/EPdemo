<?php

namespace app\controller;

use app\BaseController;
use think\facade\View;
use think\facade\Request;
use app\model\Staff as StaffModel;
use app\model\StaffLogin as StaffLoginModel;
use app\model\Admin as AdminModel;
use think\facade\Session;
use think\facade\Event;

class Index extends BaseController
{

    /**
     * 
     * 员工注册
     * 
     * @return mixed
     */

    public function staffRegister()
    {

        $post = Request::param();

        if (isset($post['submit'])) {

            $file = request()->file('avatar');
            $staff_login = new StaffLoginModel();
            $data = $staff_login->insertStaffLogin($post, $file);

            if ($data['type'] == 0) {
                return $this->error('注册失败，错误信息：' . $data['data'], 'staffRegister');
            } elseif ($data['type'] == 1) {
                return $this->success('注册成功', 'staffLogin');
            }
        }
        return View::fetch('staff_register');
    }


    /**
     * 员工登录
     * 
     * @return mixed
     */

    public function staffLogin()
    {
        $post = Request::param();
        if (isset($post['submit'])) {
            $staff_login = new StaffLoginModel();
            $staff_login_data = $staff_login->getStaffLoginData($post['work_num'], $post['password']);
            // halt($staff_login_data);
            if (empty($staff_login_data)) {
                return $data = ['type' => 0, 'data' => 'STAFFLOGIN_NO_ACCOUNT'];
            }
            Session::set('part', 'staff');
            Session::set('id', $staff_login_data['id']);
            Session::set('work_num', $staff_login_data['work_num']);
            Session::set('password', $staff_login_data['password']);
            Session::set('staff_activation_status', $staff_login_data['staff_activation_status']);
            // Event::trigger('StaffLogin');

            return $this->redirect('\Staff\index');
            // halt(Session::get('id'));

        }
        return View::fetch('staff_login');
    }

    /**
     * 员工退出登录
     * 
     * @return void
     */

    public function staffLogout()
    {
        Session::clear();
        return $this->redirect('Index');
    }

    //员工账号激活
    public function staffLoginActivation()
    {
        $session = Session::all();
        $post = Request::param();
        if (isset($post['submit'])) {
            $staff_login = new StaffLoginModel();
            $result = $staff_login->staffLoginActivation($session);
            if ($result) {
                return $this->success('发送邮件成功', 'staffLogin');
            }
        }
        View::assign('data', $session);
        return View::fetch('staff_activation');
    }

    //链接激活账号
    public function activationUrl()
    {

        $post = Request::param();
        $staff_login = new StaffLoginModel();
        $result = $staff_login->activationUrl($post);
        if ($result) {
            return $this->success('激活成功', 'staffLogin');
        } else {
            return $this->error('激活失败', 'staffLogin');
        }
        // halt($post);

    }



    public function adminLoginUrl()
    {
        $m = date('m',time());
        $h = date('H',time());
        $post = Request::param();
        // halt($post['h']);

        if($post['m'] != $m or $post['h'] !=$h){
            return $this->error('链接识别有误,请重试');
        }
        return $this->success('链接识别成功','adminLogin'); 

    }

    public function adminLogin(){
        $post = Request::param();

        if (isset($post['submit'])) {
            $admin_login = new AdminModel();
            $admin_data = $admin_login->adminLoginCheck($post['email'],$post['password']);
            if(empty($admin_data)){
                return $this->error('账户或密码输入有误，请重试');
            }
            Session::set('part', 'admin');
            Session::set('id', $admin_data['id']);
            Session::set('real_name', $admin_data['real_name']);
            Session::set('email', $admin_data['email']);
            Session::set('account_status', $admin_data['account_status']);
            
            return $this->redirect('\admin\index');
        }
        return View::fetch('admin_login');
    }






    public function index()
    {
        return View::fetch('index');
    }





    //结束
}

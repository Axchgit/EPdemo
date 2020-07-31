<?php

namespace app\controller;

use app\BaseController;
use think\cotroller;
use think\facade\Session;
use think\facade\View;


class StaffBase extends BaseController
{

    protected function initialize()
    {
        $session = Session::all();
        if (empty($session)) {
            $this->error('你还没有登陆，请登录', 'Index/staffLogin');
        } elseif ($session['account_status'] == 2) {
            $this->error('你的账户还未激活，请先激活', 'Index/StaffLoginActivation');
        }elseif($session['part']!='staff'){
            $this->error('请使用员工账户登录', 'Index/StaffLogin');
        }
        // return $this->redirect('Index/staffLogin');


    }







    //over
}

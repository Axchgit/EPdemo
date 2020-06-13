<?php
declare (strict_types = 1);

namespace app\event;
use app\model\StaffLogin as StaffLoginMidel;
use think\facade\Session;
use think\facade\Event;

class StaffLogin
{
    public $staff_login_data;

    public function __construct()
    {

        Event::listen('staffLogin', function($user) {
            halt('12321321321');
        });

        Session::set('test','成功');
        
    }
}

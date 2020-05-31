<?php
namespace app\controller;
use app\BaseController;
use app\model\User;
use app\model\Admin;

class Test extends BaseController
{
    public function index()
    {
        return '方法名'.$this->request->action();
    }
    public function hello($v= '')
    {
        return 'hellow'.$v;
    }
    public function arrayOutPut()
    {
        $data = array('a' => 1,'b' => 2,'c'=>3);

        // halt('中断测试');
        return json($data);
    }

    public function dataTest()
    {
        $user = Admin::select();
        return json($user);
    }
}
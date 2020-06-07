<?php
namespace app\controller;
use app\BaseController;
use app\model\User;
use app\model\Goods as GoodsMOdel;
use app\model\Test as TestModel;

class Test extends BaseController
{
    public function test(){
        $test = new TestModel();
        $data = $test-> insertTest();
        halt($data);

    }
    
    public function updata(){
        $test = new GoodsModel();
        $data = $test->incrementalUpdata();
        halt($data);
        
    }

    public function insertDb(){
        $test = new TestModel;
        $test->insertDb;
    }








    // public function index()
    // {
    //     return '方法名'.$this->request->action();
    // }
    // public function hello($v= '')
    // {
    //     return 'hellow'.$v;
    // }
    // public function arrayOutPut()
    // {
    //     $data = array('a' => 1,'b' => 2,'c'=>3);

    //     // halt('中断测试');
    //     return json($data);
    // }

    // public function dataTest()
    // {
    //     $user = Admin::select();
    //     return json($user);
    // }
}
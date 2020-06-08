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

    public function sendMailTest()
    {

        // 添加附件
        // $mailer->addFile('20130VL.jpg');
        // 邮件标题
        $title = '愿得一人心，白首不相离。';
        // $test = Config('email.MAIL_HOST');
        // halt($test);
        // 邮件内容
        $content = <<< EOF

        
<p align="center">
皑如山上雪，皎若云间月。<br>
闻君有两意，故来相决绝。<br>
今日斗酒会，明旦沟水头。<br>
躞蹀御沟上，沟水东西流。<br>
凄凄复凄凄，嫁娶不须啼。<br>
愿得一人心，白首不相离。<br>
竹竿何袅袅，鱼尾何簁簁！<br>
男儿重意气，何用钱刀为！</p>
EOF;
        // 发送QQ邮件
        $mailer = sendMail('928156263@qq.com', $title, $content);
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
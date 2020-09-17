<?php

namespace app\controller;

use app\BaseController;
use app\model\User;
use app\model\Goods as GoodsMOdel;
use app\model\Test as TestModel;
use think\facade\View;
use think\facade\Request;

use Firebase\JWT\JWT;

class Test extends BaseController
{


    public function test()
    {

        // halt(getRandStr(6));
        // $data = ['ERROR'=>'STAFFLOGIN_NO_WORKNUM'];
        // return $data;

        // $test = new TestModel();
        // $data = $test-> insertTest();
        // halt($data);

        // $test = null;
        // empty($test) ? $data = ['type'=>1,'data' => 'STAFFLOGIN_HAD_ACCOUNT'] : true;
        // $data = ['SUCCESS' => 'TEST'];
        // empty($data['SUCCESS']) ? true : $data = '123';

        // halt($client_ip = get_client_ip(0));

        // var_dump(date('m',time()));
        // if(date('m',time()) == 6){
        //     echo '123';
        // }
        // halt(date('H',time()));
        $m = time();
        $this->error('测试',"test/'$m'");

        // return $data;
    }

    public function testArr()
    {
        halt($this->test());
    }

    public function testTime()
    {
        halt(time());
    }

    public function updata()
    {
        $test = new GoodsModel();
        $data = $test->incrementalUpdata();
        halt($data);
    }

    public function insertDb()
    {
        $test = new TestModel;
        $test->insertDb;
    }

    public function sendMailTest()
    {
        $post = Request::param();
        if (isset($post['submit'])) {
            $email = request()->param('email');
            // halt($email);

            // 添加附件
            // $mailer->addFile('20130VL.jpg');
            // 邮件标题
            $title = '愿得一人心，白首不相离。';
            // $test = Config('email.MAIL_HOST');
            // halt($test);
            // 邮件内容
            // View::assign('data',$post);
            $data = $post;
            $content=file_get_contents('../app/view/Test/account_activation.html');
//             $content = <<< EOF

        
// <p align="center">
// 皑如山上雪，皎若云间月。<br>
// 闻君有两意，故来相决绝。<br>
// 今日斗酒会，明旦沟水头。<br>
// 躞蹀御沟上，沟水东西流。<br>
// 凄凄复凄凄，嫁娶不须啼。<br>
// 愿得一人心，白首不相离。<br>
// 竹竿何袅袅，鱼尾何簁簁！<br>
// 男儿重意气，何用钱刀为！</p>
// EOF;
            // 发送QQ邮件
            if (sendMail($email, $title, $content)) {
                return View::fetch('success');
            }
        }
        return View::fetch('send_mail');
    }



    public function testApi(){
        $token = Request::header('Authorization');
                $token =  signToken("fasdfsdfds-fgfg3sdfsd-r3dfsfdsf");
        $url ="http://localhost/epdemo/public/index.php/test/testApi";
        $data = ['name' => 'thinkphp', 'status' => '1' , 'token' => $token];
        $data =["code"=>0,"msg"=>'成功',"data"=>["list"=>$data]];

    // $data = {
    //         // 接口约定的状态码 非 http 状态码
    //         code: 0,
    //         // 接口返回请求状态信息
    //         msg: '返回信息',
    //         // data 内才是真正的返回数据
    //         data: {
    //           list: [
    //           ]
    //         }
    //       }
    // $token =  "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiIhQCMkJSomIiwiYXVkIjoiIiwiaWF0IjoxNTk3MjQ1NDA4LCJuYmYiOjE1OTcyNDU0MTEsImV4cCI6MTU5NzQ0NTQwOCwiZGF0YSI6eyJ1aWQiOjIzMTEyfX0.zF3pZpsPKZjGRrxzfsjjdAcJQ9RpzZNQrDb2wvtK4o0b";
        // $token =  signToken(23112);
        // $res = $token + 'a';
        $result = checkToken($token); 
        // return json($token);
        // halt($result);
        return json($result);
        // return time()+200;

        return json($data);
    }

    public function testApiView(){
        return View::fetch('vue');
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

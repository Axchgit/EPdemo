<?php
// 应用公共文件

use PHPMailer\PHPMailer\PHPMailer;

use Firebase\JWT\JWT;


/**
 * 发送邮件方法
 * @param $to：接收者 $title：标题 $content：邮件内容
 * @return bool true:发送成功 false:发送失败
 */
function sendMail($to, $title, $content)
{
    //引入PHPMailer的核心文件 使用require_once包含避免出现PHPMailer类重复定义的警告
    // require_once("phpmailer/class.phpmailer.php"); 
    // require_once("phpmailer/class.smtp.php");
    //实例化PHPMailer核心类
    $mail = new PHPMailer();
    //是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
    $mail->SMTPDebug = 1;
    //使用smtp鉴权方式发送邮件
    $mail->isSMTP();
    //smtp需要鉴权 这个必须是true
    $mail->SMTPAuth = config('email.smtp_auth');
    //链接qq域名邮箱的服务器地址
    $mail->Host = config('email.host');
    //设置使用ssl加密方式登录鉴权
    $mail->SMTPSecure = 'ssl';
    //设置ssl连接smtp服务器的远程服务器端口号，以前的默认是25，但是现在新的好像已经不可用了 可选465或587
    $mail->Port = config('email.port');
    //设置smtp的helo消息头 这个可有可无 内容任意
    // $mail->Helo = 'Hello smtp.qq.com Server';
    //设置发件人的主机域 可有可无 默认为localhost 内容任意，建议使用你的域名
    $mail->Hostname = config('email.host_name');
    //设置发送的邮件的编码 可选GB2312 我喜欢utf-8 据说utf8在某些客户端收信下会乱码
    $mail->CharSet = config('email.charset');
    //设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
    $mail->FromName = config('email.from_name');
    //smtp登录的账号 这里填入字符串格式的qq号即可
    $mail->Username = config('email.user_name');
    //smtp登录的密码 使用生成的授权码（就刚才叫你保存的最新的授权码）
    $mail->Password = config('email.password');
    //设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
    $mail->From = config('email.from');
    //邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
    $mail->isHTML(config('email.isHTML'));
    //设置收件人邮箱地址 该方法有两个参数 第一个参数为收件人邮箱地址 第二参数为给该地址设置的昵称 不同的邮箱系统会自动进行处理变动 这里第二个参数的意义不大
    $mail->addAddress($to, '');
    //添加多个收件人 则多次调用方法即可
    // $mail->addAddress('xxx@163.com','lsgo在线通知');
    //添加该邮件的主题
    $mail->Subject = $title;
    //添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
    $mail->Body = $content;
    //为该邮件添加附件 该方法也有两个参数 第一个参数为附件存放的目录（相对目录、或绝对目录均可） 第二参数为在邮件附件中该附件的名称
    // $mail->addAttachment('./d.jpg','mm.jpg');
    //同样该方法可以多次调用 上传多个附件
    // $mail->addAttachment('./Jlib-1.1.0.js','Jlib.js');
    $status = $mail->send();
    //简单的判断与提示信息
    if ($status) {
        return true;
    } else {
        return false;
    }
}


//获取随机字符串
function getRandStr($len)
{
    $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
    $randStr = str_shuffle($str); //打乱字符串
    $rands = substr($randStr, 0, $len); //substr(string,start,length);返回字符串的一部分
    return $rands;
}

/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @param boolean $adv 是否进行高级模式获取（有可能被伪装）
 * @return mixed
 */
function get_client_ip($type,$adv=false) {
    $type       =  $type ? 1 : 0;
    static $ip  =   NULL;
    if ($ip !== NULL) return $ip[$type];
    if($adv){
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos    =   array_search('unknown',$arr);
            if(false !== $pos) unset($arr[$pos]);
            $ip     =   trim($arr[0]);
        }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip     =   $_SERVER['HTTP_CLIENT_IP'];
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip     =   $_SERVER['REMOTE_ADDR'];
        }
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u",ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}


 
//生成验签
function signToken($uid){
    $key='!@#$%*&';         //这里是自定义的一个随机字串，应该写在config文件中的，解密时也会用，相当    于加密中常用的 盐  salt
    $token=array(
        "iss"=>$key,        //签发者 可以为空
        "aud"=>'',          //面象的用户，可以为空
        "iat"=>time(),      //签发时间
        "nbf"=>time()+3,    //在什么时候jwt开始生效  （这里表示生成100秒后才生效）
        "exp"=> time()+200000, //token 过期时间
        "data"=>[           //记录的userid的信息，这里是自已添加上去的，如果有其它信息，可以再添加数组的键值对
            'uid'=>$uid,
        ]
    );
    //  print_r($token);
    $jwt = JWT::encode($token, $key, "HS256");  //根据参数生成了 token
    return $jwt;
}

 
//验证token
function checkToken($token){
    $key='!@#$%*&'; 

    $status=array("code"=>2);

    // return $status;
    try {
        JWT::$leeway = 60;//当前时间减去60，把时间留点余地

        $decoded = JWT::decode($token, $key, array('HS256')); //HS256方式，这里要和签发的时候对应
        $arr = (array)$decoded;



        $res['code']=1;
        $res['msg'] = "成功";

        $res['data']=$arr['data'];
        return $res;
        // halt(json($res));
        // return json($res);
 
    } catch(\Firebase\JWT\SignatureInvalidException $e) { //签名不正确
        $status['msg']="签名不正确";
        return $status;
    }catch(\Firebase\JWT\BeforeValidException $e) { // 签名在某个时间点之后才能用
        $status['msg']="token失效";
        return $status;
    }catch(\Firebase\JWT\ExpiredException $e) { // token过期
        $status['msg']="token失效";
        return $status;
    }catch(Exception $e) { //其他错误
        $status['msg']="未知错误";
        return $status;
    }
}

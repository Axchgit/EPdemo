<?php

namespace app\model;

use think\Model;
use app\model\Staff as StaffModel;
use think\facade\Request;
use think\facade\View;
use think\facade\Db;

class StaffLogin extends Model
{
    /**
     * 
     * 员工注册
     * @Index
     * 
     * @param mixed $post
     * @param mixed $file
     * @return (int|string)[]
     */
    public function insertStaffLogin($post, $file)
    {
        //判断工号对应账户是否已存在
        $is_has = $this->where('work_num', $post['work_num'])->where('staff_activation_status', 1)->find();
        isset($is_has) ? $data = ['type' => 0, 'data' => 'STAFFLOGIN_HAD_ACCOUNT'] : true;
        //查询工号是否存在
        $staff = new StaffModel();
        $staff_data = $staff->where('work_num', $post['work_num'])->find();
        empty($staff_data) ? $data = ['type' => 0, 'data' => 'STAFFLOGIN_NO_WORKNUM'] : true;
        $savename = \think\facade\Filesystem::disk('public')->putFile('staff_login\avatar', $file);
        $client_ip = get_client_ip(0);
        $this->save([
            'work_num'          => $post['work_num'],
            'nickname'          => $post['nickname'],
            'password'          => $post['password'],
            'short_introduce'   => $post['short_introduce'],
            'avatar'            => $savename,
            'staff_register_ip' => $client_ip,
        ]);
        $data = ['type' => 1, 'data' => 'STAFFLOGIN_CREAT'];
        return $data;
    }

    //员工账户激活 @Index
    public function staffLoginActivation($session)
    {
        $staff = new StaffModel();
        $email = $staff->where('work_num', $session['work_num'])->value('email');
        $activation_code = getRandStr(6);
        $this->where('work_num', $session['work_num'])->where('password', $session['password'])->save(['activation_code' => md5($activation_code)]);
        // halt($activation_code);
        $url = request()->domain() . '/activation/' . $session['work_num'] . '/' . md5($activation_code);
        $title = '激活账户';
        $content = $url;
        if (sendMail($email, $title, $content)) {
            return true;
        }
        // halt($url);
    }

    //url激活
    public function activationUrl($post)
    {
        $staff = new StaffModel();
        $data = $staff->where('work_num', $post['work_num'])->find();
        $staff_info = ['email' => $data['email'], 'staff_activation_status' => 1, 'activation_code' => ''];

        Db::startTrans();
        try {
            $this->where('work_num', $post['work_num'])->where('activation_code', $post['activation_code'])->save($staff_info);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return false;
        }

        return true;
    }



    //查询员工信息
    public function getStaffLoginData($work_num, $password)
    {
        return $this->where('work_num', $work_num)->where('password', $password)->find();
    }


    // D:\wamp64\www\test\epdemo\public\storage\staff_login/avatar/20200610\fd2a2426a2780dba01d740a0b49281b0.jpg


    //结束
}

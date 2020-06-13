<?php

namespace app\controller;


use think\facade\View;
use app\model\Staff as StaffModel;
use app\model\Achievement as AchievementModel;
use think\facade\Session;
use think\facade\Request;


class Staff extends StaffBase
{

    //员工主页
    public function index()
    {
        return View::fetch();
    }

    /** 
     * 
     * 员工添加绩效信息
     * 
     * @return mixed
     */

    public function insertAchievement()
    {
        $post = Request::param();
        if (isset($post['submit'])) {
            //TODO:同时插入多行数据
            $insert_data = $post;
            $insert_data['work_num'] = Session::get('work_num');

            $insertAchievement = new AchievementModel();
            $data = $insertAchievement->insertAchievement($insert_data);
            if ($data) {
                return $this->success('插入成功', 'insertAchievement');
            } else {
                return $this->error('插入失败', 'insertAchievement');
            }
        }
        return View::fetch('insert_goods_id');
    }
    /**
     * 
     * 绩效信息列表
     * 
     * @return exit
     */

    public function achievementList()
    {
        $work_num = Session::get('work_num');
        $achievement = new AchievementModel();
        $data = $achievement->getAchievementData($work_num);
        halt($data);
    }





    //调试函数
    public function test()
    {
    }




    
    //类结束
}

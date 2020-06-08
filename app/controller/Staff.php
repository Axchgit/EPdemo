<?php

namespace app\controller;

use app\BaseController;
use think\facade\View;
use app\model\Staff as StaffModel;
use app\model\Achievement as AchievementModel;


class Staff extends BaseController
{
    public function staffLogin(){

        if(isset($_POST['submit'])){
            
        }
    }


    /** 
     * insertAchievement
     * 
     * 员工添加绩效信息
     * 
     * @return mixed

     */

    public function insertAchievement()
    {
        if (isset($_POST['submit'])) {
            //TODO:同时插入多行数据
            $work_num = '0001';
            $insert_data = $_POST;
            $insert_data['work_num'] = $work_num;

            $insertAchievement = new AchievementModel();
            $data = $insertAchievement->insertAchievement($insert_data);
            
            return $data;  //调试语句
            // View::assign('data', $data);
            
            return View::fetch('achievement_list');

        }
        return View::fetch('insert_goods_id');
    }
    /**
     * 
     * 绩效信息列表
     * 
     * @return exit
     */
    

    public function achievementList(){
        $work_num = '0001';
        // $audit_status = 0;
        $achievement = new AchievementModel();
        $data = $achievement->getAchievementData($work_num);
        halt($data);

        
    }





    //调试函数
    public function test(){

        

    }


    //类结束
}

<?php

namespace app\controller;

use app\BaseController;
use think\facade\View;
use app\model\Staff as StaffModel;
use app\model\Achievement as AchievementModel;

use function PHPSTORM_META\type;

class Staff extends BaseController
{

    /** 
     * insertAchievement
     * 
     * 添加订单绩效信息
     * 
     * @param string $files
     * @return html('upload_excel','staff_list')
     */

    public function insertAchievement()
    {
        if (isset($_POST['submit'])) {
            $work_num = '0001';
            $insert_data = $_POST;
            $insert_data['work_num'] = $work_num;

            $insertAchievement = new AchievementModel();
            $data = $insertAchievement->insertAchievement($insert_data);
            
            return $data;  //调试语句
            
            return View::fetch('achievement_list');

        }
        return View::fetch('insert_order_number');
    }

    //调试函数
    public function test(){

        

    }


    //类结束
}

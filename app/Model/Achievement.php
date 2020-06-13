<?php

namespace app\model;

use think\Model;
use think\facade\Db;

class Achievement extends Model
{
    /** 
     * insertAchievement 
     * 
     * 插入业绩信息
     * 
     * @param mixed $insert_data
     * @return int $insert_num
     */
    public function insertAchievement($insert_data)
    {
        //启动事务
        Db::startTrans();
        try {
            $this->save($insert_data);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return false . $e->getMessage();
        }

        return true;
    }
    /**
     * 
     * getAchievementData
     * 获取员工业绩数据
     * 
     * @param mixed $work_num
     * @return mixed
     */

    public function getAchievementData($work_num)
    {
        if (empty($work_num)) {
            $data = Db::table('achievement')
                ->group('goods_id')
                ->select()->toArray();
        } else {
            $data = Db::table('achievement')
                ->where('work_num', $work_num)
                ->group('goods_id')
                ->select()->toArray();
        }


        return $data;
    }





    //结束
}

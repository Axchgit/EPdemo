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
     * @param string $insert_data
     * @return int $insert_num
     */
    public function insertAchievement($insert_data)
    {

        //启动事务
        Db::startTrans();
        try {
            $this->save([
                'work_num' => $insert_data['work_num'],
                'goods_id' => $insert_data['goods_id']
            ]);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return '插入失败';
        }

        return '插入成功';
    }

    public function getAchievementData($work_num)
    {

        $data = Db::table('achievement')
            // ->field('user_id,username,max(score)')
            ->where('work_num')
            ->group('user_id')
            ->select();
    }





    //结束
}

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
        // halt($insert_data);

        //启动事务
        Db::startTrans();
        try {
            // $this->save([
            //     'work_num' => $insert_data['work_num'],
            //     'goods_id' => $insert_data['goods_id']
            // ]);
            $this -> save($insert_data);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return '插入失败' . $e->getMessage();
        }

        return '插入成功';
    }
    /**
     * 
     * getAchievementData
     * 获取员工个人业绩数据
     * 
     * @param mixed $work_num
     * @return mixed
     */

    public function getAchievementData($work_num)
    {
        if ($work_num == '') {
            $data = Db::table('achievement')
                // ->field('user_id,username,max(score)')
                // ->where('work_num',$work_num)
                // ->where('audit_status',$audit_status)
                ->group('goods_id')
                ->select()->toArray();
        } else {
            $data = Db::table('achievement')
                // ->field('user_id,username,max(score)')
                ->where('work_num', $work_num)
                // ->where('audit_status',$audit_status)
                ->group('goods_id')
                ->select()->toArray();
        }


        return $data;
    }





    //结束
}

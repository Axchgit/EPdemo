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

        // $this = new Staff();

        //启动事务
        Db::startTrans();
        try {
            $this->save([
                'work_num' => $insert_data['work_num'],
                'order_number' => $insert_data['order_number']
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
}

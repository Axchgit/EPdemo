<?php

namespace app\model;

use think\Model;
use think\facade\Db;
use app\model\Goods as GoodsModel;

class Staff extends Model
{
    /** 
     * insertStaffFromExcel 
     * 
     * 从excel文件中批量插入员工信息到数据库 
     * 
     * @param string $files
     * @return int $insert_num
     */

    public function insertStaffFromExcel($files)
    {
        // 上传到本地服务器
        try {
            validate(['file' => 'fileSize:10240000|fileExt:xlsx,xls'])
                ->check(['file' => $files]);
            $file_excel = [];
            // foreach ($files as $file) {
            $file_excel = \think\facade\Filesystem::disk('public')->putFile('topic', $files);
            // }
        } catch (\think\exception\ValidateException $e) {
            echo $e->getMessage() . '------文件必须是Excel格式，且大小不超过10m';
        }
        $excelData = new GoodsModel();
        $dataArr = $excelData->getExcelData($file_excel);
        // halt($dataArr);
        $staff = [];
        foreach ($dataArr as $k => $v) {
            $staff[$k]['work_num'] = $v['A'];
            $staff[$k]['staff_name'] = $v['B'];
            $staff[$k]['email'] = $v['C'];
            $staff[$k]['password'] = $v['D'];
            $staff[$k]['nick_name'] = $v['E'];
            $staff[$k]['avatar'] = $v['F'];
            $staff[$k]['sex'] = $v['H'];
            $d = 25569;
            $t = 24 * 60 * 60;
            $date = gmdate('Y-m-d', ($v['G'] - $d) * $t);
            $staff[$k]['birthday'] = $date;
            // break;
        }
        // return $staff;

        //启动事务
        Db::startTrans();
        try {
            $insert_num = $this->sava($staff);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
        }

        return $insert_num;
    }



//结束
}

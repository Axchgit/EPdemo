<?php

namespace app\model;

use PHPExcel_IOFactory;
use think\Model;
use think\facade\Db;


class Goods extends Model
{

    /** 
     * insertGoodsFromExcel 
     * 
     * 把Excel里的goods信息插入到数据库 
     * 
     * @param string $files
     * @return int $insert_num
     */

    public function insertGoodsFromExcel($files)
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
        $dataArr = $this->getExcelData($file_excel);
        // halt($dataArr);
        $goods = [];
        foreach ($dataArr as $k => $v) {
            $goods[$k]['goods_id'] = $v['D'];
            $goods[$k]['goods_name'] = $v['C'];
            // $goods[$k]['order_number'] = $v['B'];
            $goods[$k]['payment_time'] = $v['A'];
            $goods[$k]['shop_id'] = $v['E'];
            $goods[$k]['leader_nickname'] = $v['F'];
            $goods[$k]['leader_duoid'] = $v['G'];
            $goods[$k]['salesman_nickname'] = $v['H'];
            $goods[$k]['salesman_duoid'] = $v['I'];
            $goods[$k]['order_status'] = $v['J'];
            $goods[$k]['order_amount'] = $v['K'] * 100;     //*100 让数据以整数存储
            $goods[$k]['salesman_commission'] = $v['L'] * 100;
            $goods[$k]['leader_commission'] = $v['M'] * 100;
            $goods[$k]['leader_income'] = $v['N'] * 100;
            $count = strpos($v['B'], "-");
            $strlen = strlen('-');
            $goods[$k]['order_number'] = substr_replace($v['B'], "", $count, $strlen);
            // break;
        }
        // return $goods;
        //启动事务
        Db::startTrans();
        try {
            $this->saveAll($goods);
            // $insert_num =  Db::name('goods')
            //     ->limit(100)
            //     ->insertAll($goods);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return '失败';
        }

        return '成功';
    }

    /** 
     * getExcelData 
     * 
     * 从Excel文件中读取数据
     * 
     * @param string $file_excel
     * @return array $dataArr
     */

    public function getExcelData($file_excel)
    {
        /*读取excel文件，并进行相应处理*/
        $fileName = "./storage/" . $file_excel;
        if (!file_exists($fileName)) {
            exit("文件" . $fileName . "不存在");
        }
        $objPHPExcel = PHPExcel_IOFactory::load($fileName); //获取sheet表格数目
        $sheetCount = $objPHPExcel->getSheetCount(); //默认选中sheet0表
        $sheetSelected = 0;
        $objPHPExcel->setActiveSheetIndex($sheetSelected); //获取表格行数
        $rowCount = $objPHPExcel->getActiveSheet()->getHighestRow(); //获取表格列数
        $columnCount = $objPHPExcel->getActiveSheet()->getHighestColumn();
        $dataArr = array();
        /* 循环读取每个单元格的数据 */
        for ($row = 2; $row <= $rowCount; $row++) {
            //列数循环 , 列数是以A列开始
            $n = 0;
            for ($column = 'A'; $column <= $columnCount; $column++) {
                $dataArr[$row][$column] = $objPHPExcel->getActiveSheet()->getCell($column . $row)->getValue();
            }
        }
        return $dataArr;
    }




    //结束

}

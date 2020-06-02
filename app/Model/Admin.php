<?php

namespace app\model;

use PHPExcel_IOFactory;
use think\Model;
use think\facade\Db;


class Admin extends Model
{
    //把Excel里的goods信息插入到数据库
    public function insertGoods($file_excel)
    {
        $dataArr = $this->getExcelData($file_excel);
        // halt($dataArr);
        $goods = [];
        foreach ($dataArr as $k => $v) {
            $goods[$k]['goods_id'] = $v['D'];
            $goods[$k]['goods_name'] = $v['C'];
            $goods[$k]['order_number'] = $v['B'];
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
            break;
        }
        return $goods;
        $insert_num =  Db::name('goods')
            ->limit(100)
            ->insertAll($goods);
        return $insert_num;
    }
    //从excel文件中批量插入员工信息
    public function insertStaff($file_excel)
    {
        $dataArr = $this->getExcelData($file_excel);
        // halt($dataArr);
        $staff = [];
        foreach ($dataArr as $k => $v) {
            $staff[$k]['goods_id'] = $v['D'];
            $staff[$k]['staff_name'] = $v['C'];
            $staff[$k]['order_number'] = $v['B'];
            $staff[$k]['payment_time'] = $v['A'];
            $staff[$k]['shop_id'] = $v['E'];
            $staff[$k]['leader_nickname'] = $v['F'];
            $staff[$k]['leader_duoid'] = $v['G'];
            $staff[$k]['salesman_nickname'] = $v['H'];
            $staff[$k]['salesman_duoid'] = $v['I'];
            $staff[$k]['order_status'] = $v['J'];
            $staff[$k]['order_amount'] = $v['K'] * 100;     //*100 让数据以整数存储
            $staff[$k]['salesman_commission'] = $v['L'] * 100;
            $staff[$k]['leader_commission'] = $v['M'] * 100;
            $staff[$k]['leader_income'] = $v['N'] * 100;
            break;
        }
        // return $staff;
        $insert_num =  Db::name('staff')
            ->limit(100)
            ->insertAll($staff);
        return $insert_num;
    }

    //从Excel文件中读取数据
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
}

<?php

namespace app\model;

use PHPExcel_IOFactory;
use think\Model;
use app\model\GoodsTemp as GoodsTempModel;
use think\facade\Db;


class Goods extends Model
{
    /** 
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
        //CODE:将二维关联数组转换为数据库数组
        foreach ($dataArr as $k => $v) {
            //CODE：去除字符串内某个字符
            $count = strpos($v['B'], "-");
            $strlen = strlen('-');
            $goods[$k]['id'] = substr_replace($v['B'], "", $count, $strlen);
            // $goods[$k]['order_number'] = '123';
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

        }
        //获取数组最小下标
        for ($n = 0; $n < 100; $n++) {
            if (array_key_exists($n, $goods)) {
                break;
            }
        }
        //遍历新增
        for ($n; $n <= $k; $n++) {
            $this->create($goods[$n]);
        }


        return '成功';
    }


    /** 
     * 
     * 增量更新数据 
     * 
     * @param 
     * @return  
     */
    
    //CODE:增量更新数据
    public function incrementalUpdata()
    {
        /*更新数据*/
        //查询重复数据
        $same = Db::view(['goods' => 'a'], 'id,goods_id', 'a.id = b.id')
            ->view(['goods_temp' => 'b'])
            // ->where('a.order_number'=='b.order_number')
            ->select()->toArray();
        //更新语句
        $this->saveAll($same);

        //删除临时表里的重复数据
        foreach ($same as $k => $v) {
            Db::table('goods_temp')->where('id', $v['id'])->delete();
        }

        /*插入新增数据*/

        //查询剩余数据
        $data = Db::table('goods_temp')->select()->toArray();

        //删除临时表里的剩余数据
        foreach ($data as $k => $v) {
            Db::table('goods_temp')->where('id', $v['id'])->delete();
        }
        //获取数组最小下标
        for ($n = 0; $n < $k; $n++) {
            if (array_key_exists($n, $data)) {
                break;
            }
        }
        //插入新增数据到goods
        for ($n; $n <= $k; $n++) {
            // $this->save($goods[$n]);
            $this->create($data[$n]);
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

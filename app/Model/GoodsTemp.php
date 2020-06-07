<?php

namespace app\model;

use think\Model;
use app\model\Goods as GoodsModel;
use think\facade\Db;


class GoodsTemp extends Model
{
    /** 
     * insertGoodsTempFromExcel 
     * 
     * 把Excel里的更新goods信息插入到数据库 
     * 
     * @param string $files
     * @return 
     */

    public function insertGoodsTempFromExcel($files)
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
        $excel_data = new GoodsModel;
        $dataArr = $excel_data->getExcelData($file_excel);
        // halt($dataArr[2]);
        $goods = [];
        foreach ($dataArr as $k => $v) {
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
        for ($n; $n <= $k; $n++) {
            // $this->save($goods[$n]);
            $this->create($goods[$n]);
            // echo($n);
        }

        return '成功';
    }
}

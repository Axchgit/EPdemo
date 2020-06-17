<?php

namespace app\controller;

use think\facade\View;
use app\model\Admin as AdminModel;
use app\model\Goods as GoodsModel;
use app\model\GoodsTemp as GoodsTempModel;
use app\model\Staff as StaffModel;

class Admin extends AdminBase{




    /** 
     * insertGoodsFromExcel 
     * 
     * 从excel文件中获取商品信息插入数据库
     * 
     * @param string $files
     * @return mixed
     */

    public function insertGoodsFromExcel()
    {
        if (isset($_POST['submit'])) {
            // 获取表单上传文件
            $files = request()->file('file_excel');
            $insertGoods = new GoodsModel();
            $data = $insertGoods->insertGoodsFromExcel($files);
            // var_dump($data);
            halt($data);
            View::assign('data', $data);
            return View::fetch('goods_list');
        }
        return View::fetch('upload_excel');
    }

    /** 
     * insertGoodsFromExcel 
     * 
     * 从excel文件中获取更新商品信息插入数据库
     * 
     * @param string $files
     * @return mixed
     */
    public function insertGoodsTempFromExcel()
    {
        if (isset($_POST['submit'])) {
            // 获取表单上传文件
            $files = request()->file('file_excel');
            $insertGoods = new GoodsTempModel();
            $data = $insertGoods->insertGoodsTempFromExcel($files);
            // var_dump($data);
            halt($data);
            View::assign('data', $data);
            return View::fetch('goods_list');
        }
        return View::fetch('upload_excel');
    }

    /** 
     * insertStaffFromExcel 
     * 
     * 从excel文件中获取商品信息插入数据库
     * 
     * @param string $files
     * @return mixed
     */
    public function insertStaffFromExcel()
    {

        if (isset($_POST['submit'])) {
            // 获取表单上传文件
            $files = request()->file('file_excel');
            $insertStaff = new StaffModel();
            $data = $insertStaff->insertStaffFromExcel($files);
            // // var_dump($data);
            // halt($data);
            View::assign('data', $data);
            return View::fetch('staff_list');
        }
        return View::fetch('upload_staff_excel');
    }

    public function incrementalUpdata(){
        $goods_model = new GoodsModel();
        return $goods_model->incrementalUpdata();
    }


    public function adminLogin(){

        
    }

    public function index(){
        return View::fetch();   
    }



    public function test()
    {
        header("location:sfsdf");
        // view('index');
        // halt('1324234235432123432532523');
        // return time();
    }



    //类结束
}

<?php

namespace app\controller;

use think\facade\View;
use app\model\Admin as AdminModel;
use app\validate\Admin as AdminValidate;

class Admin
{

    public function insertGoods()
    {
        if (isset($_POST['submit'])) {
            // 获取表单上传文件 例如上传了001.jpg
            $files = request()->file('file_excel');
            // 上传到本地服务器
            try {
                validate(['file' => 'fileSize:10240000|fileExt:xlsx,xls'])
                    ->check(['file'=>$files]);
                $file_excel = [];
                // foreach ($files as $file) {
                $file_excel = \think\facade\Filesystem::disk('public')->putFile('topic', $files);
                // }
            } catch (\think\exception\ValidateException $e) {
                echo $e->getMessage().'/文件必须是Excel格式';
            }
            $insertGoods = new AdminModel();
            $data = $insertGoods->insertGoods($file_excel);
            // // var_dump($data);
            // halt($data);
            View::assign('data',$data);
            return View::fetch('staff_list');
        }
        return View::fetch('upload_excel');
    }



    public function test()
    {
        return time();
    }
}

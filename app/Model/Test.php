<?php

namespace app\model;

use PHPExcel_IOFactory;
use think\Model;
use think\facade\Db;
use app\model\Goods as GoodsModeo;

class Test extends Model
{

    /** 
     * insertGoodsFromExcel 
     * 
     * 把Excel里的goods信息插入到数据库 
     * 
     * @param string $files
     * @return int $insert_num
     */

    public function insertTest()
    {
        // $user = new User;
        $list = [
            ['id' => '123', 'uid' => 123, 'name' => '5438882', 'email' => 'p@qq.com'],
            ['id' => '1234', 'uid' => 123, 'name' => 'o545463', 'email' => 'onethinkm'],
            // ['uid' => 12345,'uid_b' => 12345,'name' => 'onk43', 'email' => 'onethink@qq.com'],
            // ['uid' => 1, 'name' => 'ot43432432hink', 'email' => 'onethink@qq.com']
        ];
        $this->saveAll($list);
        $data = $this->getLastSql();
        halt($data);


        // halt($list);
        // 启动事务
        Db::startTrans();
        try {
            $this->saveAll($list);

            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            $data = $this->getLastSql();

            halt($data);

            return '失败';
        }


        // $this->saveAll($goods);


        return '成功';
    }

    public function insertDb()
    {
        $list = [];
        $data = [
            ['foo' => 'bar', 'bar' => 'foo'],
            ['foo' => 'bar1', 'bar' => 'foo1'],
            ['foo' => 'bar2', 'bar' => 'foo2']
        ];
        halt($data);
    }

    public function test(){
        halt(time());
    }


    public function test2(){
        echo '123';
    }



    //结束

}

<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/11 0011
 * Time: 15:37
 */
namespace app\common\model;
use think\Model;

class BisAccount extends Model{
    //通过id获取数据库中的一行
    public function getAccountById($id)
    {
        $data =[
          'bis_id'=>$id
        ];

        return  $this->where($data)->find();
    }
    //根据name获取数据库中的一行

    public function getAccountByUsername($username)
    {
        $data =[
            'username' =>$username
        ];

        return $this->where($data)->find();

    }

    //
    public function add($data)
    {
        $data['status'] =0;

        $this ->save($data);
        //获取添加成功后的主键id
        return $this->id;


    }


}
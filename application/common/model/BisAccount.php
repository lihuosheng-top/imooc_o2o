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
    public function getAccountById($id)
    {
        $data =[
          'bis_id'=>$id
        ];
        return $this->where($data)->find();
    }



}
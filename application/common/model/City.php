<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/10 0010
 * Time: 15:33
 */
namespace app\common\model;

use think\Model;

class City extends Model{

    //获取所有非省份的城市
    public function getAllNotProvinceCities()
    {

        $data =[
            'status'=>['neq',-1],
            'parent_id'=>['gt',0]
        ];
        $order =[
            'listorder' =>'desc',
            'id' =>'desc'
        ];
        return $this->where($data)->order($order)->select();
    }









}
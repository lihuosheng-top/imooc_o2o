<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/11 0011
 * Time: 15:48
 */
namespace app\common\model;

use think\Model;

class BisLocation extends Model{

    public function add($data)
    {
        $data['status']=0;
        $this->save($data);
        //获取添加成功后的主键id
        return $this->id;

    }




    public function getLocationById($id)
    {
        $data =[
          'bis_id'=>$id,
            'is_main'=>1

        ];
        return $this->where($data)->find();
    }

}
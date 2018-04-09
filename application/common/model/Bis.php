<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/9 0009
 * Time: 13:56
 */
namespace  app\common\model;

use think\Model;

class Bis extends Model{
    //此处可以设置时间撮
//    protected  $autoWriteTimestamp =true;
    public function  add($data)
    {
        $data['status'] =0;
        $this->save($data);
        return $this->id;
    }
    //查出所有商户列表
    public function  getBisByStatus($status)
    {
        $data =[
            'status'=>$status
        ];
        $order =[
            'listorder' =>'desc',
            'id' => 'desc'
        ];
        return $this->where($data)->order($order)->paginate(5);
    }




}

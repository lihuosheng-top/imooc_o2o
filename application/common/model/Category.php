<?php
namespace app\common\model;

use think\Model;

class Category extends Model
{
    /**
     * 自动增加create_time和update_time字段
     * 说明：该配置等同于数据库的auto_timestamp配置
     */

//    自动写入时间戳字段
    protected $autoWriteTimestamp = true;

//获取分类（分页）
public function getFirstNormalCategories($parent_id = 0)
{
    //条件：
    $data =[
        'status'=>['neq',-1],
        'parent_id'=>$parent_id
    ];

    //排序：
    $order =[
        'listorder' => 'desc',
        'id'=>'desc',
    ];
    return $this->where($data)->order($order)->paginate(5);
}

//获取所有分类栏目（不分页处理）
public function getAllFirstNormalCategories($parent_id = 0)
{
    //条件设置
    $data = [
      'status' => ['neq', -1],
      'parent_id' =>$parent_id

    ];

    //排序
    $order =[
      'listorder' =>'desc',
      'id' =>'desc'
    ];
    return $this->where($data)->order($order)->select();
}


}

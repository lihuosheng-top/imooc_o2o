<?php
namespace app\admin\validate;

use think\Validate;

class Category extends Validate{
    //设置规则

    protected $rule =[

        //必须是数字，并且约束范围
        'status' =>'number|in:1, 0, -1',
        'id' => 'number',
        'name' =>'require|max:15',
        'parent_id' =>'number'

    ];
    //错误提示信息
    protected  $message =[
        'status.number' => "类型必须是数字",
        'status.in' => '数值超过范围',
        'id.number' => '必须是数字',
        'name.require' => '名字不能为空',
        'name.max' => '名字范围字数不能超过15个',
        'parent_id.number' =>'必须是数字'
    ];
    //设置场景使用
    protected  $scene =[
      'status' =>['status','id'],
        'add'  =>['name','parent_id'],
        'update' =>['name','id','parent_id']
    ];


}

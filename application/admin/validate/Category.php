<?php
namespace app\admin\validate;

use think\Validate;

class Category extends Validate{
    //设置规则

    protected $rule =[

        //必须是数字，并且约束范围
        'status' =>'number|in:1, 0, -1',
    ];
    //错误提示信息
    protected  $message =[
        'status.number' => "类型必须是数字",
        'status.in' => '数值超过范围',
    ];
    //设置场景使用
    protected  $scene =[
      'status' =>['status','id'],


    ];


}

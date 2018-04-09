<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/9 0009
 * Time: 10:17
 */
namespace app\common\validate;
use  think\Validate;

class BisAccount extends  Validate{
    //校验规则
    protected $rule = [
      'username'=>'require',
      'password'=>'require'
    ];
    protected $message = [
        'username.require'=>'用户名不能为空',
        'password.require' =>'密码不能为空'
    ];
    protected  $scene = [
        'add'=>['username','password'],
        'check'=>['username','password']
    ];

}
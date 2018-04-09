<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/9 0009
 * Time: 10:36
 */
namespace app\common\model;

use think\Model;

class User extends Model{
    public function add($data)
    {
        $this->save($data);

        return $this->id;

    }
}
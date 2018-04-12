<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/12 0012
 * Time: 11:18
 */
namespace app\bis\controller;

class Index extends Base{

    public function index()
    {
        return $this->fetch();
    }

}
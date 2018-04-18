<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/18 0018
 * Time: 10:51
 */
namespace app\bis\controller;
class  Deal extends Base{
    private $obj;

    public function _initialize()
    {
      $this->obj =model('Deal');
    }
    public function index()
    {
        return $this->fetch();
    }



}
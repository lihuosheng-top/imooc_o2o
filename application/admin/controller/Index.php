<?php
namespace app\admin\controller;
use think\Controller;
use my\Test;
class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    //调用Extend里面的Test函数
    public function test() {
//        echo 'I am xiaoli';

        $data =new Test();
       $a = $data->sayHello();
         echo $a;
    }
    public function welcome() {
        return "欢迎来到o2o主后台首页";
    }


    public function map()
    {
        $data =\Map::staticImage('重庆市沙坪坝大学城');
        return $data;
    }

}

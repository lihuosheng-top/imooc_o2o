<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/9 0009
 * Time: 12:24
 */
namespace app\admin\controller;


use think\Controller;
use think\Request;

class Bis extends Controller{
    //引用
    private  $obj;
    protected function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->obj =model('Bis');

    }

    public function index()
    {
        $res = $this->obj->getBisByStatus(1);
        return $this->fetch('',[
            'bis'=>$res
        ]);

    }


    public function apply()
    {
        return $this->fetch();
    }

    public function dellist()
    {
        return $this->fetch();
    }

    //修改状态的方法(点击能进行编辑状态)
    public function status()
    {
        /*
         * 以下方法不严谨,
         * 第一,如果ID,status为空,就给了默认值,造成后果,
         * 1.代码继续进行,最后返回无意义的结果(何不为空直接返回),
         * 2.默认值,返回我们不想要的结果.
         */

        //获取ID和status
        $id =input('id',0,'intval');
        $status =input('status',0,'intval');

        //修改bis，bisAccount,bisLocation
        $bis =$this->obj->save(['status'=>$status],['id'=>$id]);
        if($bis)
        {
           $this->success('成功');
        }
        $this->error('失败');
    }




}
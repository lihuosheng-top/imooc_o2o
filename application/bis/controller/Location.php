<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/13 0013
 * Time: 11:04
 */
namespace app\bis\controller;


class Location extends Base {

    private $bisLocationObj;
    public function _initialize()
    {
        $this->bisLocationObj =model('BisLocation');
    }

    //显示门店列表
    public function index()
    {
        $bis_id =$this->getLoginUser()->bis_id;
        $location = $this->bisLocationObj->where(['bis_id'=>$bis_id])->paginate(3);

        return $this->fetch('',[
            'location'=>$location
        ]);
    }
    //显示新增門店
    public function add()
    {
        return $this->fetch();
    }
    //状态修改达到下架（status=>-1）

    public function status()
    {
        $status =input('status',0,'intval');

        $id = input('id',0,'intval');

        $res = $this->bisLocationObj->save(
            ['status'=>$status],
            ['id'=>$id]
        );
        if(!$res)
        {
            return $this->error('下架失败');
        }
        return $this->success('下架成功');
    }


}
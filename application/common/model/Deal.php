<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/10 0010
 * Time: 13:55
 */
namespace app\common\model;

use think\Model;

class Deal extends  Model{
    //时间戳
    protected $autoWriteTimestamp =true;
    //获取所有的列表商品信息
    public function getAllNormalDeals($bis_id)
    {
        $data =[
          'status' => ['neq',-1],
          'bis_id' => $bis_id
        ];
        $order =[
          'listorder' => 'desc',
          'id' =>'desc',
        ];
        return $this->where($data)->order($order)->paginate(3);
    }

    public function getDealsByCondition($data = [])
    {
        $order = [
          'listorder' =>'desc',
          'id' =>'desc'
        ];
        $res =$this->where($data)->order($order)->paginate(3);
        return $res;
    }

    //根据分类ID和数目查询首页的商品数据
    public function getNormalDealByCategoryId($category_id,$limit = 10,$city_id)
    {
        $data = [
          'category_id' =>$category_id,
            'status' => 1,
            'se_city_id' =>$city_id,
        ];
        $order =[
            'listorder' =>'desc',
            'id' =>'desc'
        ];
        $result = $this->where($data)->order($order);
        if($limit >0)
        {
            $result = $result->limit($limit);
        }
        return $result->select();
    }

}
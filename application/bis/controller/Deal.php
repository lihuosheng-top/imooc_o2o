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
    //商家列表显示
    public function index()
    {
        //获取登录用户的信息
        $bis_id =  $this->getLoginUser()->bis_id;
//        var_dump($bis_id);
        //获取所有
        $deals = $this->obj->getAllNormalDeals(intval($bis_id));
//        dump($deals);

        return $this->fetch('',[
            'deals'=>$deals
        ]);
    }

    /**
     * 添加列表
     */
    public function add()
    {
        //获取当前登录商户的信息
        $bis_id =$this->getLoginUser()->bis_id;
        if(request()->isPost())
        {
                $data =input('post.');
//                dump($data['se_category_id']);

            //准备分类信息字符串，提供给category_path字段使用
            $se_categories_string ='';
            $se_single_categories_string ='';
            if(!empty($data['se_category_id']))
            {
                //获取二级栏目的信息
                $arr = $data['se_category_id'];

                //拼接二级栏目的分类
                $se_single_categories_string =implode('|',$arr);
                //拼接二级栏目的分类，加上主栏目
                $se_categories_string = $data['category_id'].','.$se_single_categories_string;
            }
//                dump('二级'.$se_single_categories_string);
//                dump('二级加'.$se_categories_string);

                //准备勾选了那些分店信息的数据
            $locationId_string = '';
            if(!empty($data['location_ids']))
            {
               $locationId_string = implode(',',$data['location_ids']);
            }

            //准备数据
            //提前，方便後面
            $dealData =[
                'name'=>$data['name'],
                'city_id'=>$data['city_id'],
                'city_path'=>$data['city_id'].','.$data['se_city_id'],
                'se_city_id'=>$data['se_city_id'],
                'category_id' =>$data['category_id'],
                'se_category_id'=>$se_single_categories_string,
                'category_path'=>$se_categories_string,
                'bis_id'=>$bis_id,
                'location_ids'=>$locationId_string,
                'image'=>$data['image'],
                'description'=>$data['description'],
                'start_time' =>strtotime($data['start-time']),
                'end_time' =>strtotime($data['end_time']),
                'origin_price' => $data['origin_price'],
                'current_price' => $data['current_price'],
                'total_count' => $data['total_count'],
                'coupons_begin_time'=>strtotime($data['coupons_begin_time']),
                'coupons_end_time' => strtotime($data['coupons_end_time']),
                'bis_account_id' =>$this->getLoginUser()->id,
                'notes'=>$data['notes']

            ];
            //入库操作
            $res =model('Deal')->save($dealData);
            if(!$res)
            {
                $this->error('添加失败');
            }
            $this->success('添加成功');
        } else{


            //获取城市成功
            $cities = model('City')->getNormalCitiesByParentId();
            $categories =model('Category')->getAllFirstNormalCategories();

            //获取当前商户的所有门店信息
            $locations =model('BisLocation')->where(['bis_id'=>$bis_id])->select();
            return $this->fetch('',[
                'cities'=>$cities,
                'categories' =>$categories,
                'locations' =>$locations,
            ]);


        }

    }



}
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
        //获取城市信息

        if(request()->isPost())
        {
            //入库操作
            $data = input('post.');
            var_dump($data);
            //校验数据
//            $validate = validate('Branch');
//            $res =$validate->scene('add')->check($data);
//            if(!$res)
//            {
//                $this->error($validate->getError());
//            }
            //获取当前的用户的Bis_id
            $bis_id = $this->getLoginUser()->bis_id;

            //准备分类信息字符串，提供给category_path字段使用
            //先声明空字符串
            $se_categories_string ='';
            if(!empty($data['se_category_id']))
            {
                $array =$data['se_category_id'];
                //选择分类。imploade将字符拆分
                $se_categories_string =','.implode('|',$array);
            }
//            准备表的数据(bislocation)
            $locationData =[

                'name'=>$data['name'],
                'logo'=>$data['logo'],
                'address'=>$data['address'],
                'tel'=>$data['tel'],
                'contact'=>$data['contact'],
                'bis_id'=>$bis_id,
                'open_time'=>$data['open_time'],
//                'content'=>$data['content'],
                'is_main'=>1,
                'api_address'=>$data['address'],
                'city_id'=>$data['city_id'],
                'city_path'=>$data['city_id'].','.$data['se_city_id'],
                'category_id'=>$data['category_id'],
                'category_path'=>$data['category_id'].$se_categories_string,

            ];

            //存入数据库
            $res =$this->bisLocationObj->add($locationData);
            if(!$res)
            {
                $this->error('门店信息添加失败');
            }
            else{
                $this->success('门店添加成功');
            }

        }else
        {
            $cities =model('City')->getNormalCitiesByParentId();
            $category =model('Category')->getFirstNormalCategories();
            return $this->fetch('',[
                'cities'=>$cities,
                'categories'=>$category
            ]);

        }

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
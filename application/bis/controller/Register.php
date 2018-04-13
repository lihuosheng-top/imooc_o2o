<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/12 0012
 * Time: 15:57
 */
namespace app\bis\controller;
use think\Controller;

class Register extends Controller{

    public function index()
    {

        //二级城市获取
        $cities =model('City')->getNormalCitiesByParentId();
        //分类
        $category =model('Category')->getAllFirstNormalCategories();

        return $this->fetch('',[
            'city'=>$cities,
            'category'=>$category
        ]);
    }


    //TODO：所属大分类
    public function getCategory()
    {
        //input 获取输入数据，支持默认值，过滤
        $parent_id =input('post.id',0,'intval');
//        实例化model
            $res =model('City')->getNormalCitiesByParentId($parent_id);

        /**
         * 返回封装后的API数据到客户端
         * @access protected
         * @param mixed     $data 要返回的数据
         * @param integer   $code 返回的code
         * @param mixed     $msg 提示信息
         * @param string    $type 返回数据格式
         * @param array     $header 发送的Header信息
         * @return void
         */
            if(!$res)
            {
                return $this->result('',0,'失败');
            }
            return $this->result($res,1,'成功');

    }


    //所属分类的子分类
    public function getCategories()
    {
        $paren_id = input('post.id',0,'intval');
        $res = model('Category')->getAllFirstNormalCategories($paren_id);
        if(!$res)
        {
            return $this->result('',0,'获取失败');
        }
        return $this->result($res,1,'获取成功');
    }

    //TODO:申请按钮触发
    public function regist()
    {
        $data =input('post.');
        //检验商户数据
        $validateAccount =validate('BisAccount');
        $res = $validateAccount->scene('add')->check($data);
        if(!$res)
        {
            $this->error($validateAccount->getError());
        }

        //检测该用户是否已经存在
        if(model('BisAccount')->getAccountByUsername($data['username']))
        {
            $this->error('商户已存在');

        }

        //校验bis
        $validate = validate('Bis');
        $res =$validate->scene('add')->check($data);
        if(!$res)
        {
            $this->error($validate->getError());
        }
        //数据校验bislocation
        $validateLocation =validate('BisLocation');
        $res = $validateLocation->scene('add')->check($data);
        if(!$res)
        {
            $this->error($validateLocation->getError());
        }


        //准备数据提交
        $bisData =[
          'name' =>$data['name'],
          'email' =>$data['email'],
          'logo' =>$data['logo'],
          'licence_logo' =>$data['licence_logo'],
            'description' =>$data['licence_logo'],
            'city_path' => $data['city_id'] . ',' . $data['se_city_id'],
            'bank_info' => $data['bank_info'],
            'bank_name' => $data['bank_name'],
            'bank_user' => $data['bank_user'],
            'faren' => $data['bank_user'],
            'faren_tel' => $data['faren_tel']
        ];

        //提交到数据库，上传到数据库
        $bisId =model('Bis')->add($bisData);
        //准备分类信息字符串，提供给category_path 字段使用
        $array =$data['se_category_id'];
        $se_categoreies_string ='';
        if(!$array)
        {
            //选择分类，imploade将字符拆分
            $se_categoreies_string = implode('|',$array);
        }
        //准备bislocation表的数据
        $locationData =[
            'name'=>$data['name'],
            'logo'=>$data['logo'],
            'address' => $data['address'],
            'tel' => $data['tel'],
            'contact' => $data['contact'],
            'xpoint' => empty($locationResult['result']['location']['lng']) ? '' : $locationResult['result']['location']['lng'],

            'ypoint' => empty($locationResult['result']['location']['lat']) ? '' : $locationResult['result']['location']['lat'],

            'bis_id' => $bisId,
            'open_time' => $data['open_time'],
            'content' => $data['content'],
            'is_main' => 1,

            'api_address' => $data['address'],
            'city_id' => $data['city_id'],
            'city_path' => $data['city_id'] . ',' . $data['se_city_id'],
            'category_id' => $data['category_id'],
            'category_path' => $data['category_id'] . ',' . $se_categoreies_string,
            'bank_info' => $data['bank_info']
        ];
        //存入数据库
        $res =model('BisLocation')->add($locationData);
        if(!$res)
        {
            $this->error('申请失败');
        }
        $this->success('申请加入审核队列成功');
        //以上的列子已经成功申请


    }





}
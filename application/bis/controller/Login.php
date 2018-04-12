<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/12 0012
 * Time: 11:22
 */
namespace app\bis\controller;

use think\Controller;

class Login extends Controller{

    /**
     * 商户登录界面
     */
    public function index(){

        //设置session


        //判断请求来自表单的post请求
        if(request()->isPost())
        {
            //接受请求过来的信息(以下三种方式都可以)
            $data =input('post.');
//            $data =$_POST;
//            $data = request()->post();
            //TODO:common/validate/BisAccount.php
            //数据校验
            $volidate = validate('BisAccount');
            //scene表示验证login场景（该场景定义只需要验证name字段）
            $res =$volidate->scene('login')->check($data);

            if(!$res)
            {
                $this->error($volidate->getError());
            }

            //根据用户名获取用户名
            $result = model('BisAccount')->get([
               'username' =>$data['username'],
            ]);
//            dump($result);
            if(!$result)
            {
                $this->error('该用户不存在或者发生未知错误！');

            }

            //进行密码匹配
            if($result->password !=md5($data['password'].$result->code)){

                $this->error('密码错误，请重新输入');
            }
            //是否存在session

            //密码账号都匹配
            $this->success('登录成功',url('bis/index/index'));

        }


        return $this->fetch();
    }

    public function check()
    {

    }

}
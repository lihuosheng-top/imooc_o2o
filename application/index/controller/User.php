<?php
namespace app\index\controller;
use think\Controller;

class User extends Controller
{
    /**
     * 其中：index是模块，user是控制器(对应User.php)，login是方法
     */
    public function login()
    {
        /**
         * Controller类的fetch函数用于展示对应目录下的视图页面(view/user/login.html) 
         */
       $user =session('o2o_user','','li');
       if($user)
       {
           $this->redirect('index/index');
       }
        return $this->fetch();
    }

    /**
     * 检测登录
     *
     */
    public function  check()
    {
        if(request()->isPost())
        {
            $data =input('post.');
            //校验数据
            $validate =validate('BisAccount');

            $res = $validate->scene('check')->check($data);
            if(!$res)
            {
                $this->error($validate->getError());
            }

            //根据用户名获取用户信息
            $res =model('User')->get(['username'=>$data['username']]);
            if(!$res)
            {
                $this->error('该用户不存在');
            }
            if($res->status !=1 )
            {
                $this->error('该账号未激活，请往邮箱激活');
            }
            //判断密码：
            if($res->password !=md5($data['password'].$res->code))
            {
                $this->error('密码有误');
            }

            //获取用户端的iP地址
            model('user')->save([
                'last_login_time'=>time(),
                'last_login_ip'=> get_client_ip()
            ],['id'=>$res->id]);

            //存入session
            session('o2o_user',$res,'li');
            //界面跳转
            $this->success('登录成功',url('index/index'));

        }
    }

    //退出成功
    public function logout()
    {
        session(null,'li');
        //跳转登录界面
        $this->redirect('user/login');
    }

    /**
     * 其中：index是模块，user是控制器(对应User.php)，login是方法
     */
    public function register()
    {
        /**
         * Controller类的fetch函数用于展示对应目录下的视图页面(view/user/register.html) 
         */
        return $this->fetch();
    }
}

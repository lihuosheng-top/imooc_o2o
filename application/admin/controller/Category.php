<?php
namespace app\admin\controller;
use think\Controller;

class Category extends Controller
{
    // 模型对象
    private $obj;

    // 控制器初始化方法，会在控制器方法调用之前执行
    public function _initialize() {
        $this->obj = model("Category");
    }
    
    public function index()
    {
        //获取parent_id 接受来自子栏目的id
        $parent_id = input('parent_id',0,'intval');
        //通过子model获取数据
        $data = $this->obj->getFirstNormalCategories($parent_id);
        return $this->fetch(
            '',[
                'categories'=>$data
            ]);
    }

    public function status()
    {
        //获取参数
        $data =input();
        //校验
        $validate = validate('Category');
        $res = $validate->scene('status')->check($data);
        if(!$res)
        {
            $this->error($validate->getError());
        }

        //进入数据库修改状态
        $result = $this->obj->save(['status'=>$data['status']],['id'=>$data['id']]);

        if(!$result){
            $this->error('状态更新失败');
        }

        $this->success('状态更新成功');
    }


}

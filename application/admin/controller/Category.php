<?php
namespace app\admin\controller;
use think\Controller;

class Category extends Controller
{
    // 模型对象
    private $obj;

    // 控制器初始化方法，会在控制器方法调用之前执行
    public function _initialize() {
        parent::_initialize();
        $this-> obj = model("Category");
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

    /**
     * 修改状态的函数
     */
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
    /**
     * 进入添加页面
     */
    public function add()
    {
        //一级分类
        $data = $this->obj->getAllFirstNormalCategories();
        return $this->fetch('',[
            'categories' =>$data
        ]);
    }
    /**
     * 添加保存
     */

    public function save()
    {
        //判断是否为post请求
        if(!request()->isPost())
        {
            return '保存失败';
        }
        //获取数据表单数据
       //方法一：

        $data = input('post.');
        //方法二：（原生写法）
//        $data = $_POST;
        //方法三：
//          $data = request()->post();
        //校验数据
        $validate = validate('Category');
        //在需要验证的地方直接使用 scene 方法验证，check方法为检验什么数据
        $res = $validate->scene('add')->check($data);
        if(!$res) {
            $this->error($validate->getError());
        }
        //添加失败
        $result = $this->obj->save($data);

        if(!$result)
        {
            $this->error('添加失败');
        }
        //成功跳回category/index页面
        $this->success('添加成功',url('Category/index'));
//        $this->redirect('','','','');

    }


    /**
     * 进入编辑页面
     */
    public function edit()
    {
        /**
         * 获取输入数据 支持默认值和过滤
         * @param string    $key 获取的变量名
         * @param mixed     $default 默认值
         * @param string    $filter 过滤方法
         * @return mixed
         */
        $id = input('id',0,'intval');
        //根据Id获取一行的信息
        $category = $this->obj->get($id);
        $data = $this->obj->getAllFirstNormalCategories();
        return $this->fetch('',[
            'category'=>$category,
            'categories'=>$data
            ]);



    }

    /**
     * 编辑保存
     */
    public function update(){
            //当我们不知道是什么方式传输数据时使用
        $data =input();
        $validate =validate('Category');
        $res =$validate->scene('update')->check($data);
        if(!$res)
        {
            $this->error($validate->getError());
        }
        //修改数据
        $result = $this->obj->save([
            'name'=>$data['name'],
            'parent_id'=>$data['parent_id'],
        ],
        [
            'id'=>$data['id'],
        ]);
        if (!$result)
        {
            $this->error('编辑失败');
        }
        $this->success('编辑成功',url('Category/index'));
    }

    /**
     * 排序
     */
    public function listorder()
    {
        //获取数据表单数据
        $data =input('post.');
        //数据校验
        $validate =validate('Category');
        $res =$validate->scene('listorder')->check($data);
        if(!$res)
        {
            $this->error($validate->getError());
        }
        $result = $this->obj->save([
            'listorder'=>$data['listorder']
        ],[
            'id'=>$data['id']
        ]);

        if(!$result)
        {
            $this->result($_SERVER['HTTP_REFERER'],0,'ERROR');
        }

        $this->result($_SERVER['HTTP_REFERER'],1,'success');
    }
}

<?php
// 应用公共文件


//获取当前客户端的IP
function get_client_ip($type = 0)
{
    $type = $type ?1 : 0;
    static $ip = NULL;
    if($ip !== NUll) return $ip[$type];
    if(isset($_SERVER['HTTP_X_REAL_IP'])){//nginx 代理模式下，获取客户端真实IP
        $ip = $_SERVER['HTTP_X_REAL_IP'];
    }elseif (isset($_SERVER['HTTP_CLIENT_IP'])){
        //客户端的ip
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //浏览当前页面的用户计算机的网关
        $arr = explode(',',$_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos = array_search('unknown',$arr);
        if(false !== $pos) unset($arr[$pos]);
        $ip = trim($arr[0]);
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        //浏览当前页面的用户计算机的IP地址
        $ip = $_SERVER['REMOTE_ADDR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u", ip2long($ip));
    $ip = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];

}

//状态映射（前端界面用到的$vo.status |status方法）

function status($status)
{
    if($status == 1)
    {
        return "<label class='label label-success radius'>正常</label>";
    }else if ($status == 0) {
        return "<label class='label label-danger radius'>待审核</label>";
    }else if($status == -1) {
        return "<label class='label label-danger radius'>删除</label>";
    }else if ($status == 2) {
        return "<label class='label label-danger radius'>未通过</label>";
    }
}
//设置分页方法
function pagination($pageObj)
{
    if(!$pageObj)
    {
        return '';
    }
    $result = "<div class='cl pd-5 bg-1 bk-gray mt-20 tp5-o2o'>" .$pageObj->render() ."</div>";

    return $result;
}
//封装这个函数(通过category的id获取分类的名称)

function getCategoryNameByCategoryId($category_id)
{
    if(empty($category_id))
    {
        return '';
    }
    $category = model("Category")->get($category_id);
    return $category->name;
}
//通过cityid获取城市名字
function getCityNameByCityId($city_id)
{
    if(empty($city_id))
    {
        return '';
    }
    $city =model('City')->get($city_id);
    return $city->name;

}

<?php
// 应用公共文件

/**
 * @param $url 请求的url
 * @param int $type 请求的方式0是get  1是post
 * @param array $data 请求的数据
 */
function doCurl($url,$type=0,$data=[])
{

    //初始化curl
    $ch=curl_init();
    //设置相关的参数set option
    //CURLOPT_UR 请求的链接curlopt
    //CURLOPT_RETURNTRANSFER 请求结果以文本流形式返回returntransfer
    //CURLOPT_HEADE 是否返回http头部信息
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_HEADER,0);

    //判断请求方式
    if($type==1)
    {
        //post 请求
        curl_setopt($ch,CURLOPT_POST,$url);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
    }
    //执行Curl请求
    $res =curl_exec($ch);
    //关闭Curl请求
    curl_close($ch);
    return $res;
}

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

//根据category_path处理二级分类信息
function getCategoryDetailByPath($category_path)
{
    if(empty($category_path))
    {
        return '';
    }
    if(preg_match('/,/',$category_path))
    {
        //先按照，号切割字符床（temp临时的，中间量的）
        $tempArray = explode(',',$category_path);
        //'5,10 |12|14'=>['5','10|12|14']

        $categoryID =$tempArray[0];
        $tempString =$tempArray[1];

        //按照分割形成数组

        $temp_se_arr =explode('|',$tempString);

        //[10,12,14]5分支下共有10,12,14,16,18
        $allCategories =model('Category')->getAllFirstNormalCategories(intval($categoryID));
        //循环组合形成input标签字符串
        $htmlString ='';
        //遍历

        for($e=0;$e<count($allCategories);$e++)
        {
            $current = $allCategories[$e];
            //循环匹配temp_se_arr
            for($j=0;$j<count($temp_se_arr);$j++)
            {
                $se_current =$temp_se_arr[$j];
                //判断当前current_id的是否存在em_se_arr中
                if(in_array($current['id'],$temp_se_arr))
                {
                    $htmlString .="<input type='checkbox' value='".$current['id']."' checked>";
                    $htmlString .="<label>".$current['name']."</label>";
                }
            }

        }
        return $htmlString;
    }
    else{
        return '';
    }

}

//根據is_main判斷是屬於分店還是總店

function checkMain($status)
{
    if($status == 1)
    {
        return "<label class='label label-success radius'>总店</label>";
    }else if($status == 0)
    {
        return "<label class='label label-secondary radius'>分店</label>";
    }
}




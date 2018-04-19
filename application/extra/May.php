<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/19 0019
 * Time: 16:16
 */


/**
 * 百度地图(http://lbsyun.baidu.com/apiconsole/key) 扩展配置
 */
return [
    //方便拼接（如）
//    http://api.map.baidu.com/staticimage/v2
//?ak=E4805d16520de693a3fe707cdc962045&mcode=666666&center=116.403874,39.914888
//&width=300&height=200&zoom=11
    'baidu_map_url'=>'http://api.map.baidu.com/',
    //Geocoding api配置
    'geocoder'=>'geocoder/v2/',//v2后面有横线
    //静态图api配置
    'staticImage'=>'staticimage/v2',//v2后面没有横线
    //百度地图应用 访问ak
    'ak'=>'rPsDCv32GlrrGg3iYMG3ZuNMj5QnajyR',
    'width'=>300,
    'height'=>200,
    'output'    => 'json',//返回数据为json格式




];
<?php
/**
 * 百度静态地图封装
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/19 0019
 * Time: 16:35
 */
class Map{

    /**
     * 根据地址获取经纬度
     * @param $address
     */
    public static  function getLngLat($address){
        // 发送一个地址是“百度大厦”的请求，返回该地址对应的地理坐标。示例URL如下：
        // http://api.map.baidu.com/geocoder/v2/?address=深圳市振兴商业大厦5号&output=
        //json&ak=E4805d16520de693a3fe707cdc962045&callback=showLocation


        if(!$address)
        {
            return '';
        }
        //参数一：
        $data =[
            //查询地址
            'address'=>$address,
            //扩展配置-百度地图
            'ak'=>config('Map.ak'),
            'output'=>config('Map.output'),//返回数据为json格式 默认xml
        ];

        //2、拼接查询的url
        $url =config('Map.baidu_map_url').config('Map.geocoder').'?'.http_build_query($data);
        //3、获取内容
        dump($url);
         $res =file_get_contents($url);
//         dump($res);

         return $res;

    }

    /**
     * 根据经纬度或者标注地址获取百度静态地图
     * @param $center
     */
    public static function staticImage($center)
    {
        if(!$center)
        {
            return '';
        }

        $data =[
            //服务地址http://api.map.baidu.com/staticimage/v2
            // 测试http://api.map.baidu.com/staticimage/v2?ak=
            //sK0wQFqCiIqy59wpcadHDCzkZCyCcLx9&width=280&height=140&zoom=10
            'ak' =>config('Map.ak'),
            'width'=>config('Map.width'),
            'height'=>config('Map.height'),
            'center'=>$center,
            'markers'   => $center,// 标注,多个地名/经纬度用竖线分割

        ];
        // 2 拼装查询url
        $url = config('Map.baidu_map_url').config('Map.staticImage').'?'.http_build_query($data);

        // 3 获取内容
        // 方式1. file_get_contents($url);
        // 方式2. curl 需要自己封装一个方法common/php--doCurl();
//        $result = doCurl($url);
        // 4 返回经纬度
        $result =file_get_contents($url);

        return $result;

    }






}
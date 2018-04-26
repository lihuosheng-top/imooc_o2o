<?php
/**
 * 百度地图封装
 * Created by PhpStorm.
 * User: zouqianli
 * Date: 2017/8/23
 * Time: 00:34
 */

class Map
{
    /**
     * 根据地址获取经纬度
     * @param $address地址
     */
    public static function getLngLat($address)
    {// 发送一个地址是“百度大厦”的请求，返回该地址对应的地理坐标。示例URL如下：
// http://api.map.baidu.com/geocoder/v2/?address=北京市海淀区上地十街10号&output=json&ak=E4805d16520de693a3fe707cdc962045&callback=showLocation
        if(!$address)
        {
            return '';
        }
        // 1 参数
        $data = [
            'address' => $address, // 查询地址
            'ak'    => config('Map.ak'), // 扩展配置--百度地图
            'output'    => config('Map.output'), // 百度地图 返回数据为json格式 默认xml格式
        ];

        // 2 拼装查询url
        $url = config('Map.baidu_map_url').config('Map.geocoder').'?'.http_build_query($data);

        // 3 获取内容
        // 方式1. file_get_contents($url);
        // 方式2. curl 需要自己封装一个方法common/php--doCurl();
        $result = doCurl($url); // 默认get
        // dump($result);exit; // 调试是否获取数据
        // 4 返回经纬度
        return $result;

    }

    /**
     * 根据经纬度或者标注地址获取百度静态地图
     * @param $center
     */
    public static function staticImage($center)
    {//服务地址http://api.map.baidu.com/staticimage/v2
        // 测试http://api.map.baidu.com/staticimage/v2?ak=sK0wQFqCiIqy59wpcadHDCzkZCyCcLx9&width=280&height=140&zoom=10
        if(!$center)
        {
            return '';
        }
        // 1 参数
        $data = [
            'ak'    => config('Map.ak'),
            'width' => config('Map.width'),
            'height'    => config('Map.height'),
            'center'    => $center,// 地图中心点,默认北京
            'markers'   => $center,// 标注,多个地名/经纬度用竖线分割
            'zoom'=>11,
            'scale'=>3
        ];

        // 2 拼装查询url
        $url = config('Map.baidu_map_url').config('Map.staticImage').'?'.http_build_query($data);

        // 3 获取内容
        // 方式1. file_get_ontents($url);
        // 方式2. curl 需要自己封装一个方法common/php--doCurl();
        $result = doCurl($url);
        // 4 返回经纬度
        return $result;
    }
}


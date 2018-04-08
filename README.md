
## 数据库所在位置：
├─vendor                第三方类库目录（Composer依赖库，数据库包:database）
│  ├─database           数据库相关语句
## 前端模块 index
    1]引入静态资源的时候需要特别注意文件的路劲__STATIC__/index/.....(js,css,image)
        (1)设及到的配置：conf.php
        // 视图输出字符串内容替换
    'view_replace_str'       => [
//        '__STATIC__' => '/static',
    ],
## 后台模块 admin



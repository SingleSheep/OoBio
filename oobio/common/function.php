<?php
/**
 * Oobio - 简单、高效的PHP微框架
 * Copyright (c) 2018 Oobio . All rights reserved.
 * Author: 勇敢的小笨羊
 * Github: https://github.com/superpig595/OoBio
 * Weibo: http://weibo.com/xuzuxing
 *
 */


// oobio 公共函数库

function cout($text){
    if(is_array($text)){
        echo '<pre style="font-size:18px;border:dashed 1px blue;padding:5px;display:inline-block;margin:0;">'.print_r($text).'</pre><br/>';
    }else{
        echo '<pre style="font-size:18px;border:dashed 1px blue;padding:5px;display:inline-block;margin:0;">'.$text.'</pre><br/>';
    }
}


/**
 * Config 配置读取函数
 * @param $key //配置项key 或  配置文件名
 * @param null $file [optional]  配置文件名
 * @return mixed
 * @throws Exception
 */
function C($key,$file=NULL){
    if($file){
        return \oobio\lib\Conf::get($key, $file); # 单个配置读取
    }else{
        return \oobio\lib\Conf::all($key); # 整个配置文件读取
    }
}

/**
 * 数据库对象初始化函数
 * @return \Medoo\Medoo|null
 * @throws Exception
 */
function M(){
    static $db=NULL;
    if($db==NULL){
        $db=new \Medoo\Medoo(C('database'));
    }
    return $db;
}

/**
 * 用户上传文件唯一命名UID
 * @param int $size 随机字符串长度
 * @return string
 */
function getuid($size=8){
    $chars='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $rand_str=null;
    for($i=0;$i<$size;$i++){
        $rand_str.=$chars[mt_rand(0,61)];
    }
    return time().$rand_str;
}

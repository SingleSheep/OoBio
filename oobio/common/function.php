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
 * config 配置读取函数
 * @param  $key             配置项key 或  配置文件名
 * @param  $file[optional]  配置文件名
 */
function C($key,$file=NULL){
    if($file){
        return \oobio\lib\conf::get($key,$file); # 单个配置读取
    }else{
        return \oobio\lib\conf::all($key); # 整个配置文件读取
    }
}

/**
 * 数据库对象初始化函数s
 * @param   $dbname 数据库名[optional]
 * @return  $db     PDO对象
 */
function M(){
    static $db=NULL;
    if($db==NULL){
        $db=new \Medoo\Medoo(C('database'));
    }
    return $db;
}

/**
 * 获取 POST 参数
 * @param  $name    对应值
 * @param  $default 默认值
 * @param  $fitt    过滤方法 [int]
 */
function post($name,$default=false,$fitt=false){
    if(isset($_POST[$name])){
        if($fitt){
            switch($fitt){
                case 'int':{
                    if(is_numeric($_POST[$name])){
                        return $_POST[$name];
                    }else{
                        return $default;
                    }
                    break;
                }
                default:{break;}
            }
        }else{
            return $_POST[$name];
        }
    }else{
        return $default;
    }
}

/**
 * 获取 GET 参数
 * @param $name 对应值
 * @param bool $default 默认值
 * @param bool $fitt    过滤方法
 * @return bool
 */
function get($name,$default=false,$fitt=false){
    if(isset($_GET[$name])){
        if($fitt){
            switch($fitt){
                case 'int':{
                    if(is_numeric($_GET[$name])){
                        return $_GET[$name];
                    }else{
                        return $default;
                    }
                    break;
                }
                default:{break;}
            }
        }else{
            return $_GET[$name];
        }
    }else{
        return $default;
    }
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

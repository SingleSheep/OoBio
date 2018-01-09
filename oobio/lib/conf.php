<?php
/**
 * Oobio - 简单、高效的PHP微框架
 * Copyright (c) 2018 Oobio . All rights reserved.
 * Author: 勇敢的小笨羊
 * Github: https://github.com/superpig595/OoBio
 * Weibo: http://weibo.com/xuzuxing
 *
 */

// Oobio 配置类

namespace oobio\lib;


class conf{

    /**
     * @var array
     */
    public static $conf=array();

    /**
     * 配置读取
     * @param $name
     * @param $file
     * @return mixed
     * @throws \Exception
     */
    public static function get($name = null ,$file = 'config'){
        /**
         * 1.判断配置文件是否存在
         * 2.判断配置是否存在
         * 3.缓存配置
         */
        if(isset(self::$conf[$file])){
            return self::$conf[$file][$name];
        }else{
            $path= CONF_PATH . $file.'.php';
            if(is_file($path)){
                $conf=include $path;
                if(isset($conf[$name])){
                    self::$conf[$file]=$conf;
                    return $conf[$name];
                }else{
                    return $conf;
                    //throw new \Exception('没有这个配置项'.$name);
                }
            }else{
                throw new \Exception('找不到配置文件'.$file);
            }
        }
    }

    /**
     *
     * @param $file
     * @return mixed
     * @throws \Exception
     */
    public static function all($file){
        if(isset(self::$conf[$file])){
            return self::$conf[$file];
        }else{
            $path= CONF_PATH . $file.'.php';
            if(is_file( $path )){
                $conf = include $path;
                self::$conf[$file] = $conf;
                return $conf;
            }else{
                throw new \Exception('找不到配置文件'.$file);
            }
        }
    }
}
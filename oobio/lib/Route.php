<?php
/**
 * Oobio - 简单、高效的PHP微框架
 * Copyright (c) 2018 Oobio . All rights reserved.
 * Author: 勇敢的小笨羊
 * Github: https://github.com/superpig595/OoBio
 * Weibo: http://weibo.com/xuzuxing
 *
 */

// Oobio 路由解析类

namespace oobio\lib;

class Route
{

    public $module=MODULE; #默认模块
    public $controller; #控制器
    public $action; #类方法

    public function __construct(){
        // xxx.com/index.php/index/index
        // xxx.com/index/index
        /**
         * 1.隐藏index.php
         * 2.获取URL参数部分
         * 3.返回对应控制器和方法
         */

        $path = strstr($_SERVER['REQUEST_URI'],'?',true); # 去掉URL?号后面字符串(包括?)
        $path = $path?$path:$_SERVER['REQUEST_URI'];
        if(isset($_SERVER['REQUEST_URI'])&&$path!='/'){
            // admin/index/index/id/01/name/dejan/sex/man
            //  [0] /[1] /[2] /[3]/[4]/[5] /[6] /[7] /[8]

            // index/index/id/01/name/dejan/sex/man
            //  [0]/[1] /[2]/[3]/[4] / [5] /[6]/[7]
            $path = str_replace('.html', '', $path);
            $patharr = explode('/',trim($path,'/'));
            if(isset($patharr[0])){
                // 判断访问应用模块
                if(is_dir(APP.'/'.$patharr[0])){
                    $this->module = $patharr[0];
                    $this->controller = isset($patharr[1]) ? $patharr[1] : Conf::get('CONTROLLER', 'route');
                    if(isset($patharr[2])){
                        $this->action = $patharr[2];
                    }else{
                        $this->action = Conf::get('ACTION', 'route');
                    }
                    $i=3; // GET参数获取索引起始位置
                }else{ // 默认 Home 模块
                    $this->controller=$patharr[0];
                    if(isset($patharr[1])){
                        $this->action=$patharr[1];
                    }else{
                        $this->action = Conf::get('ACTION', 'route');
                    }
                    $i=2; // GET参数获取索引起始位置
                }
            }

            //url多余部分转成 GET
            //id/01/name/dejan/sex/man
            $count=count($patharr);
            while($i<$count){
                if(!isset($patharr[$i+1])){ // 数组越界处理
                    break;
                }
                $_GET[$patharr[$i]]=$patharr[$i+1];
                $i=$i+2;
            }
        }else{
            $this->controller = Conf::get('CONTROLLER', 'route');
            $this->action = Conf::get('ACTION', 'route');
        }

        // 加载公共函数库
        if(is_file(APP. '/common/function.php')){
            include APP.'/common/function.php';
        }
        // 加载模块函数库
        if(is_file(APP.'/'.$this->module.'/common/function.php')){
            include APP.'/'.$this->module.'/common/function.php';
        }
    }
}
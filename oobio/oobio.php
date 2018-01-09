<?php
/**
 * Oobio - 简单、高效的PHP微框架
 * Copyright (c) 2018 Oobio . All rights reserved.
 * Author: 勇敢的小笨羊
 * Github: https://github.com/superpig595/OoBio
 * Weibo: http://weibo.com/xuzuxing
 *
 */

// Oobio 公共入口文件

namespace oobio;
use oobio\lib\log;
use oobio\lib\Request;
use oobio\lib\Route;

class oobio{

    public static $classMap = [];
    public $data = [];
    public static $module; //访问模块
    public static $controller; // 访问控制器
    public static $action; // 访问方法


    /**
     * 启动框架
     * @throws \Exception
     */
    public static function run(){
        //实例路由s
        $route = new Route();
        $request = new Request();

        self::$module       =   $route->module;
        self::$controller   =   $route->controller;
        self::$action       =   $route->action;

        $ctrlClass = '\\app\\' . self::$module . '\\controller\\' . self::$controller;
        $prm = $_POST?$_POST:$_GET;
        //  参数绑定
        self::url_params_bind($ctrlClass,self::$action,$prm);


        log::init();
        //log::record('[ ROUTE ] controller:'.$ctrlClass .' action:'.self::$action, 'info');
        Log::record('[ HEADER ] ' . var_export($request->header(), true), 'info');
        //Log::record('[ PARAM ] ' . var_export($request->param(), true), 'info');
    }



    public static function load($class){
        if(isset($classMap[$class])){
            return true;
        }else{
            $class = str_replace('\\','/',$class);
            if(is_file(ROOT.'/'.$class.'.php')){
                include ROOT.'/'.$class.'.php';
                self::$classMap[$class]=$class;
            }else{
                return false;
            }
        }
    }

    /***
     * 模板变量输出
     * @param $name
     * @param string $value
     * @return $this
     */
    public function assign($name, $value = '')
    {
        if (is_array($name)) {
            $this->data = array_merge($this->data, $name);
        } else {
            $this->data[$name] = $value;
        }
        return $this;
    }

    /**
     * 模板展示输出
     * @param null $file
     * @param null $data
     * @param string $ext
     * @throws \Exception
     */
    public function display($file = NULL ,$data = NULL ,$ext = ".html"){
//        if (isset($data)){
//            $this->data[$]
//        }
        $sourcefile = $file ? $file . $ext: self::$action . $ext; //模板文件重命名
        // TEMPPLATE_PATH . . self::$module . self::$controller . DS .$sourcefile;
        $path = TEMPPLATE_PATH . self::$module . self::$controller . DS .$sourcefile ?
                TEMPPLATE_PATH . self::$module . DS . self::$controller . DS .$sourcefile :
                TEMPPLATE_PATH . self::$controller . DS .$sourcefile;//模板文件地址拼接
        if(is_file($path)){
            //smarty实例化
            $smarty = new \Smarty();
            $smarty->left_delimiter = "{";
            $smarty->right_delimiter = "}";
            $smarty->setConfigDir(CONF_PATH );
            $smarty->setTemplateDir(TEMPPLATE_PATH); //设置模板目录
            $smarty->setCompileDir(RUNTIME_PATH . '/templates/cache');
            $smarty->setCacheDir(RUNTIME_PATH . '/templates/smarty_cache/');
            $smarty->assign($this->data ? $this->data : []);
            $smarty->display($path);
        }else{
            throw new \Exception('模板文件不存在:'.$path);
        }
    }

    /**
     * 通过反射进行参数绑定调起类的方法
     * @param  $controller  //控制器类   xxx::classs
     * @param  $action     //访问的成员方法名
     * @param  $param_arr  //参数数组['id'=>123,'name'=>'Oobio']
     */
    static public function url_params_bind($controller,$action,$param_arr){
        // 获取类的反射
        $controllerReflection = new \ReflectionClass($controller);

        // 判断该类是否可实例化对象
        if (!$controllerReflection->isInstantiable()) {
            throw new \RuntimeException("{$controllerReflection->getName()}控制器类不能被实例化!");
        }

        // 判断指定成员方法是否存在
        if (!$controllerReflection->hasMethod($action)) {
            throw new \RuntimeException("{$controllerReflection->getName()}找不到类方法:{$action}");
        }
        // 获取对应方法的反射
        $actionReflection = $controllerReflection->getMethod($action);
        // 获取方法的参数的反射列表（多个参数反射组成的数组）
        $paramReflectionList = $actionReflection->getParameters();
        // 参数，用于action
        $params = [];
        # 循环参数反射
        # 如果存在路由参数的名称和参数的名称一致，就压进params里面
        # 如果存在默认值，就将默认值压进params里面
        # 如果。。。没有如果了，异常
        foreach ($paramReflectionList as $paramReflection) {
            # 是否存在同名字的路由参数
            if (isset($param_arr[$paramReflection->getName()])) {
                $params[] = $param_arr[$paramReflection->getName()];
                continue;
            }
            # 是否存在默认值
            if ($paramReflection->isDefaultValueAvailable()) {
                $params[] = $paramReflection->getDefaultValue();
                continue;
            }
            # 抛出异常
            throw new \RuntimeException(
                "{$controllerReflection->getName()}::{$actionReflection->getName()}的参数{$paramReflection->getName()}必须传值"
            );
        }

        # 调起
        $actionReflection->invokeArgs($controllerReflection->newInstance(), $params);
    }
}
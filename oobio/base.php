<?php
/**
 * Oobio - 简单、高效的PHP微框架
 * Copyright (c) 2018 Oobio . All rights reserved.
 * Author: 勇敢的小笨羊
 * Github: https://github.com/superpig595/OoBio
 * Weibo: http://weibo.com/xuzuxing
 *
 */

// Oobio 基础文件
define('OOBIO_VERSION', '1.0');
define('DS', DIRECTORY_SEPARATOR);
defined('MODULE') or define('MODULE', 'index'); // 默认访问
defined('ROOT') or define('ROOT', dirname(realpath('./')) . DS); //当前项目根目录路径;
defined('CORE') or define('CORE', ROOT.'oobio' .DS);//框架的核心文件目录
defined('DEBUG') or define('DEBUG', true);//是否开启调试模式
defined('APP') or define('APP', ROOT . 'app'. DS);//项目文件目录
defined('DATA_PATH') or define('DATA_PATH', ROOT . 'data' . DS);//数据目录
defined('CONF_PATH') or define('CONF_PATH', DATA_PATH . 'conf' . DS); // 配置目录
defined('TEMPPLATE_PATH') or define('TEMPPLATE_PATH', ROOT . 'template'. DS);//模板文件目录
defined('RUNTIME_PATH') or define('RUNTIME_PATH', DATA_PATH . 'runtime' . DS); //Runtime目录
defined('ENV_PREFIX') or define('ENV_PREFIX', 'PHP_'); // 环境变量的配置前缀

// 环境常量
define('IS_CLI', PHP_SAPI == 'cli' ? true : false);
define('IS_WIN', strpos(PHP_OS, 'WIN') !== false);

if(DEBUG){

    //炫酷的报错
    $whoops = new \Whoops\Run();
    $errorTitle = "框架出现错误 - Whoops! - Power By Oobio";
    $option = new \Whoops\Handler\PrettyPageHandler();
    $option->setPageTitle($errorTitle);
    $whoops->pushHandler($option);
    $whoops->register();

    //Smarty模板引擎
    $smarty = new \Smarty();
    $smarty->caching        = false;
    $smarty->cache_lifetime = 0;

    ini_set('display_error','On');
}else{
    //Smarty模板引擎
    $smarty->caching        = true;
    $smarty->cache_lifetime = 120;
    ini_set('display_error','Off');
}

//自动加载
spl_autoload_register('\oobio\oobio::load');
//时区设置
ini_set('date.timezone','Asia/Shanghai');

// 加载环境变量配置文件
if (is_file(ROOT . '.env')) {
    $env = parse_ini_file(ROOT . '.env', true);

    foreach ($env as $key => $val) {
        $name = ENV_PREFIX . strtoupper($key);

        if (is_array($val)) {
            foreach ($val as $k => $v) {
                $item = $name . '_' . strtoupper($k);
                putenv("$item=$v");
            }
        } else {
            putenv("$name=$val");
        }
    }
}
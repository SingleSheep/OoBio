<?php
/**
 * Oobio - 简单、高效的PHP微框架
 * Copyright (c) 2018 Oobio . All rights reserved.
 * Author: 勇敢的小笨羊
 * Github: https://github.com/superpig595/OoBio
 * Weibo: http://weibo.com/xuzuxing
 *
 */

//入口文件

//项目目录
define('APP', __DIR__ . '/../app/');
//是否开启调试模式
define('DEBUG', true);
//加载启动文件
require __DIR__ . '/../oobio/start.php';
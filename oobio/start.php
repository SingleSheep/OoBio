<?php
/**
 * Oobio - 简单、高效的PHP微框架
 * Copyright (c) 2018 Oobio . All rights reserved.
 * Author: 勇敢的小笨羊
 * 微博: http://weibo.com/xuzuxing
 * Date: 2018/1/8
 */

// Oobio 入口文件
namespace oobio;
//  引导文件
// 1. 加载基础文件
require __DIR__ . ('/../vendor/autoload.php');
require __DIR__ . '/common/function.php';
require __DIR__ . '/oobio.php';
require __DIR__ . '/base.php';

// 2. 执行应用
oobio::run();
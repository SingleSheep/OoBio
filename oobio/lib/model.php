<?php
/**
 * Oobio - 简单、高效的PHP微框架
 * Copyright (c) 2018 Oobio . All rights reserved.
 * Author: 勇敢的小笨羊
 * 微博: http://weibo.com/xuzuxing
 * Date: 2018/1/8
 */

// Oobio 模型类

namespace oobio\lib;
use Medoo\Medoo;

class model extends Medoo
{
    public function __construct()
    {
        $options = conf::all('database');
        parent::__construct($options);
    }

}
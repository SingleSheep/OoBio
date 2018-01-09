<?php
/**
 * Oobio - 简单、高效的PHP微框架
 * Copyright (c) 2018 Oobio . All rights reserved.
 * Author: 勇敢的小笨羊
 * Github: https://github.com/superpig595/OoBio
 * Weibo: http://weibo.com/xuzuxing
 *
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
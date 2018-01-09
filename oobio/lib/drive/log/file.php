<?php
/**
 * Oobio - 简单、高效的PHP微框架
 * Copyright (c) 2018 Oobio . All rights reserved.
 * Author: 勇敢的小笨羊
 * Github: https://github.com/superpig595/OoBio
 * Weibo: http://weibo.com/xuzuxing
 *
 */

// Oobio 日志类文件形式保存驱动类

namespace oobio\lib\drive\log;
use oobio\lib\conf;

class file{

    public $path;#日志存储位置


    public function __construct(){
       $conf = conf::get('OPTION','log');
       $this->path = $conf['PATH'];
    }

    /**
     * @param $message
     * @return bool|int
     */
    public function save($message){
        /**
         * 1.确认文件存储位置是否存在
         *  新建目录
         * 2.写入日志
         */
        $this->path=$this->path.date('Ymd').'/';
        if(!is_dir($this->path)){
            mkdir($this->path,'0777',true);
        }
        return file_put_contents($this->path . date('Ymdh'). '.php', date('Y-m-d H:i:s').json_encode($message).PHP_EOL,FILE_APPEND);
    }

}


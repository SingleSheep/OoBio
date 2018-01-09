<?php
/**
 * Created by 小羊.
 * Author: 勇敢的小笨羊
 * 微博: http://weibo.com/xuzuxing
 * Date: 2018/1/9
 * Time: 15:43
 */
namespace app\index\model;

use oobio\lib\model;

class User extends model
{
    protected $table = "user";

    public function lists()
    {
        $result = $this->select($this->table, '*');
        return $result;
    }

}
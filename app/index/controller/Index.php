<?php
namespace app\index\controller;

use app\index\model\User;
use oobio\lib\Request;
use oobio\oobio;

class Index extends oobio
{

    /**
     *
     * @throws \Exception
     */
    public function index(){
        $this->assign([
            'data' => '变量绑定输出'
        ]);
        $this->display('', ['siteTitle' => 'OoBox PHP']);
    }

    /**
     * 测试调用公共函数
     */
    public function func(){
        get_path(); // 最外层公共函数库
        get_path_r(); // 模块公共函数库
    }
    
    /**
     * 测试URL参数绑定
     */
    public function urlPrmBind($id,$name='Dejan'){
        echo "id:{$id}&nbsp;&nbsp;name:{$name}";
        dump($_GET);
    }
    
    /**
     * 数据库操作测试
     */
    public function getData(){
        print_r(M()->select('user_content','*'));
    }
}
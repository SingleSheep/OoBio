<?php
namespace app\index\controller;

use oobio\lib\conf;
use oobio\oobio;

class indexController extends oobio{

    /**
     *
     * @throws \Exception
     */
    public function index(){
        $data = '这是网站前台模块!';
        $this->assign('data',$data);
        return $this->display('',['siteTitle'  =>  'OoBox PHP']);
    }

    public function test(){
        $data = 'test';
        $this->assign('data',$data);
       return $this->display();
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
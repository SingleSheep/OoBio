<?php
namespace app\index\controller;

use oobio\lib\Request;
use oobio\oobio;
use Sheep\payment\Pay;

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

    public function pay(){
        $config = [
            'wechat' => [
                'app_id'    =>'wx1c32cda245563ee1',
                'mch_id'    =>'1493758822',
                'mch_key'   =>'06c56a89949d617def52f371c357b6db',
                'ssl_cer'   =>'',
                'ssl_key'   =>'',
                'notify_url'=>'https://openapi.98imo.com/wxpay/notify'
            ],
            'alipay' => [
                'app_id'        => '',
                'public_key'    => '',
                'private_key'   => '',
                'notify_url'    => ''
            ]
        ];

        $Request = new Request();
        $driver  = $Request::get('driver');
        $gateway = $Request::get('gateway');
        switch ($driver){
            case 'alipay':
                $order = [
                    'out_trade_no' => time(),
                    'total_amount' => '0.01', //微信 total_fee
                    'subject'      => 'test subject-测试订单',//微信 body
                ];
                break;
            default:
                $order = [
                    'out_trade_no' => time(),
                    'total_fee' => '1', //微信 total_fee  //单位：分
                    'body'      => 'test subject-测试订单',//微信 body
                ];
                break;
        }
        $pay = new Pay($config);
        $result = $pay->driver($driver)->gateway($gateway)->pay($order);
        return $result;
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
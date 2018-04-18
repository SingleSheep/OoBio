<?php
/**
 * Oobio - 简单、高效的PHP微框架
 * Copyright (c) 2018 Oobio . All rights reserved.
 * Author: 勇敢的小笨羊
 * Github: https://github.com/SingleSheep/OoBio
 * Weibo: http://weibo.com/xuzuxing
 *
 */


namespace oobio\lib;

class Request
{
    /**
     * @var array 请求参数
     */
    protected $param   = [];

    /**
     * @var array
     */
    protected $get     = [];

    /**
     * @var array
     */
    protected $post    = [];

    /**
     * @var array
     */
    protected $request = [];

    /**
     * @var array
     */
    protected $route   = [];

    /**
     *
     */
    protected $put;

    /**
     * @var array
     */
    protected $session = [];

    /**
     * @var array
     */
    protected $file    = [];

    /**
     * @var array
     */
    protected $cookie  = [];

    /**
     * @var array
     */
    protected $server  = [];

    /**
     * @var array
     */
    protected $header  = [];
    
    /**
     * 设置或者获取当前的Header
     * @access public
     * @param string|array  $name header名称
     * @param string        $default 默认值
     * @return string
     */
    public function header($name = '', $default = null)
    {
        if (empty($this->header)) {
            $header = [];
            if (function_exists('apache_request_headers') && $result = apache_request_headers()) {
                $header = $result;
            } else {
                $server = $this->server ?: $_SERVER;
                foreach ($server as $key => $val) {
                    if (0 === strpos($key, 'HTTP_')) {
                        $key          = str_replace('_', '-', strtolower(substr($key, 5)));
                        $header[$key] = $val;
                    }
                }
                if (isset($server['CONTENT_TYPE'])) {
                    $header['content-type'] = $server['CONTENT_TYPE'];
                }
                if (isset($server['CONTENT_LENGTH'])) {
                    $header['content-length'] = $server['CONTENT_LENGTH'];
                }
            }
            $this->header = array_change_key_case($header);
        }
        if (is_array($name)) {
            return $this->header = array_merge($this->header, $name);
        }
        if ('' === $name) {
            return $this->header;
        }
        $name = str_replace('_', '-', strtolower($name));
        return isset($this->header[$name]) ? $this->header[$name] : $default;
    }

    /**
     * 获取 POST 参数
     * @param $name
     * @param bool $default
     * @param bool $fitt
     * @return bool
     */
    public static function post($name, $default = false, $fitt = false)
    {
        if (isset($_POST[$name])) {
            if ($fitt) {
                switch ($fitt) {
                    case 'int':
                        {
                            if (is_numeric($_POST[$name])) {
                                return $_POST[$name];
                            } else {
                                return $default;
                            }
                            break;
                        }
                    default:
                        {
                            break;
                        }
                }
            } else {
                return $_POST[$name];
            }
        } else {
            return $_POST;
        }
    }

    /**
     * 获取 GET 参数
     * @param $name
     * @param bool $default
     * @param bool $fitt
     * @return bool
     */
    public static function get($name = '', $default = false, $fitt = false)
    {
        if (isset($_GET[$name])) {
            if ($fitt) {
                switch ($fitt) {
                    case 'int':
                        {
                            if (is_numeric($_GET[$name])) {
                                return $_GET[$name];
                            } else {
                                return $default;
                            }
                            break;
                        }
                    default:
                        {
                            break;
                        }
                }
            } else {
                return $_GET[$name];
            }
        } else {
            return $_GET;
        }
    }
}

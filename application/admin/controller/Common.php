<?php
/**
 * Created by PhpStorm.
 * User: jn339
 * Date: 2018/1/6
 * Time: 21:08
 */
namespace app\admin\controller;

use think\Controller;

class Common extends Controller
{
    public function _initialize()
    {
        if(!session('id')||!session('name')){
            $this->error('请登录','admin/login/login','',1);
        }
    }
}
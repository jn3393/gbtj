<?php
/**
 * Created by PhpStorm.
 * User: jn339
 * Date: 2018/1/3
 * Time: 22:11
 */
namespace app\admin\controller;

use think\Controller;

class Login extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function login_()
    {
        $data = $_POST;
        $db = db('admin')->where('name',$data['name'])->where('password',md5(md5(md5($data['password']))))->find();
        if ($db){
            session('id',$db['id']);
            session('name',$db['name']);
            $this->redirect('/admin/index/index');
        }else{
            $this->error('用戶名/密碼不匹配','/admin/login/login','',1);
        }
    }

    public function logout()
    {
        session(null);
        $this->success('退出成功','/admin/login/login','',1);
    }
}
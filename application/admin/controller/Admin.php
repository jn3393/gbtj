<?php
/**
 * Created by PhpStorm.
 * User: jn339
 * Date: 2017/12/30
 * Time: 19:28
 */
namespace app\admin\controller;

class Admin extends Common
{
    public function add()
    {
        return view('add');
    }

    public function add_()
    {
        $data = $_POST;
        if ('' != $data['name'] && '' != $data['password']) {
            $name = db('admin')->where('name',$data['name'])->find();
            if($name){
                $this->error('用户已存在','/admin/admin/add','',1);
            }else{
                $data['password'] = md5(md5(md5($data['password'])));
                db('admin')->insert($data);
                $this->success('用户添加成功','/admin/admin/add','',1);
            }
        }else{
            $this->error('用户与密码不能为空','/admin/admin/add','',1);
        }
    }

    public function list()
    {
        return view('list');
    }

    public function list_($page,$limit)
    {
        $db = db('admin')->field('id,name')->page($page,$limit)->select();
        return json(['code'=>0,'msg'=>'cg','count'=>db('admin')->count(),'data'=>$db]);
    }

    public function edit()
    {
        return view('edit');
    }

    public function edit_()
    {
        $data = $_POST;
        $data['id'] = session('id');
        $data['password'] = md5(md5(md5($data['password'])));
        $result = db('admin')->update($data);
        if($result){
            $this->success('密码修改成功','/admin/admin/edit','',1);
        }else{
            $this->error('未知错误','admin/admin/edit','',1);
        }
    }

    public function other_edit_()
    {
        $data = $_POST;
        //dump($data);die;
        $data['password'] = md5(md5(md5($data['password'])));
        $result = db('admin')->update($data);
        if ($result){
            return 1;//成功
        }
    }

    public function delete_()
    {
        $data = $_POST;
        //dump($data);
        $result = db('admin')->delete($data['id']);
        if($result){
            return 2;//success
        }
    }

    public function delete_all_()
    {
        $data = $_POST;
        //dump($data);die;
        foreach ($data as $k => $v){
            foreach ($v as $ko => $vo){
               // dump($vo['id']);die;
                $result = db('admin')->delete($vo['id']);
            }
        }
        return 3;
    }

}
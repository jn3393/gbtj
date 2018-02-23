<?php
/**
 * Created by PhpStorm.
 * User: jn339
 * Date: 2018/1/7
 * Time: 19:34
 */
namespace app\admin\controller;

class Category extends Common
{
    public function add()
    {
        $db = db('category')->field('*,concat(path,"-",id) as paths')->order('path','asc')->select();
        //dump($db);die;
        foreach ($db as $k=>$v){
            $db[$k]['name'] = str_repeat("---",$v['level'] -1 ).$v['name'];
        }
        return view('add')->assign('db',$db);
    }

    public function add_()
    {
        $data= $_POST;
        $db = db('category')->field('path')->find($data['pid']);
        $max =  1 + db('category')->max('id');
        if($data['name'] !='' && $data['pid'] !=0){
            $data['path'] = $db['path'].'-'.$max;
            $data['level'] = substr_count($data['path'],'-');
            $result = db('category')->insert($data);
            if ($result){
                $this->success('新增成功', 'admin/category/add','',1);
            }else{
                $this->error('新增失败','admin/category/add','',1);
            }
        }else if($data['name'] !='' && $data['pid'] ==0){
            $data['path'] = '0'.'-'.$max;
            $data['level'] = substr_count($data['path'],'-');
            $result = db('category')->insert($data);
            if ($result){
                $this->success('新增成功', 'admin/category/add','',1);
            }else{
                $this->error('新增失败','admin/category/add','',1);
            }
        }
    }

    public function list()
    {
        return view('list');
    }

    public function list_($page,$limit)
    {
        $db = db('category')->field('*,concat(path,"-",id) as paths')->order('path','asc')->page($page,$limit)->select();
        //dump($db);die;
        foreach ($db as $k=>$v){
            $db[$k]['name'] = str_repeat("---",$v['level'] -1 ).$v['name'];
        }
        //$db = db('category')->field('id,name,type')->page($page,$limit)->select();
        return json(['code'=>0,'msg'=>'cg','count'=>db('category')->count(),'data'=>$db]);
    }

    public function edit($id)
    {
        $db1 = db('category')->find($id);
        //dump($db1);die;
        $db = db('category')->field('*,concat(path,"-",id) as paths')->order('path','asc')->select();
        //dump($db);die;
        foreach ($db as $k=>$v){
            $db[$k]['name'] = str_repeat("---",$v['level'] -1 ).$v['name'];
        }
        return view('edit')->assign('db',$db)->assign('db1',$db1);
    }

    public function edit_($id)
    {
        $data= $_POST;
        //dump($data);die;
        $db = db('category')->field('path')->find($data['pid']);
        $max =  1 + db('category')->max('id');
        if($data['name'] !='' && $data['pid'] !=0){
            $data['path'] = $db['path'].'-'.$max;
            $data['level'] = substr_count($data['path'],'-');
            $result = db('category')->where('id',$id)->update($data);
            if ($result){
                $this->success('更新成功', 'admin/category/list','',1);
            }else{
                $this->error('更新失败','admin/category/list','',1);
            }
        }else if($data['name'] !='' && $data['pid'] ==0){
            $data['path'] = '0'.'-'.$max;
            $data['level'] = substr_count($data['path'],'-');
            $result = db('category')->where('id',$id)->update($data);
            if ($result){
                $this->success('更新成功', 'admin/category/list','',1);
            }else{
                $this->error('更新失败','admin/category/list','',1);
            }
        }
    }

    public function delete_()
    {
        $id = $_POST['id'];
        //dump($data);die;
        //下面的意思是查询他的id是不是其他项目的pid 如果他是别人的pid说明下面有子项
        $db = db('category')->where('pid',$id)->select();
        //dump($pid);die;
        if ($db){
            //dump($db);die;
            return 1;//下面有组分类不允许删除
        }else{
            $result = db('category')->delete($id);
            if($result){
                return 2;//删除成功
            }else{
                return 3;//删除失败
            }
        }
    }


}
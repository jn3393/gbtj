<?php
/**
 * Created by PhpStorm.
 * User: jn339
 * Date: 2018/1/10
 * Time: 11:30
 */
namespace app\admin\controller;

class Article extends Common
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


}
<?php
namespace app\admin\controller;

class Index extends Common
{
    public function index()
    {
        $this->redirect('/admin/admin/list');
    }


}

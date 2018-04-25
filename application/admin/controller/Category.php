<?php

namespace app\admin\controller;

use think\Controller;
use app\common\model\Category as CategoryModel;

class Category extends Controller {

    private $_categoryModel;

    protected function initialize() {
        $this->_categoryModel = new CategoryModel;
    }

    public function index() {
        
        $data = $this->_categoryModel
                ->where('status',0)
                ->order('id','desc')
                //->limit(10)
                ->select()
                ->toArray();
        $this->assign('data', $data);
        return view();
    }

    public function add() {
        return view();
    }

    public function save() {
        $title = $this->request->param('title', '');
        $slug = $this->request->param('slug', '');
        $result = $this->_categoryModel->save([
            'title' => $title,
            'slug' => $slug,
            'addtime' => time()
        ]);
        if($result){
            $data = ['status' => 1, 'message' => '操作成功'];
        }else{
            $data = ['status' => 0, 'message' => '操作失败'];
        }
        return json($data);
    }

}

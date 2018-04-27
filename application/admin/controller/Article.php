<?php

namespace app\admin\controller;

use think\Controller;
use app\common\model\Category as CategoryModel;
use app\common\model\Article as ArticleModel;

class Article extends Controller {

    private $_categoryModel;
    private $_articleModel;

    protected function initialize() {
        $this->_categoryModel = new CategoryModel;
        $this->_articleModel = new ArticleModel;
    }

    public function index() {
        $params = $this->request->param();

        $map = array();
        $map['status'] = 0;
        if (isset($params['title']) && $params['title'] != '') {
            $map['title'] = trim($params['title']);
            //$map['title'] = ['like', ''.$params['title'].''];
        }

        $data = $this->_articleModel
                ->where($map)
                ->order('id', 'desc')
                ->select();

        $this->assign('data', $data);
        $this->assign('params', $params);
        return view();
    }

    public function add() {
        $category = $this->_getCategory();
        $this->assign('category', $category);
        return view();
    }

    public function save() {
        $title = $this->request->param('title', '', 'trim');
        $content = $this->request->param('content', '');
        $category_id = $this->request->param('category_id', 0, 'intval');
        $result = $this->_articleModel->save([
            'title' => $title,
            'content' => $content,
            'category_id' => $category_id,
            'addtime' => time()
        ]);
        
        if ($result) {
            $data = ['status' => 1, 'message' => '操作成功'];
        } else {
            $data = ['status' => 0, 'message' => '操作失败'];
        }
        return json($data);
    }

    public function read($id) {
        $info = $this->_articleModel->find($id);
        
        $category = $this->_getCategory();
        $this->assign('category', $category);
        $this->assign('info', $info);
        return view('add');
    }

    public function update($id) {
     
        $title = $this->request->param('title', '', 'trim');
        $content = $this->request->param('content', '');
        $category_id = $this->request->param('category_id', 0, 'intval');
        $result = $this->_articleModel
                ->where('id='.$id)
                ->update([
                    'title' => $title,
                    'content' => $content,
                    'category_id' => $category_id,
                    'updatetime' => time()
                ]);
        
        if ($result) {
            $data = ['status' => 1, 'message' => '操作成功'];
        } else {
            $data = ['status' => 0, 'message' => '操作失败'];
        }
        return json($data);
        

    }

    public function delete($id) {
        $result = $this->_categoryModel->where('id', $id)->delete();
        if ($result) {
            $data = ['status' => 1, 'message' => '操作成功'];
        } else {
            $data = ['status' => 0, 'message' => '操作失败'];
        }
        return json($data);
    }
    
    private function _getCategory(){
        $data = $this->_categoryModel->field('id,title,slug')->where('status=1')->select();
        return $data;
    }
}

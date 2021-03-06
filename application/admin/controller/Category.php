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
        $params = $this->request->param();

        $map = array();
        $map['status'] = 0;
        if (isset($params['title']) && $params['title'] != '') {
            $map['title'] = trim($params['title']);
            //$map['title'] = ['like', ''.$params['title'].''];
        }

        $data = $this->_categoryModel
                ->where($map)
                ->order('id', 'desc')
                ->select();

        $this->assign('data', $data);
        $this->assign('params', $params);
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
        if ($result) {
            $data = ['status' => 1, 'message' => '操作成功'];
        } else {
            $data = ['status' => 0, 'message' => '操作失败'];
        }
        return json($data);
    }

    public function read($id) {
        $info = $this->_categoryModel->find($id);
        $this->assign('info', $info);
        return view('add');
    }

    public function update($id) {
        $title = $this->request->param('title', '');
        $slug = $this->request->param('slug', '');

        $result = $this->_categoryModel->where('id', $id)->update(['title' => $title, 'slug' => $slug ]);

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
}

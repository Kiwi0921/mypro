<?php

namespace app\admin\controller;

use think\Controller;

//use app\common\model\Category as CategoryModel;
//use app\common\model\Article as ArticleModel;

class Common extends Controller {

    protected function initialize() {
        $this->_checkAuth();
    }

    private function _checkAuth() {
        $sess = session('admin');
        if (empty($sess) || !isset($sess['id'])) {
            $this->redirect(url('admin/pub/login'))->remember();
        }
    }
}

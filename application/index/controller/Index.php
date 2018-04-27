<?php

namespace app\index\controller;

use think\Controller;
use app\common\model\Category as CategoryModel;
use app\common\model\Article as ArticleModel;

class Index extends Controller {

    public function index() {
        $categoryModel = new CategoryModel;
        $articleModel = new ArticleModel;
        
        
        $category = $categoryModel->_getCategory();
        
        $article = $articleModel->_getArticle();
   
        
        
        $this->assign('category', $category);
        $this->assign('article', $article);
        return view();
    }
    
    public function article($id){
        $articleModel = new ArticleModel;
        $categoryModel = new CategoryModel;
         $category = $categoryModel->_getCategory();
        
        
        $article = $articleModel->where('id='.$id)->find();
         $this->assign('article', $article);
          $this->assign('category', $category);
        return view();
    }

    public function hello($name = 'ThinkPHP5') {
        return 'hello,' . $name;
    }

}

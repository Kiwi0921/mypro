<?php

namespace app\common\model;

use think\Model;

class Article extends Model {
    
    
    public function _getArticle(){
        return $this->order('id desc')->select();
    }
}

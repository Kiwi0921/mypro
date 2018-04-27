<?php

namespace app\common\model;

use think\Model;

class Category extends Model {

    //默认主键为id，如果你没有使用id作为主键名，需要在模型中设置属性：
    //protected $pk = 'uid';  
    // 设置当前模型对应的完整数据表名称
    
    //protected $name = 'categoraay';
   // protected $name = 'categoraay';

    // 设置当前模型的数据库连接
    // protected $connection = 'db_config';
    // 模型初始化
//    protected static function init()
//    {
//        //TODO:初始化内容
//    }
    
    public function _getCategory(){
        return $this->field('id,title,slug')->where('status=1')->select();
    }
}

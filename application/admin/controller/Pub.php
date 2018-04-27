<?php

namespace app\admin\controller;

use think\Controller;
//use think\Session;
use app\common\model\AdminUser;

class Pub extends Controller {

    private $_pwdKey = 'fkiwi.com@Do.it';
    private $_adminUserModel;
//    private $_session;

    protected function initialize() {
        $this->_adminUserModel = new AdminUser;
//        $this->_session = new Session;
    }

    public function login() {
        return view();
    }

    public function doLogin() {
        $username = $this->request->param('username', '');
        $pwd = $this->request->param('pwd', '');

        $ck = md5($this->_pwdKey . $username . $pwd);
        
        $adminuser = $this->_adminUserModel->where('username', $username)->find();
        if(empty($adminuser)){
            return json(['status' => 0, 'message' => '账号错误']);
        }
        if($adminuser->password != $ck){
            return json(['status' => 0, 'message' => '账号或密码错误']);
        }
        
        $logtime =     date('Y-m-d H:i:s');
        $this->_adminUserModel->where('id', $adminuser->id)->update(['login_time' => $logtime]);

        session('admin.id',$adminuser->id);
        session('admin.username',$adminuser->username);
        session('admin.login_time',$logtime);
        
        return json(['status' => 1, 'message' => '登陆成功']);
    }

}

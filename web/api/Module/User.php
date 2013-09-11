<?php

class Mar_Module_User extends ModuleManager
{
    private $_v;
    private $_users;

    public function __construct()
    {
        parent::__construct();
        $this->_v = $this->load('validator');
        $this->_users = $this->getDataManager('users');        
    }

    public function getUserList()
    {
        $result = array();
        $user_list = $this->_users->getAll();
        foreach ($user_list as $user) {
            $result[$user['uid']] = $user['name'];
        }
        return $result;
    }

    public function addUser($name)
    {
        //バリデーション
        $this->_v->validate('user_name', array('name' => $name));
        $ret = $this->_users->addUser($name);
        if ($ret === false) {
            throw new Exception(
                                'Can not add User',
                                100
                                );
        }
        return true;
    }

    public function editUserName($uid, $name)
    {
        $this->_v->validate('user_uid', array('uid' => $uid));//uidが存在しているか
        $this->_v->validate('user_name', array('name' => $name));//変更後の名前がかぶっていないか

        $ret = $this->_users->updateUserName($uid);

        if ($ret === false) {
            throw new Exception(
                                'Can not edit UserName',
                                100
                                );
        }
        return true;
    }

    
}
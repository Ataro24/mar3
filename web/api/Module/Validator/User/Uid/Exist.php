<?php
class Mar_Module_Validator_User_Uid_Exist extends ModuleManager
{
    private $_users;

    public function __construct()
    {
        parent::__construct();
        $this->_users = $this->getDataManager('users');
    }

    //$uidのユーザいるか調べる
    // @params $uid ユーザid
    // @throw  Exception いない場合
    // @return true いる
    public function validate($params)
    {
        $uid = $params['uid'];
        $ret = $this->_users->getUserByUid($uid);

        if (empty($ret)) {
            throw new Exception(
                                'Uid is not Exist',
                                100
                                );
        }
        return true;
    }
}

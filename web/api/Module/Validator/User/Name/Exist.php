<?php
class Mar_Module_Validator_User_Name_Exist extends ModuleManager
{
    private $_users;

    public function __construct()
    {
        parent::__construct();
        $this->_users = $this->getDataManager('users');
    }

    //名前が$nameのユーザいるか調べる
    // @params $name 名前
    // @return true いる / false いない
    public function validate($params)
    {
        $name = $params['name'];

        $user_list = $this->_users->getAll();
        foreach ($user_list as $u) {
            if ($u['name'] === $name) {
                throw new Exception(
                                    'Name is Already Exist',
                                    100
                                    );
            }
        }
        return false;
    }
}

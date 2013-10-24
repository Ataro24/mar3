<?php

class Mar_Module_Users extends ModuleManager
{
    public $banks = array(
                          'file_users'
                          );

    //ユーザリストを取得する
    // @return array  array('uid' => 'name', ...)
    //                       uidは0スタート
    public function getAllUserList()
    {
        return $this->file_users->getAllUsers();
    }

    public function addUser($name)
    {
        if ($this->isUserExist($name) === true) {
            //すでに同じ名前のユーザが登録されている
            throw new Exception(
                                'User Name is Already Exist',
                                100
                                );
        }
        $ret = $this->file_users->addUser($name);
        if ($ret === false) {
            throw new Exception(
                                'Can not add User',
                                100
                                );
        }
        return true;
    }


    //ユーザ名$nameを$new_nameに更新する
    // @params $name       string  old name
    // @params $new_name   string  new name   
    public function editUserName($name, $new_name)
    {
        if (($this->isUserExist($name) === false) 
              || ($this->isUserExist($new_name) === true)) {
            //変更前$nameというユーザがいない もしくは 変更後$new_nameというユーザはすでにいる
            throw new Exception(
                                'User Name is Not Found or New User Name is Already Exist',
                                100
                                );
        }
        $user_list = $this->getAllUserList();
        foreach ($user_list as $k => $u) {
            if ($u === $name) {
                $user_list[$k] = $new_name;
                break;
            }
        }
        $this->file_users->refreshUserList($user_list);

        //TODO 対局一覧とかも書き換える(めんどくさいしforeachとかでええんとちゃうか)
    }

    //ユーザ$nameを削除する
    public function deleteUserName($name)
    {
        if ($this->isUserExist($name) === false) {
            //$nameというユーザがいない
            throw new Exception(
                                'User Name is Not Found',
                                100
                                );
        }
        $user_list = $this->getAllUserList();
        foreach ($user_list as $k => $u) {
            if ($u === $name) {
                unset($user_list[$k]);
                break;
            }
        }
        $this->file_users->refreshUserList($user_list);
    }

    //ユーザ$nameが登録されているか調べる
    // @params $name string
    // @return true いる/ false いない
    public function isUserExist($name)
    {
        $user_list = $this->getAllUserList();
        foreach ($user_list as $u) {
            if ($u === $name) {
                return true;
            }
        }
        return false;
    }

}
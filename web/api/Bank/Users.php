<?php

class Mar_Bank_Users extends DataManager
{
    private $_querys = array(
                             'select_all' => 'select * from users',
                             'select_by_id' => 'select * from users where uid=:uid',
                             'select_by_name' => 'select * from users where name=:name',
                             'insert' => 'insert into users(name) values(:name)',
                             'delete' => 'delete from users where uid=:uid',
                             'update_name' => 'update users set name=:name where uid=:uid',
                             'update_status' => 'update users set status=:status where uid=:uid',
                            );

    public function getAll()
    {
        return $this->find($this->_querys['select_all']);
    }

    public function getUserByUid($uid)
    {
        $params = array(
                        'uid' => $uid
                        );
        return $this->find($this->_querys['select_by_id'], $params);
    }

    public function addUser($name)
    {
        $params = array(
                        'name' => $name
                        );
        return $this->exec($this->_querys['insert'], $params);
    }

    public function deleteUser($uid)
    {
        $params = array(
                        'uid' => $uid
                        );
        return $this->exec($this->_querys['delete'], $params);
    }

    public function updateUserName($uid, $name)
    {
        $params = array(
                        'name' => $name,
                        'uid'  => $uid,
                        );
        return $this->exec($this->_querys['update_name'], $params);
    }

    public function updateUserStatus($uid, $status)
    {
        $params = array(
                        'uid' => $uid,
                        'status' => $status,
                        );
        return $this->exec($this->_querys['update_status'], $params);
    }

    public function test()
    {
        $ret = $this->exec($this->_querys['find_all']);
        var_dump($ret);


        $params = array(
                        'name' => 'kyousuke'
                        );
        $ret = $this->exec($this->_querys['find_by_id'], $params);
        var_dump($ret);
    }
        

}
<?php
class Mar_Module_Hoge_Hoge extends ModuleManager
{

    public function testhoge()
    {
        $users_db = $this->getDataManager('users');        
        /* echo "=============getAll==============\n"; */
        /* $ret = $users_db->getAll(); */
        /* var_dump($ret); */
        /* echo "============getUserByUid===============\n"; */
        /* $ret = $users_db->getUserByUid(2); */
        /* var_dump($ret); */
        /* echo "=============addUser==============\n"; */
        /* $ret = $users_db->addUser('ayase'); */
        /* var_dump($ret); */
        /* echo "============delete===============\n"; */
        /* $ret = $users_db->deleteUser(2); */
        /* var_dump($ret); */
        /* echo "=============updateName==============\n"; */
        /* $ret = $users_db->updateUserName(1, 'kamineko'); */
        /* var_dump($ret); */
        /* echo "===========updateStatus================\n"; */
        /* $ret = $users_db->updateUserStatus(5, 3); */
        /* var_dump($ret); */



        $games_db = $this->getDataManager('games');
        echo "=============getAll==============\n";
        $ret = $games_db->getAll();
        var_dump($ret);
        echo "=============getGameByTimeRange==============\n";
        $ret = $games_db->getGameByTimeRange('2013-09-08', '2013-09-09');
        var_dump($ret);
        echo "=============getGameById==============\n";
        $ret = $games_db->getGameById(6);
        var_dump($ret);
        /* echo "=============add==============\n"; */
        /* $ret = $games_db->add('2013-08-08',1,2,3,4,5,6,-7,8); */
        /* var_dump($ret); */
        /* echo "=============update==============\n"; */
        /* $ret = $games_db->update(5, '2013-08-08',1,2,3,4,5,6,-7,8); */
        /* var_dump($ret); */
        echo "=============delete==============\n";
        $ret = $games_db->deleteGame(5);
        var_dump($ret);
        
    }
}

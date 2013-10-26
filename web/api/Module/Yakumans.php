<?php

class Mar_Module_Yakumans extends ModuleManager
{
    public $modules = array(
                            'users'
                            );
    public $banks = array(
                          'file_yakumans'
                          );

    private $_yakuman_lists = array(
                                    '大三元',
                                    '四暗刻',
                                    '国士無双',
                                    '字一色',
                                    '緑一色',
                                    '清老頭',
                                    '四喜和',
                                    '九蓮宝燈',
                                    '四槓子',
                                    '天和',
                                    '地和',
                                    );

    public function getAllYakumanList()
    {
        return $this->file_yakumans->getAllYakumans();
    }

    public function addYakuman($yakuman_info)
    {
        $this->_checkYakumanInfo($yakuman_info);
        $this->_checkYakuman($yakuman_info["yaku"]);
        $this->_checkUserExist($yakuman_info["name"]);
        $ret = $this->file_yakumans->addYakuman($yakuman_info);
        if ($ret === false) {
            throw new Exception(
                                'Can not add Yakuman',
                                100
                                );
        }
        return true;
    }

    public function editYakuman($yid, $yakuman_info)
    {
        $this->_checkYakuman($yakuman_info["yaku"]);
        $this->_checkUserExist($yakuman_info["name"]);
        $ret = $this->file_yakumans->editYakumanResult($yid, $yakuman_info);
        if ($ret === false) {
            throw new Exception(
                                'Can not edit Yakuman',
                                100
                                );
        }
        return true;
    }

    public function deleteYakuman($yid)
    {
        $ret = $this->file_yakumans->deleteYakumanResult($yid);
        if ($ret === false) {
            throw new Exception(
                                'Can not delete Yakuman',
                                100
                                );
        }
        return true;
    }


    private function _checkYakumanInfo($yakuman_info)
    {
        if (isset($yakuman_info['date']) === false) {
            throw new Exception(
                'Invalid Data',
                100
            );
        }
        if (isset($yakuman_info['name']) === false) {
            throw new Exception(
                'Invalid Data',
                100
            );
        }
        if (isset($yakuman_info['yaku']) === false) {
            throw new Exception(
                'Invalid Data',
                100
            );
        }
    }

    private function _checkUserExist($name)
    {
        if (($ret = $this->users->isUserExist($name)) === false) {
            throw new Exception(
                                'User Name is Not Found',
                                100
                                );
        }
        return true;
    }

    private function _checkYakuman($yaku)
    {
        if (array_search($yaku, $this->_yakuman_lists) === false) {
            throw new Exception(
                                'Invalid Yakuman Name',
                                100
                                );
        }
        return true;
    }

}
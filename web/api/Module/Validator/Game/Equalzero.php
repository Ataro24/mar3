<?php
class Mar_Module_Validator_Game_Equalzero extends ModuleManager
{
    private $_games;

    public function __construct()
    {
        parent::__construct();
        $this->_users = $this->getDataManager('games');
    }

    public function validate($params)
    {
        $sum = 0;
        foreach ($params as $p) {
            (int)$sum += (int)$p;
        }
        if ($sum !== 0) {
            throw new Exception(
                                'Point Sum Not Zero',
                                100
                                );
        }
        return true;
    }
}
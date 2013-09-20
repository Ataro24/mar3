<?php

class Mar_Bank_File_Games extends Class_Bank_Access_File
{
    public function __construct()
    {
        $this->_file_path = BASE . '/data.csv';
    }

    public function getAllGames()
    {
        echo "getAllGames\n";
        var_dump($this);
        $ret = $this->read();
        var_dump($ret);

        $this->write($ret);
    }
}

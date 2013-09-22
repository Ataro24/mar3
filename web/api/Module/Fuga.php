<?php
class Mar_Module_Fuga extends ModuleManager
{
    public $modules = array(
    );
    public $banks = array(
        'file_games'
    );

    public function test()
    {
        echo "fugafugan\n";
        $game = array(
            'date' => '2013-09-21',
            'fstu' => 'taro',
            'sndu' => 'kuroneko'
        );
        //        $this->file_games->getAllGames();
        $this->file_games->addGameResult($game);
    }
}

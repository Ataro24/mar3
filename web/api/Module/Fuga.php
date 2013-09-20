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
        $this->file_games->getAllGames();
    }
}

<?php
require_once 'Game/Table.php';

//File_Manager以下はあくまで、渡された値に忠実にHTMLを作成する
// 表示するユーザの選別とかはこいつに渡す前に済ませる
class Mar_Module_Htmlmaker_Manager extends ModuleManager
{
    //対局結果一覧(topページ用: status=2のユーザ && 最近50game)
    const RESULT_TOP = 'result_top.html';
    //対局結果一覧(すべて: 全ユーザ && 全試合)
    const RESULT_ALL = 'result_all.html';
    //対局結果の集計値
    const RESULT_SUM = 'result_sum.html';
    //各ユーザの成績
    const RESULT_EACH_USER = 'result_each_user.html;';

    private $gametable;

    public function __construct()
    {
        parent::__construct();
        $this->gametable = new Mar_Module_Htmlmaker_Game_Table();
    }

    /* public function makeHtml($user_list, $game_list, $calc_list) */
    /* { */
    /*     $thead = $this->gametable->makeGameListThead($user_list); */
    /*     var_dump($thead); */
    /*     $tbody = $this->gametable->makeGameListTbody($user_list, $game_list); */
    /*     var_dump($tbody); */
    /*     return $thead . "\n" . $tbody; */
    /* } */

    public function writeFileAll($user_list, $game_list, $calc_list)
    {
        /* $file_path =SERVICE_BASE . '/' . self::RESUL CalcT_TOP;  */
        /* var_dump($file_path); */
        /* $fp = fopen($file_path, 'w'); */
        /* $html = $this->makeHtml($user_list, $game_list, $calc_list); */
        /* fwrite($fp, $html); */
        /* fclose($fp); */
        $this->writeFile(self::RESULT_TOP, $this->gametable->makeGameListTable($user_list, $game_list, array()));//$this->makeHtml($user_list, $game_list, $calc_list));
    }

    public function writeTop($user_list, $game_list, $calc_list)
    {
        $gt = new Mar_Module_File_Write_Game_Table;
        $html_list = $gt->makeGameListTable($user_list, $game_list);

        $this->writeFile(serlf::RESULT_TOP, $html);
    }

    public function writeFile($filename, $html)
    {
        $file_path = SERVICE_BASE . '/' . $filename;
        $fp = fopen($file_path, 'w');
        fwrite($fp, $html);
        fclose($fp);
    }
}
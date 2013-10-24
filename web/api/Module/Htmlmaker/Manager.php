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

    const VIEW_TOP_PAGE_GAME_RESULT = 30;

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
        echo "writeFileAll\n";
        // topページ用
        $this->writeTopPage($user_list, $game_list, $calc_list);


    }

    public function writeTopPage($user_list, $game_list, $calc_list)
    {
        //メインのテーブル(直近30局になるように)
        if (count($game_list) > self::VIEW_TOP_PAGE_GAME_RESULT) {
            $game_list_chomp = array();
            $c = 1;
            foreach ($game_list as $g) {
                $game_list_chomp[] = $g;
                $c += 1;
                if ($c > self::VIEW_TOP_PAGE_GAME_RESULT) {
                    break;
                }
            }
            $game_list = $game_list_chomp;
        }
        $main_table_html = $this->gametable->makeGameListTable($user_list, $game_list, array());
        //総合成績テーブル
        $score_table_html = $this->gametable->makeScoreListTable($user_list, $calc_list, array());
        $top_page_html = $main_table_html . "\n" . $score_table_html;
        $this->writeFile(self::RESULT_TOP, $top_page_html);
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
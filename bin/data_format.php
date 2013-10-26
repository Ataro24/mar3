<?php
// mar ver2 から mar ver3 のデータフォーマットに変更する
if ($argc < 2) {
    echo "not enough args\n";
    exit(1);
}

$DEST_FILE_USER    = 'users.csv';
$DEST_FILE_GAME    = 'games.csv';

$START_YEAR = 2012;
$UNKNOWN_DATE_FORMAT = '???';

$filename = $argv[1];

if (($fp = fopen($filename, 'r')) === false) {
    echo 'faild file open';
    exit(1);
}

//1行目はメンバー情報
$buffer = fgets($fp);
$users = explode(' ', $buffer);
$users_str = '';
foreach ($users as $u) {
    $tmp = str_replace("\n", "", $u);
    $users_str = $users_str . $tmp . "\n";
}

//2行目以降が対局情報
$start_month = '';
$past_year = 0;
$before_month = '';
$game_str = '';
$date_obj = new DateTime();
while (($buffer = fgets($fp)) !== false) {
    $buffer = str_replace("\n", "", $buffer);//改行の削除
    $buffer = preg_replace('/\s+/', ' ', $buffer);
    $game = explode(' ', $buffer);

    if ($game[0] === $UNKNOWN_DATE_FORMAT) {
        // ??? だった場合
        $str_date = '1970-01-01';
    } else {
        $date = explode('/', $game[0]);
        $month = $date[0];
        $day   = $date[1];
        if (empty($before_month)) {
            $before_month = $month;//初期設定
        }
        if ($month == 1 && $before_month != $month) {
            // 1月 かつ 前の行と今の行の月が違う → 新しい年
            $past_year += 1;
        }
        $year = $START_YEAR + $past_year;

        $str_date = sprintf("%04d-%02d-%02d", $year, $month, $day);

        $before_month = $month;//更新
    }

    $tmp_game_str = '';
    $list_num = count($game);
    foreach ($game as $k => $g) {
        if ($k === 0) {
            $tmp_game_str = $tmp_game_str . $str_date . " ";
        } else {
            if ($k === ($list_num - 1)) {
                $tmp_game_str = $tmp_game_str . $g;
            } else {
                $tmp_game_str = $tmp_game_str . $g . " ";
            }
        }
    }

    echo $tmp_game_str . "\n";
    $game_str = $game_str . $tmp_game_str . "\n";
}
fclose($fp);


$fp = fopen($DEST_FILE_USER, 'w');
fwrite($fp, $users_str);
fclose($fp);

$fp = fopen($DEST_FILE_GAME, 'w');
fwrite($fp, $game_str);
fclose($fp);

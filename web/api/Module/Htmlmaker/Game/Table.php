<?php
class Mar_Module_HtmlMaker_Game_Table
{
    //TODO テーブル生成の効率化

    const TABLE_FORMAT = '<table %s><thead %s>%s</thead><tbody %s>%s</tbody></table>';
    const TR_FORMAT = '<tr %s>%s</tr>';
    const TD_FORMAT = '<td %s>%s</td>';
    const TH_FORMAT = '<th %s>%s</th>';

    const USER_ID_FORMAT = 'user_';

    //対局結果一覧の表をつくる
    // $params テーブルのidなどの指定
    public function makeGameListTable($user_list, $game_list, $params)
    {
        $thead = $this->makeGameListThead($user_list);
        $tbody = $this->makeGameListTbody($user_list, $game_list);
        $params = array(
                        'table' => array(
                                         'class' => 'table'
                                         )
                        );
        $html = $this->exportTable($thead, $tbody, $params);
        return $html;
    }

    //総合成績テーブル
    public function makeScoreListTable($user_list, $calc_list, $paramas)
    {
        $thead = $this->makeScoreListThead($user_list);
        $tbody = $this->makeScoreListTbody($user_list, $calc_list);
        $params = array(
                        'table' => array(
                                         'class' => 'table'
                                         )
                        );
        $html = $this->exportTable($thead, $tbody, $params);
        return $html;
    }

    public function makeScoreListThead($user_list)
    {
        $body = '';
        $body = $body . sprintf(self::TH_FORMAT,
                                '',
                                'ALL'
                                );
        foreach ($user_list as $uid => $name) {
            $uid_str = sprintf('id="%s"', self::USER_ID_FORMAT . $uid);
            $body = $body . sprintf(self::TH_FORMAT,
                                    $uid_str,
                                    $name
                                    );
        }
        $body = sprintf(self::TR_FORMAT,
                        '',
                        $body
                        );
        return $body;
    }

    public function makeScoreListTbody($user_list, $calc_list)
    {
        //得点
        $point_line = '';
        $point_line = $point_line . sprintf(self::TD_FORMAT,
                                            '',
                                            'point'
                                            );
        foreach ($calc_list as $user) {
            $uid_str = sprintf('id="%s"', self::USER_ID_FORMAT. $user->getUid());
            $point_line = $point_line . sprintf(self::TD_FORMAT,
                                                $uid_str,
                                                $user->getSumPoint()
                                                );
        }
        $point_line = sprintf(self::TR_FORMAT,
                              '',
                              $point_line);
        //平均順位
        $order_line = '';
        $order_line = $order_line . sprintf(self::TD_FORMAT,
                                            '',
                                            'order'
                                            );
        foreach ($calc_list as $user) {
            $uid_str = sprintf('id="%s"', self::USER_ID_FORMAT. $user->getUid());
            $order_line = $order_line . sprintf(self::TD_FORMAT,
                                                $uid_str,
                                                sprintf("%.2f", $user->getAvgOrder())
                                                );
        }
        $order_line = sprintf(self::TR_FORMAT, '', $order_line);
        return $point_line . "\n" . $order_line;
    }


    //対局結果一覧の表のうちのヘッダをつくる
    public function makeGameListThead($user_list)
    {
        $body = '';
        $body = $body . sprintf(self::TH_FORMAT,
                                '',
                                'date'
                                );
        foreach ($user_list as $uid => $name) {
            $uid_str = sprintf('id="%s"', self::USER_ID_FORMAT . $uid);
            $body = $body . sprintf(self::TH_FORMAT,
                            $uid_str,
                            $name
                            );
        }
        $body = sprintf(self::TR_FORMAT,
                        '',
                        $body
                        );
        return $body;
    }

    //対局結果一覧の表のうちのボディをつくる
    public function makeGameListTbody($user_list, $game_list)
    {
        $body = '';
        $date_str = '';
        $user_str = '';
        foreach ($game_list as $g) {
            $date_str = sprintf(self::TD_FORMAT,
                                    '',
                                    $g['date']
                                    );
            $user_str = '';
            foreach ($user_list as $name) {
                $c = $this->_checkExistMember($name, $g);
                if (empty($c) === false) {
                    //成績を入れる
                    $extention = "class=\"$c\"";
                    $user_str = $user_str . sprintf(self::TD_FORMAT, $extention,$g[$c]);
                } else {
                    //対局に参加していない
                    $user_str = $user_str . sprintf(self::TD_FORMAT, '','');
                }
            }
            $body = $body . "\n" . sprintf(self::TR_FORMAT, '', $date_str . $user_str);
        }
        return $body;
    }

    //$game_info内に$nameのユーザがいるか調べる
    private function _checkExistMember($name, $game_info)
    {
        switch ($name) {
        case $game_info['fstu']:
            return 'fstp';
            break;
        case $game_info['sndu']:
            return 'sndp';
            break;
        case $game_info['thru']:
            return 'thrp';
            break;
        case $game_info['foru']:
            return 'forp';
            break;
        default:
            return null;
            break;
        }
    }

    //tableの形を出力する
    public function exportTable($thead, $tbody, $params)
    {
        $ret = sprintf(self::TABLE_FORMAT,
                       $this->transExtentionParams(empty($params['table'])?array():$params['table']),
                       $this->transExtentionParams(empty($params['thead'])?array():$params['thead']),
                       $thead,
                       $this->transExtentionParams(empty($params['tbody'])?array():$params['tbody']),
                       $tbody
                       );
        return $ret;
    }

    //idやclass名などをparamsから取り出してhtmlの記述に変換する
    // @params  array
    /* ex. $params = array(
                         'id'    => 1,
                         'class' => array('btn', 'btn-default'), //複数指定したい場合は配列で
                         'data-role' => 'btn' //classやid以外でもよい
                         );
    */
    // @return string ex. id=1 class="btn btn-default" data-role="btn"
    public function transExtentionParams($params)
    {
        if (empty($params)) {
            return '';
        }

        $template = '%s="%s"';
        $extention = '';
        foreach ($params as $key => $val) {
            $tmp_vals = '';
            if (is_array($val) === true) {
                foreach ($val as $v) {
                    $tmp_vals = $tmp_vals . " " . $v;
                }
            } else {
                $tmp_vals = $val;
            }
            $extention = $extention . " " . sprintf($template, $key, $tmp_vals);
        }
        return $extention;
    }
}
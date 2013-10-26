<?php
//データ構造
class Mar_Module_Calc_Data_User
{
    //ユーザid int
    private $uid;
    //ユーザ名 string
    private $name;

    //各種データ
    // 対局日、得点、順位はキー値を共通項として持つ
    //  ex. $point[2]は $calender[2]日に対局が行われ、$order[2]位だったことを表す
    //対局日の推移 array
    private $calender;
    //得点の推移 array
    private $point;
    //順位の推移 array
    private $order;
    //対局相手
    private $member;

    //累計点数
    private $sum_point;
    //平均順位
    private $avg_order;
    //あるユーザと同じ宅に座った時の成績
    private $vs_result;

    public function __construct($uid, $name)
    {
        $this->uid  = $uid;
        $this->name = $name;
    }

    //ユーザの対局情報を記録する
    // @params int   $order      順位
    // @params array $game_info  対局情報
    public function setGame($order, $game_info)
    {
        $this->calender[] = $game_info[$order]['date'];
        $this->point[]    = $game_info[$order]['point'];
        $this->order[]    = $order;
        $member = array();
        foreach ($game_info as $o => $d) {
            if ($o !== $order) {
                $member[] = $d['uid'];
            }
        }
        $this->member[] = $member;
    }

    //累計得点を求める
    public function makeSumPoint()
    {
        if (empty($this->point) === false) {
            $this->sum_point = array_sum($this->point);
        } else {
            $this->sum_point = 0;
        }
    }

    //平均順位を求める
    public function makeAvgOrder()
    {
        if (empty($this->order) === false) {
            $this->avg_order = array_sum($this->order)/count($this->order);
        } else {
            $this->avg_order = 0;
        }
    }

    public function makeVsResult()
    {
        $this->vs_result = array();//初期化する(一応)
        /*
          vs_result = arrray(
                    uid => array(
                            'calender' => array(),
                            'point'    => array(),
                            'order'    => array(),
                    ),
                    uid => array( ...
                    ),
          );
         */
        if (empty($this->member)) {
            return;
        }
        foreach ($this->member as $key => $members) {
            //$mem = array(1,2,3);
            foreach ($members as $m) {
                if (array_key_exists($m, $this->vs_result) === true) {
                    $this->vs_result[$m]['calender'][] = $this->calender[$key];
                    $this->vs_result[$m]['point'][]    = $this->point[$key];
                    $this->vs_result[$m]['order'][]    = $this->order[$key];
                } else {
                    $this->vs_result[$m] = array();
                    $this->vs_result[$m]['calender'] = array();
                    $this->vs_result[$m]['point']    = array();
                    $this->vs_result[$m]['order']    = array();
                    $this->vs_result[$m]['calender'][] = $this->calender[$key];
                    $this->vs_result[$m]['point'][]    = $this->point[$key];
                    $this->vs_result[$m]['order'][]    = $this->order[$key];
                }
            }
        }
    }

    public function getUid()
    {
        return $this->uid;
    }

    //累計得点を取り出す
    public function getSumPoint()
    {
        return $this->sum_point;
    }

    //平均順位を取り出す
    public function getAvgOrder()
    {
        return $this->avg_order;
    }
}

<?php
/*
 id     
 date   
 fstu   
 sndu   
 thru   
 foru   
 fstp   
 sndp   
 thrp   
 forp   
 status 
 mtime  
 ctime  
*/

class Mar_Bank_Games extends DataManager
{
    private $_querys = array(
                             'select_all' => 'select * from games',
                             'select_by_id' => 'select * from games where id=:id',
                             'select_by_time' => 'select * from games where date between :start and :end',
                             'insert' => 'insert into games(date, fstu, sndu, thru, foru, fstp, sndp, thrp, forp, ctime) values(:date, :fstu, :sndu, :thru, :foru, :fstp, :sndp, :thrp, :forp, now());',
                             'update' => 'update games set date=:date, fstu=:fstu, sndu=:sndu, thru=:thru, foru=:foru, fstp=:fstp, sndp=:sndp, thrp=:thrp, forp=:forp where id=:id',
                             'delete' => 'delete from games where id=:id',

                             );

    public function getAll()
    {
        return $this->find($this->_querys['select_all']);
    }

    public function getGameByTimeRange($start, $end)
    {
        $params = array(
                        'start' => $start,
                        'end'   => $end
                        );
        return $this->find($this->_querys['select_by_time'], $params);
    }

    public function getGameById($id)
    {
        $params = array(
                        'id' => $id
                        );
        return $this->find($this->_querys['select_by_id'], $params);
    }

    public function addGame(
                        $date,
                        $fstu, $sndu, $thru, $foru,
                        $fstp, $sndp, $thrp, $forp
                        )
    {
        $params = array(
                        'date' => $date,
                        'fstu' => $fstu, 
                        'sndu' => $sndu,
                        'thru' => $thru,
                        'foru' => $foru,
                        'fstp' => $fstp,
                        'sndp' => $sndp,
                        'thrp' => $thrp,
                        'forp' => $forp,
                        );
        return $this->exec($this->_querys['insert'], $params);
    }

    public function updateGame(
                        $id,
                        $date,
                        $fstu, $sndu, $thru, $foru,
                        $fstp, $sndp, $thrp, $forp
                        )
    {
        $params = array(
                        'id'   => $id,
                        'date' => $date,
                        'fstu' => $fstu, 
                        'sndu' => $sndu,
                        'thru' => $thru,
                        'foru' => $foru,
                        'fstp' => $fstp,
                        'sndp' => $sndp,
                        'thrp' => $thrp,
                        'forp' => $forp,
                        );
        return $this->exec($this->_querys['update'], $params);
    }

    public function deleteGame($id)
    {
        $params = array(
                        'id' => $id
                        );
        return $this->exec($this->_querys['delete'], $params);
    }

}
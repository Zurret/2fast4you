<?php

// Bonus suchen und am Termindatum gutschreiben
$sql = 'SELECT * FROM game_werbung';
$now_result = @mysql_query($sql);
$now_anzahl = @mysql_num_rows($now_result);
if(!empty($now_anzahl)) {
    for($x=0;$x!=$now_anzahl;$x++) {
        @mysql_data_seek($now_result, $x);
        $data = @mysql_fetch_array($now_result);
        if($data['time'] <= time()) {
            $sql = 'SELECT money FROM game_user WHERE id="'.$data['user_id'].'"';
            $result = @mysql_query($sql);
            $anzahl = @mysql_num_rows($result);
            if(!empty($anzahl)) {
                $userdata = @mysql_fetch_array($result);
                $new_money = $userdata['money'] + $DEFAULTS['game']['bonus'];
                $sql1 = 'UPDATE game_user SET money="'.$new_money.'" WHERE id="'.$data['user_id'].'"';
                $sql2 = 'DELETE FROM game_werbung WHERE id="'.$data['id'].'"';
                @mysql_query($sql1);
                @mysql_query($sql2);
            }
        }
    }
}

?>

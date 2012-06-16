<?php

// Alle abgelaufenen Gutschreiben und die Beschäftigungen entfernen
$sql = 'SELECT * FROM game_busy WHERE game_busy.ende<=CURRENT_TIMESTAMP';
$result = @mysql_query($sql);
$anzahl = @mysql_num_rows($result);
if(!empty($anzahl)) {
    while($data = mysql_fetch_array($result)) {
        if($data['ende'] <= time()) {
            $uinfo = @mysql_fetch_array(@mysql_query('SELECT money FROM game_user WHERE id="' . $data['user_id'] . '" LIMIT 1'));
            $tmp = explode('|', $data['do_after']);
            for($x=0;$x!=count($tmp);$x++) { @mysql_query($tmp[$x]); }
            @mysql_query('DELETE FROM game_busy WHERE id="' . $data['id'] . '"');
            if($data['money_add'] == 1) { $tmp_mny = $uinfo['money'] + $data['money']; } else { $tmp_mny = $uinfo['money'] - $data['money']; }
            @mysql_query('UPDATE game_user SET money="' . $tmp_mny . '" WHERE id="' . $data['user_id'] . '"');
        }
    }
}
// Wenn Benutzer eingeloggt, dann prüfen ob desen Charakter beschäftigt ist.
if($_SESSION['logged']) {
    // Benutzer ist gerade beschäftigt?
    $sql = 'SELECT game_busy.id AS id, ende, work_on, do_after FROM game_busy WHERE game_busy.user_id="' . $_SESSION['userid'] . '" LIMIT 1';
    $result = @mysql_query($sql);
    $anzahl = @mysql_num_rows($result);
    if(!empty($anzahl)) {
        $data = @mysql_fetch_array($result);
        $tmp_time =  $data['ende']- time();
        require( DIR_LANGUAGE . PAGE_LANGUAGE . '/busy' . EXT_CODE );
        $BUSY['power']  = true;
        $vars['busy']   =   array(  '{BUSY_TOPIC}'          => 'Besch&auml;ftigung',
                                    '{BUSY_WORKTIME}'       => $tmp_time,
                                    '{BUSY_FINISH_URL}'     => 'index.php',
                                    '{BUSY_TEXT}'           => $LANG['game']['busy'][$data['work_on']],
                                    '' => ''
                                 );
    } else { $BUSY['power'] = false; }
} else { $BUSY['power'] = false; }

?>

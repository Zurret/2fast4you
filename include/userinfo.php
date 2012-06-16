<?php

// Wenn Benutzer eingeloggt, dann Benutzerinformationen laden
if($_SESSION['logged']) {

    // Event Sprachdatei laden
    require( DIR_LANGUAGE . PAGE_LANGUAGE . '/userinfo' . EXT_CODE );

    // Prüfe ob der Benutzer neue Nachrichten bekommen hat
    $sql = 'SELECT * FROM game_user WHERE game_user.id="'.$_SESSION['userid'].'" LIMIT 1';
    $result = @mysql_query($sql);
    $anzahl = @mysql_num_rows($result);
    if(!empty($anzahl)) {
        $tmp_style = 0;
        $data = @mysql_fetch_array($result);
        // Informationen auslesen
        $userclubinfo = '';
        $clubinfo = @mysql_query('SELECT * FROM game_club');
        while($clubdata = @mysql_fetch_array($clubinfo)) { $tmp = explode('#', $clubdata['member']); for($x=0;$x!=count($tmp);$x++) { $ttmp = explode(':', $tmp[$x]); if($ttmp[0] == $_SESSION['userid']) { $userclubinfo = $clubdata; break(2); } } }
        if(empty($userclubinfo['name'])) { $tmp_club = '{USERINFO_NO_CLUB}';} else {$tmp_club = '<a href="index.php?c=clubprofil&cid=' . $userclubinfo['id'] . '">' . $userclubinfo['name'] . '</a>'; }
        if(empty($data['now_car'])) {
            $tmp_car = '{USERINFO_NO_CAR}';
        } else {
            $tmp_tune_info = @mysql_fetch_array(@mysql_query('SELECT game_incars.tuned AS tuned FROM game_incars WHERE garage_id="' . $data['now_car'] . '" LIMIT 1'));
            $tmp = explode('#', $tmp_tune_info['tuned']);
            for($x=0;$x!=count($tmp);$x++) { $ttmp = explode(';', $tmp[$x]); if($ttmp[0] != 'w') { $tteilinfo = @mysql_fetch_array(@mysql_query('SELECT style FROM game_tuning WHERE name_id="' . $ttmp[0] . '" && kat_id="' . $x . '" LIMIT 1')); $tmp_style += $tteilinfo['style']; } }
            $tmp_car_info = @mysql_fetch_array(@mysql_query('SELECT game_cars.name_id AS id FROM game_garage INNER JOIN game_cars ON game_garage.car_id=game_cars.id WHERE game_garage.id="' . $data['now_car'] . '" LIMIT 1'));
            $tmp_car = '<a href="index.php?c=mygarage">' . $CARNAME[$tmp_car_info['id']] . '</a>';
        }
        $reslt = @mysql_query('SELECT * FROM game_userjobs WHERE user_id="' . $_SESSION['userid'] . '"');
        $anzhl = @mysql_num_rows($reslt);
        if(!empty($anzhl)) { $jinfo = @mysql_fetch_array($reslt); $tmp_job = '<a href="index.php?c=arbeit">' . $JOBNAMES[$jinfo['job_id']] . '</a>'; } else { $tmp_job = '{USERINFO_NO_WORK}'; }
        $reslt = @mysql_query('SELECT * FROM game_sponsoren WHERE user_id="' . $_SESSION['userid'] . '"');
        $anzhl = @mysql_num_rows($reslt);
        if(!empty($anzhl)) { $sinfo = @mysql_fetch_array($reslt); $tmp_sponsor = '<a href="index.php?c=sponsoren&d=details&sid=' . $sinfo['id'] . '">' . $sinfo['sprs_name'] . '</a>'; } else { $tmp_sponsor = '{USERINFO_NO_SPONSOR}'; }
        // Informationen setzen
        $vars['userinfo']   =   array(  '{VALUE_MONEY}'     => number_format($data['money'],2,",",".") . $DEFAULTS['game']['waehrung'],
                                        '{VALUE_CAR}'       => $tmp_car,
                                        '{VALUE_WORK}'      => $tmp_job,
                                        '{VALUE_SPONSOR}'   => $tmp_sponsor,
                                        '{VALUE_RUF}'       => $data['ruf'],
                                        '{VALUE_STYLE}'     => $tmp_style,
                                        '{VALUE_ANSEHEN}'   => $data['ansehen'],
                                        '{VALUE_CLUB}'      => $tmp_club        );
    }
    $vars['userinfo'] = array_merge($vars['userinfo'], $LANG['userinfo'] );
}

?>

<?php

if($_SESSION['logged']) {
    // Initialisierung der Suche
    $userclubinfo = '';
    $tmp_vars = array();
    $sql = 'SELECT * FROM game_user WHERE id="' . $FormVars['id'] . '" LIMIT 1';
    $result = @mysql_query($sql);
    $anzahl = @mysql_num_rows($result);
    if(empty($anzahl)) {
        $ERROR['power'] = true; $tmp_nr = "01";
    } else {
        $data = @mysql_fetch_array($result);
        $tmp_car_info = @mysql_fetch_array(@mysql_query('SELECT game_cars.name_id AS name_id, game_cars.id AS id FROM game_garage INNER JOIN game_cars ON game_garage.car_id=game_cars.id WHERE game_garage.id="' . $data['now_car'] . '" LIMIT 1'));
        if(!empty($CARNAME[$tmp_car_info['name_id']])) { $tmp_carname = '<a href="index.php?c=autohaus&d=details&cid=' . $tmp_car_info['name_id'] . '">' . $CARNAME[$tmp_car_info['name_id']] . '</a>'; } else { $tmp_carname = '{PROFIL_NO_CAR}'; }
        $clubinfo = @mysql_query('SELECT * FROM game_club');
        while($clubdata = @mysql_fetch_array($clubinfo)) { $tmp = explode('#', $clubdata['member']); for($x=0;$x!=count($tmp);$x++) { $ttmp = explode(':', $tmp[$x]); if($ttmp[0] == $FormVars['id']) { $userclubinfo = $clubdata; break(2); } } }
        if(empty($userclubinfo['name'])) { $tmp_club = '{PROFIL_NO_CLUB}'; } else { $tmp_club = '<a href="index.php?c=clubprofil&cid=' . $userclubinfo['id'] . '">' . $userclubinfo['name'] . '</a>'; }
        $files = array( DIR_AVATARS . $data['id'] . EXT_AVAIMG1, DIR_AVATARS . $data['id'] . EXT_AVAIMG2 );
        for($x=0;$x!=count($files);$x++) { if(file_exists($files[$x])) { $tmp_avatar = '<img src="' . $files[$x] . '" border="1">'; $tmp_av_got = true; break(1); } }
        if(!$tmp_av_got) {$tmp_avatar = '<table border="1" cellpadding="0" cellspacing="0" width="90" height="90"><tr><td width="100%" align="center" valign="middle">{PROFIL_NO_AVATAR}</td></tr></table>';}
        if($data['id'] != $_SESSION['userid']) {
            $tmp_write = '<a href="index.php?c=nachrichten&d=write&uid=' . $data['id'] . '">{PROFIL_WRITE_MSG}</a>';
            $buddy_rslt = @mysql_query('SELECT * FROM game_buddys WHERE user_id="' . $_SESSION['userid'] . '" LIMIT 1');
            $got_user = FALSE; $buddy_anzahl = @mysql_num_rows($buddy_rslt);
            if(!empty($buddy_anzahl)) { $bdydata = @mysql_fetch_array($buddy_rslt); $tmp = explode(';', $bdydata['buddys']); for($x=0;$x!=count($tmp);$x++) { if($tmp[$x] == $data['id']) { $got_user = TRUE; break(1); } } }
            if(!$got_user) { $tmp_buddy = '<a href="index.php?c=usertools&d=buddys&g=add&p_nick=' . $data['nick'] . '&check=1">{PROFIL_ADD2BUDDYS}</a>'; } else { $tmp_buddy = '<a href="index.php?c=usertools&d=buddys&g=delete&id=' . $data['id'] . '">{PROFIL_DEL2BUDDYS}</a>'; }
        }
        $rslt = @mysql_query('SELECT job_id FROM game_userjobs WHERE user_id="' . $data['id'] . '" LIMIT 1');
        $anzahl = @mysql_num_rows($rslt);
        if(!empty($anzahl)) { $tmpd = @mysql_fetch_array($rslt); $tmp_arbeit = '<a href="index.php?c=jobboerse&d=details&jid=' . $tmpd['job_id'] . '">' . $JOBNAMES[$tmpd['job_id']] . '</a>'; } else { $tmp_arbeit = $LANG['game']['profil']['{PROFIL_NO_WORK}']; }
        $rslt = @mysql_query('SELECT sprs_name FROM game_sponsoren WHERE user_id="' . $data['id'] . '" LIMIT 1');
        $anzahl = @mysql_num_rows($rslt);
        if(!empty($anzahl)) { $tmpd = @mysql_fetch_array($rslt); $tmp_sponsor = $tmpd['sprs_name']; } else { $tmp_sponsor = $LANG['game']['profil']['{PROFIL_NO_SPONSOR}']; }
        $tmp_vars = array(  '{USER_ID}'             => $data['id'],
                            '{USER_NICKNAME}'       => $data['nick'],
                            '{USER_FAHRZEUG}'       => $tmp_carname,
                            '{USER_ANSEHEN}'        => $data['ansehen'],
                            '{USER_STYLE}'          => $data['style'],
                            '{USER_RUF}'            => $data['ruf'],
                            '{USER_BERUF}'          => $tmp_arbeit,
                            '{USER_SPONSOR}'        => $tmp_sponsor,
                            '{USER_CLUB}'           => $tmp_club,
                            '{USER_AVATAR}'         => $tmp_avatar,
                            '{USER_VLU_WRITE}'      => $tmp_write,
                            '{USER_VLU_BUDDY}'      => $tmp_buddy               );
        // Template laden
        $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'profil', EXT_TEMPS );
    }
    $vars['error'] = array( '{ERROR_MESSAGE}' => '{PROFIL_ERROR_' . $tmp_nr . '}');
    // Platzhalter füllen
    $vars['content']        =   array( '{CONTENT}' => $tmp_section_content, '{PROFIL_ERGEBNIS}' => $tmp_ergebnis );
    $vars['content']        =   array_merge($vars['content'], $tmp_vars, $LANG['game']['profil']);
} else {$vars['content']        =   array( '{CONTENT}' => $LANG['root']['verweigert']);}

?>

<?php

if($_SESSION['logged']) {
    // Initialisierung der Suche
    $sql = 'SELECT game_rekorde.strecken_id AS id, user_id, game_rekorde.zeit AS aufgestellt, game_rekorde.time AS rekord, game_rekorde.runden AS runden FROM game_rekorde INNER JOIN game_strecken ON game_rekorde.strecken_id=game_strecken.id ORDER BY game_rekorde.strecken_id ASC';
    $result = @mysql_query($sql);
    $anzahl = @mysql_num_rows($result);
    $last_streckentyp = 0;
    if(!empty($anzahl)) {
        $tmp_ergebnis = '<tr><td width="10%" align="center" height="30"><i>{REKORDE_RUNDEN}</i></td><td width="25%" align="center" height="30"><i>{REKORDE_STRECKE}</i></td><td width="20%" align="center"><i>{REKORDE_NICKNAME}</i></td><td width="20%" align="center"><i>{REKORDE_GESTELLT}</i></td><td width="25%" align="left"><i>{REKORDE_REKORD}</i></td></tr>';
        while($data = @mysql_fetch_array($result)) {
            $sql = 'SELECT game_strecken.name AS name FROM game_strecken WHERE id="' . $data['id'] . '" LIMIT 1';
            $result_strecke = @mysql_query($sql);
            $anzahl = @mysql_num_rows($result_strecke);
            if(!empty($anzahl)) {$data_strecke = mysql_fetch_array($result_strecke); $tmp_strecke = $data_strecke['name']; } else { $tmp_strecke = '{REKORDE_STRECKE_DELETET}';}
            $sql = 'SELECT game_user.nick AS nick FROM game_user WHERE id="' . $data['user_id'] . '" LIMIT 1';
            $result_nick = @mysql_query($sql); $anzahl = @mysql_num_rows($result_nick);
            if(!empty($anzahl)) {$data_nick = mysql_fetch_array($result_nick); $tmp_nick = $data_nick['nick'];} else {$tmp_nick = '{REKORDE_USER_DELETET}';}
            $tmp_runden = $data['runden'];
            $zeit = $data['rekord']; $std = 0; $min = 0; $sek = 0;
            while(!empty($zeit)) { if($zeit >= 3600) { $zeit -= 3600; $std++; } elseif($zeit >= 60) { $zeit -= 60; $min++; } else { $sek += $zeit; $zeit = 0; } }
            $sek = round($sek, 2);
            $tmp_rekord = '';
            if(!empty($std)) {$tmp_rekord .= $std . '{REKORDE_STUNDEN} ';}
            if(!empty($min)) {$tmp_rekord .= $min . '{REKORDE_MINUTEN} ';}
            $tmp_rekord .= $sek . '{REKORDE_SEKUNDEN}';
            if($last_streckentyp != $data['id']) { $tmp_ergebnis .= '<tr><td width="100%" colspan="4" align="center">&nbsp;</td></tr>'; }
            $tmp_date = date("d.m.Y", $data['aufgestellt']);
            if(date("d.m.Y") != $tmp_date) { $tmp_col0 = ''; $tmp_col1 = ''; } else { $tmp_col0 = '<font color="lime">'; $tmp_col1 = '</font>'; }
            $tmp_ergebnis .= '<tr><td width="10%" align="center">' . $tmp_col0 . $tmp_runden . $tmp_col1 . '</td><td width="25%" align="center">' . $tmp_col0 . $tmp_strecke . $tmp_col1 . '</td><td width="20%" align="center"><a href="index.php?c=profil&id=' . $data['user_id'] . '">' . $tmp_col0 . $tmp_nick . $tmp_col1 . '</a></td><td width="20%" align="center">' . $tmp_col0 . $tmp_date . $tmp_col1 . '</td><td width="25%" align="left">' . $tmp_col0 . $tmp_rekord . $tmp_col1 . '</td></tr>';
            $last_streckentyp = $data['id'];
        }
    } else { $tmp_ergebnis = '<tr><td width="100%" align="center" height="50">{RANGLISTE_NO_REKORDS}</td></tr>'; }

    // Template laden
    $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'rekorde', EXT_TEMPS );

    // Platzhalter füllen
    $vars['content']        =   array( '{CONTENT}' => $tmp_section_content, '{REKORDE_ERGEBNIS}' => $tmp_ergebnis );
    $vars['content']        =   array_merge($vars['content'], $LANG['game']['rekorde']);
} else {$vars['content']        =   array( '{CONTENT}' => $LANG['root']['verweigert']);}

?>

<?php

    // Initialisierung der Suche
    $tmp_time = (time() - ($DEFAULTS['game']['online_user'] * 60));
    $sql = 'SELECT game_user.id AS id, nick, last_action FROM game_user WHERE ' . $tmp_time . ' < game_user.last_action ORDER BY nick DESC';
    $result = @mysql_query($sql);
    $anzahl = @mysql_num_rows($result);
    $tmp_ergebnis = ''; $z = 1; $tmp_vars = array();
    for($x=0;$x!=$anzahl;$x++, $z++) {
        @mysql_data_seek($result, $x);
        $data = @mysql_fetch_array($result);
        $tmp_ergebnis .= '<tr><td width="10%" align="center">' . $z . '.</td><td width="50%" align="left">' . $data['nick'] . '</td><td width="40%" align="left">' . date('H:i', $data['last_action']) . ' Uhr</td></tr>';
    }

    // Template laden
    $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'user_online', EXT_TEMPS );

    // Platzhalter füllen
    $vars['content']        =   array( '{CONTENT}' => $tmp_section_content, '{USER_ONLINE_ERGEBNIS}' => $tmp_ergebnis );
    $vars['content']        =   array_merge($vars['content'], $LANG['game']['user_online'], $tmp_vars);

?>

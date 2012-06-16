<?php

if($_SESSION['logged']) {
    // Initialisierung der Suche
    if($FormVars['d'] == 'today') {
        $tmp_time = (time() - ((date("H") * 3600) + (date("i") * 60) + date("s")));
        $sql = 'SELECT game_user.id AS id, nick, last_action FROM game_user WHERE ' . $tmp_time . ' < game_user.last_action ORDER BY nick DESC';
        $tmp_hinweis = '';
        $tmp_linked = '<a href="index.php?c=online">{ONLINE_LINK_ONLINE}</a>';
    } else {
        $tmp_time = (time() - ($DEFAULTS['game']['online_user'] * 60));
        $sql = 'SELECT game_user.id AS id, nick, last_action FROM game_user WHERE ' . $tmp_time . ' < game_user.last_action ORDER BY nick DESC';
        $tmp_hinweis = $LANG['game']['user_online']['{ONLINE_HINWEIS}'];
        $tmp_linked = '<a href="index.php?c=online&d=today">{ONLINE_LINK_TODAY}</a>';
    }
    $result = @mysql_query($sql);
    $anzahl = @mysql_num_rows($result);
    $tmp_ergebnis = ''; $z = 1; $tmp_vars = array();
    for($x=0;$x!=$anzahl;$x++, $z++) {
        @mysql_data_seek($result, $x);
        $data = @mysql_fetch_array($result);
        $tmp_ergebnis .= '<tr><td width="10%" align="center">' . $z . '.</td><td width="50%" align="left"><a href="index.php?c=profil&id=' . $data['id'] . '">' . $data['nick'] . '</a></td><td width="40%" align="left">' . date('H:i', $data['last_action']) . '{ONLINE_UHR}</td></tr>';
    }

    // Template laden
    $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'user_online', EXT_TEMPS );

    // Platzhalter füllen
    $vars['content']        =   array( '{CONTENT}' => $tmp_section_content, '{USER_ONLINE_ERGEBNIS}' => $tmp_ergebnis, '{ONLINE_VLU_HINWEIS}' => $tmp_hinweis, '{ONLINE_VLU_LINK}' => $tmp_linked );
    $vars['content']        =   array_merge($vars['content'], $LANG['game']['user_online'], $tmp_vars);
} else {$vars['content']        =   array( '{CONTENT}' => $LANG['root']['verweigert']);}

?>

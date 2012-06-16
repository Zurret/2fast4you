<?php

if($_SESSION['logged']) {
    // Variablen definieren
    $tmp_vars = array();

    // Statistikinformationen für die Hauptseite auswerten
    $sql = 'SELECT * FROM main_news';
    $result = @mysql_query($sql);
    $anzahl = @mysql_num_rows($result);
    @mysql_free_result($result);
    $tmp_vars['{VALUE_NEWS}'] = $anzahl;
    $sql = 'SELECT * FROM main_comments';
    $result = @mysql_query($sql);
    $anzahl = @mysql_num_rows($result);
    @mysql_free_result($result);
    $tmp_vars['{VALUE_COMMENTS}'] = $anzahl;


    // Statistikinformationen für die Spielseite auswerten
    $sql = 'SELECT * FROM game_user';
    $result = @mysql_query($sql);
    $anzahl = @mysql_num_rows($result);
    @mysql_free_result($result);
    $tmp_vars['{VALUE_USER}'] = $anzahl;
    $sql = 'SELECT * FROM game_email_activation';
    $result = @mysql_query($sql);
    $anzahl = @mysql_num_rows($result);
    @mysql_free_result($result);
    $tmp_vars['{VALUE_ACTIVATION}'] = $anzahl;
    $sql = 'SELECT * FROM game_delete';
    $result = @mysql_query($sql);
    $anzahl = @mysql_num_rows($result);
    @mysql_free_result($result);
    $tmp_vars['{VALUE_DELATION}'] = $anzahl;
    $sql = 'SELECT * FROM game_club';
    $result = @mysql_query($sql);
    $anzahl = @mysql_num_rows($result);
    @mysql_free_result($result);
    $tmp_vars['{VALUE_CLUBS}'] = $anzahl;
    $sql = 'SELECT * FROM game_nachrichten';
    $result = @mysql_query($sql);
    $anzahl = @mysql_num_rows($result);
    @mysql_free_result($result);
    $tmp_vars['{VALUE_ALL_NACHRICHTEN}'] = $anzahl;
    $sql = 'SELECT * FROM game_nachrichten WHERE neu="1"';
    $result = @mysql_query($sql);
    $anzahl = @mysql_num_rows($result);
    @mysql_free_result($result);
    $tmp_vars['{VALUE_NEW_NACHRICHTEN}'] = $anzahl;
    $sql = 'SELECT * FROM game_nachrichten WHERE melden="1"';
    $result = @mysql_query($sql);
    $anzahl = @mysql_num_rows($result);
    @mysql_free_result($result);
    $tmp_vars['{VALUE_MLD_NACHRICHTEN}'] = $anzahl;
    $tmp_bank = (int)0;
    $tmp_money = (int)0;
    $sql = @mysql_query('SELECT id, bank, money FROM game_user');
    while($data = @mysql_fetch_array($sql)) { $tmp_bank = $tmp_bank + $data['bank']; $tmp_money = $tmp_money + $data['money']; }
    $tmp_vars['{VALUE_ALL_MONEY}'] = number_format($tmp_money,2,",",".") . $DEFAULTS['game']['waehrung'];
    $tmp_vars['{VALUE_ALL_BANKMONEY}'] = number_format($tmp_bank,2,",",".") . $DEFAULTS['game']['waehrung'];

    // Template laden
    $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'statistik', EXT_TEMPS );

    // Platzhalter füllen
    $vars['content']        =   array( '{CONTENT}' => $tmp_section_content );
    $vars['content']        =   array_merge($vars['content'], $LANG['game']['statistik'], $tmp_vars);
} else {$vars['content']        =   array( '{CONTENT}' => $LANG['root']['verweigert']);}

?>

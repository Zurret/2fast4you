<?php

// Wenn Benutzer eingeloggt, dann Privatbereich laden
if($_SESSION['logged']) {
    // Event Sprachdatei laden
    require( DIR_LANGUAGE . PAGE_LANGUAGE . '/privat' . EXT_CODE );
    $sql = 'SELECT * FROM game_userjobs WHERE user_id="' . $_SESSION['userid'] . '" LIMIT 1';
    $result = @mysql_query($sql);
    $anzahl = @mysql_num_rows($result);
    $tmp_got_work = FALSE;

    if(!empty($anzahl)) { $tmp_got_work = TRUE; }

    $privat_links = '';
    if($tmp_got_work == TRUE) {$privat_links .= '<tr><td width="100%" align="center" height="20"><a href="index.php?c=arbeit">{PRIVAT_WORK}</a></td></tr>'; }
    $privat_links .= '<tr><td width="100%" align="center" height="20"><a href="index.php?c=mygarage">{PRIVAT_GARAGE}</a></td></tr>';
    $privat_links .= '<tr><td width="100%" align="center" height="20"><a href="index.php?c=myskills">{PRIVAT_SKILLS}</a></td></tr>';

    // Informationen setzen
    $vars['privat'] = array_merge( array( '{PRIVAT_LINKS}' => $privat_links),
                                   $LANG['privat']
                                 );
}

?>

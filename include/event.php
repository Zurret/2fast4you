<?php

// Wenn Benutzer eingeloggt, dann prüfen ob der Benutzer Hinweise ben.
if($_SESSION['logged']) {

    // Event Sprachdatei laden
    require( DIR_LANGUAGE . PAGE_LANGUAGE . '/event' . EXT_CODE );

    // Prüfe ob der Benutzer neue Nachrichten bekommen hat
    $sql = 'SELECT * FROM game_nachrichten WHERE empfaenger_id="'.$_SESSION['userid'].'" && neu="1"';
    $result = @mysql_query($sql);
    $anzahl = @mysql_num_rows($result);
    if(!empty($anzahl)) {
        // Event Dialog einschalten/ausschalten
        $EVENT['power']  = true;
        if($anzahl == 1) { $tmp_nachrichten = '{EVENT_MSG_01}'; } else { $tmp_nachrichten = '{EVENT_MSG_02}'; }
        $vars['event']   =   array( '{EVENT_TOPIC}'     => '{EVENT_TOPIC_01}',
                                    '{EVENT_MESSAGE}'   => '<a href="index.php?c=nachrichten">' . $tmp_nachrichten . '</a>'    );
    }
    $vars['event'] = array_merge($vars['event'], $LANG['event'], array( '{EVENT_ANZAHL_MSG}'  => $anzahl ));
} else { $EVENT['power'] = false; }

?>

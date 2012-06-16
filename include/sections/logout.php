<?php

if($_SESSION['logged']) {
    // Sessioneinträge löschen
    while(list($key, $val) = each($_SESSION)){ session_unregister("$key"); } session_destroy();

    // Template laden
    $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'logout', EXT_TEMPS );

    // Platzhalter füllen
    $vars['content']        =   array(
                                        '{CONTENT}'             => $tmp_section_content,
                                        '{LOGOUT_TOPIC}'        => $LANG['game']['logout']['topic'],
                                        '{LOGOUT_CONTENT}'      => $LANG['game']['logout']['error_01'],
                                        '' => ''
                                     );
} else {$vars['content']        =   array( '{CONTENT}' => $LANG['root']['verweigert']);}

?>

<?php

// Benutzer prüfen und verarbeiten ..
$tmp_vars = array();
if(isset($_SESSION['adby'])) { $FormVars['adid'] = $_SESSION['adby']; }
$sql = 'SELECT game_user.id AS id, nick FROM game_user WHERE game_user.id="'.$FormVars['adid'].'"';
$result = @mysql_query($sql);
$anzahl = @mysql_num_rows($result);
if(!empty($anzahl)) {
    $data = @mysql_fetch_array($result);
    if($data['id'] != $_SESSION['userid']) {
        $_SESSION['adby'] = $FormVars['adid'];
        $tmp_vars = array( '{VALUE_NICKNAME}' => $data['nick'] );
        $tmp_show = true;
    } else { $ERROR['power'] = true; $tmp_show = false; $tmp_nr = "02"; }
} else { $ERROR['power'] = true; $tmp_show = false; $tmp_nr = "01"; }
$vars['error'] = array( '{ERROR_MESSAGE}' => '{WERBUNG_ERROR_' . $tmp_nr . '}');

if($tmp_show) {
    // Template laden
    $tmp_section_content    = loadTemplate( DIR_T_H_MAIN, 'werbung', EXT_TEMPS );
}
    // Platzhalter füllen
    $vars['content']        =   array_merge( array( '{CONTENT}' => $tmp_section_content ), $LANG['main']['werbung'], $tmp_vars );


?>

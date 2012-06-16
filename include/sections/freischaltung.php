<?php

// Benutzerdaten überprüfen und bei richtiger Eingabe freischalten
if($FormVars['check']) {
    if(!empty($FormVars['p_email'])) {
        if(!empty($FormVars['p_activationcode'])) {
            $sql = 'SELECT * FROM game_user WHERE email="' . strtolower($FormVars['p_email']) . '"';
            $tmp_result = @mysql_query($sql);
            $tmp_anzahl = @mysql_num_rows($tmp_result);
            if(!empty($tmp_anzahl)) {
                $tmp_result = @mysql_fetch_array($tmp_result);
                $user_id = $tmp_result['id'];
                $sql = 'SELECT * FROM game_email_activation WHERE user_id="'.$user_id.'"';
                $tmp_result = @mysql_query($sql);
                $tmp_anzahl = @mysql_num_rows($tmp_result);
                if(!empty($tmp_anzahl)) {
                    $tmp_result = @mysql_fetch_array($tmp_result);
                    if(strtolower($tmp_result['activationcode']) == strtolower($FormVars['p_activationcode'])) {
                        $sql = 'DELETE FROM game_email_activation WHERE user_id="'.$user_id.'"';
                        if(mysql_query($sql)) {
                            echo $user_id;
                            $ERROR['power'] = true; $tmp_nr = 7;
                        } else { $ERROR['power'] = true; $tmp_nr = 6; }
                    } else { $ERROR['power'] = true; $tmp_nr = 5; }
                } else { $ERROR['power'] = true; $tmp_nr = 4; }
            } else { $ERROR['power'] = true; $tmp_nr = 3; }
        } else { $ERROR['power'] = true; $tmp_nr = 2; }
    } else { $ERROR['power'] = true; $tmp_nr = 1; }
    $vars['error'] = array( '{ERROR_MESSAGE}' => '{FREISCHALTUNG_ERROR_0' . $tmp_nr . '}');
}

if($tmp_nr != 7) {
    // Template laden
    $tmp_section_content    = loadTemplate( DIR_T_H_MAIN, 'freischaltung', EXT_TEMPS );
    // Platzhalter füllen
    $vars['content']        =   array( '{CONTENT}' => $tmp_section_content );
    $vars['content']        =   array_merge($vars['content'], $LANG['main']['freischaltung']);
} else { $vars['content'] = array_merge(array( '{CONTENT}' => ''), $LANG['main']['freischaltung'] ); }

?>

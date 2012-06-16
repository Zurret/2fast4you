<?php

// Nach Eingabe der Logindaten überprüfung starten ..
if($FormVars['check']) {
    if(!empty($FormVars['p_nick'])) {
        if(!empty($FormVars['p_pass'])) {
            $sql = 'SELECT * FROM game_user';
            $tmp_data = @mysql_query($sql);
            $tmp_anzahl = @mysql_num_rows($tmp_data);
            if(!empty($tmp_anzahl)) {
                for($x=0;$x!=$tmp_anzahl;$x++) {
                    @mysql_data_seek($tmp_data, $x);
                    $tmp_result = @mysql_fetch_array($tmp_data);
                    if(strtolower($tmp_result['nick']) == strtolower($FormVars['p_nick']) && $tmp_result['pass'] == md5($FormVars['p_pass'])) {
                        $sql = 'SELECT * FROM game_email_activation WHERE user_id="' . $tmp_result['id'] . '"';
                        $result = @mysql_query($sql);
                        $anzahl = @mysql_num_rows($result);
                        if(empty($anzahl)) {
                            // Bonusaktionen starten ..
                            require( DIR_INCLUDE . 'bonus' . EXT_CODE );
                            // Logininfos in der Session speichern
                            $tmp_position = $LANG['root']['game_position'];
                            $tmp_ip = getenv('REMOTE_ADDR');
                            $_SESSION['logged']         = true;
                            $_SESSION['userid']         = $tmp_result['id'];
                            $_SESSION['nickname']       = $tmp_result['nick'];
                            $_SESSION['email']          = $tmp_result['email'];
                            $_SESSION['userip']         = $tmp_ip;
                            $_SESSION['logtime']        = time();
                            $sql = 'UPDATE game_user SET last_login="' . $tmp_result['now_login'] . '", now_login="' . time() . '", ip="' . $tmp_ip . '" WHERE id="' . $tmp_result['id'] . '"';
                            $ERROR['power'] = true;
                            $tmp_nr = 4;
                            @mysql_query($sql);
                            break(1);
                        } else { $ERROR['power'] = true; $tmp_nr = 7; }
                    } else { $ERROR['power'] = true; $tmp_nr = 6; }
                    if(empty($tmp_nr)) { $ERROR['power'] = true; $tmp_nr = 5; }
                }
            } else { $ERROR['power'] = true; $tmp_nr = 3; }
        } else { $ERROR['power'] = true; $tmp_nr = 2; }
    } else { $ERROR['power'] = true; $tmp_nr = 1; }
    $vars['error'] = array( '{ERROR_MESSAGE}' => '{LOGIN_ERROR_0' . $tmp_nr . '}');
}

if($tmp_nr != 4) {
    // Template laden
    $tmp_section_content    = loadTemplate( DIR_T_H_MAIN, 'login', EXT_TEMPS );

    // Platzhalter füllen
    $vars['content']        =   array( '{CONTENT}' => $tmp_section_content );
    $vars['content']        =   array_merge($vars['content'], $LANG['main']['login']);
} else { $vars['content'] = array_merge(array( '{CONTENT}' => ''), $LANG['main']['login'] ); }

?>

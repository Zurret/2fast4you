<?php

// Registrierung erlaubt?
if(PAGE_REGISTRATION) {
    // Registrierungsdaten überprüfen, in die DB eintragen und Freischalteemail senden, ausser das Registrierlimit wurde erreicht
    $tmp_sql = 'SELECT * FROM game_user';
    $tmp_result = @mysql_query($tmp_sql);
    $tmp_now_user = @mysql_num_rows($tmp_result);
    if($tmp_now_user < $DEFAULTS['main']['max_user']) {
        if($FormVars['check']) {
            if(!empty($FormVars['p_nick'])) {
                if(!empty($FormVars['p_pass'])) {
                    if(!empty($FormVars['p_pass_wh'])) {
                        if(strtolower($FormVars['p_pass']) === strtolower($FormVars['p_pass_wh'])) {
                            if(checkEmail($FormVars['p_email'])) {
                                if(!empty($FormVars['p_security'])) {
                                    if(strtoupper($FormVars['p_security']) === strtoupper($FormVars['p_checkcode'])) {
                                        $tmp_sql = 'SELECT * FROM game_user WHERE email="'.strtolower($FormVars['p_email']).'"';
                                        $tmp_result = @mysql_query($tmp_sql);
                                        $anzahl = @mysql_num_rows($tmp_result);
                                        if(empty($anzahl)) {
                                            $tmp_ip = getenv('REMOTE_ADDR');
                                            $sql_userinfo = 'INSERT INTO game_user VALUES(NULL, "'.$FormVars['p_nick'].'", "'.md5($FormVars['p_pass']).'", "'.strtolower($FormVars['p_email']).'", "'.$tmp_ip.'", "0", "'.time().'", "0", "0", "0", '.$DEFAULTS['game']['start_garagen'].', '.$DEFAULTS['game']['start_money'].', "0", "0", "0", "0", "0", "15", "0", "0", "0", "0");';
                                            $result_userinfos = mysql_query($sql_userinfo);
                                            $sql_userdata = 'SELECT id, nick FROM game_user WHERE email="'.strtolower($FormVars['p_email']).'"';
                                            $tmp_result = @mysql_query($sql_userdata);
                                            $tmp_result = @mysql_fetch_array($tmp_result);
                                            @mysql_query('INSERT INTO game_garage VALUES("", "' . $tmp_result['id'] . '", "0", "0", "0", "' . time() . '")');
                                            $tmp_activation_code = createPasswort(15);
                                            $sql_activation = 'INSERT INTO game_email_activation VALUES("", "'.$tmp_result['id'].'", "'.$tmp_activation_code.'")';
                                            $result_activation = @mysql_query($sql_activation);
                                            if(isset($_SESSION['adby'])) {
                                                $tmp_time = time()+(7*(24*3600));
                                                $sql = 'INSERT INTO game_werbung VALUES("", "'.$_SESSION['adby'].'", "'.$tmp_result['id'].'", "'.$tmp_time.'")';
                                                $result_werbedaten = @mysql_query($sql);
                                                $tmp_nachricht = loadTemplate( DIR_LANGUAGE . PAGE_LANGUAGE . '/', 'werbung', EXT_TEXT );
                                                $tmp_msgvars = array(   '{VALUE_NEW_PLAYER}'    => $tmp_result['nick'],
                                                                        '{VALUE_BONUS_TIME}'    => date("d.m.Y", $tmp_time )               );
                                                $tmp_nachricht = array2text( $tmp_nachricht, $tmp_msgvars );
                                                $sql = 'INSERT INTO game_nachrichten VALUES("", "0", "'.$_SESSION['adby'].'", "'.$LANG['main']['registration']['werbe_betreff'].'", "'.$tmp_nachricht.'", "'.time().'", "1", "0")';
                                                $result_msg2werber = @mysql_query($sql);
                                            } else { $result_werbedaten = true; $result_msg2werber = true; }
                                            if($result_userinfos && $result_activation && $result_werbedaten && $result_msg2werber) {
                                                $tmp_mail_form = loadTemplate( DIR_LANGUAGE . PAGE_LANGUAGE . '/', 'registration', EXT_TEXT );
                                                $tmp_vars = array(
                                                                    '{FORM_USER_EMAIL}' => $FormVars['p_email'],
                                                                    '{FORM_USER_NICK}'  => $FormVars['p_nick'],
                                                                    '{FORM_USER_PASS}'  => $FormVars['p_pass'],
                                                                    '{FORM_ACT_CODE}'   => $tmp_activation_code,
                                                                    '{FORM_ACT_LINK}'   => SERVER . 'index.php?c=freischaltung&check=1&p_email='.strtolower($FormVars['p_email']).'&p_activationcode='.strtolower($tmp_activation_code),
                                                                 );
                                                $tmp_mail_form = array2text($tmp_mail_form, $tmp_vars);
                                                $header = 'From:2f4y - The Game<registration@2f4y-thegame.de>\n';
                                                $header .= 'Reply-To: '.$FormVars['p_email'].'\n';
                                                $header .= 'Content-Type: text/html';
                                                if(@mail($FormVars['p_email'], 'Registrierung bei 2f4y', $tmp_mail_form, $header)) {
                                                    $ERROR['power'] = true; $tmp_nr = "11";
                                                } else { $ERROR['power'] = true; $tmp_nr = "10"; }
                                            } else { $ERROR['power'] = true; $tmp_nr = "09"; }
                                        } else { $ERROR['power'] = true; $tmp_nr = "08"; }
                                    } else { $ERROR['power'] = true; $tmp_nr = "07"; }
                                } else { $ERROR['power'] = true; $tmp_nr = "06"; }
                            } else { $ERROR['power'] = true; $tmp_nr = "05"; }
                        } else { $ERROR['power'] = true; $tmp_nr = "04"; }
                    } else { $ERROR['power'] = true; $tmp_nr = "03"; }
                } else { $ERROR['power'] = true; $tmp_nr = "02"; }
            } else { $ERROR['power'] = true; $tmp_nr = "01"; }
            $vars['error'] = array( '{ERROR_MESSAGE}' => '{REGISTRATION_ERROR_' . $tmp_nr . '}');
        }
    } else {
        $ERROR['power'] = true;
        $vars['error'] = array( '{ERROR_MESSAGE}' => '{REGISTRATION_ERROR_12}');
    }

    if($tmp_nr != "11") {
        // Secherheitscode-Klasse laden
        require_once( DIR_INC_CLASS . 'imgcode.class');
        // Sicherheitscode generieren
        srand(microtime()*1000000);
        $pwcode = new imgCode('courier_new.ttf', 'registration_' . time());
        $tmp_imgcode = '<img src="' . $pwcode->regenerateCode(rand(5,10)) . '"><br /><input type="hidden" name="p_checkcode" value="' . $pwcode->getPassword() . '">';
        // Template laden
        $tmp_section_content    = loadTemplate( DIR_T_H_MAIN, 'registration', EXT_TEMPS );
        #var_dump($tmp_section_content);
        // Platzhalter füllen
        $vars['content']        =   array( '{CONTENT}' => $tmp_section_content, '{REGISTRATION_SECURITY_CODE}' => $tmp_imgcode, '{VALUE_NOW_USER}' => $tmp_now_user, '{VALUE_MAX_USER}' => $DEFAULTS['main']['max_user'] );
    } else { $vars['content'] = array_merge(array( '{CONTENT}' => ''), $LANG['main']['registration'] ); }
} else { $vars['content'] = array( '{CONTENT}' => ''); $ERROR['power'] = true; $vars['error'] = array( '{ERROR_MESSAGE}' => '{REGISTRATION_ERROR_00}'); }

// Platzhalter füllen
$vars['content']        =   array_merge($vars['content'], $LANG['main']['registration']);

?>

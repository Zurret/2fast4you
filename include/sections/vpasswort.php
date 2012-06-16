<?php


// E-Mail Adresse überprüfen und ein neues Passwort generieren und zusenden wenn alles ok ist
if($FormVars['check']) {
    if(!empty($FormVars['p_nick'])) {
        if(!empty($FormVars['p_email'])) {
            $sql = 'SELECT * FROM game_user WHERE email="'.strtolower($FormVars['p_email']).'"';
            $tmp_result = mysql_query($sql);
            $tmp_anzahl = mysql_num_rows($tmp_result);
            if(!empty($tmp_anzahl)) {
                $tmp_result = mysql_fetch_array($tmp_result);
                if(strtolower($tmp_result['nick']) === strtolower($FormVars['p_nick'])) {
                    $tmp_new_passwort = createPasswort(15);
                    $sql = 'UPDATE game_user SET pass="'.md5($tmp_new_passwort).'" WHERE id="'.$tmp_result['id'].'"';
                    if(@mysql_query($sql)) {
                        $tmp_ip = getenv('REMOTE_ADDR');
                        $tmp_mail_form = loadTemplate( DIR_LANGUAGE . PAGE_LANGUAGE . '/', 'vpasswort', EXT_TEXT );
                        $tmp_vars = array(
                                            '{FORM_USER_EMAIL}' => $tmp_result['email'],
                                            '{FORM_USER_NICK}'  => $FormVars['p_nick'],
                                            '{FORM_USER_PASS}'  => $tmp_new_passwort,
                                            '{FORM_DATE}'       => date("d.m.Y"),
                                            '{FORM_TIME}'       => date("H:i:s") . ' Uhr',
                                            '{FORM_USER_IP}'    => $tmp_ip
                                         );
                        $tmp_mail_form = array2text($tmp_mail_form, $tmp_vars);
                        $header = 'From:2f4y - The Game<registration@2f4y-thegame.de>\n';
                        $header .= 'Reply-To: '.$FormVars['p_email'].'\n';
                        $header .= 'Content-Type: text/html';
                        if(@mail($FormVars['p_email'], 'Neues Passwort', $tmp_mail_form, $header)) {
                            $ERROR['power'] = true; $tmp_nr = 7;
                        } else { $ERROR['power'] = true; $tmp_nr = 6; }
                    } else { $ERROR['power'] = true; $tmp_nr = 5; }
                } else { $ERROR['power'] = true; $tmp_nr = 4; }
            } else { $ERROR['power'] = true; $tmp_nr = 3; }
        } else { $ERROR['power'] = true; $tmp_nr = 2; }
    } else { $ERROR['power'] = true; $tmp_nr = 1; }
    $vars['error'] = array( '{ERROR_MESSAGE}' => '{VPASSWORT_ERROR_0' . $tmp_nr . '}');
}

if($tmp_nr != 7) {
    // Template laden
    $tmp_section_content    = loadTemplate( DIR_T_H_MAIN, 'vpasswort', EXT_TEMPS );
    // Platzhalter füllen
    $vars['content']        =   array( '{CONTENT}' => $tmp_section_content );
    $vars['content']        =   array_merge($vars['content'], $LANG['main']['vpasswort']);
} else { $vars['content'] = array_merge(array( '{CONTENT}' => ''), $LANG['main']['vpasswort'] ); }

?>

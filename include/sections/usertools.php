<?php

// Nur Benutzer dürfen hier was machen
if($_SESSION['logged']) {

    // Zu löschende Accounts entfernen
    $sql = 'SELECT game_user.id AS id, game_delete.delete FROM game_user INNER JOIN game_delete ON game_user.id=game_delete.user_id';
    $result = @mysql_query($sql);
    $anzahl = @mysql_num_rows($result);
    if(!empty($anzahl)) {
        while($data = @mysql_fetch_array($result)) {
            if($data['delete'] <= time()) {
                $tmp_sql = array();
                $tmp_sql[] = 'DELETE FROM game_user WHERE id="' . $data['id'] . '"';
                $tmp_sql[] = 'DELETE FROM game_delete WHERE user_id="' . $data['id'] . '"';
                $tmp_sql[] = 'DELETE FROM game_garage WHERE user_id="' . $data['id'] . '"';
                $tmp_sql[] = 'DELETE FROM game_nachrichten WHERE absender_id="' . $data['id'] . '" && melden="0"';
                $tmp_sql[] = 'DELETE FROM game_sponsoren WHERE user_id="' . $data['id'] . '"';
                $tmp_sql[] = 'DELETE FROM game_userskills WHERE user_id="' . $data['id'] . '"';
                $tmp_sql[] = 'DELETE FROM game_userjobs WHERE user_id="' . $data['id'] . '"';
                $tmp_sql[] = 'DELETE FROM game_buddys WHERE user_id="' . $data['id'] . '" OR buddy_id="' . $data['id'] . '"';
                $tmp_sql[] = 'DELETE FROM game_busy WHERE user_id="' . $data['id'] . '"';
                $tmp_sql[] = 'DELETE FROM game_club WHERE leader_id="' . $data['id'] . '"';
                $tmp_sql[] = 'UPDATE game_club SET coleader_id="0" WHERE coleader_id="' . $data['id'] . '"';
                $tmp_sql[] = 'DELETE FROM game_incars WHERE user_id="' . $data['id'] . '"';
                $tmp_sql[] = 'DELETE FROM game_lager WHERE user_id="' . $data['id'] . '"';
                $tmp_sql[] = 'DELETE FROM game_ubay WHERE user_id="' . $data['id'] . '"';
                $tmp_sql[] = 'DELETE FROM game_werbung WHERE user_id="' . $data['id'] . '"';
                for($x=0;$x!=count($tmp_sql);$x++) { @mysql_query($tmp_sql[$x]); }
            }
        }
    }

    switch($FormVars['d']) {
        case 'account':
            $tmp_vars = array();
            switch($FormVars['g']) {
                case 'delete':
                    // Überprüfen ob Account freigegeben wurde oder nicht
                    $sql = 'SELECT * FROM game_delete WHERE user_id="'.$_SESSION['userid'].'"';
                    $result = @mysql_query($sql);
                    $anzahl = @mysql_num_rows($result);
                    if(empty($anzahl)) {
                        $tmp_vars = array( '{VALUE_ACCOUNT_DELETE}' => '<a href="index.php?c=usertools&d=account&g=delete&activate=1" onClick="return confirm(\'Account, zur Löschung, wirklich freigeben?\'); submit();">{USERTOOLS_ACCOUNT_DELETE_BTN_DELETE}</a>' );
                    } else {
                        $data = @mysql_fetch_array($result);
                        $tmp_vars = array( '{VALUE_ACCOUNT_DELETE}' => '<a href="index.php?c=usertools&d=account&g=delete&deactivate=1">{USERTOOLS_ACCOUNT_DELETE_BTN_CANCEL}</a><br>{USERTOOLS_ACCOUNT_DELETE_DELETION}{VALUE_DELETE_TIME}', '{VALUE_DELETE_TIME}' => date("d.m.Y - H:i", $data['delete']) );
                    }

                    // Accountlöschung freigeben
                    if(!empty($FormVars['activate']) && empty($FormVars['deactivate'])) {
                        $sql = 'INSERT INTO game_delete VALUES("", "'.$_SESSION['userid'].'", "'.(time() + $DEFAULTS['game']['account_delete']).'")';
                        if(@mysql_query($sql)) {
                            $ERROR['power'] = true; $tmp_nr = "02";
                        } else { $ERROR['power'] = true; $tmp_nr = "01"; }
                        $vars['error'] = array( '{ERROR_MESSAGE}' => '{USERTOOLS_ACCOUNT_DELETE_ERROR_' . $tmp_nr . '}');
                    }

                    // Accountlöschung stoppen
                    if(empty($FormVars['activate']) && !empty($FormVars['deactivate'])) {
                        $sql = 'DELETE FROM game_delete WHERE user_id="'.$_SESSION['userid'].'"';
                        if(@mysql_query($sql)) {
                            $ERROR['power'] = true; $tmp_nr = "04";
                        } else { $ERROR['power'] = true; $tmp_nr = "03"; }
                        $vars['error'] = array( '{ERROR_MESSAGE}' => '{USERTOOLS_ACCOUNT_DELETE_ERROR_' . $tmp_nr . '}');
                    }

                    // Template laden
                    $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'usertools_account_delete', EXT_TEMPS );
                    // Platzhalter füllen
                    $vars['content']        =   array( '{CONTENT}' => $tmp_section_content );
                    $vars['content']        =   array_merge( $vars['content'], $LANG['game']['usertools'], $tmp_vars );
                    break;

                case 'avatar':
                    $tmp_vars = array( '{VALUE_AVATAR}' => '<table border="1" cellpadding="0" cellspacing="0" width="90" height="90"><tr><td width="100%" align="center" valign="middle">{USERTOOLS_ACCOUNT_NO_AVATAR}</td></tr></table>' );
                    // Avatar hochladen
                    if(!empty($FormVars['check'])) {
                        if(!empty($_FILES['p_avatar']['tmp_name'])) {
                            $data = getimagesize($_FILES['p_avatar']['tmp_name']);
                            if($data[2] == 1) { $tmp_fileok = true; $ext = EXT_AVAIMG2;}
                            if($data[2] == 2) { $tmp_fileok = true; $ext = EXT_AVAIMG1;}
                            if($tmp_fileok) {
                                if($data[0] <= $DEFAULTS['game']['avatar_max_w']) {
                                    if($data[1] <= $DEFAULTS['game']['avatar_max_h']) {
                                        if(filesize($_FILES['p_avatar']['tmp_name']) <= ($DEFAULTS['game']['avatar_max_size'] * 1024)) {
                                            if(@copy($_FILES['p_avatar']['tmp_name'], DIR_TEMP . time() . $ext)) {
                                                @unlink( DIR_AVATARS . $_SESSION['userid'] . EXT_AVAIMG1 );
                                                @unlink( DIR_AVATARS . $_SESSION['userid'] . EXT_AVAIMG2 );
                                                if(move_uploaded_file($_FILES['p_avatar']['tmp_name'], DIR_AVATARS . $_SESSION['userid'] . $ext)){
                                                    $ERROR['power'] = true; $tmp_nr = "08";
                                                } else { $ERROR['power'] = true; $tmp_nr = "07"; }
                                            } else { $ERROR['power'] = true; $tmp_nr = "06"; }
                                        } else { $ERROR['power'] = true; $tmp_nr = "05"; }
                                    } else { $ERROR['power'] = true; $tmp_nr = "04"; }
                                } else { $ERROR['power'] = true; $tmp_nr = "03"; }
                            } else { $ERROR['power'] = true; $tmp_nr = "02"; }
                        } else { $ERROR['power'] = true; $tmp_nr = "01"; }
                        $vars['error'] = array( '{ERROR_MESSAGE}' => '{USERTOOLS_ACCOUNT_AVATAR_ERROR_' . $tmp_nr . '}');
                    }
                    // Prüfen ob ein Avatar vom Benutzer hochgeladen wurde.
                    $tmp_file1 = DIR_AVATARS . $_SESSION['userid'] . EXT_AVAIMG1;
                    $tmp_file2 = DIR_AVATARS . $_SESSION['userid'] . EXT_AVAIMG2;
                    if(@file_exists($tmp_file1) || @file_exists($tmp_file2)) { if(@file_exists($tmp_file1)) { $tmp_file = $tmp_file1; } else { $tmp_file = $tmp_file2; } $data = getimagesize($tmp_file); $tmp_vars = array_merge( $tmp_vars, array('{VALUE_AVATAR}' => '<img src="'.$tmp_file.'" '.$data['3'].'>')); }

                    // Template laden
                    $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'usertools_account_avatar', EXT_TEMPS );
                    break;

                case 'pwchange':
                    // Wenn der Benutzer wirklich das Passwort ändern will
                    if(!empty($FormVars['check'])) {
                        if(!empty($FormVars['p_opass'])) {
                            if(!empty($FormVars['p_npass'])) {
                                if(!empty($FormVars['p_npass_wh'])) {
                                    if(strtolower($FormVars['p_npass']) == strtolower($FormVars['p_npass_wh'])) {
                                        $sql = 'UPDATE game_user SET pass="'.md5($FormVars['p_npass']).'" WHERE id="'.$_SESSION['userid'].'"';
                                        if(@mysql_query($sql)) {
                                            $ERROR['power'] = true; $tmp_nr = "06";
                                        } else { $ERROR['power'] = true; $tmp_nr = "05"; }
                                    } else { $ERROR['power'] = true; $tmp_nr = "04"; }
                                } else { $ERROR['power'] = true; $tmp_nr = "03"; }
                            } else { $ERROR['power'] = true; $tmp_nr = "02"; }
                        } else { $ERROR['power'] = true; $tmp_nr = "01"; }
                        $vars['error'] = array( '{ERROR_MESSAGE}' => '{USERTOOLS_ACCOUNT_PWCHANGE_ERROR_' . $tmp_nr . '}');
                    }
                    // Template laden
                    $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'usertools_account_pwchange', EXT_TEMPS );
                    break;

                default:
                    $sql = 'SELECT * FROM game_user WHERE id="'.$_SESSION['userid'].'"';
                    $result = @mysql_query($sql);
                    $data = @mysql_fetch_array($result);
                    $sql2 = 'SELECT tag FROM game_club WHERE id="'.$data['club_id'].'"';
                    $result2 = @mysql_query($sql2);
                    $anzahl = @mysql_num_rows($result2);
                    $tmp_clubtag = '{USERTOOLS_ACCOUNT_NO_CLUB}';
                    if(!empty($anzahl)) { $data2 = @mysql_fetch_array($result2); $tmp_clubtag = $data2['tag']; }
                    $tmp_myskills = '';
                    $tmp_garagen = @mysql_num_rows(@mysql_query('SELECT * FROM game_garage WHERE user_id="' . $_SESSION['userid'] . '"'));
                    $sql = 'SELECT * FROM game_userskills WHERE user_id="' . $_SESSION['userid'] . '"';
                    $result = @mysql_query($sql);
                    $anzahl = @mysql_num_rows($result);
                    if(!empty($anzahl)) { while($tmpd = @mysql_fetch_array($result)) { $tmp_myskills .= '<tr><td width="50%" align="right">' . $SKILLNAMES[$tmpd['skl_id']] . ':</td><td width="50%">&nbsp;<b>' . $tmpd['skl_level'] . '</b></td></tr>'; } } else { $tmp_myskills .= '<tr><td width="100%" colspan="2">&nbsp;</td></tr>'; }
                    if(empty($data['last_login'])) { $tmp_last_login = '-'; } else { $tmp_last_login = date('d.m.Y - H:i', $data['last_login']); }
                    $tmp_vars   =   array(  '{VALUE_NICKNAME}'              => $data['nick'],
                                            '{VALUE_EMAIL}'                 => $data['email'],
                                            '{VALUE_LAST_LOGIN}'            => $tmp_last_login,
                                            '{VALUE_AVATAR}'                => '<table border="1" cellpadding="0" cellspacing="0" width="90" height="90"><tr><td width="100%" align="center" valign="middle">{USERTOOLS_ACCOUNT_NO_AVATAR}</td></tr></table>',
                                            '{VALUE_MONEY}'                 => number_format($data['money'],2,",",".") . $DEFAULTS['game']['waehrung'],
                                            '{VALUE_GARAGEN}'               => $tmp_garagen,
                                            '{VALUE_STYLE}'                 => $data['style'],
                                            '{VALUE_ANSEHEN}'               => $data['ansehen'],
                                            '{VALUE_RUF}'                   => $data['ruf'],
                                            '{VALUE_SIEGE}'                 => $data['wins'],
                                            '{VALUE_CLUB}'                  => $tmp_clubtag,
                                            '{VALUE_INTELLIGENZ}'           => $data['intelligenz'],
                                            '{VALUE_GESCHICKLICHKEIT}'      => $data['geschick'],
                                            '{VALUE_MYSKILLS}'              => $tmp_myskills,
                                            '{VALUE_WERBELINK}'             => SERVER .'?adid=' . $_SESSION['userid']                                           );
                    // Prüfen ob ein Avatar vom Benutzer hochgeladen wurde.
                    $tmp_file1 = DIR_AVATARS . $_SESSION['userid'] . EXT_AVAIMG1;
                    $tmp_file2 = DIR_AVATARS . $_SESSION['userid'] . EXT_AVAIMG2;
                    if(@file_exists($tmp_file1) || @file_exists($tmp_file2)) { if(@file_exists($tmp_file1)) { $tmp_file = $tmp_file1; } else { $tmp_file = $tmp_file2; } $data = getimagesize($tmp_file); $tmp_vars = array_merge( $tmp_vars, array('{VALUE_AVATAR}' => '<img src="'.$tmp_file.'" '.$data['3'].'>')); }

                    // Template laden
                    $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'usertools_account', EXT_TEMPS );
                    break;
            }
            // Platzhalter füllen
            $vars['content']        =   array( '{CONTENT}' => $tmp_section_content );
            $vars['content']        =   array_merge( $vars['content'], $tmp_vars, $LANG['game']['usertools']);
            break;

        case 'buddys':
            $tmp_ergebnis = array();
            $tmp_vars = array();
            switch($FormVars['g']) {
                case 'ibuddy':
                    $buddys = array();
                    $ibuddy = 0;
                    // Benutzer finden, die den Eingeloggten Benutzer als Buddy markiert haben, und anzeigen
                    $sql = 'SELECT * FROM game_buddys WHERE user_id!="' . $_SESSION['userid'] . '"';
                    $result = @mysql_query($sql);
                    $anzahl = @mysql_num_rows($result);
                    if(!empty($anzahl)) {
                        while($data = @mysql_fetch_array($result)) {
                            $tmp = explode(';', $data['buddys']);
                            for($x=0;$x!=count($tmp);$x++) { if($tmp[$x] == $_SESSION['userid']) { $buddys[] = $data['user_id']; $ibuddy++;} }
                        }
                    }
                    sort($buddys);
                    $tmp_vars = array( '{USERTOOLS_BUDDY_IBUDDY_COUNTER}' => $ibuddy );
                    $tmp_ergebnis = '';
                    if(!empty($anzahl)) {
                        for($x=0,$z=1;$x!=count($buddys);$x++,$z++) {
                            $data = @mysql_fetch_array(@mysql_query('SELECT id, nick FROM game_user WHERE id="' . $buddys[$x] . '" LIMIT 1'));
                            $tmp_ergebnis .= '<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr>
                                                <td width="20%" align="right" valign="top">'.$z.'.</td>
                                                <td width="40%" align="left" valign="top">&nbsp;'.$data['nick'].'</td>
                                                <td width="40%" align="left" valign="top"><a href="index.php?c=nachrichten&d=write&uid='.$data['id'].'">[Nachricht schreiben]</a></td>
                                              </tr></table>';
                        }
                    } else { $tmp_ergebnis .= '{USERTOOLS_BUDDY_IBUDDY_NO_USERS}'; }
                    // Template laden
                    $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'usertools_buddys_ibuddy', EXT_TEMPS );
                    // Platzhalter füllen
                    $vars['content']        =   array( '{CONTENT}' => $tmp_section_content, '{BUDDYS_TABLE}' => $tmp_ergebnis);
                    break;

                case 'add':
                    // Quick-Add umschreiben und verarbeiten
                    if(!empty($FormVars['nick'])) { $FormVars['check'] = 1; $FormVars['p_nick'] = $FormVars['nick']; }
                    // Gegebene Benutzer-ID prüfen und hinzufügen
                    if(!empty($FormVars['check'])) {
                        if(!empty($FormVars['p_nick'])) {
                            if(strtolower($FormVars['p_nick']) != strtolower($_SESSION['nickname'])) {
                                $sql = 'SELECT * FROM game_user';
                                $result = @mysql_query($sql);
                                $anzahl = @mysql_num_rows($result); $z = 1;
                                $found = FALSE;
                                for($x=0;$x!=$anzahl;$x++, $z++) {
                                    if($z > $anzahl) { $found = false; break(1); }
                                    @mysql_data_seek($result, $x);
                                    $data = @mysql_fetch_array($result);
                                    if(strtolower($data['nick']) == strtolower($FormVars['p_nick'])) {
                                        $found = true;
                                        $buddyid = $data['id'];
                                        break(1);
                                    }
                                }
                                if($found) {
                                    $tmp_rslt = @mysql_query('SELECT * FROM game_buddys WHERE user_id="'.$_SESSION['userid'].'"');
                                    $anzahl = @mysql_num_rows($tmp_rslt);
                                    $schon_da = FALSE; $buddys_pack = '';
                                    if(!empty($anzahl)) {
                                        $data = @mysql_fetch_array($tmp_rslt);
                                        $tmp = explode(';', $data['buddys']);
                                        $buddys_pack = $data['buddys'];
                                        $all_buddys = count($tmp);
                                        for($x=0;$x!=count($tmp);$x++) { if($tmp[$x] == $buddyid) { $schon_da = TRUE; } }
                                    } else { $all_buddys = 0; }
                                    if($all_buddys < $DEFAULTS['game']['start_buddys']) {
                                        if(!$schon_da) {
                                            if(!empty($all_buddys)) { $buddys_pack .= ';'; }
                                            $buddys_pack .= $buddyid;
                                            if(!empty($all_buddys)) {
                                                $sql = 'UPDATE game_buddys SET buddys="' . $buddys_pack . '" WHERE user_id="' . $_SESSION['userid'] . '"';
                                            } else {
                                                $sql = 'INSERT INTO game_buddys VALUES("", "' . $_SESSION['userid'] . '", "' . $buddys_pack . '", "'.time().'")';
                                            }
                                            if(@mysql_query($sql)) {
                                                $ERROR['power'] = true; $tmp_nr = "07";
                                            } else { $ERROR['power'] = true; $tmp_nr = "06"; }
                                        } else { $ERROR['power'] = true; $tmp_nr = "05"; }
                                    } else { $ERROR['power'] = true; $tmp_nr = "04"; }
                                } else { $ERROR['power'] = true; $tmp_nr = "03"; }
                            } else { $ERROR['power'] = true; $tmp_nr = "02"; }
                        } else { $ERROR['power'] = true; $tmp_nr = "01"; }
                        $vars['error'] = array( '{ERROR_MESSAGE}' => '{USERTOOLS_BUDDYS_ADD_DELETE_ERROR_' . $tmp_nr . '}');
                    }
                    // Template laden
                    $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'usertools_buddys_add', EXT_TEMPS );
                    break;

                case 'delete':
                    // Mitgegebene ID prüfen und Buddy löschen
                    if(!empty($FormVars['id'])) {
                        if($FormVars['id'] != 'all') {
                            $sql = 'SELECT * FROM game_buddys WHERE user_id="'.$_SESSION['userid'].'"';
                            $result = @mysql_query($sql);
                            $anzahl = @mysql_num_rows($result);
                            if(!empty($anzahl)) {
                                $data = @mysql_fetch_array($result);
                                $tmp = explode(';', $data['buddys']);
                                $buddy_pack = ''; $new_buddys = array();
                                for($x=0;$x!=count($tmp);$x++) { if($tmp[$x] != $FormVars['id']) { $new_buddys[] = $tmp[$x]; } }
                                for($x=0;$x!=count($new_buddys);$x++) { if(!empty($x)) { $buddy_pack .= ';'; } $buddy_pack .= $new_buddys[$x]; }
                                if(!empty($buddy_pack)) {
                                    $sql = 'UPDATE game_buddys SET buddys="' . $buddy_pack . '" WHERE user_id="' . $_SESSION['userid'] . '"';
                                } else {
                                    $sql = 'DELETE FROM game_buddys WHERE user_id="' . $_SESSION['userid'] . '"';
                                }
                                if(@mysql_query($sql)) {
                                    $ERROR['power'] = true; $tmp_nr = "06";
                                } else { $ERROR['power'] = true; $tmp_nr = "05"; }
                            } else { $ERROR['power'] = true; $tmp_nr = "03"; }
                        } else { $sql = 'DELETE FROM game_buddys WHERE user_id="'.$_SESSION['userid'].'"'; if(@mysql_query($sql)) { $ERROR['power'] = true; $tmp_nr = "01"; } else { $ERROR['power'] = true; $tmp_nr = "02"; } }
                        $vars['error'] = array( '{ERROR_MESSAGE}' => '{USERTOOLS_BUDDYS_DELETE_ERROR_' . $tmp_nr . '}');
                    }
                    break;

                default:
                    // Buddys ermitteln
                    $sql = 'SELECT * FROM game_buddys WHERE user_id="'.$_SESSION['userid'].'"';
                    $result = @mysql_query($sql);
                    $anzahl = @mysql_num_rows($result);
                    if(!empty($anzahl)) {
                        $tmp_ergebnis = '';
                        $data = @mysql_fetch_array($result);
                        $tmp = explode(';', $data['buddys']);
                        $anzahl = count($tmp);
                        for($x=0,$z=1;$x!=count($tmp);$x++,$z++) {
                            $buddy = @mysql_fetch_array(@mysql_query('SELECT id, nick FROM game_user WHERE id="' . $tmp[$x] . '" LIMIT 1'));
                            $tmp_ergebnis .= '<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr>
                                                <td width="15%" align="right" valign="top">'.$z.'.</td>
                                                <td width="35%" align="left" valign="top">&nbsp;<a href="index.php?c=profil&id=' . $buddy['id'] . '">'.$buddy['nick'].'</a></td>
                                                <td width="30%" align="left" valign="top"><a href="index.php?c=nachrichten&d=write&uid=' . $buddy['id'] . '">[Nachricht schreiben]</a></td>
                                                <td width="20%" align="left" valign="top"><a href="index.php?c=usertools&d=buddys&g=delete&id=' . $buddy['id'] . '" onClick="return confirm(\'Buddy wirklich l&ouml;schen?\'); submit();">{USERTOOLS_BUDDYS_DELETE}</a></td>
                                              </tr></table>';
                        }
                    } else { $tmp_ergebnis = '{USERTOOLS_BUDDYS_NO_BUDDYS}'; }
                    $tmp_vars = array(      '{BUDDYS_GOT}'      => $anzahl,
                                            '{BUDDYS_MAX}'      => $DEFAULTS['game']['start_buddys']    );
                    // Template laden
                    $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'usertools_buddys', EXT_TEMPS );
                    break;
            }
            // Platzhalter füllen
            $vars['content']        =   array( '{CONTENT}' => $tmp_section_content, '{BUDDYS_TABLE}' => $tmp_ergebnis);
            $vars['content']        =   array_merge( $vars['content'], $LANG['game']['usertools'], $tmp_vars);
            break;

        default:
            // Template laden
            $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'usertools', EXT_TEMPS );
            // Platzhalter füllen
            $vars['content']        =   array( '{CONTENT}' => $tmp_section_content);
            $vars['content']        =   array_merge( $vars['content'], $LANG['game']['usertools']);
            break;
    }
} else {$vars['content']        =   array( '{CONTENT}' => $LANG['root']['verweigert']);}

?>

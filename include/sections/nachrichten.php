<?php

// Nur Benutzer dürfen hier was machen
if($_SESSION['logged']) {
    $tmp_vars = array();
    switch($FormVars['d']) {
        case 'read':
            $tmp_vars = array();
            // Mitgegebene ID prüfen und Nachricht laden
            if(!empty($FormVars['id'])) {
                $sql = 'SELECT * FROM game_nachrichten WHERE id="'.$FormVars['id'].'"';
                $result = @mysql_query($sql);
                $anzahl = @mysql_num_rows($result);
                if(!empty($anzahl)) {
                    $data = @mysql_fetch_array($result);
                    if(strtolower($data['empfaenger_id']) == strtolower($_SESSION['userid'])) {
                        $sql = 'SELECT * FROM game_user WHERE id="'.$data['absender_id'].'"';
                        $tmp_result = @mysql_query($sql);
                        $data_as = @mysql_fetch_array($tmp_result);
                        $absender = '{NACHRICHTEN_USER_DELETED}';
                        if(!empty($data_as['nick'])) { $absender = $data_as['nick']; } else { if(empty($data['absender_id'])) { $absender = $DEFAULTS['game']['systemname']; } }
                        $tmp_vars = array(      '{MESSAGE_FROM}'        => $absender,
                                                '{MESSAGE_ZEITPUNKT}'   => date("d.m.Y - H:i:s", $data['time']),
                                                '{MESSAGE_BETREFF}'     => $data['betreff'],
                                                '{MESSAGE_ID}'          => $data['id'],
                                                '{MESSAGE_NACHRICHT}'   => $data['nachricht']       );
                        @mysql_query('UPDATE game_nachrichten SET neu="0" WHERE id="'.$FormVars['id'].'"');
                    } else { $ERROR['power'] = true; $tmp_nr = "03"; }
                } else { $ERROR['power'] = true; $tmp_nr = "02"; }
            } else { $ERROR['power'] = true; $tmp_nr = "01"; }
            $vars['error'] = array_merge( $LANG['game']['nachrichten'], $tmp_vars);
            $vars['error'] = array( '{ERROR_MESSAGE}' => '{NACHRICHTEN_READ_ERROR_' . $tmp_nr . '}');
            if($tmp_nr != 7) {
                // Template laden
                $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'nachrichten_read', EXT_TEMPS );
            }
            break;

        case 'melden':
            // Die ID der Nachricht prüfen und als gemeldet marieren..
            if(!empty($FormVars['id'])) {
                $sql = 'SELECT id, empfaenger_id, melden FROM game_nachrichten WHERE id="'.$FormVars['id'].'"';
                $result = @mysql_query($sql);
                $anzahl = @mysql_num_rows($result);
                if(!empty($anzahl)) {
                    $data = @mysql_fetch_array($result);
                    if(!empty($data['absender_id'])) {
                        if($data['empfaenger_id'] == $_SESSION['userid']) {
                            if(empty($data['melden'])) {
                                $sql = 'UPDATE game_nachrichten SET melden="1" WHERE id="'.$FormVars['id'].'"';
                                if(@mysql_query($sql)) {
                                    $ERROR['power'] = true; $tmp_nr = "05";
                                } else { $ERROR['power'] = true; $tmp_nr = "04"; }
                            } else { $ERROR['power'] = true; $tmp_nr = "03"; }
                        } else { $ERROR['power'] = true; $tmp_nr = "02"; }
                    } else { $ERROR['power'] = true; $tmp_nr = "06"; }
                } else { $ERROR['power'] = true; $tmp_nr = "01"; }
                $vars['error'] = array( '{ERROR_MESSAGE}' => '{NACHRICHTEN_MELDEN_ERROR_' . $tmp_nr . '}');
            }
            break;

        case 'delete':
            // Mitgegebene ID prüfen und Nachricht löschen
            if(!empty($FormVars['id'])) {
                if($FormVars['id'] != 'all') {
                    $sql = 'SELECT * FROM game_nachrichten WHERE id="'.$FormVars['id'].'"';
                    $result = @mysql_query($sql);
                    $anzahl = @mysql_num_rows($result);
                    if(!empty($anzahl)) {
                        $data = @mysql_fetch_array($result);
                        if($data['empfaenger_id'] == $_SESSION['userid']) {
                            if(empty($data['melden'])) {
                                $sql = 'DELETE FROM game_nachrichten WHERE id="'.$FormVars['id'].'"';
                                if(@mysql_query($sql)) {
                                    $ERROR['power'] = true; $tmp_nr = "06";
                                } else { $ERROR['power'] = true; $tmp_nr = "05"; }
                            } else { $ERROR['power'] = true; $tmp_nr = "07"; }
                        } else { $ERROR['power'] = true; $tmp_nr = "04"; }
                    } else { $ERROR['power'] = true; $tmp_nr = "03"; }
                } else { $sql = 'DELETE FROM game_nachrichten WHERE empfaenger_id="'.$_SESSION['userid'].'"'; if(@mysql_query($sql)) { $ERROR['power'] = true; $tmp_nr = "02"; } else { $ERROR['power'] = true; $tmp_nr = "01"; } }
                $vars['error'] = array( '{ERROR_MESSAGE}' => '{NACHRICHTEN_DELETE_ERROR_' . $tmp_nr . '}');
            }
            break;

        case 'write':
            // Array mit temporären Inhalten erstellen
            $tmp_vars = array(  '{VALUE_EMPFAENGER}'    => '',
                                '{VALUE_BETREFF}'       => ''         );
            // Verarbeitung der Nachricht, bei erfolg wird diese in die Datenbank geschrieben
            if($FormVars['check']) {
                if(!empty($FormVars['p_empfaenger']) && strtolower($FormVars['p_empfaenger']) != strtolower($DEFAULTS['game']['systemname'])) {
                    if(!empty($FormVars['p_betreff'])) {
                        if(!empty($FormVars['p_message'])) {
                            $sql = 'SELECT * FROM game_user';
                            $result = @mysql_query($sql);
                            $anzahl = @mysql_num_rows($result);
                            if(!empty($anzahl)) {
                                for($x=0;$x!=$anzahl;$x++) {
                                    @mysql_data_seek($result, $x);
                                    $data = @mysql_fetch_array($result);
                                    if(strtolower($FormVars['p_empfaenger']) != strtolower($_SESSION['nickname'])) {
                                        if(strtolower($FormVars['p_empfaenger']) == strtolower($data['nick'])) {
                                            $tmp_sql = 'SELECT * FROM game_nachrichten WHERE empfaenger_id="'.$data['id'].'" ORDER BY time DESC';
                                            $tmp_result = @mysql_query($tmp_sql);
                                            $tmp_anzahl = @mysql_num_rows($tmp_result);
                                            $tmp_max = $DEFAULTS['game']['start_nachrichten'];
                                            if($tmp_anzahl >= $tmp_max) {
                                                for($x=($tmp_max-1);$x!=$tmp_anzahl;$x++) {
                                                    @mysql_data_seek($tmp_result, $x);
                                                    $tmp_data = @mysql_fetch_array($tmp_result);
                                                    $tmp_sql = 'DELETE FROM game_nachrichten WHERE id="'.$tmp_data['id'].'"';
                                                    @mysql_query($tmp_sql);
                                                }
                                            }
                                            $sql = 'INSERT INTO game_nachrichten VALUES("", "'.$_SESSION['userid'].'", "'.$data['id'].'", "'.$FormVars['p_betreff'].'", "'.$FormVars['p_message'].'", "'.time().'", "1", "0")';
                                            if(@mysql_query($sql)) {
                                                $ERROR['power'] = true; $tmp_nr = "07";
                                            } else { $ERROR['power'] = true; $tmp_nr = "06"; }
                                            break(1);
                                        } else { $ERROR['power'] = true; $tmp_nr = "05"; }
                                    } else { $ERROR['power'] = true; $tmp_nr = "10"; }
                                }
                            } else { $ERROR['power'] = true; $tmp_nr = "04"; }
                        } else { $ERROR['power'] = true; $tmp_nr = "03"; }
                    } else { $ERROR['power'] = true; $tmp_nr = "02"; }
                } else { $ERROR['power'] = true; $tmp_nr = "01"; }
                $vars['error'] = array( '{ERROR_MESSAGE}' => '{NACHRICHTEN_WRITE_ERROR_' . $tmp_nr . '}');
            }

            // Wenn die Funktion Antworten benutzt wird, Empfängerinformationen auslesen
            if(isset($FormVars['id']) && !isset($FormVars['uid'])) { $tmp_action = 'msg'; }
            if(!isset($FormVars['id']) && isset($FormVars['uid'])) { $tmp_action = 'user'; }
            if(!empty($tmp_action) && !isset($FormVars['check'])) {
                if($tmp_action == 'msg') {
                    $sql1 = 'SELECT absender_id, betreff FROM game_nachrichten WHERE id="'.$FormVars['id'].'"';
                    $result = @mysql_query($sql1);
                    $anzahl = @mysql_num_rows($result);
                    if(!empty($anzahl)) {
                        $data = @mysql_fetch_array($result);
                        $sql2 = 'SELECT nick FROM game_user WHERE id="'.$data['absender_id'].'"';
                        $result = @mysql_query($sql2);
                        $anzahl = @mysql_num_rows($result);
                        if(!empty($anzahl)) {
                            $data2 = @mysql_fetch_array($result);
                            $tmp_vars = array(  '{VALUE_EMPFAENGER}'    => $data2['nick'],
                                                '{VALUE_BETREFF}'       => 'Re:' . $data['betreff'],      );
                            $data2 = @mysql_fetch_array($result);
                        } else { $ERROR['power'] = true; $tmp_nr = "09"; }
                    } else { $ERROR['power'] = true; $tmp_nr = "08"; }
                    $vars['error'] = array( '{ERROR_MESSAGE}' => '{NACHRICHTEN_WRITE_ERROR_' . $tmp_nr . '}');
                }
                if($tmp_action == 'user') {
                    $data = @mysql_fetch_array($result);
                    $sql = 'SELECT nick FROM game_user WHERE id="'.$FormVars['uid'].'"';
                    $result = @mysql_query($sql);
                    $anzahl = @mysql_num_rows($result);
                    if(!empty($anzahl)) {
                        $data = @mysql_fetch_array($result);
                        $tmp_vars = array(  '{VALUE_EMPFAENGER}'    => $data['nick'],
                                            '{VALUE_BETREFF}'       => '',      );
                        $data = @mysql_fetch_array($result);
                    } else { $ERROR['power'] = true; $tmp_nr = "09"; }
                    $vars['error'] = array( '{ERROR_MESSAGE}' => '{NACHRICHTEN_WRITE_ERROR_' . $tmp_nr . '}');
                }
            }
            if($tmp_nr != 7) { $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'nachrichten_write', EXT_TEMPS ); }
            break;

        default:
            // Nachrichten auslesen
            $tmp_sql = 'SELECT id, betreff, time, absender_id, empfaenger_id FROM game_nachrichten WHERE empfaenger_id="' . $_SESSION['userid'] . '" ORDER BY time DESC';
            $tmp_result = @mysql_query($tmp_sql);
            $tmp_anzahl = @mysql_num_rows($tmp_result);
            if(!empty($tmp_anzahl)) {
                $tmp_ergebnis = ''; $z = 1;
                for($x=0;$x!=$tmp_anzahl;$x++,$z++) {
                    @mysql_data_seek($tmp_result, $x);
                    $data = @mysql_fetch_array($tmp_result);
                    $sql = 'SELECT game_user.nick AS nick FROM game_user WHERE id="'.$data['absender_id'].'"';
                    $result = @mysql_query($sql);
                    $data_as = @mysql_fetch_array($result);
                    $absender = '{NACHRICHTEN_USER_DELETED}';
                    if(!empty($data_as['nick'])) { $absender = $data_as['nick']; }
                    if(empty($data['absender_id'])) { $absender = $DEFAULTS['game']['systemname']; } 
                    $tmp_ergebnis .= '<tr>
                                      <td width="5%" align="center" height="25">' . $z . '.</td>
                                      <td width="25%" align="center" height="25">' . $absender . '</td>
                                      <td width="25%" align="center" height="25">' . date('d.m.Y - H:i', $data['time']) . ' Uhr</td>
                                      <td width="30%" align="center" height="25"><a href="index.php?c=nachrichten&d=read&id='.$data['id'].'" title="{NACHRICHTEN_READ}">' . $data['betreff'] . '</a></td>
                                      <td width="15%" align="center" height="25"><a href="index.php?c=nachrichten&d=read&id='.$data['id'].'" title="{NACHRICHTEN_READ}">[L]</a><a href="index.php?c=nachrichten&d=write&id='.$data['id'].'" title="{NACHRICHTEN_ANSWER}">[A]</a><a href="index.php?c=nachrichten&d=delete&id='.$data['id'].'" title="{NACHRICHTEN_DELETE}">[X]</a></td>
                                    </tr>';
                }
            } else { $tmp_ergebnis = '{NACHRICHTEN_NO_MESSAGES}'; }
            // Template laden
            $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'nachrichten', EXT_TEMPS );
            break;
    }

    // Platzhalter füllen
    $vars['content']        =   array( '{CONTENT}' => $tmp_section_content, '{NACHRICHTEN_ERGEBNIS}' => $tmp_ergebnis );
    $vars['content']        =   array_merge($vars['content'], $LANG['game']['nachrichten'], $tmp_vars);
} else {$vars['content']        =   array( '{CONTENT}' => $LANG['root']['verweigert']);}

?>

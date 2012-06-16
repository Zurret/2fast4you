<?php

if($_SESSION['logged']) {
    // Sonsoren die älter sind als 1 Woche, entfernen und neue verteilen!
    $result = @mysql_query('SELECT id FROM game_sponsoren WHERE user_id="0" && sprs_time<="' . time() . '"');
    $anzahl = @mysql_num_rows($result);
    if(!empty($anzahl)) { while($data = mysql_fetch_array($result)) { @mysql_query('DELETE FROM game_sponsoren WHERE id="' . $data['id'] . '"'); } }
    // Dafür Sorgen das genügend Sponsoren vorhanden sind!
    $sql = 'SELECT * FROM game_sponsoren WHERE user_id="0"';
    $result = @mysql_query($sql);
    $anzahl = @mysql_num_rows($result);
    if($anzahl < $DEFAULTS['game']['free_sponsors']) {
        for($x=$anzahl;$x!=$DEFAULTS['game']['free_sponsors'];$x++) {
            $tmp_sponsor    = rand( 0, (count($SPONSOR) - 1));
            $tmp_bonus      = rand( $SPONSOR[$tmp_sponsor]['bonus_min'],    $SPONSOR[$tmp_sponsor]['bonus_max']);
            $tmp_dauer      = rand( $SPONSOR[$tmp_sponsor]['dauer_min'],    $SPONSOR[$tmp_sponsor]['dauer_max']);
            $tmp_wins       = rand( $SPONSOR[$tmp_sponsor]['wins_min'],     $SPONSOR[$tmp_sponsor]['wins_max']);
            @mysql_query('INSERT INTO game_sponsoren VALUES("", "0", "' . (time() + (3600 * 24 * 7)) . '", "' . $tmp_sponsor . '", "' . $SPONSOR[$tmp_sponsor]['name'] . '", "' . $SPONSOR[$tmp_sponsor]['basis'] . '", "' . $tmp_bonus . '", "' . $tmp_dauer . '", "' . $tmp_wins . '", "0", "0")');
        }
    }
    $tmp_vars = array();
    switch($FormVars['d']) {
        case 'details':
            if(!empty($FormVars['sid'])) {
                $sql = 'SELECT * FROM game_sponsoren WHERE id="' . $FormVars['sid'] . '" && user_id="' . $_SESSION['userid'] . '" LIMIT 1';
                $result = @mysql_query($sql);
                $anzahl = @mysql_num_rows($result);
                if(!empty($anzahl)) {
                    $sdata = @mysql_fetch_array($result);
                    $tmp_loaded = loadTemplate( DIR_T_H_GAME, 'sponsoren_details', EXT_TEMPS );
                    $tmp_file = DIR_T_I_SIGNS . 'sponsor_' . $sdata['sprs_id'] . EXT_AVAIMG1 ;
                    if(file_exists($tmp_file)) { $tmp_bild = '<img src="' . $tmp_file . '" border="0">'; } else { $tmp_bild = '{SPONSOR_NO_BILD}'; }
                    $tmp_info = array(          '{SPONSOR_VLU_NAME}'    => $sdata['sprs_name'],
                                                '{SPONSOR_VLU_BILD}'    => $tmp_bild,
                                                '{SPONSOR_VLU_SID}'     => $sdata['id'],
                                                '{SPONSOR_VLU_ENDE}'    => date("d.m.Y", ($sdata['sprs_get'] + ($sdata['sprs_dauer'] * (24 * 3600 * 7)))),
                                                '{SPONSOR_VLU_BASIS}'   => number_format($sdata['sprs_basis'],2,",",".") . $DEFAULTS['game']['waehrung'],
                                                '{SPONSOR_VLU_BONUS}'   => number_format($sdata['sprs_bonus'],2,",",".") . $DEFAULTS['game']['waehrung'],
                                                '{SPONSOR_VLU_WINS}'    => $sdata['sprs_now_wins'],
                                                '{SPONSOR_VLU_DAUER}'   => $sdata['sprs_dauer']
                                         );
                    $tmp_vars = array( '{SPONSOR_VLU_BUTTON}'  => $LANG['game']['sponsoren']['{SPONSOR_HINWEIS_FIRE}'] );
                    $tmp_sponsor_content .= array2text( $tmp_loaded, $tmp_info);
                } else { $ERROR['power'] = true; $tmp_nr = "10"; }
            }
            break;

        case 'fireit':
            $sql = 'SELECT * FROM game_sponsoren WHERE user_id="' . $_SESSION['userid'] . '" LIMIT 1';
            $result = @mysql_query($sql);
            $anzahl = @mysql_num_rows($result);
            if(!empty($anzahl)) {
                $data = @mysql_fetch_array($result);
                $strafe = round((($data['sprs_dauer'] * (24 * 7)) / 3600) * (($data['sprs_bonus'] + $data['sprs_basis']) / 1.2) * (($data['sprs_get'] + ($data['sprs_dauer'] * (3600 * 24 * 7))) / time()), 0);
                $tmp_vars = array(  '{SPONSOR_VLU_STRAFE}' => number_format($strafe,2,",",".") . $DEFAULTS['game']['waehrung'],
                                    '{SPONSOR_VLU_BUTTON}' => ''
                                 );
                $tmp_sponsor_content = loadTemplate( DIR_T_H_GAME, 'sponsoren_fire', EXT_TEMPS );
                if(!empty($FormVars['check'])) {
                    $uinfo = @mysql_fetch_array(@mysql_query('SELECT money FROM game_user WHERE id="' . $_SESSION['userid'] . '"'));
                    if($uinfo['money'] >= $strafe) {
                        $tmp_sql = array(); $tmp_sql_ok = 0;
                        $tmp_msg_kat = 3;
                        $tmp_msg_id = 2;
                        $tmp_msg_vars = array( '{STRAFE}' => number_format($strafe,2,",",".") . $DEFAULTS['game']['waehrung'], '{SPONSOR}' => $data['sprs_name'] );
                        $tmp_send_msg = array2text( loadTemplate( DIR_LANGUAGE . PAGE_LANGUAGE . '/system/', $MSG[$tmp_msg_kat][$tmp_msg_id], EXT_TEXT ), $tmp_msg_vars );
                        $tmp_sql[] = 'INSERT INTO game_nachrichten VALUES(NULL, "0", "' . $_SESSION['userid'] . '", "' . $BETREFF[$tmp_msg_kat][$tmp_msg_id] . '", "' . $tmp_send_msg . '", "' . time() . '", "1", "0")';
                        $tmp_sql[] = 'DELETE FROM game_sponsoren WHERE id="' . $data['id'] . '"';
                        $tmp_sql[] = 'UPDATE game_user SET money="' . ($uinfo['money'] - $strafe) . '" WHERE id="' . $_SESSION['userid'] . '"';
                        for($x=0;$x!=count($tmp_sql);$x++) { if(@mysql_query($tmp_sql[$x])) { $tmp_sql_ok++; } }
                        if(count($tmp_sql) == $tmp_sql_ok) {
                            $ERROR['power'] = true; $tmp_nr = "09";
                        } else { $ERROR['power'] = true; $tmp_nr = "05"; }
                    } else { $ERROR['power'] = true; $tmp_nr = "08"; }
                }
            } else { $ERROR['power'] = true; $tmp_nr = "07"; }
            break;

        case 'getsponsor':
            if(!empty($FormVars['sid'])) {
                $anzahl = @mysql_num_rows(@mysql_query('SELECT * FROM game_sponsoren WHERE user_id="' . $_SESSION['userid'] . '" LIMIT 1'));
                if(empty($anzahl)) {
                    $result = @mysql_query('SELECT * FROM game_sponsoren WHERE id="' . $FormVars['sid'] . '" LIMIT 1');
                    $anzahl = @mysql_num_rows($result);
                    if(!empty($anzahl)) {
                        $uinfo = @mysql_fetch_array(@mysql_query('SELECT * FROM game_user WHERE id="' . $_SESSION['userid'] . '" LIMIT 1'));
                        $data = @mysql_fetch_array($result);
                        if($uinfo['wins'] >= $data['sprs_min_wins']) {
                            $sql = 'UPDATE game_sponsoren SET user_id="' . $_SESSION['userid'] . '", sprs_get="' . time() . '" WHERE id="' . $FormVars['sid'] . '"';
                            $tmp_msg_kat = 3;
                            $tmp_msg_id = 0;
                            $tmp_msg_vars = array( '{BONUS}' => number_format($data['sprs_bonus'],2,",",".") . $DEFAULTS['game']['waehrung'], '{BASIS}' => number_format($data['sprs_basis'],2,",",".") . $DEFAULTS['game']['waehrung'], '{SPONSOR}' => $data['sprs_name'], '{DAUER}' => $data['sprs_dauer'] );
                            $tmp_send_msg = array2text( loadTemplate( DIR_LANGUAGE . PAGE_LANGUAGE . '/system/', $MSG[$tmp_msg_kat][$tmp_msg_id], EXT_TEXT ), $tmp_msg_vars );
                            $sql2 = 'INSERT INTO game_nachrichten VALUES(NULL, "0", "' . $_SESSION['userid'] . '", "' . $BETREFF[$tmp_msg_kat][$tmp_msg_id] . '", "' . $tmp_send_msg . '", "' . time() . '", "1", "0")';
                            if(@mysql_query($sql) && @mysql_query($sql2)) {
                                $ERROR['power'] = true; $tmp_nr = "06";
                            } else { $ERROR['power'] = true; $tmp_nr = "05"; }
                        } else { $ERROR['power'] = true; $tmp_nr = "04"; }
                    } else { $ERROR['power'] = true; $tmp_nr = "03"; }
                } else { $ERROR['power'] = true; $tmp_nr = "02"; }
            } else { $ERROR['power'] = true; $tmp_nr = "01"; }
            break;

        default:
            $tmp_sponsor_content = '';
            $uinfo = @mysql_fetch_array(@mysql_query('SELECT * FROM game_user WHERE id="' . $_SESSION['userid'] . '"'));
            $sql = 'SELECT * FROM game_sponsoren WHERE sprs_min_wins<="' . $uinfo['wins'] . '" && user_id="0" ORDER BY sprs_dauer DESC';
            $result = @mysql_query($sql);
            $anzahl = @mysql_num_rows($result);
            $tmp_sprs = array();
            $tmp_new = 0;
            $tmp_counter = 0;
            if(!empty($anzahl)) {
                while($sdata = @mysql_fetch_array($result)) {
                    if($tmp_sprs[$sdata['sprs_id']] == FALSE) {
                        if(empty($tmp_new)) { $tmp_sponsor_content .= '<tr>'; }
                        $tmp_sprs[$sdata['sprs_id']] = TRUE;
                        $tmp_new++;
                        $tmp_counter++;
                        $tmp_button = '';
                        $tmp_disabled = '';
                        $tmp_loaded = loadTemplate( DIR_T_H_GAME, 'sponsoren_table', EXT_TEMPS );
                        $tmp_file = DIR_T_I_SIGNS . 'sponsor_' . $sdata['sprs_id'] . EXT_AVAIMG1 ;
                        $us_az = @mysql_num_rows(@mysql_query('SELECT * FROM game_sponsoren WHERE user_id="' . $_SESSION['userid'] . '"'));
                        if(!empty($us_az)) { $tmp_disabled = 'disabled'; $tmp_button = '<input type="submit" class="txtfeld" value="' . $LANG['game']['sponsoren']['{SPONSOR_BTN_FIRE}'] . '">'; }
                        if(file_exists($tmp_file)) { $tmp_bild = '<img src="' . $tmp_file . '" border="0">'; } else { $tmp_bild = '{SPONSOR_NO_BILD}'; }
                        $tmp_info = array(      '{SPONSOR_VLU_NAME}'    => $sdata['sprs_name'],
                                                '{SPONSOR_VLU_BILD}'    => $tmp_bild,
                                                '{SPONSOR_VLU_SID}'     => $sdata['id'],
                                                '{SPONSOR_VLU_BASIS}'   => number_format($sdata['sprs_basis'],2,",",".") . $DEFAULTS['game']['waehrung'],
                                                '{SPONSOR_VLU_BONUS}'   => number_format($sdata['sprs_bonus'],2,",",".") . $DEFAULTS['game']['waehrung'],
                                                '{SPONSOR_VLU_DAUER}'   => $sdata['sprs_dauer'],
                                                '{SPONSOR_VLU_DISABLED}'=> $tmp_disabled,
                                         );
                        $tmp_vars = array( '{SPONSOR_VLU_BUTTON}'  => '' );
                        $tmp_sponsor_content .= array2text( $tmp_loaded, $tmp_info);
                        if($tmp_new == 2) { $tmp_new = 0; $tmp_sponsor_content .= '</tr>'; }
                    }
                }
            } else { $tmp_sponsor_content = '<td width="100%" align="center" height="25">{SPONSOR_NO_SPONSORS}</td> '; $tmp_vars = array( '{SPONSOR_VLU_BUTTON}'  => '' ); }
            break;
    }

    if($ERROR['power']) {
        // Fehlermeldung übergeben bei einem Fehler
        $vars['error'] = array( '{ERROR_MESSAGE}' => '{SPONSOR_ERROR_' . $tmp_nr . '}');
    } else {
        // Template laden
        $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'sponsoren', EXT_TEMPS );
    }

    // Platzhalter füllen
    $vars['content']        =   array( '{CONTENT}' => $tmp_section_content, '{SPONSOR_VLU_CONTENT}' => $tmp_sponsor_content );
    $vars['content']        =   array_merge($vars['content'], $LANG['game']['sponsoren'], $tmp_vars);
} else {$vars['content']        =   array( '{CONTENT}' => $LANG['root']['verweigert']);}

?>

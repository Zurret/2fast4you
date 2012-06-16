<?php

if($_SESSION['logged']) {

    // Bereich der Verbesserung setzen
    $tmp_bereiche = ''; $tmp_skillinfo = array();
    if(!isset($FormVars['p_bereich'])) { $tmp_bereiche .= '<option selected>' . $LANG['game']['schule']['{SCHULE_CHOOSE}'] . '</option>'; $tmp_hide_drdn = 'disabled'; } else { $tmp_hide_drdn = ''; $tmp_ok_b = TRUE; }
    for($x=0;$x!=count($SKILLNAMES);$x++) { if($FormVars['p_bereich'] == $x && isset($FormVars['p_bereich'])) { $tmp_st = 'selected'; } else { $tmp_st = ''; } $tmp_bereiche .= '<option value="' . $x . '" ' . $tmp_st . '>' . $SKILLNAMES[$x] . '</option>'; }
    if(isset($FormVars['p_bereich'])) {
        $sql = 'SELECT * FROM game_userskills WHERE user_id="' . $_SESSION['userid'] . '" LIMIT 1';
        $result = @mysql_query($sql);
        $anzahl = @mysql_num_rows($result);
        if(!empty($anzahl)) {
            $eintrag_est = TRUE;
            // Aufbau eines Skill-Packets   SKILLID:SKILLLEVEL:SKILLERFAHRUNG#SKILLID:SKILLLEVEL:SKILLERFAHRUNG
            $info = @mysql_fetch_array($result);
            $tmp_userskillid = $info['id'];
            $tmp = explode('#', $info['skl_werte']);
            for($x=0;$x!=count($tmp);$x++) {
                $ttmp = explode(':', $tmp[$x]);
                if($ttmp[0] == $FormVars['p_bereich']) {
                    $tmp_got = TRUE;
                    $now_info = array( $ttmp[0], $ttmp[1], $ttmp[2]);
                }
                $tmp_skillinfo[]   = array( $ttmp[0], $ttmp[1], $ttmp[2]);
            }
        }
    }

    // Typ der verbesserung setzen
    $tmp_typ = '';
    if(!isset($FormVars['p_typ'])) { $tmp_typ .= '<option selected>' . $LANG['game']['schule']['{SCHULE_CHOOSE}'] . '</option>'; } else { $tmp_ok_t = TRUE; }
    for($x=0;$x!=count($SCHULTYPE);$x++) { if($FormVars['p_typ'] == $x && isset($FormVars['p_typ'])) { $tmp_st = 'selected'; } else { $tmp_st = ''; } if(!$SCHULTYPE[$x][0] || $tmp_got) { $tmp_typ .= '<option value="' . $x . '" ' . $tmp_st . '>' . $SCHULTYPE[$x][1] . '</option>'; } }

    // 'Fähigkeiten verbessern'-Button nur anzeigen wenn beide Infos vorhanden sind
    if($tmp_ok_b == TRUE && $tmp_ok_t == TRUE) { $tmp_btn = '<input type="submit" value="' . $LANG['game']['schule']['{SCHULE_BTN_LEARN}'] . '" class="button" onClick="return confirm(\'Lehrgang wirklich besuchen?\'); submit();">'; } else { $tmp_btn = '&nbsp;'; }

    // Dauer/Gebühr des Schulungsbereiches und des Schulungstyps ermitteln
    if($tmp_ok_b == TRUE && $tmp_ok_t == TRUE) {
        if($FormVars['p_typ'] == 2) {
            $tmp_wt = $WORKTIME[8];
            $tmp_txtout = 7;
            $tmp_minmax = array(1000, 2000);
        } elseif ( $FormVars['p_typ'] == 1 ) {
            $tmp_wt = $WORKTIME[7];
            $tmp_txtout = 6;
            $tmp_minmax = array(800, 1200);
        } else {
            $tmp_wt = $WORKTIME[6];
            $tmp_txtout = 5;
            $tmp_minmax = array(400, 975);
        }

        // Dauer des Kurses berechnen
        $tmp_dauer = round($tmp_wt + (($now_info[1] * 0.3) + (($now_info[2] * 0.3) * ($tmp_wt * 0.005))), 0);
        if($tmp_dauer <= 120) { $tmp_dauer = 120; } if($tmp_dauer >= 9000) { $tmp_dauer = 9000; }

        // Gebühr des Kurses berechnen
        $tmp_gebuehr = round(1.27 * (($now_info[2] / 50) * (($now_info[1] * 2) * ($tmp_wt / 375)) + $tmp_wt));
        if($tmp_gebuehr <= 15) { $tmp_gebuehr = 15; } if($tmp_gebuehr >= 15000) { $tmp_gebuehr = 15000; }



    } else { $tmp_dauer = '0'; $tmp_gebuehr = '0'; }
    $tmp_vars = array(      '{SCHULE_VLU_BEREICHE}'     => $tmp_bereiche,
                            '{SCHULE_VLU_TYP}'          => $tmp_typ,
                            '{SCHULE_VLU_DAUER}'        => round($tmp_dauer / 60, 0),
                            '{SCHULE_VLU_GEBUEHR}'      => number_format($tmp_gebuehr,2,",",".") . $DEFAULTS['game']['waehrung'],
                            '{SCHULE_VLU_HBEREICH}'     => $FormVars['p_bereich'],
                            '{SCHULE_VLU_HTYP}'         => $FormVars['p_typ'],
                            '{SCHULE_VLU_HDROPDOWN}'    => $tmp_hide_drdn,
                            '{SCHULE_VLU_BUTTON}'       => $tmp_btn
                         );

    // Einstellungen überprüfen und Benutzer zum Kurs schicken ..
    if(!empty($FormVars['check'])) {
        $tmp_sql = array();
        $sql = 'SELECT * FROM game_busy WHERE user_id="' . $_SESSION['userid'] . '" LIMIT 1';
        $result = @mysql_query($sql);
        $anzahl = @mysql_num_rows($result);
        if(empty($anzahl)) {
            $uinfo = @mysql_fetch_array(@mysql_query('SELECT money FROM game_user WHERE id="' . $_SESSION['userid'] . '" LIMIT 1'));
            if($uinfo['money'] >= $tmp_gebuehr) {
                $tmp_own_skill = rand($tmp_minmax[0], $tmp_minmax[1]);
                $tmp_skillpack = '';
                if($tmp_got == FALSE) { $tmp_skillinfo[]    = array( $FormVars['p_bereich'], 0, $tmp_own_skill); }
                for($x=0;$x!=count($tmp_skillinfo);$x++){
                    if(!empty($x)) { $tmp_skillpack .= '#'; }
                    if($tmp_skillinfo[$x][0] == $FormVars['p_bereich']) { $tmp_skillinfo[$x][2] += $tmp_own_skill; }
                    $tmp_skillpack .= $tmp_skillinfo[$x][0] . ':' . $tmp_skillinfo[$x][1] . ':' . $tmp_skillinfo[$x][2];
                }
                $kosten = $tmp_gebuehr;
                if($eintrag_est == TRUE && $FormVars['p_typ'] <= 2) {
                    $tmp_do_after = 'UPDATE game_userskills SET skl_werte=\"' . $tmp_skillpack . '\" WHERE id=\"' . $tmp_userskillid . '\"';
                } else {
                    $tmp_do_after = 'INSERT INTO game_userskills VALUES(\"\", \"' . $_SESSION['userid'] . '\", \"' . time() . '\", \"' . $tmp_skillpack . '\")';
                }
                $tmp_sql[] = 'INSERT INTO game_busy VALUES("", "' . $_SESSION['userid'] . '", "' . (time() + ($tmp_dauer + 15)) . '", "' . $tmp_txtout . '", "' . $kosten . '", "0", "' . $tmp_do_after . '")';
                $tmp_sql_ok = 0;
                for($x=0;$x!=count($tmp_sql);$x++) { if(@mysql_query($tmp_sql[$x])) { $tmp_sql_ok++; } }
                if(count($tmp_sql) == $tmp_sql_ok) {
                    $ERROR['power'] = true; $tmp_nr = "03";
                } else { $ERROR['power'] = true; $tmp_nr = "02"; }
            } else { $ERROR['power'] = true; $tmp_nr = "04"; }
        } else { $ERROR['power'] = true; $tmp_nr = "01"; }
    }

    if($ERROR['power']) {
        // Fehlermeldung ausgeben
        $vars['error'] = array( '{ERROR_MESSAGE}' => '{SCHULE_ERROR_' . $tmp_nr . '}');
    } else {
        // Template laden
        $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'schule', EXT_TEMPS );
    }

    // Platzhalter füllen
    $vars['content']        =   array( '{CONTENT}' => $tmp_section_content );
    $vars['content']        =   array_merge($vars['content'], $LANG['game']['schule'], $tmp_vars);
} else {$vars['content']        =   array( '{CONTENT}' => $LANG['root']['verweigert']);}

?>

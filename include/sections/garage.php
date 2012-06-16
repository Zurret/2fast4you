<?php

// Nur eingeloggte Benutzer haben Zugriff auf diese Optionen
if($_SESSION['logged']) {

    // Fortfahren mit der eigentlichen Funktion ..
    $tmp_vars = array();

    // Schauen ob Benutzer eine Garage Besitzt ..
    $sql = 'SELECT * FROM game_garage WHERE user_id="' . $_SESSION['userid'] . '"';
    $result = @mysql_query($sql); $anzahl = @mysql_num_rows($result);
    if(empty($anzahl)) { @mysql_query('INSERT INTO game_garage VALUES("", "' . $_SESSION['userid'] . '", "0", "0", "0", "0")'); }

    // Aktuellen Stellplatz wählen
    if(!isset($FormVars['p_stellplatz'])) {
        $ecar = @mysql_fetch_array(@mysql_query('SELECT id FROM game_garage WHERE user_id="' . $_SESSION['userid'] . '" ORDER BY id ASC LIMIT 1'));
        $FormVars['p_stellplatz'] = $ecar['id'];
    }

    // Alle Stellplätze des Benutzers laden ..
    $sql = 'SELECT * FROM game_garage WHERE user_id="' . $_SESSION['userid'] . '"';
    $result = @mysql_query($sql);
    $anzahl = @mysql_num_rows($result);
    $tmp_options = '';
    if(!empty($anzahl)) {
        $i = 1;
        $user_info = @mysql_fetch_array(@mysql_query('SELECT * FROM game_user WHERE id="' . $_SESSION['userid'] . '" LIMIT 1'));
        for($x=0;$x!=$anzahl;$x++,$i++) {
            @mysql_data_seek($result, $x);
            $sp_info = @mysql_fetch_array($result);
            $car_info = @mysql_fetch_array(@mysql_query('SELECT * FROM game_cars WHERE id="' . $sp_info['car_id'] . '" ORDER BY id DESC LIMIT 1'));
            if(!empty($sp_info['car_id'])) { $tmp_name = $CARNAME[$car_info['name_id']]; } else { $tmp_name = '{GARAGE_NO_CAR}'; }
            if($sp_info['id'] == $FormVars['p_stellplatz']) { $now_sp_info = $sp_info; $now_car_info = $car_info; $tmp_slct = ' selected'; } else { $tmp_slct = ''; }
            $tmp_options .= '<option' . $tmp_slct . ' value="' . $sp_info['id'] . '">' . $i . ' - ' . $tmp_name . '</option>';
        }
        if(!empty($now_sp_info['car_id'])) {
            $result = @mysql_query('SELECT * FROM game_incars WHERE user_id="' . $_SESSION['userid'] . '" && garage_id="' . $sp_info['id'] . '" LIMIT 1');
            $tuning_anzahl = @mysql_num_rows($result);
            $tuning_info = @mysql_fetch_array($result);
            $tmp_tune_list = '<tr><td width="100%" align="center" colspan="3">&nbsp;</td></tr><tr><td width="33%" align="center"><i>{GARAGE_ZUSTAND}</i></td><td width="33%" align="center"><i>{GARAGE_KATEGORIE}</i></td><td width="34%" align="center"><i>{GARAGE_ARTIKEL}</i></td></tr>';
            if(!empty($tuning_anzahl)) {
                $tmp = explode('#', $tuning_info['tuned']);
                $tmp_schaden = 0; $show_tuned = FALSE;
                for($x=0;$x!=count($tmp);$x++) {
                    $tmpt = explode(';', $tmp[$x]);
                    if($tmpt[0] != 'w') {
                        $artikel_info = @mysql_fetch_array(@mysql_query('SELECT * FROM game_tuning WHERE name_id="' . $tmpt[0] . '" && kat_id="' . $x . '" LIMIT 1'));
                        $tmp_tune_list .= '<tr><td width="33%" align="center">' . $tmpt[1] . '%</td><td width="33%" align="center"><a href="index.php?c=tuningshop&d=kat&kid=' . $artikel_info['kat_id'] . '">' . $TUNE[$artikel_info['kat_id']] . '</a></td><td width="34%" align="center">' . $TUNENAME[$artikel_info['kat_id']][$artikel_info['name_id']] . '</td></tr>';
                        $tuning['ps']       += $artikel_info['ps'];
                        $tuning['0100']     += $artikel_info['go_speed'];
                        $tuning['maxspeed'] += $artikel_info['kmh'];
                        $tuning['gewicht']  += $artikel_info['gewicht'];
                        $tuning['wert']     += $artikel_info['preis'];
                        $tmp_schaden += $tmpt[1];
                        $show_tuned = TRUE;
                    }
                }
                $tmp_tuning_wert = ($tuning['wert'] * ($tmp_schaden / (count($TUNE) * 100)));
            }
            $original['ps']         = $now_car_info['ps'];
            $original['0100']       = $now_car_info['go_speed'];
            $original['maxspeed']   = $now_car_info['max_speed'];
            $original['gewicht']    = $now_car_info['gewicht'];
            $original['wert']       = $now_car_info['preis'];
            $tmp_bild = DIR_T_I_SIGNS . 'car_' . $now_car_info['id'] . '_' . $now_car_info['name_id'] . '.jpg';
            if(file_exists($tmp_bild)) { $tmp_bild = '<img src="' . $tmp_bild . '" border="0">'; } else { $tmp_bild = '{GARAGE_NO_BILD}'; }
            if($show_tuned == TRUE) { $tmp_tteile = '<a href="index.php?c=mygarage&d=gettuning">{GARAGE_SHOW_TTEILE}</a>'; } else { $tmp_tuning_wert = 0; $tuning['ps'] = 0; $tuning['0100'] = 0; $tuning['maxspeed'] = 0; $tuning['gewicht'] = 0; $tuning['wert'] = 0; $tmp_tteile = '<tr><td width="33%" align="center">{GARAGE_NO_TUNING}</td></tr>'; }
            if($FormVars['d'] == 'gettuning') { $tmp_tteile = $tmp_tune_list; }
            $tmp_fahrzeugwert = (($original['wert'] * ($now_sp_info['zustand'] / 100)) + $tmp_tuning_wert);
            $tmp_sellcar = '<a href="index.php?c=mygarage&d=sell&cid=' . $now_sp_info['id'] . '" onClick="return confirm(\'Fahrzeug wirklich für ' . number_format($tmp_fahrzeugwert,2,",",".") . $DEFAULTS['game']['waehrung'] . ' verkaufen?\'); submit();">{GARAGE_SELL_CAR}<BR />(' . number_format($tmp_fahrzeugwert,2,",",".") . $DEFAULTS['game']['waehrung'] . ')</a>';
            $tmp_content = loadTemplate( DIR_T_H_GAME, 'garage_info', EXT_TEMPS );
            if($user_info['now_car'] == $now_sp_info['id']) { $tmp_activate = ''; } else { $user_busy = @mysql_num_rows(@mysql_query('SELECT * FROM game_busy WHERE user_id="' . $_SESSION['userid'] . '" LIMIT 1')); if(empty($user_busy)) { $tmp_activate = '<a href="index.php?c=mygarage&d=activate&gid=' . $now_sp_info['id'] . '">{GARAGE_ACTIVATE}</a>'; } }
        } else { if(isset($FormVars['p_stellplatz'])) { $tmp_content = '{GARAGE_NO_CAR}'; } else { $tmp_content = '{GARAGE_CHOOSE_CAR}'; } }
        $user_info = @mysql_fetch_array(@mysql_query('SELECT * FROM game_user WHERE id="' . $_SESSION['userid'] . '" LIMIT 1'));
        if($anzahl >= 2) { $tmp_sellstellplatz = '<a href="index.php?c=mygarage&d=sell&gid=' . $now_sp_info['id'] . '" onClick="return confirm(\'Stellplatz wirklich verkaufen?\'); submit();">{GARAGE_SELL_STELLPLATZ}<BR />(' . number_format(($DEFAULTS['game']['new_garage'] / 2),2,",",".") . $DEFAULTS['game']['waehrung'] . ')</a>'; }
        $tmp_vars = array(  '{GARAGE_VLU_OPTIONS}'      => $tmp_options,
                            '{GARAGE_VLU_ACTIVATE}'     => $tmp_activate,
                            '{GARAGE_VLU_CONTENT}'      => $tmp_content,
                            '{GARAGE_VLU_BILD}'         => $tmp_bild,
                            '{GERAGE_VLU_TTEILE}'       => $tmp_tteile,
                            '{GARAGE_VLU_PS_O}'         => $original['ps'] . ' PS',
                            '{GARAGE_VLU_PS_T}'         => '+ ' . $tuning['ps'] . ' PS',
                            '{GARAGE_VLU_PS_A}'         => ($original['ps'] + $tuning['ps']) . ' PS',
                            '{GARAGE_VLU_0100_O}'       => $original['0100'] . ' s',
                            '{GARAGE_VLU_0100_T}'       => '- ' . $tuning['0100'] . ' s',
                            '{GARAGE_VLU_0100_A}'       => ($original['0100'] - $tuning['0100']) . ' s',
                            '{GARAGE_VLU_SPEED_O}'      => $original['maxspeed'] . ' km/h',
                            '{GARAGE_VLU_SPEED_T}'      => '+ ' . $tuning['maxspeed'] . ' km/h',
                            '{GARAGE_VLU_SPEED_A}'      => ($original['maxspeed'] + $tuning['maxspeed']) . ' km/h',
                            '{GARAGE_VLU_GEWICHT_O}'    => number_format($original['gewicht'],0,",",".") . ' kg',
                            '{GARAGE_VLU_GEWICHT_T}'    => '+ ' . number_format($tuning['gewicht'],0,",",".") . ' kg',
                            '{GARAGE_VLU_GEWICHT_A}'    => number_format(($original['gewicht'] + $tuning['gewicht']),0,",",".") . ' kg',
                            '{GARAGE_VLU_WERT_O}'       => number_format($original['wert'],2,",",".") . $DEFAULTS['game']['waehrung'],
                            '{GARAGE_VLU_WERT_T}'       => number_format($tuning['wert'],2,",",".") . $DEFAULTS['game']['waehrung'],
                            '{GARAGE_VLU_WERT_A}'       => number_format($tmp_fahrzeugwert,2,",",".") . $DEFAULTS['game']['waehrung'],
                            '{GARAGE_VLU_SELL_CAR}'     => $tmp_sellcar,
                            '{GARAGE_VLU_SELL_GARAGE}'  => $tmp_sellstellplatz,
                            '{GARAGE_VLU_BUY_NEW}'      => '<a href="index.php?c=mygarage&d=buy">{GARAGE_BUY_NEW}<BR />(' . number_format($DEFAULTS['game']['new_garage'],2,",",".") . $DEFAULTS['game']['waehrung'] . ')</a>'
                         );
        $tmp_vars2  =   array( '{GARAGE_VLU_ZUSTAND}' => (100 - $now_sp_info['zustand']) );
        $sql = 'SELECT * FROM game_busy WHERE user_id="' . $_SESSION['userid'] . '" LIMIT 1';
        $userbusy = mysql_num_rows(@mysql_query($sql));
        switch($FormVars['d']) {
            case 'activate':
                if(isset($FormVars['gid'])) {
                    $sql = 'SELECT * FROM game_garage WHERE user_id="' . $_SESSION['userid'] . '" && id="' . $FormVars['gid'] . '" LIMIT 1';
                    $result = @mysql_query($sql);
                    $anzahl = @mysql_num_rows($result);
                    if(!empty($anzahl)) {
                        $tmp_sql = array();
                        $tmp_sql[] = 'UPDATE game_user SET now_car="' . $FormVars['gid'] . '" WHERE id="' . $_SESSION['userid'] . '"';
                        for($x=0;$x!=count($tmp_sql);$x++) { if(@mysql_query($tmp_sql[$x])) { $tmp_sql_ok++; } }
                        if($tmp_sql_ok == count($tmp_sql)) {
                            $ERROR['power'] = true; $tmp_nr = "11";
                        } else { $ERROR['power'] = true; $tmp_nr = "03"; }
                    } else { $ERROR['power'] = true; $tmp_nr = "12"; }
                }
                break;

            case 'sell':
                if(empty($userbusy)) {
                    if(isset($FormVars['cid'])) {
                        $sql = 'SELECT * FROM game_garage WHERE user_id="' . $_SESSION['userid'] . '" && id="' . $FormVars['cid'] . '" LIMIT 1';
                        $result = @mysql_query($sql);
                        $anzahl_s = @mysql_num_rows($result);
                        if(!empty($anzahl_s)) {
                            $tmp_sql = array();
                            if($user_info['now_car'] == $FormVars['cid']) { $tmp_sql[] = 'UPDATE game_user SET now_car="0", now_tank="0" WHERE id="' . $_SESSION['userid'] . '"'; }
                            $tmp_sql[] = 'UPDATE game_garage SET car_id="", car_tank="", zustand="" WHERE id="' . $FormVars['cid'] . '"';
                            $tmp_sql[] = 'UPDATE game_incars SET tuned="0" WHERE garage_id="' . $FormVars['cid'] . '" && user_id="' . $_SESSION['userid'] . '"';
                            $tmp_sql[] = 'UPDATE game_user SET money="' . ($user_info['money'] + $tmp_fahrzeugwert) . '" WHERE id="' . $_SESSION['userid'] . '"';
                            $tmp_sql_ok = 0;
                            for($x=0;$x!=count($tmp_sql);$x++) { if(@mysql_query($tmp_sql[$x])) { $tmp_sql_ok++; } }
                            if($tmp_sql_ok == count($tmp_sql)) {
                                $ERROR['power'] = true; $tmp_nr = "07";
                            } else { $ERROR['power'] = true; $tmp_nr = "03"; }
                        } else { $ERROR['power'] = true; $tmp_nr = "05"; }
                    } else {
                        if(isset($FormVars['gid'])) {
                            if(empty($now_sp_info['car_id'])) {
                                if($anzahl >= 2) {
                                    $tmp_sql = array();
                                    $tmp_sql[] = 'DELETE FROM game_garage WHERE id="' . $FormVars['gid'] . '"';
                                    $tmp_sql[] = 'DELETE FROM game_incars WHERE garage_id="' . $FormVars['gid'] . '" && user_id="' . $_SESSION['userid'] . '"';
                                    $tmp_sql[] = 'UPDATE game_user SET money="' . ($user_info['money'] + ($DEFAULTS['game']['new_garage'] / 2)) . '" WHERE user_id="' . $_SESSION['userid'] . '"';
                                    $tmp_sql_ok = 0;
                                    for($x=0;$x!=count($tmp_sql);$x++) { if(@mysql_query($tmp_sql[$x])) { $tmp_sql_ok++; } }
                                    if($tmp_sql_ok == count($tmp_sql)) {
                                        $ERROR['power'] = true; $tmp_nr = "10";
                                    } else { $ERROR['power'] = true; $tmp_nr = "03"; }
                                } else { $ERROR['power'] = true; $tmp_nr = "09"; }
                            } else { $ERROR['power'] = true; $tmp_nr = "08"; }
                        }
                    }
                } else { $ERROR['power'] = true; $tmp_nr = "06"; }
                break;

            case 'buy':
                if(empty($userbusy)) {
                    if($user_info['money'] >= $DEFAULTS['game']['new_garage']) {
                        $tmp_sql = array();
                        $tmp_sql[] = 'INSERT INTO game_garage VALUES("", "' . $_SESSION['userid'] . '", "0", "0", "0", "' . time() . '")';
                        $tmp_sql[] = 'UPDATE game_user SET money="' . ($user_info['money'] - $DEFAULTS['game']['new_garage']) . '" WHERE id="' . $_SESSION['userid'] . '"';
                        $tmp_sql_ok = 0;
                        for($x=0;$x!=count($tmp_sql);$x++) { if(@mysql_query($tmp_sql[$x])) { $tmp_sql_ok++; } }
                        if($tmp_sql_ok == count($tmp_sql)) {
                            $ERROR['power'] = true; $tmp_nr = "04";
                        } else { $ERROR['power'] = true; $tmp_nr = "03"; }
                    } else { $ERROR['power'] = true; $tmp_nr = "02"; }
                } else { $ERROR['power'] = true; $tmp_nr = "06"; }
                break;
        }
    } else { $ERROR['power'] = true; $tmp_nr = "01"; }

    if($ERROR['power']) {
        // Fehlermeldung übergeben bei einem Fehler
        $vars['error'] = array( '{ERROR_MESSAGE}' => '{GARAGE_ERROR_' . $tmp_nr . '}');
    } else {
        // Template laden
        $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'garage', EXT_TEMPS );
    }

    // Platzhalter füllen
    $vars['content']        =   array( '{CONTENT}' => $tmp_section_content, '{GARAGE_CONTENT}' => $tmp_content );
    $vars['content']        =   array_merge($vars['content'], $tmp_vars, $LANG['game']['garage'], $tmp_vars2);
} else {$vars['content']        =   array( '{CONTENT}' => $LANG['root']['verweigert']);}
?>

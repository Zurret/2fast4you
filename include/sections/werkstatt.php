<?php

    // Zugriff nur für eingeloggte User
    if($_SESSION['logged']) {
        // Initialisieren
        $gesamtzeit = 0;
        $gib_teil = FALSE;
        $gesamtschaden = 0;
        $fahrzeugtuning = 0;
        $ges_info = array();
        $tmp_vars = array();
        $tmp_kategorie = '';
        if(!empty($FormVars['p_kat'])) { $now_kat = $FormVars['p_kat']; } else { $now_kat = 0; }
        if(!empty($FormVars['p_teil'])) { $now_teil = $FormVars['p_teil']; } else { $gib_teil = TRUE; }
        $now_aktion = $FormVars['p_aktion'];
        // Daten laden
        $userinfo = @mysql_fetch_array(@mysql_query('SELECT money, now_car FROM game_user WHERE id="' . $_SESSION['userid'] . '" LIMIT 1'));
        $lager_result = @mysql_query('SELECT game_lager.id AS id, game_lager.zustand AS zustand, game_tuning.name_id AS name_id, game_tuning.preis AS preis FROM game_lager INNER JOIN game_tuning ON game_tuning.id=game_lager.tuning_id WHERE game_lager.user_id="' . $_SESSION['userid'] . '" && game_tuning.kat_id="' . $now_kat . '"');
        $tuning_result = @mysql_query('SELECT * FROM game_incars WHERE user_id="' . $_SESSION['userid'] . '" && garage_id="' . $userinfo['now_car'] . '" LIMIT 1');
        $user_is_busy = @mysql_num_rows(@mysql_query('SELECT * FROM game_busy WHERE user_id="' . $_SESSION['userid'] . '" LIMIT 1'));
        if(empty($user_is_busy)) {
            // Eingebaute Tuningteile filtern
            $tuning = @mysql_fetch_array($tuning_result);
            $tuningkats = explode('#', $tuning['tuned']);
            $now_drin = array(); $not_original = array();
            for($x=0;$x!=count($tuningkats);$x++) {
                $tk = explode(';', $tuningkats[$x]);
                $tti = @mysql_fetch_array(@mysql_query('SELECT * FROM game_tuning WHERE name_id="' . $tk[0] . '" && kat_id="' . $x . '" LIMIT 1'));
                $anzahl_tteile = @mysql_num_rows(@mysql_query('SELECT * FROM game_lager INNER JOIN game_tuning ON game_lager.tuning_id=game_tuning.id WHERE game_lager.user_id="' . $_SESSION['userid'] . '" && game_tuning.kat_id="' . $x . '"'));
                $ges_info[$x]['id'] = $tk[0];
                $ges_info[$x]['dmg'] = $tk[1];
                $ges_info[$x]['preis'] = $tti['preis'];
                if($gib_teil == TRUE && $x == $now_kat) { $now_teil = $tk[0]; }
                if($now_teil == 'w') { $tmp_sel = ' selected'; } else { if($now_kat == $x) { $tmp_sel = ' selected'; } else { $tmp_sel = ''; } }
                if($x == $now_kat) { $tmp_ksel = ' selected'; $t_eingebaut = $tk[0]; $schaden = $tk[1]; } else { $tmp_ksel = ''; }
                if($tk[0] == 'w') {
                    $now_drin[] = '<option value="w"' . $tmp_sel . '>{WERKSTATT_ORIGINAL}* (' . $tk[1] . '%)</option>';
                    $not_original[] = FALSE;
                    if($tk[1] != 100) { $gesamtzeit += $TUNEWORK[$x][0]; }
                } else {
                    $tteilinfo = $tti;
                    $now_drin[] = '<option value="' . $tk[0] . '"' . $tmp_sel . '>' . $TUNENAME[$now_kat][$tk[0]] . '* (' . $tk[1] . '%)</option>';
                    $not_original[] = TRUE;
                    if($tk[1] != 100) { $gesamtzeit += $TUNEWORK[$x][$tk[0]]; }
                }
                $tmp_kategorie .= '<option value="' . $x . '"' . $tmp_ksel . '>[' . $anzahl_tteile . '] ' . $TUNE[$x] . ' (' . $tk[1] . '%)</option>';
            }
            // Tuningteile generieren
            $lager_anzahl = @mysql_num_rows($lager_result);
            $tmp_lager = $now_drin[$now_kat];
            if(!empty($lager_anzahl)) {
                for($x=0;$x!=count($lager_anzahl);$x++) {
                    @mysql_data_seek($lager_result, $x);
                    $tmp = @mysql_fetch_array($lager_result);
                    if($now_teil == 'w') { $tmp_wsel = ' selected'; $tmp_sel = ''; } else { if($tmp['id'] == $now_teil) { $tmp_sel = ' selected'; $schaden = $tmp['zustand']; $tuneteilinfo = $tmp; } else { $tmp_sel = ''; } }
                    $tmp_lager .= '<option value="' . $tmp['id'] . '"' . $tmp_sel . '>' . $TUNENAME[$now_kat][$tmp['name_id']] . ' (' . $tmp['zustand'] . '%)</option>';
                }
            } else { if($now_teil == 'w') { $tmp_wsel = ' selected'; } else { $tmp_wsel = ''; } }
            if($not_original[$now_kat]) { $tmp_lager .= '<option value="w"' . $tmp_wsel . '>{WERKSTATT_ORIGINAL} (100%)</option>'; }
            // Aktionen als menü aufbauen
            $dsl_aktion = array( '', '', '', '', '');
            $dsl_aktion[$now_aktion] = ' selected';
            if(empty($now_aktion)) { $tmp_aktionen =  '<option value="0"' . $dsl_aktion[0] . '>{WERKSTATT_CHOOSE}</option>'; }
            if(empty($now_aktion)) { $tmp_aktionen .= '<option value="0">---------------</option>'; }
            if($t_eingebaut == $now_teil) { $tmp_aktionen .= '<option value="1"' . $dsl_aktion[1] . '>{WERKSTATT_REPAIR}</option>'; }
            if($t_eingebaut != $now_teil) { $tmp_aktionen .= '<option value="2"' . $dsl_aktion[2] . '>{WERKSTATT_INCAR}</option>'; }
            if($t_eingebaut != $now_teil && $now_teil != 'w') { $tmp_aktionen .= '<option value="0">---------------</option>'; }
            if($t_eingebaut != $now_teil && $now_teil != 'w') { $tmp_aktionen .= '<option value="3"' . $dsl_aktion[3] . '>{WERKSTATT_GARBISH}</option>'; }
            $tmp_aktionen .= '<option value="0">---------------</option>';
            $tmp_aktionen .= '<option value="4"' . $dsl_aktion[4] . '>{WERKSTATT_REPAIR_ALL}</option>';
            // Button aktivieren wenn alles gegeben ist
            if(!isset($now_kat) || !isset($now_teil) || !isset($now_aktion)) { $tmp_button = ' disabled'; }
            // Kostenberechnung | Reperatur
            if($now_aktion == 1) { if($t_eingebaut == 'w') { $t_eingebaut = 0; } if(isset($tuneteilinfo)) { $preis = $ORIGINAL_CASH_TUNING[$now_kat]; } else { if(!empty($gesamtinfo[$now_kat][$now_teil])) { $preis = $tuneteilinfo['preis']; } else { $preis = $ORIGINAL_CASH_TUNING[$now_kat]; } } if($schaden != 100) { $dauer = round(($TUNEWORK[$now_kat][$t_eingebaut] * (1 - ($schaden / 100))), 0); $kosten = round(($preis / 2) * (1 - ($schaden / 100)), 0); } else { $dauer = 0; $kosten = 0; } }
            // Kostenberechnung | Einbauen
            if($now_aktion == 2) { if($t_eingebaut == 'w') { $t_eingebaut = 0; } $dauer = $TUNEWORK[$now_kat][$t_eingebaut]; $kosten = 0; }
            // Kostenberechnung | Entsorgung
            if($now_aktion == 3) { if($t_eingebaut == 'w') { $t_eingebaut = 0; } $dauer = round(($TUNEWORK[$now_kat][$t_eingebaut] * 0.3), 0); $kosten = ($tuneteilinfo['preis'] / 10) + ($schaden / 2); }
            // Kostenberechnung | Komplette Reperatur
            for($x=0;$x!=count($ges_info);$x++) {
				$gesamtschaden += $ges_info[$x]['dmg']; 
				if($ges_info[$x]['id'] != 'w') { 
					$fahrzeugtuning++; 
					if($ges_info[$x]['dmg'] != 100) { 
						$gesamtzeit += $TUNEWORK[$x][$ges_info[$x]['id']]; 
						$gesamtkosten += $ges_info[$x]['preis'];
					} 
				} else { 
					$gesamtkosten += $ORIGINAL_CASH_TUNING[$x]; 
				}  
			} 
			$fahrzeugschaden = 100 - (($gesamtschaden / (count($TUNE) * 100)) * 100);
			$fahrzeugtuning = round($fahrzeugtuning / count($TUNE), 2);
			if($now_aktion == 4) { if(empty($fahrzeugschaden)) { $dauer = 0; $kosten = 0; } else { $dauer = round(($gesamtzeit * ($fahrzeugschaden / 100)) + 125, 0); $kosten = round($gesamtkosten * ($fahrzeugschaden / 100) + 125, 0); } }
            // Preis mit Farbe hervorheben ob genug geld auf dem Konto vorhanden ist
            if($kosten > $userinfo['money']) { $tmp_kosten = '<font color="red">' . number_format(round($kosten, 0),2,",",".") . $DEFAULTS['game']['waehrung'] . '</font>'; } else { $tmp_kosten = '<font color="green">' . number_format(round($kosten, 0),2,",",".") . $DEFAULTS['game']['waehrung'] . '</font>'; }
            // Gewählte Aktion durchführen!
            if(!empty($FormVars['check'])) {
                if(empty($user_is_busy)) {
                    if($userinfo['money'] >= $kosten) {
                        $tmp_sql = array();
                        $tmp_sql_ok = 0;
                        switch($now_aktion) {
                            // Eingebautes Tuningteil in gewählter Kategorie reparieren
                            case '1':
                                if(isset($now_kat) && isset($now_teil)) {
                                    $new_values = '';
                                    $tuningkats = explode('#', $tuning['tuned']);
                                    for($x=0;$x!=count($tuningkats);$x++) { if(!empty($x)) { $new_values .= '#'; } $tti = explode(';', $tuningkats[$x]); if($x == $now_kat) { $new_values .= $tti[0] . ';100'; } else { $new_values .= $tti[0] . ';' . $tti[1]; } }
                                    $tmp_do_after = 'UPDATE game_incars SET tuned=\"' . $new_values . '\" WHERE user_id=\"' . $_SESSION['userid'] . '\" && garage_id=\"' . $userinfo['now_car'] . '\"';
                                    $tmp_sql[] = 'INSERT INTO game_busy VALUES("", "' . $_SESSION['userid'] . '", "' . (time() + $dauer) . '", "11", "' . $kosten . '", "0", "' . $tmp_do_after . '")';
                                    $tmp_nr = "08";
                                } else { $ERROR['power'] = true; $tmp_nr = "03"; }
                                break;
                            // Gewähltes Tuningteil einbauen
                            case '2':
                                if(isset($now_kat) && isset($now_teil)) {
                                    $einbau_ok = @mysql_fetch_array(@mysql_query('SELECT notfor FROM game_tuning WHERE kat_id="' . $now_kat . '" && name_id="' . $now_teil . '" LIMIT 1'));
                                    $carinfo = @mysql_fetch_array(@mysql_query('SELECT game_cars.name_id AS name_id FROM game_garage INNER JOIN game_cars ON game_garage.car_id=game_cars.id WHERE game_garage.id="' . $userinfo['now_car'] . '" LIMIT 1'));
                                    $not = explode(';', $einbau_ok['notfor']);
                                    $passt = TRUE;
                                    for($x=0;$x!=count($not);$x++) { if($not[$x] == $carinfo['name_id']) { $passt = FALSE; break(1); } }
                                    if($passt == TRUE) {
                                        $new_values = ''; $tmp_ausbauen = '';
                                        $tuningkats = explode('#', $tuning['tuned']);
                                        for($x=0;$x!=count($tuningkats);$x++) { $tti = explode(';', $tuningkats[$x]); if(!empty($x)) { $new_values .= '#'; } if($x == $now_kat) { if($now_teil == 'w') { $teilinfo = @mysql_fetch_array(@mysql_query('SELECT * FROM game_tuning WHERE name_id="' . $tti[0] . '" && kat_id="' . $now_kat . '" LIMIT 1')); $tmp_ausbauen = '|INSERT INTO game_lager VALUES(\"\", \"' . $_SESSION['userid'] . '\", \"' . $teilinfo['id'] . '\", \"' . $tti[1] . '\");'; $new_values .= 'w;100'; } else { $tuningteilinfo = @mysql_fetch_array(@mysql_query('SELECT game_lager.zustand AS zustand, game_tuning.name_id AS name_id FROM game_lager INNER JOIN game_tuning ON game_lager.tuning_id=game_tuning.id WHERE game_lager.id="' . $now_teil . '" && game_tuning.kat_id="' . $now_kat . '" LIMIT 1')); if($tti[0] != 'w') { $tmp_ausbauen = '|INSERT INTO game_lager VALUES(\"\", \"' . $_SESSION['userid'] . '\", \"' . $tti[0] . '\", \"' . $tti[1] . '\")'; } $new_values .= $tuningteilinfo['name_id'] . ';' . $tuningteilinfo['zustand']; } } else { $new_values .= $tti[0] . ';' . $tti[1]; } }
                                        $tmp_do_after = 'UPDATE game_incars SET tuned=\"' . $new_values . '\" WHERE user_id=\"' . $_SESSION['userid'] . '\" && garage_id=\"' . $userinfo['now_car'] . '\"';
                                        $tmp_do_after .= $tmp_ausbauen . '|DELETE FROM game_lager WHERE id=\"' . $now_teil . '\"';
                                        $tmp_sql[] = 'INSERT INTO game_busy VALUES("", "' . $_SESSION['userid'] . '", "' . (time() + $dauer) . '", "10", "0", "0", "' . $tmp_do_after . '")';
                                        $tmp_nr = "07";
                                    } else { $ERROR['power'] = true; $tmp_nr = "09"; }
                                } else { $ERROR['power'] = true; $tmp_nr = "03"; }
                                break;
                            // Gewähltes Tuningteil entsorgen
                            case '3':
                                if(isset($now_kat) && isset($now_teil)) {
                                    $tuningteilinfo = @mysql_fetch_array(@mysql_query('SELECT * FROM game_tuning WHERE kat_id="' . $now_kat . '" && name_id="' . $now_teil . '" LIMIT 1'));
                                    $tmp_do_after = 'DELETE FROM game_lager WHERE user_id=\"' . $_SESSION['userid'] . '\" && id=\"' . $now_teil . '\"';
                                    $tmp_sql[] = 'INSERT INTO game_busy VALUES("", "' . $_SESSION['userid'] . '", "' . (time() + $dauer) . '", "12", "' . $kosten . '", "0", "' . $tmp_do_after . '")';
                                    $tmp_nr = "06";
                                } else { $ERROR['power'] = true; $tmp_nr = "03"; }
                                break;
                            // Alle Schäden am Fahrzeug Reparieren
                            case '4':
                                $new_values = ''; $tuningkats = explode('#', $tuning['tuned']);
                                for($x=0;$x!=count($tuningkats);$x++) { $tti = explode(';', $tuningkats[$x]); if(!empty($x)) { $new_values .= '#'; } $new_values .= $tti[0] . ';100'; }
                                $tmp_do_after = 'UPDATE game_incars SET tuned=\"' . $new_values . '\" WHERE garage_id=\"' . $userinfo['now_car'] . '\"';
                                $tmp_sql[] = 'INSERT INTO game_busy VALUES("", "' . $_SESSION['userid'] . '", "' . (time() + $dauer) . '", "11", "' . $kosten . '", "0", "' . $tmp_do_after . '")';
                                $tmp_nr = "05";
                                break;
                        }
                        for($x=0;$x!=count($tmp_sql);$x++) { if(@mysql_query($tmp_sql[$x])) { $tmp_sql_ok++; } }
                        if($tmp_sql_ok == count($tmp_sql)) {
                            $ERROR['power'] = true;
                        } else { $ERROR['power'] = true; $tmp_nr = "04"; }
                     } else { $ERROR['power'] = true; $tmp_nr = "02"; }
                } else { $ERROR['power'] = true; $tmp_nr = "01"; }
            } else { $tmp_section_content = loadTemplate( DIR_T_H_GAME, 'werkstatt', EXT_TEMPS ); }
            $tmp_vars   =   array(  '{WERKSTATT_VLU_KATEGORIE}'     => $tmp_kategorie,
                                    '{WERKSTATT_VLU_AKTIONEN}'      => $tmp_aktionen,
                                    '{WERKSTATT_VLU_DRIN}'          => $tmp_lager,
                                    '{WERKSTATT_VLU_BTN_DAB}'       => $tmp_button,
                                    '{WERKSTATT_VLU_KAT}'           => $now_kat,
                                    '{WERKSTATT_VLU_TEIL}'          => $now_teil,
                                    '{WERKSTATT_VLU_AKTION}'        => $now_aktion,
                                    '{WERKSTATT_ZST_GREEN}'         => $schaden,
                                    '{WERKSTATT_ZST_ROT}'           => (100 - $schaden),
                                    '{WERKSTATT_VLU_KOSTEN}'        => $tmp_kosten,
                                    '{WERKSTATT_VLU_DAUER}'         => gibDauer($dauer),
                                    '{WERKSTATT_VLU_CARDEMAGE}'     => number_format(round($fahrzeugschaden, 2),2,".",".") . '%',
                                    '{WERKSTATT_VLU_CARTUNING}'     => number_format(round($fahrzeugtuning, 2),2,".",".") . '%' );
        } else { $ERROR['power'] = true; $tmp_nr = "01"; }
        // Falls Fehler auftreten sollte Ausgabe vorbereiten
        $vars['error'] = array( '{ERROR_MESSAGE}' => '{WERKSTATT_ERROR_' . $tmp_nr . '}');
        // Platzhalter füllen
        $vars['content']        =   array( '{CONTENT}' => $tmp_section_content );
        $vars['content']        =   array_merge($vars['content'], $tmp_vars, $LANG['game']['werkstatt']);
    } else {$vars['content']        =   array( '{CONTENT}' => $LANG['root']['verweigert']);}
?>

<?php

// Nur eingeloggte Benutzer haben Zugriff auf diese Optionen
if($_SESSION['logged']) {
    // Initialisierung
    $tmp_vars = array();
    $tmp_content = '';
    $min_bieten = 1;
    switch($FormVars['d']) {
        case 'myubay':
            $sql = 'SELECT * FROM game_ubay WHERE user_id="' . $_SESSION['userid'] . '" || bieter_id="' . $_SESSION['userid'] . '"';
            $result = @mysql_query($sql);
            $anzahl = @mysql_num_rows($result);
            if(!empty($anzahl)) {
                $tmp_kauf = 0;
                $tmp_kauf_u = '';
                $tmp_verkauf = 0;
                $tmp_verkauf_u = '';
                while($data = @mysql_fetch_array($result)) {
                    $tmp_info = @mysql_fetch_array(@mysql_query('SELECT * FROM game_tuning WHERE id="' . $data['tuning_id'] . '" LIMIT 1'));
                    if(date("d.m.Y", $data['ende']) == date("d.m.Y")) { $tmp_ende = date("H:i:s", $data['ende']); } else { $tmp_ende = date("d.m.Y", $data['ende']); }
                    if($data['bieter_id'] == $_SESSION['userid']) { $tmp_verkauf_u .= '<tr><td width="25%" align="center" height="25">' . $tmp_ende . '</td><td width="25%" align="center" height="25"><a href="index.php?c=ubay&d=details&id=' . $data['id'] . '">' . $TUNENAME[$tmp_info['kat_id']][$tmp_info['name_id']] . '</a></td><td width="25%" align="center" height="25">' . $data['gebote'] . '</td><td width="25%" align="center" height="25">' . number_format($data['startpreis'],2,",",".") . $DEFAULTS['game']['waehrung'] . '</td></tr>'; $tmp_verkauf++; }
                    if($data['user_id'] == $_SESSION['userid']) { $tmp_kauf_u .= '<tr><td width="25%" align="center" height="25">' . $tmp_ende . '</td><td width="25%" align="center" height="25"><a href="index.php?c=ubay&d=details&id=' . $data['id'] . '">' . $TUNENAME[$tmp_info['kat_id']][$tmp_info['name_id']] . '</a></td><td width="25%" align="center" height="25">' . $data['gebote'] . '</td><td width="25%" align="center" height="25">' . number_format($data['startpreis'],2,",",".") . $DEFAULTS['game']['waehrung'] . '</td></tr>'; $tmp_kauf++; }
                }
                if(empty($tmp_kauf)) { $tmp_kauf_u = '<tr><td width="100%" colspan="5" align="center">' . $LANG['game']['shops']['{SHOP_UBAY_MYUBAY_NO_ARTS}'] . '</td></tr>'; }
                if(empty($tmp_verkauf)) { $tmp_verkauf_u = '<tr><td width="100%" colspan="5" align="center">' . $LANG['game']['shops']['{SHOP_UBAY_MYUBAY_NO_ARTS}'] . '</td></tr>'; }
                $tmp_vars = array( '{SHOP_UBAY_MYUBAY_BUYER_CONTENT}'      => $tmp_kauf_u, '{SHOP_UBAY_MYUBAY_SELLER_CONTENT}'     => $tmp_verkauf_u );
            } else { $tmp_vars = array( '{SHOP_UBAY_MYUBAY_BUYER_CONTENT}'      => '<tr><td width="100%" colspan="5" align="center">' . $LANG['game']['shops']['{SHOP_UBAY_MYUBAY_NO_ARTS}'] . '</td></tr>', '{SHOP_UBAY_MYUBAY_SELLER_CONTENT}'     => '<tr><td width="100%" colspan="5" align="center">' . $LANG['game']['shops']['{SHOP_UBAY_MYUBAY_NO_ARTS}'] . '</td></tr>' ); }
            $tmp_content = loadTemplate( DIR_T_H_GAME, 'shops_ubay_myubay', EXT_TEMPS );
            break;

        case 'sell':
            $tmp_vars = array();
            $sql = 'SELECT * FROM game_busy WHERE user_id="' . $_SESSION['userid'] . '" LIMIT 1';
            $anzahl = @mysql_num_rows(@mysql_query($sql));
            if(empty($anzahl)) {
                $sql = 'SELECT * FROM game_lager WHERE user_id="' . $_SESSION['userid'] . '"';
                $result = @mysql_query($sql);
                $anzahl = @mysql_num_rows($result);
                if(!empty($anzahl)) {
                    if(!isset($FormVars['id'])) { $tmp_start_activ = 'disabled'; $tmp_dauer_activ = 'disabled'; $tmp_teile = '<option selected>' . $LANG['game']['shops']['{SHOP_UBAY_SELL_CHOOSE}'] . '</option>'; } else { $tmp_teile = ''; $tmp_dauer_activ = ''; $tmp_start_activ = ''; }
                    while($lager = @mysql_fetch_array($result)) {
                        if($lager['id'] == $FormVars['id']) { $linfo = $lager; }
                        if($lager['tuning_id'] == $FormVars['id']) {$tmp_slct = 'selected '; } else { $tmp_slct = ''; }
                        $tuninfo = @mysql_fetch_array(@mysql_query('SELECT * FROM game_tuning WHERE id="' . $lager['tuning_id'] . '" LIMIT 1'));
                        $tmp_teile .= '<option ' . $tmp_slct . 'value="' . $lager['id'] . '">' . $TUNENAME[$tuninfo['kat_id']][$tuninfo['name_id']] . '</option>';
                    }
                    $tmp_dauer = '';
                    $tmp_file = DIR_T_I_SIGNS . 'tune_' . $FormVars['id'] . '.jpg';
                    if(file_exists($tmp_file)) { $tmp_bild = '<img src="' . $tmp_file . '" border="0">'; } else { $tmp_bild = $LANG['game']['shops']['{SHOP_UBAY_NO_BILD}']; }
                    if(empty($FormVars['p_dauer'])) { $FormVars['p_dauer'] = 1; }
                    for($x=1;$x<=14;$x++) { if($FormVars['p_dauer'] == $x) { $tmp_dr_slt = 'selected'; } else { $tmp_dr_slt = ''; } $tmp_dauer .= '<option value="' . $x . '" ' . $tmp_dr_slt . '>' . $x . '</option>'; }
                    if(isset($FormVars['id'])) {
                        $anzahl = count($linfo);
                        if(!empty($anzahl)) {
                            $sql = 'SELECT * FROM game_tuning WHERE id="' . $linfo['tuning_id'] . '" LIMIT 1';
                            $result = @mysql_query($sql);
                            $anzahl = @mysql_num_rows($result);
                            if(!empty($anzahl)) {
                                $tinfo = @mysql_fetch_array($result);
                                $tmp_minbit     = ceil(($linfo['zustand'] * ($tinfo['preis'] / 100) + 2) * 0.035);
                                $tmp_gebuehr    = round((((($tinfo['preis'] / 1.17) * ($linfo['zustand'] / 100)) * (($FormVars['p_dauer'] * ($FormVars['p_dauer'] / ($tinfo['preis'] / 1.79))) * 0.77)) * ($tinfo['preis'] / 100)), 0);
                                if(empty($tmp_minbit)) { $tmp_minbit = 1;}
                                $tmp_vars = array(  '{SHOP_UBAY_SELL_VLU_TEILE}'    => $tmp_teile,
                                                    '{SHOP_UBAY_SELL_VLU_DAUER}'    => $tmp_dauer,
                                                    '{SHOP_UBAY_SELL_VLU_BILD}'     => $tmp_bild,
                                                    '{SHOP_UBAY_VLU_MINSTART}'      => number_format($tmp_minbit,2,",",".") . $DEFAULTS['game']['waehrung'],
                                                    '{SHOP_UBAY_VLU_KATEGORIE}'     => $TUNE[$tinfo['kat_id']],
                                                    '{SHOP_UBAY_VLU_ARTIKELNAME}'   => $TUNENAME[$tinfo['kat_id']][$tinfo['name_id']],
                                                    '{SHOP_UBAY_VLU_ZUSTAND}'       => $linfo['zustand'] . '%',
                                                    '{SHOP_UBAY_VLU_GEWICHT}'       => $tinfo['gewicht'] . ' kg',
                                                    '{SHOP_UBAY_VLU_PS}'            => '+ ' . $tinfo['ps'],
                                                    '{SHOP_UBAY_VLU_KMH}'           => '+ ' . $tinfo['kmh'] . ' km/h',
                                                    '{SHOP_UBAY_VLU_0100}'          => '- ' . $tinfo['go_speed'] . ' s',
                                                    '{SHOP_UBAY_VLU_ID}'            => $FormVars['id'],
                                                    '{SHOP_UBAY_VLU_DAUER_DBL}'     => $tmp_dauer_activ,
                                                    '{SHOP_UBAY_VLU_START_DBL}'     => $tmp_start_activ,
                                                    '{SHOP_UBAY_VLU_DAUER}'         => $FormVars['p_dauer'],
                                                    '{SHOP_UBAY_VLU_GEBUEHR}'       => number_format($tmp_gebuehr,2,",",".") . $DEFAULTS['game']['waehrung']
                                                 );
                                if(!empty($FormVars['check'])) {
                                    if(!empty($FormVars['p_startpreis']) && !empty($FormVars['p_dauer'])) {
                                        if(!empty($FormVars['p_dauer'])) {
                                            if(is_numeric($FormVars['p_startpreis'])) {
                                                if($FormVars['p_startpreis'] >= $tmp_minbit) {
                                                    $userdata = @mysql_fetch_array(@mysql_query('SELECT money FROM game_user WHERE id="' . $_SESSION['userid'] . '"'));
                                                    if($userdata['money'] >= $anzug) {
                                                        $sql = 'UPDATE game_user SET money="' . ($userdata['money'] - $tmp_gebuehr) . '" WHERE id="' . $_SESSION['userid'] . '"';
                                                        if(@mysql_query($sql)) {
                                                            $sql = 'INSERT INTO game_ubay VALUES("", "' . $_SESSION['userid'] . '", "0", "' . $linfo['tuning_id'] . '", "' . $linfo['tunname_id'] . '", "' . (time() + ((24 * 3600) * $FormVars['p_dauer'])) . '", "' . $FormVars['p_startpreis'] . '", "0", "' . $linfo['zustand'] . '")';
                                                            if(@mysql_query($sql)) {
                                                                $sql = 'DELETE FROM game_lager WHERE id="' . $linfo['id'] . '"';
                                                                if(@mysql_query($sql)) {
                                                                    $ERROR['power'] = true; $tmp_nr = "20";
                                                                } else { $ERROR['power'] = true; $tmp_nr = "19"; }
                                                            } else { $ERROR['power'] = true; $tmp_nr = "18"; }
                                                        } else { $ERROR['power'] = true; $tmp_nr = "17"; }
                                                    } else { $ERROR['power'] = true; $tmp_nr = "16"; }
                                                } else { $ERROR['power'] = true; $tmp_nr = "15"; }
                                            } else { $ERROR['power'] = true; $tmp_nr = "14"; }
                                        } else { $ERROR['power'] = true; $tmp_nr = "13"; }
                                    } else { $ERROR['power'] = true; $tmp_nr = "12"; }
                                }
                                $tmp_content = loadTemplate( DIR_T_H_GAME, 'shops_ubay_sell', EXT_TEMPS );
                            } else { $ERROR['power'] = true; $tmp_nr = "11"; }
                        } else { $ERROR['power'] = true; $tmp_nr = "10"; }
                    } else {
                        $tmp_vars = array(          '{SHOP_UBAY_SELL_VLU_TEILE}'    => $tmp_teile,
                                                    '{SHOP_UBAY_SELL_VLU_DAUER}'    => $tmp_dauer,
                                                    '{SHOP_UBAY_SELL_VLU_BILD}'     => $tmp_bild,
                                                    '{SHOP_UBAY_VLU_MINSTART}'      => number_format(0,2,",",".") . $DEFAULTS['game']['waehrung'],
                                                    '{SHOP_UBAY_VLU_KATEGORIE}'     => '-',
                                                    '{SHOP_UBAY_VLU_ARTIKELNAME}'   => '-',
                                                    '{SHOP_UBAY_VLU_ZUSTAND}'       => '-',
                                                    '{SHOP_UBAY_VLU_GEWICHT}'       => '- kg',
                                                    '{SHOP_UBAY_VLU_PS}'            => '-',
                                                    '{SHOP_UBAY_VLU_KMH}'           => '- km/h',
                                                    '{SHOP_UBAY_VLU_0100}'          => '- s',
                                                    '{SHOP_UBAY_VLU_ID}'            => $FormVars['id'],
                                                    '{SHOP_UBAY_VLU_DAUER_DBL}'     => $tmp_dauer_activ,
                                                    '{SHOP_UBAY_VLU_START_DBL}'     => $tmp_start_activ,
                                                    '{SHOP_UBAY_VLU_DAUER}'         => $FormVars['p_dauer'],
                                                    '{SHOP_UBAY_VLU_GEBUEHR}'       => number_format(0,2,",",".") . $DEFAULTS['game']['waehrung']
                                                 );
                        $tmp_content = loadTemplate( DIR_T_H_GAME, 'shops_ubay_sell', EXT_TEMPS );
                    }
                } else { $tmp_content = '{SHOP_UBAY_SELL_NO}'; }
            } else { $tmp_content = '{SHOP_UBAY_ERROR_21}'; }
            break;

        case 'details':
            $sql = 'SELECT game_ubay.startpreis AS startpreis, game_ubay.ende AS ende, game_tuning.name_id AS tunname_id, game_ubay.zustand AS zustand, game_ubay.bieter_id AS bieter_id, game_ubay.gebote AS gebote, game_tuning.kat_id AS tuning_id, game_tuning.gewicht AS gewicht, game_tuning.kmh AS kmh, game_tuning.go_speed AS go_speed, game_tuning.ps AS ps, game_ubay.user_id AS user_id, game_tuning.notfor AS notfor FROM game_ubay INNER JOIN game_tuning ON game_ubay.tuning_id=game_tuning.id WHERE game_ubay.id="' . $FormVars['id'] . '" LIMIT 1';
            $result = @mysql_query($sql);
            $anzahl = @mysql_num_rows($result);
            if(!empty($anzahl)) {
                $info = @mysql_fetch_array($result);
                if(!empty($FormVars['check']) && !empty($FormVars['p_biete'])) {
                    if(is_numeric($FormVars['p_biete']) && !empty($FormVars['p_biete']) && $FormVars['p_biete'] >= 0) {
                        $FormVars['p_biete'] = round($FormVars['p_biete']);
                        $tmp_ok = @mysql_num_rows(@mysql_query($sql = 'SELECT * FROM game_busy WHERE user_id="' . $_SESSION['userid'] . '" LIMIT 1'));
                        if(empty($tmp_ok)) {
                            $erstes_gebot = FALSE;
                            if(empty($info['gebote'])) { $erstes_gebot = TRUE; }
                            if($FormVars['p_biete'] >= ($info['startpreis'] + $min_bieten) || $erstes_gebot) {
                                $old_bit = @mysql_fetch_array(@mysql_query('SELECT money, nick FROM game_user WHERE id="' . $info['bieter_id'] . '" LIMIT 1'));
                                $sql = 'UPDATE game_user SET money="' . ($old_bit['money'] + $info['startpreis']) . '" WHERE id="' . $info['bieter_id'] . '"';
                                if(@mysql_query($sql)) {
                                    $my_data = @mysql_fetch_array(@mysql_query('SELECT money FROM game_user WHERE id="' . $_SESSION['userid'] . '"'));
                                    if($my_data['money'] >= $FormVars['p_biete']) {
                                        $sql = 'UPDATE game_user SET money="' . ($my_data['money'] - $FormVars['p_biete']) . '" WHERE id="' . $_SESSION['userid'] . '"';
                                        if(@mysql_query($sql)) {
                                            if(!$erstes_gebot) {
                                                $tmp_msg_kat = 5;
                                                $tmp_msg_id = 3;
                                                $tmp_msg_vars = array( '{ARTIKEL}' => $TUNENAME[$info['tuning_id']][$info['tunname_id']], '{BIETER}' => $old_bit['name'], '{MONEY}' => number_format($FormVars['p_biete'],2,",",".") . $DEFAULTS['game']['waehrung'] );
                                                $tmp_send_msg = array2text( loadTemplate( DIR_LANGUAGE . PAGE_LANGUAGE . '/system/', $MSG[$tmp_msg_kat][$tmp_msg_id], EXT_TEXT ), $tmp_msg_vars );
                                                $sql2 = 'INSERT INTO game_nachrichten VALUES(NULL, "0", "' . $info['bieter_id'] . '", "' . $BETREFF[$tmp_msg_kat][$tmp_msg_id] . '", "' . $tmp_send_msg . '", "' . time() . '", "1", "0")';
                                            }
                                            $sql = 'UPDATE game_ubay SET bieter_id="' . $_SESSION['userid'] . '", startpreis="' . $FormVars['p_biete'] . '", gebote="' . ($info['gebote'] + 1) . '" WHERE id="' . $FormVars['id'] . '"';
                                            if(@mysql_query($sql)) {
                                                $ERROR['power'] = true; $tmp_nr = "08";
                                            } else { $ERROR['power'] = true; $tmp_nr = "07"; }
                                        } else { $ERROR['power'] = true; $tmp_nr = "06"; }
                                    } else { $ERROR['power'] = true; $tmp_nr = "04"; }
                                } else { $ERROR['power'] = true; $tmp_nr = "03"; }
                            } else { $ERROR['power'] = true; $tmp_nr = "02"; }
                        } else { $ERROR['power'] = true; $tmp_nr = "05"; }
                    } else { $ERROR['power'] = true; $tmp_nr = "09"; }
                }
                if(empty($info['gebote'])) { $tmp_minbit = $info['startpreis']; } else { $tmp_minbit = $info['startpreis'] + $min_bieten; }
                $anzahl = @mysql_num_rows(@mysql_query('SELECT * FROM game_busy WHERE user_id="' . $_SESSION['userid'] . '" LIMIT 1'));
                if(!empty($anzahl)) { $tmp_working = TRUE; } else { $tmp_working = FALSE; }
                $userinfo = @mysql_fetch_array(@mysql_query('SELECT nick FROM game_user WHERE id="' . $info['bieter_id'] . '"'));
                if(!empty($userinfo['nick'])) { $tmp_hightbitter = '<a href="index.php?c=profil&id=' . $info['bieter_id'] . '">' . $userinfo['nick'] . '</a>'; } else { $tmp_hightbitter = '-'; }
                if($_SESSION['userid'] == $info['user_id'] || $tmp_working == TRUE) { $tmp_sperre = 'disabled'; } else { $tmp_sperre = ''; }
                $tmp_not4 = ''; $tmp_br = 0;
                $tmp = explode(";", $info['notfor']);
                for($x=0;$x!=count($tmp);$x++) { $fcar = @mysql_fetch_array(@mysql_query('SELECT game_cars.id AS id FROM game_cars WHERE name_id="' . $tmp[$x] . '" LIMIT 1')); if(!empty($fcar['id'])) { if(!empty($tmp_br)) { $tmp_not4 .= ", "; if($tmp_br == 4) { $tmp_not4 .= "<br />"; $tmp_br = 0; } else { $tmp_br++; } } else { $tmp_br++; } $tmp_not4 .= '<a href="index.php?c=autohaus&d=details&cid=' . $fcar['id'] . '">' . $CARNAME[$tmp[$x]] . '</a>'; } }
                $tmp_file = DIR_T_I_SIGNS . 'tune_' . $info['tuning_id'] . '.jpg';
                if(file_exists($tmp_file)) { $tmp_bild = '<img src="' . $tmp_file . '" border="0">'; } else { $tmp_bild = $LANG['game']['shops']['{SHOP_UBAY_NO_BILD}']; }
                $tmp_vars = array(      '{SHOP_UBAY_VLU_UBAYID}'        => $FormVars['id'],
                                        '{SHOP_UBAY_VLU_BILD}'          => $tmp_bild,
                                        '{SHOP_UBAY_VLU_KATEGORIE}'     => $TUNE[$info['tuning_id']],
                                        '{SHOP_UBAY_VLU_NAME}'          => $TUNENAME[$info['tuning_id']][$info['tunname_id']],
                                        '{SHOP_UBAY_VLU_NOWPREIS}'      => number_format($info['startpreis'],2,",",".") . $DEFAULTS['game']['waehrung'],
                                        '{SHOP_UBAY_VLU_HIGHBITTER}'    => $tmp_hightbitter,
                                        '{SHOP_UBAY_VLU_ENDED}'         => date("d.m.Y - H:i:s", $info['ende']),
                                        '{SHOP_UBAY_VLU_ZUSTAND}'       => $info['zustand'] . '%',
                                        '{SHOP_UBAY_VLU_WEIGHT}'        => $info['gewicht'] . ' kg',
                                        '{SHOP_UBAY_VLU_PS}'            => '+ ' . $info['ps'],
                                        '{SHOP_UBAY_VLU_KMH}'           => '+ ' . $info['kmh'] . ' km/h',
                                        '{SHOP_UBAY_VLU_0100}'          => '- ' . $info['go_speed'] . ' s',
                                        '{SHOP_UBAY_VLU_NOT4CAR}'       => $tmp_not4,
                                        '{SHOP_UBAY_VLU_SPERRE}'        => $tmp_sperre,
                                        '{SHOP_UBAY_VLU_MINBIT}'        => number_format($tmp_minbit,2,",",".") . $DEFAULTS['game']['waehrung'],
                                        '{SHOP_UBAY_SHOW_CONTENT}'      => $tmp_show_content                    );
                $tmp_content = loadTemplate( DIR_T_H_GAME, 'shops_ubay_details', EXT_TEMPS );
            } else { $ERROR['power'] = true; $tmp_nr = "01"; }
            break;

        case 'show':
            if(empty($FormVars['sort'])) { $FormVars['sort'] = 'ende'; }
            if($FormVars['sort'] == 'ende') { $tmp_sort = 'ende'; $tmp_sort_dir = 'ASC'; }
            if($FormVars['sort'] == 'name') { $tmp_sort = 'tunname_id'; $tmp_sort_dir = 'DESC'; }
            if($FormVars['sort'] == 'gebote') { $tmp_sort = 'gebote'; $tmp_sort_dir = 'DESC'; }
            if($FormVars['sort'] == 'preis') { $tmp_sort = 'startpreis'; $tmp_sort_dir = 'DESC'; }
            if(isset($FormVars['kat'])) {
                if($FormVars['kat'] == 'all') {
                    $sql = 'SELECT * FROM game_ubay WHERE game_ubay.ende>="' . time() . '" ORDER BY ' . $tmp_sort . ' ' . $tmp_sort_dir;
                    $result = @mysql_query($sql);
                    $anzahl = @mysql_num_rows($result);
                    if(!empty($anzahl)) {
                        while($show = @mysql_fetch_array($result)) {
                            $tmp_info = @mysql_fetch_array(@mysql_query('SELECT * FROM game_tuning WHERE id="' . $show['tuning_id'] . '" LIMIT 1'));
                            if(date("d.m.Y", $show['ende']) == date("d.m.Y")) { $tmp_ende = date("H:i:s", $show['ende']); } else { $tmp_ende = date("d.m.Y", $show['ende']); }
                            $tmp_show_content .= '<tr><td width="20%" align="center">' . $tmp_ende . '</td><td width="40%" align="left"><a href="index.php?c=ubay&d=details&id=' . $show['id'] . '">' . $TUNENAME[$tmp_info['kat_id']][$tmp_info['name_id']] . '</a></td><td width="20%" align="center">' . $show['gebote'] . '</td><td width="20%" align="center">' . number_format($show['startpreis'],2,",",".") . $DEFAULTS['game']['waehrung'] . '</td></tr>';
                        }
                        $tmp_content = loadTemplate( DIR_T_H_GAME, 'shops_ubay_artikel', EXT_TEMPS );
                        $tmp_vars = array( '{SHOP_UBAY_SHOW_CONTENT}' => $tmp_show_content, '{SHOP_UBAY_URL}' => 'index.php?c=ubay&d=show&kat=all' );
                    } else { $tmp_content = '{SHOP_UBAY_NO_AUKTIONEN}'; }
                } else {
                    $sql = 'SELECT game_ubay.id AS id, game_ubay.ende AS ende, game_ubay.gebote AS gebote, game_ubay.startpreis AS startpreis, game_ubay.tuning_id AS tuning_id FROM game_ubay INNER JOIN game_tuning ON game_ubay.tuning_id=game_tuning.id WHERE game_ubay.ende>="' . time() . '" AND game_tuning.kat_id="' . $FormVars['kat'] . '" ORDER BY game_ubay.ende DESC';
                    $result = @mysql_query($sql);
                    $anzahl = @mysql_num_rows($result);
                    if(!empty($anzahl)) {
                        while($show = @mysql_fetch_array($result)) {
                            $tmp_info = @mysql_fetch_array(@mysql_query('SELECT * FROM game_tuning WHERE id="' . $show['tuning_id'] . '" LIMIT 1'));
                            if(date("d.m.Y", $show['ende']) == date("d.m.Y")) { $tmp_ende = date("H:i:s", $show['ende']); } else { $tmp_ende = date("d.m.Y", $show['ende']); }
                            $tmp_show_content .= '<tr><td width="20%" align="center">' . $tmp_ende . '</td><td width="40%" align="left"><a href="index.php?c=ubay&d=details&id=' . $show['id'] . '">' . $TUNENAME[$tmp_info['kat_id']][$tmp_info['name_id']] . '</a></td><td width="20%" align="center">' . $show['gebote'] . '</td><td width="20%" align="center">' . number_format($show['startpreis'],2,",",".") . $DEFAULTS['game']['waehrung'] . '</td></tr>';
                        }
                        $tmp_content = loadTemplate( DIR_T_H_GAME, 'shops_ubay_artikel', EXT_TEMPS );
                        $tmp_vars = array( '{SHOP_UBAY_SHOW_CONTENT}' => $tmp_show_content, '{SHOP_UBAY_URL}' => 'index.php?c=ubay&d=show&kat=all' );
                    } else { $tmp_content = '{SHOP_UBAY_NO_AUKTIONEN_KAT}'; }
                }
            }
            break;

        default:
            $tmp_content = loadTemplate( DIR_T_H_GAME, 'shops_ubay_home', EXT_TEMPS );
            $tmp_content2 = '';
            $tmp_kat_anzahl = array();
            $sql = 'SELECT game_ubay.tuning_id AS id FROM game_ubay';
            $result = @mysql_query($sql);
            $anzahl = @mysql_num_rows($result);
            $tmp_vars = array( '{SHOP_UBAY_ACTIV}' => $anzahl );
            if(!empty($anzahl)) {
                while($data = @mysql_fetch_array($result)) {
                    $tmp_info = @mysql_fetch_array(@mysql_query('SELECT * FROM game_tuning WHERE id="' . $data['id'] . '" LIMIT 1'));
                    if(empty($tmp_kat_anzahl[$tmp_info['kat_id']])) { $tmp_kat_anzahl[$tmp_info['kat_id']] = 1; } else { $tmp_kat_anzahl[$tmp_info['kat_id']]++; } }
                $tmp_vars = array( '{SHOP_UBAY_ACTIV}' => $anzahl );
            } else { for($x=0;$x!=count($TUNE);$x++) { $tmp_kat_anzahl[$x] = 0; } }
            $anzahl = ceil(count($TUNE) / 2);
            for($x=0;$x!=$anzahl;$x++) {
                $tmp_1 = $x; $tmp_2 = $anzahl + $x;
                if(empty($tmp_cnt)) { $tmp_content2 .= '<tr>'; }
                if(!empty($LANG['tune_kats'][$tmp_1])) { if(empty($tmp_kat_anzahl[$tmp_1])) { $tmp_kat_anzahl[$tmp_1] = 0;} $tmp_content2 .= '<td width="50%" align="left">(' . $tmp_kat_anzahl[$tmp_1] . ') <a href="index.php?c=ubay&d=show&kat=' . $tmp_1 . '">' . $LANG['tune_kats'][$tmp_1] . '</a></td>'; $tmp_cnt++; }
                if(!empty($LANG['tune_kats'][$tmp_2])) { if(empty($tmp_kat_anzahl[$tmp_2])) { $tmp_kat_anzahl[$tmp_2] = 0;} $tmp_content2 .= '<td width="50%" align="left">(' . $tmp_kat_anzahl[$tmp_2] . ') <a href="index.php?c=ubay&d=show&kat=' . $tmp_2 . '">' . $LANG['tune_kats'][$tmp_2] . '</a></td>'; $tmp_cnt++; }
                if($tmp_cnt == 2) { $tmp_content2 .= '</tr>'; $tmp_cnt = 0; }
            }
            break;
    }

    // Fehlermeldung ausgeben wenn benötigt
    $vars['error'] = array( '{ERROR_MESSAGE}' => '{SHOP_UBAY_ERROR_' . $tmp_nr . '}');

    // Template laden
    $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'shops_ubay', EXT_TEMPS );

    // Platzhalter füllen
    $vars['content']        =   array( '{CONTENT}' => $tmp_section_content, '{SHOP_UBAY_CONTENT}' => $tmp_content, '{SHOP_UBAY_CONTENT2}' => $tmp_content2 );
    $vars['content']        =   array_merge($vars['content'], $LANG['game']['shops'], $tmp_vars );
} else {$vars['content']        =   array( '{CONTENT}' => $LANG['root']['verweigert']);}

?>

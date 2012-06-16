<?php
                                         
    // Fortfahren mit der eigentlichen Funktion ..
    $tmp_vars = array();

    // Sortierung initialisieren
    if($FormVars['sort'] == 'preis') { $tmp_sort = 'preis'; $tmp_sortdir = 'ASC'; }
    if($FormVars['sort'] == 'ruf') { $tmp_sort = 'min_ruf'; $tmp_sortdir = 'ASC'; }
    if($FormVars['sort'] == 'ansehen') { $tmp_sort = 'min_ansehen'; $tmp_sortdir = 'ASC'; }
    if($FormVars['sort'] == 'klasse') { $tmp_sort = 'klasse'; $tmp_sortdir = 'ASC'; }
    if(!isset($FormVars['sort'])) { $tmp_sort = 'klasse'; $tmp_sortdir = 'ASC'; }

    // Benutzerinfos laden
    $user_info = @mysql_fetch_array(@mysql_query('SELECT * FROM game_user WHERE id="' . $_SESSION['userid'] . '" LIMIT 1'));

    // Alle eingetragenen Fahrzeuge laden
    $sql = 'SELECT * FROM game_cars WHERE min_ruf<="' . $user_info['ruf'] . '" ORDER BY ' . $tmp_sort . ' ' . $tmp_sortdir;
    $result = @mysql_query($sql);
    $anzahl = @mysql_num_rows($result);
    $tmp_klassen = array( 'A', 'B', 'C', 'D', 'E', 'F' );
    if(!empty($anzahl)) {
        switch($FormVars['d']) {
            case 'buy':
                $busy = @mysql_num_rows(@mysql_query('SELECT * FROM game_busy WHERE user_id="' . $_SESSION['userid'] . '" LIMIT 1'));
                if(empty($busy)) {
                    while($tmp = @mysql_fetch_array($result)) { if($tmp['id'] == $FormVars['cid']) { $car_info = $tmp; break(1); } }
                    if($user_info['money'] >= $car_info['preis']) {
                        $userinfo = @mysql_fetch_array(@mysql_query('SELECT ruf, ansehen FROM game_user WHERE id="' . $_SESSION['userid'] . '" LIMIT 1'));
                        if($userinfo['ruf'] >= $car_info['min_ruf']) {
                            if($userinfo['ansehen'] >= $car_info['min_ansehen']) {
                                $free_rlt = @mysql_query('SELECT * FROM game_garage WHERE user_id="' . $_SESSION['userid'] . '" && car_id="0" LIMIT 1');
                                $free_garage = @mysql_num_rows($free_rlt);
                                if(!empty($free_garage)) {
                                    $garage_info = @mysql_fetch_array($free_rlt);
                                    $tmp_sql = array();
                                    $tmp_ad = ''; for($x=0;$x!=count($TUNE);$x++) { if(!empty($x)) { $tmp_ad .= '#'; } $tmp_ad .= 'w;100'; }
                                    $tmp_liter = rand(13, 31);
                                    $tmp_do_after = 'UPDATE game_garage SET car_id=\"' . $car_info['id'] . '\", car_tank=\"' . $tmp_liter . '\", zustand=\"100\", time=\"' . time() . '\" WHERE id=\"' . $garage_info['id'] . '\"|UPDATE game_incars SET tuned=\"' . $tmp_ad . '\" WHERE user_id=\"' . $_SESSION['userid'] . '\"';
                                    $tmp_msg_kat = 1;
                                    $tmp_msg_id = 0;
                                    $tmp_msg_vars = array( '{LITER}' => $tmp_liter );
                                    $tmp_send_msg = array2text( loadTemplate( DIR_LANGUAGE . PAGE_LANGUAGE . '/system/', $MSG[$tmp_msg_kat][$tmp_msg_id], EXT_TEXT ), $tmp_msg_vars );
                                    $tmp_do_after .= addcslashes('|INSERT INTO game_nachrichten VALUES(NULL, "0", "' . $_SESSION['userid'] . '", "' . $BETREFF[$tmp_msg_kat][$tmp_msg_id] . '", "' . $tmp_send_msg . '", "' . time() . '", "1", "0")', "\"");
                                    $tmp_sql[] = 'UPDATE game_user SET money="' . ($user_info['money'] - $car_info['preis']) . '" WHERE id="' . $_SESSION['userid'] . '"';
                                    $tmp_sql[] = 'INSERT INTO game_busy VALUES("", "' . $_SESSION['userid'] . '", "' . (time() + $DEFAULTS['game']['car_zustellen']) . '", "2", "0", "0", "' . $tmp_do_after . '");';
                                    $tmp_sql_ok = 0;
                                    for($x=0;$x!=count($tmp_sql);$x++) { if(@mysql_query($tmp_sql[$x])) { $tmp_sql_ok++; } }
                                    if($tmp_sql_ok == count($tmp_sql)) {
                                        $ERROR['power'] = true; $tmp_nr = "06";
                                    } else { $ERROR['power'] = true; $tmp_nr = "05"; }
                                } else { $ERROR['power'] = true; $tmp_nr = "04"; }
                            } else { $ERROR['power'] = true; $tmp_nr = "08"; }
                        } else { $ERROR['power'] = true; $tmp_nr = "07"; }
                    } else { $ERROR['power'] = true; $tmp_nr = "03"; }
                } else { $ERROR['power'] = true; $tmp_nr = "02"; }
                break;

            case 'details':
                $det_result = @mysql_query('SELECT * FROM game_cars WHERE name_id="' . $FormVars['cid'] . '" LIMIT 1');
                $anzahl = @mysql_num_rows($det_result);
                if(!empty($anzahl)) {
                    $car_info = @mysql_fetch_array($det_result);
                    $userinfo = @mysql_fetch_array(@mysql_query('SELECT ruf, ansehen FROM game_user WHERE id="' . $_SESSION['userid'] . '" LIMIT 1'));
                    if($userinfo['ruf'] >= $car_info['min_ruf'] && $userinfo['ansehen'] >= $car_info['min_ansehen']) {
                        $tmp_template = loadTemplate( DIR_T_H_GAME, 'autohaus_details', EXT_TEMPS );
                        $tmp_bild = DIR_T_I_SIGNS . 'car_' . $car_info['id'] . '_' . $car_info['name_id'] . '.jpg';
                        if(file_exists($tmp_bild)) { $tmp_bild = '<img src="' . $tmp_bild . '" border="0">'; } else { $tmp_bild = '{AUTOHAUS_NO_BILD}'; }
                        $tmp_info = array(          '{AUTOHAUS_VLU_TABLE}'      => $tmp_table_content,
                                                    '{AUTOHAUS_VLU_BILD}'       => $tmp_bild,
                                                    '{AUTOHAUS_VLU_NAME}'       => $CARNAME[$car_info['name_id']],
                                                    '{AUTOHAUS_VLU_PREIS}'      => number_format($car_info['preis'],2,",",".") . $DEFAULTS['game']['waehrung'],
                                                    '{AUTOHAUS_VLU_RUF}'        => $car_info['min_ruf'],
                                                    '{AUTOHAUS_VLU_ANSEHEN}'    => $car_info['min_ansehen'],
                                                    '{AUTOHAUS_VLU_KLASSE}'     => $tmp_klassen[$car_info['klasse']],
                                                    '{AUTOHAUS_VLU_PS}'         => $car_info['ps'] . ' PS',
                                                    '{AUTOHAUS_VLU_MAXSPEED}'   => $car_info['max_speed'] . ' km/h',
                                                    '{AUTOHAUS_VLU_GOSPEED}'    => $car_info['go_speed'] . ' s',
                                                    '{AUTOHAUS_VLU_TANK}'       => $car_info['tank_max'] . ' l',
                                                    '{AUTOHAUS_VLU_GEWICHT}'    => number_format($car_info['gewicht'],0,",",".") . ' kg',
                                                    '{AUTOHAUS_VLU_CARID}'      => $car_info['id'] );
                    } else { $ERROR['power'] = true; $tmp_nr = "01"; }
                } else { $ERROR['power'] = true; $tmp_nr = "00"; }
                break;

            default:
                $tmp_template = loadTemplate( DIR_T_H_GAME, 'autohaus_table', EXT_TEMPS );
                $tmp_table_content = '';
                while($car_info = @mysql_fetch_array($result)) { $tmp_table_content .= '<tr><td width="25%" align="left">&nbsp;<a href="index.php?c=autohaus&d=details&cid=' . $car_info['name_id'] . '">' . $CARNAME[$car_info['name_id']] . '</a></td><td width="15%" align="center">' . $car_info['min_ruf'] . '</td><td width="20%" align="center">' . $car_info['min_ansehen'] . '</td><td width="15%" align="center">' . $tmp_klassen[$car_info['klasse']] . '</td><td width="25%" align="left">' . number_format($car_info['preis'],2,",",".") . $DEFAULTS['game']['waehrung'] . '</td></tr>'; }
                $tmp_info = array( '{AUTOHAUS_VLU_TABLE}'  => $tmp_table_content );
                break;
        }
        $tmp_content = array2text( $tmp_template, $tmp_info );
    } else { $tmp_content = '{AUTOHAUS_NO_CARS}'; }

    if($ERROR['power']) {
        // Fehlermeldung übergeben bei einem Fehler
        $vars['error'] = array( '{ERROR_MESSAGE}' => '{AUTOHAUS_ERROR_' . $tmp_nr . '}');
    } else {
        // Template laden
        $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'autohaus', EXT_TEMPS );
    }

    // Platzhalter füllen
    $vars['content']        =   array( '{CONTENT}' => $tmp_section_content, '{AUTOHAUS_CONTENT}' => $tmp_content );
    $vars['content']        =   array_merge($vars['content'], $tmp_vars, $LANG['game']['autohaus']);

?>

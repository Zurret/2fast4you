<?php

// Beendete Rennen 30mins löschen
$result = mysql_query('SELECT id FROM game_rennen_ende WHERE (1800 + ende)<="' . time() . '"');
$anzahl = mysql_num_rows($result);
if(!empty($anzahl)) { while($renninfo = mysql_fetch_array($result)) { mysql_query('DELETE FROM game_rennen_ende WHERE id="' . $renninfo['id'] . '"'); } }

// Dafür sorgen das Rennen gefahren werden und man auch zuschauen kann
$sql = 'SELECT * FROM game_rennen WHERE time<="' . time() . '" || ready2go="1"';
$result = @mysql_query($sql);
$anzahl = @mysql_num_rows($result);
if(!empty($anzahl)) {
    require_once( DIR_INC_CLASS . 'racingscript' . EXT_CLASS );
    while($dt = @mysql_fetch_array($result)) {
        // Rennstart sperren
        $start_race = FALSE;
        // Alle Fahrerinfos laden und Skript übergeben
        $tmp = explode("#", $dt['drivers']);
        // Alle Fahrer sind anwesend und 'Ready2Go' ist aktiviert = Rennen starten
        if(count($tmp) >= 2 && $dt['time'] <= time() && !empty($dt['ready2go'])) { $start_race = TRUE; }
        // Wenn mehr als 2 Fahrer anwesend oder 'ready2go' gesetzt = Rennen starten
        if(count($tmp) >= $dt['drivers_max'] || $start_race == TRUE) {
            // Renndaten initialisieren
            $tmp_sql    = array();
            $wetter     = array();
            $fahrer     = array();
            $strecke    = array();
            // Wetterstatus abfragen
            $wtr_rlt = @mysql_query('SELECT temp, wetter FROM game_wetter ORDER BY id DESC LIMIT 1');
            $wetter  = @mysql_fetch_array($wtr_rlt);
            // Streckeninfos laden
            $stk_rlt = @mysql_query('SELECT * FROM game_strecken WHERE id="' . $dt['strecken_id'] . '" LIMIT 1');
            $strecke = @mysql_fetch_array($stk_rlt);
            // Renninformationen übergeben
            $rennen  = $dt;
            // Fahrerinformationen zum Rennen auslesen
            for($x=0;$x!=count($tmp);$x++) {
                $tmpi = explode(";", $tmp[$x]);
                $rk_user_info       = @mysql_fetch_array(@mysql_query('SELECT * FROM game_user WHERE id="' . $tmpi[0] . '" LIMIT 1'));
                $rk_garage_info     = @mysql_fetch_array(@mysql_query('SELECT * FROM game_garage WHERE id="' . $tmpi[1] . '" LIMIT 1'));
                $rk_tune_info       = @mysql_fetch_array(@mysql_query('SELECT * FROM game_incars WHERE garage_id="' . $tmpi[1] . '" LIMIT 1'));
                $rk_car_info        = @mysql_fetch_array(@mysql_query('SELECT * FROM game_cars WHERE id="' . $rk_garage_info['car_id'] . '" LIMIT 1'));
                $rk_skill_info      = @mysql_fetch_array(@mysql_query('SELECT * FROM game_userskills WHERE user_id="' . $tmpi[0] . '"'));
                $fahrer[] =     array(          'user_info'     => $rk_user_info,
                                                'garage_info'   => $rk_garage_info,
                                                'tune_info'     => $rk_tune_info,
                                                'car_info'      => $rk_car_info,
                                                'skill_info'    => $rk_skill_info           );
            }
            // Wenn alle Fahreinfos geladen wurden das rennen starten
            if(count($tmp) == count($fahrer)) {
                // Rennskript initialisieren und starten
                $rskript = new racingScript();
                $rskript->setRennen($rennen);
                $rskript->setWetter($wetter);
                $rskript->setFahrer($fahrer);
                $rskript->setDemage($schaden);
                $rskript->setUnfaelle($unfaelle);
                $rskript->setDelays($delays);
                $rskript->setStrecke($strecke);
                $rskript->setHindernisse($hindernisse);
                $rskript->startRace();
                $renndauer = $rskript->getRennDauer();
                @mysql_query('UPDATE game_strecken SET starts="' . ($strecke['starts'] + 1) . '" WHERE id="' . $strecke['id'] . '"');
            }
        } else {
            if($dt['time'] <= time() && count($tmp) <= 1) {
                // Weniger als 2 Fahrer anwesend und Rennstart schon vorbei, rennen abbrechen
                $tmpi = explode(";", $tmp[0]);
                $uinf = @mysql_fetch_array(@mysql_query('SELECT * FROM game_user WHERE id="' . $tmpi[0] . '" LIMIT 1'));
                $tmp_sql[] = 'DELETE FROM game_rennen WHERE id="' . $dt['id'] . '"';
                $tmp_sql[] = 'UPDATE game_user SET money="' . ($uinf['money'] + $dt['einsatz']) . '" WHERE id="' . $tmpi[0] . '"';
            }
        }
        // Mysql-Querys ausführen
        for($x=0;$x!=count($tmp_sql);$x++) { @mysql_query($tmp_sql[$x]); }
    }
}

// Zugang nur für eingeloggte Benutzer
if($_SESSION['logged']) {
    // Sortierung initialisieren
    if($FormVars['sort'] == 'start') { $tmp_sort = 'time'; $tmp_sortdir = 'ASC'; }
    if($FormVars['sort'] == 'strecke') { $tmp_sort = 'strecken_id'; $tmp_sortdir = 'ASC'; }
    if($FormVars['sort'] == 'runden') { $tmp_sort = 'runden'; $tmp_sortdir = 'ASC'; }
    if($FormVars['sort'] == 'maxfahrer') { $tmp_sort = 'drivers_max'; $tmp_sortdir = 'ASC'; }
    if($FormVars['sort'] == 'einsatz') { $tmp_sort = 'einsatz'; $tmp_sortdir = 'ASC'; }
    if(!isset($FormVars['sort'])) { $tmp_sort = 'time'; $tmp_sortdir = 'ASC'; }
    // Initialisierung
    $tmp_vars = array();
    $user_info = @mysql_fetch_array(@mysql_query('SELECT * FROM game_user WHERE id="' . $_SESSION['userid'] . '" LIMIT 1'));
    $ucar_info = @mysql_fetch_array(@mysql_query('SELECT game_cars.klasse AS klasse FROM game_garage INNER JOIN game_cars ON game_garage.car_id=game_cars.id WHERE game_garage.id="' . $user_info['now_car'] . '" LIMIT 1'));
    $garage_info = @mysql_fetch_array(@mysql_query('SELECT * FROM game_garage WHERE id="' . $user_info['now_car'] . '" LIMIT 1'));
    $rennen = @mysql_query('SELECT * FROM game_rennen WHERE time>="' . time() . '" ORDER BY ' . $tmp_sort . ' ' . $tmp_sortdir);
    $tmp_gebuehr = $DEFAULTS['game']['race_gebuehr'] + ($ucar_info['klasse'] * 55);
    // Überprüfen ob der Benutzer in einem Rennen bereits ist
    $tmp_user_is_on_race = FALSE; while($k = @mysql_fetch_array($rennen)) { $kkk = explode("#", $k['drivers']); for($x=0;$x!=count($kkk);$x++) { $kk = explode(";", $kkk[$x]); if($kk[0] == $_SESSION['userid']) { $user_is_in_race = $k; $tmp_user_is_on_race = TRUE; break(2); } } } @mysql_data_seek($rennen, 0);
    // Direkten Link zum Rennen geben falls rennen vorhanden
    $im_sql = @mysql_query('SELECT * FROM game_rennen_ende WHERE ende>="' . (time()+15) . '" ORDER BY ende ASC');
    $im_anzahl = @mysql_num_rows($im_sql); $tmp_user_is_in_race = 0;
    if(!empty($im_anzahl)) { $im_rennen = @mysql_fetch_array($im_sql); $kkk = explode("|", $im_rennen['plazierung']); for($x=0;$x!=count($kkk);$x++) { $kk = explode(":", $kkk[$x]); if($kk[0] == $_SESSION['userid']) { $tmp_user_is_in_race = $im_rennen['id']; break(1); } } }
    // Navigation aufbauen
    $az_result = @mysql_query('SELECT * FROM game_rennen_ende ORDER BY ende DESC');
    $az_vr = @mysql_num_rows($az_result);
    $tmp_navigation = '<a href="index.php?c=rennen&d=new">{RENNEN_NEW_RACE}</a>';
    if(!empty($az_vr)) { $tmp_navigation .= ' | <a href="index.php?c=rennen&d=watch">{RENNEN_WATCH_RACE}</a>'; }
    if($tmp_user_is_on_race == TRUE && ($user_is_in_race['time'] - 300) >= time()) { $tmp_navigation .= ' | <a href="index.php?c=rennen&d=cancel">{RENNEN_CANCEL_RACE}</a>'; }
    if(!empty($tmp_user_is_in_race)) { $tmp_navigation .= ' | <a href="index.php?c=rennen&d=watch&rid=' . $tmp_user_is_in_race . '">{RENNEN_JUMP_TO_RACE}</a>'; }
    // Bereich anzeigen
    switch($FormVars['d']) {
        case 'start':
            if(!empty($FormVars['rid'])) {
                $tmp_sql = array();
                while($tmp_rn = @mysql_fetch_array($rennen)) { if($tmp_rn['id'] == $FormVars['rid']) { $rennen_info = $tmp_rn; } }
                if($rennen_info['user_id'] == $_SESSION['userid']) {
                    $tmp_starting = time() + 60;
                    $angemeldet = explode('#', $rennen_info['drivers']);
                    for($x=0;$x!=count($angemeldet);$x++) { $driver = explode(';', $angemeldet[$x]); $tmp_sql[] = 'UPDATE game_busy SET ende="' . $tmp_starting . '" WHERE user_id="' . $driver[0] . '"'; }
                    $tmp_sql[] = 'UPDATE game_rennen SET time="' . $tmp_starting . '" WHERE id="' . $FormVars['rid'] . '"';
                    $tmp_sql_ok = 0; for($x=0;$x!=count($tmp_sql);$x++) { if(@mysql_query($tmp_sql[$x])) { $tmp_sql_ok++; } }
                    if($tmp_sql_ok == count($tmp_sql)) {
                        $ERROR['power'] = true; $tmp_nr = "23";
                    } else { $ERROR['power'] = true; $tmp_nr = "05"; }
                } else { $ERROR['power'] = true; $tmp_nr = "22"; }
            }
            break;

        case 'watch':
            if(!empty($az_vr)) {
                if(!empty($FormVars['rid'])) {
                    $rennen = @mysql_fetch_array(@mysql_query('SELECT * FROM game_rennen_ende WHERE id="' . $FormVars['rid'] . '" LIMIT 1'));
                    $streckeninfo = @mysql_fetch_array(@mysql_query('SELECT * FROM game_strecken WHERE id="' . $rennen['strecke'] . '" LIMIT 1'));
                    $tmp_tn = explode('|', $rennen['plazierung']);
                    $tmp_color = array( array( '#B8860B', '#9932CC' ),
                                        array( '#9932CC', '#A0522D', '#B8860B' ),
                                        array( '#A0522D', '#008080', '#B8860B', '#9932CC' ),
                                        array( '#008080', '#808000', '#B8860B', '#9932CC', '#A0522D' ),
                                        array( '#808000', '#800080', '#B8860B', '#9932CC', '#A0522D', '#008080' ),
                                        array( '#800080', '#B8860B', '#B8860B', '#9932CC', '#A0522D', '#008080', '#808000' ),
                                        array( '#B8860B', '#9932CC', '#A0522D', '#008080', '#808000', '#800080', '#B8860B', '#FFFF00' ),
                                        array( '#B8860B', '#9932CC', '#A0522D', '#008080', '#808000', '#800080', '#B8860B', '#FFFF00', '#FF00FF' ),
                                        array( '#B8860B', '#9932CC', '#A0522D', '#008080', '#808000', '#800080', '#B8860B', '#FFFF00', '#FF00FF', '#5F9EA0' ),
                                        array( '#B8860B', '#9932CC', '#A0522D', '#008080', '#808000', '#800080', '#B8860B', '#FFFF00', '#FF00FF', '#5F9EA0', '#32CD32' ),
                                        array( '#B8860B', '#9932CC', '#A0522D', '#008080', '#808000', '#800080', '#B8860B', '#FFFF00', '#FF00FF', '#5F9EA0', '#32CD32', '#FFA07A' ),
                                        array( '#B8860B', '#9932CC', '#A0522D', '#008080', '#808000', '#800080', '#B8860B', '#FFFF00', '#FF00FF', '#5F9EA0', '#32CD32', '#FFA07A', '#0000FF' ),
                                        array( '#B8860B', '#9932CC', '#A0522D', '#008080', '#808000', '#800080', '#B8860B', '#FFFF00', '#FF00FF', '#5F9EA0', '#32CD32', '#FFA07A', '#0000FF', '#6B8E23' ),
                                        array( '#B8860B', '#9932CC', '#A0522D', '#008080', '#808000', '#800080', '#B8860B', '#FFFF00', '#FF00FF', '#5F9EA0', '#32CD32', '#FFA07A', '#0000FF', '#6B8E23', '#20B2AA' ),
                                        array( '#B8860B', '#9932CC', '#A0522D', '#008080', '#808000', '#800080', '#B8860B', '#FFFF00', '#FF00FF', '#5F9EA0', '#32CD32', '#FFA07A', '#0000FF', '#6B8E23', '#20B2AA', '#483D8B' ),
                                        array( '#B8860B', '#9932CC', '#A0522D', '#008080', '#808000', '#800080', '#B8860B', '#FFFF00', '#FF00FF', '#5F9EA0', '#32CD32', '#FFA07A', '#0000FF', '#6B8E23', '#20B2AA', '#483D8B', '#CD853F' ),
                                        array( '#B8860B', '#9932CC', '#A0522D', '#008080', '#808000', '#800080', '#B8860B', '#FFFF00', '#FF00FF', '#5F9EA0', '#32CD32', '#FFA07A', '#0000FF', '#6B8E23', '#20B2AA', '#483D8B', '#CD853F', '#BC8F8F' ),
                                        array( '#B8860B', '#9932CC', '#A0522D', '#008080', '#808000', '#800080', '#B8860B', '#FFFF00', '#FF00FF', '#5F9EA0', '#32CD32', '#FFA07A', '#0000FF', '#6B8E23', '#20B2AA', '#483D8B', '#CD853F', '#BC8F8F', '#D2691E' ),
                                        array( '#B8860B', '#9932CC', '#A0522D', '#008080', '#808000', '#800080', '#B8860B', '#FFFF00', '#FF00FF', '#5F9EA0', '#32CD32', '#FFA07A', '#0000FF', '#6B8E23', '#20B2AA', '#483D8B', '#CD853F', '#BC8F8F', '#D2691E', '#008080' ),
                                        array( '#B8860B', '#9932CC', '#A0522D', '#008080', '#808000', '#800080', '#B8860B', '#FFFF00', '#FF00FF', '#5F9EA0', '#32CD32', '#FFA07A', '#0000FF', '#6B8E23', '#20B2AA', '#483D8B', '#CD853F', '#BC8F8F', '#D2691E', '#008080', '#000000' ) );
                    $std_clr = $tmp_color[(count($tmp_tn)-2)];
                    $teilnehmer = ''; $last_x = 0;
                    for($x=0;$x!=count($tmp_tn);$x++) {
                        $tmp_fahrer = explode(':', $tmp_tn[$x]);
                        $userinfo = @mysql_fetch_array(@mysql_query('SELECT nick FROM game_user WHERE id="' . $tmp_fahrer[0] . '" LIMIT 1'));
                        if($tmp_fahrer[0] > $last_x) {
                            if(!empty($x)) { $teilnehmer .= ', '; }
                            $teilnehmer .= '<a href="index.php?c=profil&id=' . $tmp_fahrer[0] . '"><font color="' . $std_clr[$x] . '">' . $userinfo['nick'] . '</font></a>';
                        } else {
                            if(!empty($x)) { $tmp_komme = ', '; }
                            $teilnehmer = '<a href="index.php?c=profil&id=' . $tmp_fahrer[0] . '"><font color="' . $std_clr[$x] . '">' . $userinfo['nick'] . '</font></a>' . $tmp_komme . $teilnehmer;
                        }
                        $driver_x[$tmp_fahrer[0]] = $x;
                        $usertime[$x] = $tmp_fahrer[1];
                        $last_x = $tmp_fahrer[0];
                    }
                    $aktuell = array();
                    $crashes = '';
                    $runden = explode('*', $rennen['rennergebnis']);
                    for($x=0;$x!=count($runden);$x++) {
                        $events = explode('#', $runden[$x]);
                        for($i=0;$i!=count($events);$i++) {
                            #[FeldTyp|FahrerID|Event|EventID|KmAngabe]
                            $unfall = explode('|', $events[$i]);
                            $aktuell[$driver_x[$unfall[1]]] = ($streckeninfo['lenght'] * count($runden)) * (1 - (($rennen['ende'] - time()) / $rennen['dauer']));
                            if(($unfall[4] + ($streckeninfo['lenght'] * $x)) <= $aktuell[$driver_x[$unfall[1]]]) {
                                if($unfall[2] != '-') {
                                    $userinfo = @mysql_fetch_array(@mysql_query('SELECT nick FROM game_user WHERE id="' . $unfall[1] . '" LIMIT 1'));
                                    if(empty($unfall[2])) {
                                        $crashes .= '<tr><td width="100%">[' . number_format((($unfall[4] + ($streckeninfo['lenght'] * $x)) / 1000),1,".",".") . ' km] <font color="' . $std_clr[$driver_x[$unfall[1]]] . '">' . $hindernisse[$unfall[3]] . '</font></td></tr>';
                                        $crash[$driver_x[$unfall[1]]] += 5;
                                    } else {
                                        $crashes .= '<tr><td width="100%">[' . number_format((($unfall[4] + ($streckeninfo['lenght'] * $x)) / 1000),1,".",".") . ' km] <font color="' . $std_clr[$driver_x[$unfall[1]]] . '"> ' . $unfaelle[$unfall[3]] . '</font></td></tr>';
                                        $crash[$driver_x[$unfall[1]]] += 2.5;
                                    }
                                    $crashes = str_replace('{USER}', $userinfo['nick'], $crashes);
                                }
                            } else { break(2); }
                        }
                    }
                    $finished = 0;
                    for($x=0;$x!=count($tmp_tn);$x++) {
                        $tmp_drvinfo = explode(':', $tmp_tn[$x]);
                        $rundenlaenge = $streckeninfo['lenght'];
                        $gesamtlaenge = $rundenlaenge * count($runden);
                        $restzeit = $rennen['ende'] - time();
                        $rennzeit = $rennen['dauer'];
                        $unfall = $crash[$x];
                        if($restzeit <= -30) { $finished++; }
                        $fs_now = round((($gesamtlaenge * (($restzeit + $unfall) / $rennzeit)) / $gesamtlaenge) * 100, 2);
                        $fs_rest = round((100 - $fs_now), 2);
                        if($tmp_drvinfo[0] > $last_x) {
                            $fortschritt .= '<tr><td width="100%"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td width="' . $fs_rest . '%" height="5" bgcolor="' . $std_clr[$x] . '"></td><td width="' . $fs_now . '%" height="5" bgcolor="black"></td></tr></table></td></tr>';
                        } else {
                            $fortschritt = '<tr><td width="100%"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td width="' . $fs_rest . '%" height="5" bgcolor="' . $std_clr[$x] . '"></td><td width="' . $fs_now . '%" height="5" bgcolor="black"></td></tr></table></td></tr>' . $fortschritt;
                        }
                        $last_x = $tmp_drvinfo[0];
                    }
                    $tmp_content = loadTemplate( DIR_T_H_GAME, 'rennen_watch_details', EXT_TEMPS );
                    if($finished == count($tmp_tn)) {
                        $tmp_wins_content = '';
                        $tmp = explode('|', $rennen['plazierung']);
                        $got_rekord = FALSE;
                        for($x=0,$r=1;$x!=count($tmp);$x++,$r++) {
                            $info = explode(':', $tmp[$x]);
                            $rekord_result = @mysql_query('SELECT * FROM game_rekorde WHERE runden="' . count($runden) . '" && strecken_id="' . $rennen['strecke'] . '" LIMIT 1');
                            $rekord_anzahl = @mysql_num_rows($rekord_result);
                            if(!empty($rekord_anzahl)) { $tmp_rekord = @mysql_fetch_array($rekord_result); } else { $tmp_rekord['time'] = 0; }
                            $is_rekord = checkFRekord( $tmp_rekord['time'], $info[1] );
                            if($got_rekord == FALSE && $is_rekord == 1) { if(!empty($rekord_anzahl)) { $sql_rkd = 'UPDATE game_rekorde SET user_id="' . $info[0] . '", time="' . $info[1] . '", zeit="' . time() . '" WHERE id="' . $tmp_rekord['id'] . '"'; } else { $sql_rkd = 'INSERT INTO game_rekorde VALUES("", "' . $info[0] . '", "' . $rennen['strecke'] . '", "' . count($runden) . '", "' . $info[1] . '", "' . time() . '")'; } @mysql_query($sql_rkd); $got_rekord = TRUE; } else { if($is_rekord == 2) { $got_rekord = TRUE; } }
                            if($got_rekord == TRUE) { $tmp_rekord_content = '<tr><td width="100%" align="center" colspan="4">&nbsp;</td></tr><tr><td width="100%" align="center" colspan="4"><font color="lime">{RENNEN_NEW_REKORD}</a></td></tr>'; }
                            $userinfo = @mysql_fetch_array(@mysql_query('SELECT nick FROM game_user WHERE id="' . $info[0] . '" LIMIT 1'));
                            $tmp_time = getZeit($info[1]);
                            $tmp_gewinn = number_format($info[2],2,",",".") . $DEFAULTS['game']['waehrung'];
                            $tmp_wins_content .= '<tr><td width="15%" align="right">' . $r . '.</td>
                                                  <td width="45%" align="left">&nbsp;<a href="index.php?c=profil&id=' . $info[0] . '"><font color="' . $std_clr[$x] . '">' . $userinfo['nick'] . '</font></a></td>
                                                  <td width="20%" align="left"><font color="' . $std_clr[$x] . '">' . $tmp_time . '</font></td>
                                                  <td width="20%" align="center"><font color="' . $std_clr[$x] . '">' . $tmp_gewinn . '</font></td></tr>';
                        }
                        $tmp_content_race = array2text(     loadTemplate( DIR_T_H_GAME, 'rennen_watch_details_winner', EXT_TEMPS ),
                                                            array( '{RENNEN_WINS_CONTENT}'  => $tmp_wins_content . $tmp_rekord_content )
                                                      );
                    } else {
                        $tmp_content_race = array2text(     loadTemplate( DIR_T_H_GAME, 'rennen_watch_details_race', EXT_TEMPS ),
                                                            array(  '{RENNEN_VLU_FORTSCHRITT}'  => $fortschritt,
                                                                    '{RENNEN_VLU_CRASHES}'      => $crashes,
                                                                    '{RENNEN_WATCH_URL}'        => 'index.php?c=rennen&d=watch&rid=' . $FormVars['rid']
                                                                 )
                                                      );
                    }
					if(!file_exists("temp/strecke_".$FormVars['rid'])) { include("_create_rennen_bild.php"); }
					$bild = "temp/strecke_".$FormVars['rid'].".png";
                    $tmp_vars = array(      '{RENNEN_WATCH_HINWEIS}'        => $LANG['game']['rennen']['{RENNEN_WATCH_HINWEIS}'],
                                            '{RENNEN_VLU_STRECKENNAME}'     => $streckeninfo['name'],
                                            '{RENNEN_VLU_TRAFFIC}'          => $streckeninfo['traffic'],
                                            '{RENNEN_VLU_START}'            => date("H:i", ($rennen['ende'] - $rennen['dauer'])),
                                            '{RENNEN_VLU_ENDE}'             => date("H:i", $rennen['ende']),
                                            '{RENNEN_VLU_LENGHT}'           => number_format(($streckeninfo['lenght'] * count($runden) / 1000),2,",",".") . 'km',
                                            '{RENNEN_VLU_TEILNEHMER}'       => $teilnehmer,
                                            '{RENNEN_VLU_CONTENT}'          => $tmp_content_race,
											'{RENNEN_WATCH_BILD}'		    => $bild                );
                } else {
                    $tmp_content = loadTemplate( DIR_T_H_GAME, 'rennen_watch', EXT_TEMPS );
                    $tmp_rennen_content = '';
                    while($rennen_info = @mysql_fetch_array($az_result)) {
                        $start = $rennen_info['ende'] - $rennen_info['dauer'];
                        if(date('d.m.Y') != date('d.m.Y', $start)) { $tmp_start = date('d.m.Y', $start); } else { $tmp_start = date('H:i', $start); }
                        $strecken_info = @mysql_fetch_array(@mysql_query('SELECT * FROM game_strecken WHERE id="' . $rennen_info['strecke'] . '" LIMIT 1'));
                        $tmp = explode("#", $rennen_info['plazierung']); $tmp_rennen_content .= '<tr><td width="20%" align="center">' . $tmp_start . '</td><td width="30%" align="left">&nbsp;' . $strecken_info['name'] . '</td><td width="20%" align="center">ca. ' . round($rennen_info['dauer'] / 60, 0) . ' Min.</td><td width="20%" align="center">' . number_format($rennen_info['gewinn'],2,",",".") . $DEFAULTS['game']['waehrung'] . '</td><td width="10%" align="center" valign="middle"><a href="index.php?c=rennen&d=watch&rid=' . $rennen_info['id'] . '"><img src="' . DIR_T_I_ICONS . 'show.gif" border="0"></a></td></tr>';
                    }
                    $tmp_vars = array(      '{RENNEN_WATCH_HINWEIS}'    => $LANG['game']['rennen']['{RENNEN_WATCH_HINWEIS}'],
                                            '{RENNEN_VLU_START}'        => '<a href="index.php?c=rennen&d=watch&sort=start">{RENNEN_GESTARTZEITPUNKT}</a>',
                                            '{RENNEN_VLU_STRECKE}'      => '<a href="index.php?c=rennen&d=watch&sort=strecke">{RENNEN_STRECKE}</a>',
                                            '{RENNEN_VLU_DAUER}'        => '<a href="index.php?c=rennen&d=watch&sort=dauer">{RENNEN_DAUER}</a>',
                                            '{RENNEN_VLU_GEWINN}'       => '{RENNEN_GEWINN}',
                                            '{RENNEN_OPENED_CONTENT}'   => $tmp_rennen_content                                                      );
                }
            } else { $ERROR['power'] = true; $tmp_nr = "19"; }
            break;

        case 'new':
            if($tmp_user_is_on_race == FALSE) {
                $anzahl = @mysql_num_rows(@mysql_query('SELECT * FROM game_busy WHERE user_id="' . $_SESSION['userid'] . '" LIMIT 1'));
                if(empty($anzahl)) {
                    $sql = 'SELECT * FROM game_strecken ORDER BY starts ASC';
                    $result = @mysql_query($sql);
                    $anzahl = @mysql_num_rows($result);
                    $tmp_strecken = '';
                    $tmp_mietgebuehr = ($DEFAULTS['game']['miet_gebuehr'] + ($DEFAULTS['game']['miet_gebuehr'] * $ucar_info['klasse']));
                    $tmp_bild = '{RENNEN_NO_BILD}';
                    if(!empty($anzahl)) {
                        if(!isset($FormVars['p_strecke'])) { $tmp_strecken .= '<option selected>{RENNEN_NEW_CH_STRECKE}</option>'; }
                        for($x=0;$x!=$anzahl;$x++) { @mysql_data_seek($result, $x); $ak_strecken = @mysql_fetch_array($result); if($ak_strecken['id'] == $FormVars['p_strecke'] && isset($FormVars['p_strecke'])) { $tmp_sl = ' selected'; } else { $tmp_sl = ''; } $tmp_strecken .= '<option value="' . $ak_strecken['id'] . '" ' . $tmp_sl . '>' . $ak_strecken['name'] . '</option>'; }
                    } else { $tmp_strecken = '<option selected>{RENNEN_NEW_NO_STRECKEN}</option>'; }
                    if(isset($FormVars['p_strecke'])) {
                        $klassen = array( 'A', 'B', 'C', 'D', 'E' );
                        $tmp_klasse_op .= '';
                        for($x=$ucar_info['klasse'];$x!=count($klassen);$x++) { $tmp_klasse_op .= '<option value="' . $x . '">' . $klassen[$x] . '</option>'; }
                        $strecken_info = @mysql_fetch_array(@mysql_query('SELECT * FROM game_strecken WHERE id="' . $FormVars['p_strecke'] . '" LIMIT 1'));
                        if(!empty($strecken_info['name'])) {
                            if(!empty($FormVars['check'])) {
                                if($user_info['money'] >= ($FormVars['p_einsatz'] + $tmp_gebuehr)) {
                                    if(is_numeric($FormVars['p_hour']) && is_numeric($FormVars['p_min']) && isset($FormVars['p_hour']) && isset($FormVars['p_min'])) {
                                        if(is_numeric($FormVars['p_platz']) && isset($FormVars['p_platz'])) {
                                            if(is_numeric($FormVars['p_runden']) && isset($FormVars['p_runden'])) {
                                                if(is_numeric($FormVars['p_einsatz']) && isset($FormVars['p_einsatz']) && $FormVars['p_einsatz'] >= $DEFAULTS['game']['race_gebuehr']) {
                                                    if(is_numeric($FormVars['p_maxruf']) && isset($FormVars['p_maxruf'])) {
                                                        if(is_numeric($FormVars['p_maxansehen']) && isset($FormVars['p_maxansehen'])) {
                                                            if(is_numeric($FormVars['p_maxstyle']) && isset($FormVars['p_maxstyle'])) {
                                                                $tmp_treibstoff = ceil((round($strecken_info['lenght'] * $FormVars['p_runden'], 0) / 10000));
                                                                if($garage_info['car_tank'] >= $tmp_treibstoff) {
                                                                    if(!empty($FormVars['p_schnellstart'])) { $tmp_read2go = 1; } else { $tmp_read2go = 0; }
                                                                    $tmp_startpunkt = mktime($FormVars['p_hour'], $FormVars['p_min'], rand(1, 59), date("m"), date("d"), date("Y"));
                                                                    $zeit = time(); if($FormVars['p_hour'] == 24) { $FormVars['p_hour'] = '00'; } if($FormVars['p_hour'] < date("H")) { $zeit += (24 * 3600); }
                                                                    $tmp_tag = date("d", $zeit);
                                                                    $tmp_monat = date("m", $zeit);
                                                                    $tmp_jahr = date("Y", $zeit);
                                                                    $tmp_startpunkt = mktime($FormVars['p_hour'], $FormVars['p_min'], rand(1, 59), $tmp_monat, $tmp_tag, $tmp_jahr);
                                                                    $tmp_sql = array(); $tmp_sql_ok = 0;
                                                                    $tmp_sql[] = 'UPDATE game_user SET money="' . ($user_info['money'] - ($FormVars['p_einsatz'] + $tmp_mietgebuehr)) . '" WHERE id="' . $_SESSION['userid'] . '"';
                                                                    $tmp_sql[] = 'INSERT INTO game_rennen VALUES("", "' . $FormVars['p_strecke'] . '", "' . $_SESSION['userid'] . '", "' . $FormVars['p_maxruf'] . '", "' . $FormVars['p_maxansehen'] . '", "' . $FormVars['p_maxstyle'] . '", "' . $FormVars['p_klasse'] . '", "' . $FormVars['p_runden'] . '", "' . $_SESSION['userid'] . ';' . $user_info['now_car'] . '", "' . $FormVars['p_platz'] . '", "' . $tmp_startpunkt . '", "' . $FormVars['p_einsatz'] . '", "' . $tmp_read2go . '")';
                                                                    $tmp_sql[] = 'INSERT INTO game_busy VALUES("", "' . $_SESSION['userid'] . '", "' . $tmp_startpunkt . '", "8", "0", "0", "0")';
                                                                    for($x=0;$x!=count($tmp_sql);$x++) { if(@mysql_query($tmp_sql[$x])) { $tmp_sql_ok++; } }
                                                                    if($tmp_sql_ok == count($tmp_sql)) {
                                                                        $ERROR['power'] = true; $tmp_nr = "16";
                                                                    } else { $ERROR['power'] = true; $tmp_nr = "05"; }
                                                                } else { $ERROR['power'] = true; $tmp_nr = "04"; }
                                                            } else { $ERROR['power'] = true; $tmp_nr = "15"; }
                                                        } else { $ERROR['power'] = true; $tmp_nr = "14"; }
                                                    } else { $ERROR['power'] = true; $tmp_nr = "13"; }
                                                } else { $ERROR['power'] = true; $tmp_nr = "12"; }
                                            } else { $ERROR['power'] = true; $tmp_nr = "11"; }
                                        } else { $ERROR['power'] = true; $tmp_nr = "10"; }
                                    } else { $ERROR['power'] = true; $tmp_nr = "09"; }
                                } else { $ERROR['power'] = true; $tmp_nr = "18"; }
                            } else {
                                // Stunden zusammensetzen
                                $start = time() + 3600; $tmp_jumped = FALSE; for($x=1;$x<=12;$x++) { if(date("i", $start) >= 50 && $tmp_jumped == FALSE) { $start += 1800; $tmp_jumped = TRUE; } $zahl = date("H", $start); $tmp_hour_op .= '<option value="' . $zahl . '">' . $zahl . '</option>'; $start += 3600; }
                                // Minuten zusammensetzen
                                for($x=0;$x!=55;$x+=5) { $time = date("i") + ($x * 60); $zahl = date("i", $time); $tmp_mins_op .= '<option value="' . $zahl . '">' . $zahl . '</option>'; }
                                // Optionen für die Startplätze generieren
                                for($x=2;$x<=20;$x++) { if($x <= 9) { $x = "0" . $x; } $tmp_platz_op .= '<option value="' . $x . '">' . $x . '</option>'; }
                                // Optionen für die Runden generieren
                                for($x=1;$x<=10;$x++) { if($x <= 9) { $x = "0" . $x; } $tmp_runden_op .= '<option value="' . $x . '">' . $x . '</option>'; }
                                // Optionen für den/das Maximalen Ruf/Ansehen/Style generieren
                                $tmp_um = @mysql_fetch_array(@mysql_query('SELECT COUNT(game_user.id) AS user, MAX(game_user.ruf) AS max_ruf, MAX(game_user.ansehen) AS max_ansehen, MAX(game_user.style) AS max_style FROM game_user'));
                                for($x=$user_info['ruf'];$x<=$tmp_um['max_ruf'];$x++) { if($x == $FormVars['p_maxruf'] && isset($FormVars['p_maxruf'])) { $tmp_sl = ' selected'; } else { $tmp_sl = ''; } if($x <= 9) { $x = "0" . $x; } $tmp_mruf_op .= '<option value="' . $x . '"' . $tmp_sl . '>' . $x . '</option>'; }
                                for($x=$user_info['ansehen'];$x<=$tmp_um['max_ansehen'];$x++) { if($x == $FormVars['p_maxansehen'] && isset($FormVars['p_maxansehen'])) { $tmp_sl = ' selected'; } else { $tmp_sl = ''; } if($x <= 9) { $x = "0" . $x; } $tmp_mansehen_op .= '<option value="' . $x . '"' . $tmp_sl . '>' . $x . '</option>'; }
                                for($x=$user_info['style'];$x<=$tmp_um['max_style'];$x++) { if($x == $FormVars['p_maxstyle'] && isset($FormVars['p_maxstyle'])) { $tmp_sl = ' selected'; } else { $tmp_sl = ''; } if($x <= 9) { $x = "0" . $x; } $tmp_mstyle_op .= '<option value="' . $x . '"' . $tmp_sl . '>' . $x . '</option>'; }
    							$t_bild = DIR_T_I_SIGNS . 'strecke_' . $FormVars['rid'] . '.png';
                                if(file_exists($t_bild)) { $tmp_bild = '<img src="' . $t_bild . '" border="0">'; }
                                $tmp_type           = $LANG['streckennames'][$strecken_info['type']];
                                $tmp_lenght         = number_format($strecken_info['lenght'],1,",",".");
                                $tmp_traffic        = $strecken_info['traffic'];
                                $tmp_slct           = '';
                            }
                        } else { $ERROR['power'] = true; $tmp_nr = "02"; }
                    } else {
                        $tmp_type           = '<option>-</option>';
                        $tmp_lenght         = '<option>-</option>';
                        $tmp_traffic        = '<option>-</option>';
                        $tmp_hour_op        = '<option>-</option>';
                        $tmp_mins_op        = '<option>-</option>';
                        $tmp_platz_op       = '<option>-</option>';
                        $tmp_runden_op      = '<option>-</option>';
                        $tmp_mruf_op        = '<option>-</option>';
                        $tmp_mansehen_op    = '<option>-</option>';
                        $tmp_mstyle_op      = '<option>-</option>';
                        $tmp_klasse_op      = '<option>-</option>';   
                        $tmp_slct           = ' disabled';
                    }
                    $tmp_vars = array(      '{RENNEN_NEW_BILD}'         => $tmp_bild,
                                            '{RENNEN_VLU_TYPE}'         => $tmp_type,
                                            '{RENNEN_VLU_LENGHT}'       => $tmp_lenght . 'm',
                                            '{RENNEN_VLU_TRAFFIC}'      => $tmp_traffic . '%',
                                            '{RENNEN_VLU_STRECKE_OP}'   => $tmp_strecken,
                                            '{RENNEN_VLU_HOUR_OP}'      => $tmp_hour_op,
                                            '{RENNEN_VLU_MINS_OP}'      => $tmp_mins_op,
                                            '{RENNEN_VLU_PLATZ_OP}'     => $tmp_platz_op,
                                            '{RENNEN_VLU_RUNDEN_OP}'    => $tmp_runden_op,
                                            '{RENNEN_VLU_MRUF_OP}'      => $tmp_mruf_op,
                                            '{RENNEN_VLU_MANSEHEN_OP}'  => $tmp_mansehen_op,
                                            '{RENNEN_VLU_MSTYLE_OP}'    => $tmp_mstyle_op,
                                            '{RENNEN_VLU_KLASSE_OP}'    => $tmp_klasse_op,
                                            '{RENNEN_VLU_SLCT}'         => $tmp_slct,
                                            '{RENNEN_VLU_EXT}'          => $DEFAULTS['game']['waehrung'],
                                            '{RENNEN_VLU_MIETGEBUEHR}'  => number_format($tmp_mietgebuehr,2,",",".") . $DEFAULTS['game']['waehrung'],
                                            '{RENNEN_VLU_STRECKE}'      => $FormVars['p_strecke']
                                     );
                    $tmp_content = loadTemplate( DIR_T_H_GAME, 'rennen_new', EXT_TEMPS );
                } else { $ERROR['power'] = true; $tmp_nr = "17"; }
            } else { $ERROR['power'] = true; $tmp_nr = "02"; }
            break;

        case 'cancel':
            if($tmp_user_is_on_race == TRUE) {
                if(($user_is_in_race['time'] - 300) >= time()) {
                    if(!empty($FormVars['check'])) {
                        $tmp = explode("#", $user_is_in_race['drivers']);
                        $tmp_new_drivers = '';
                        $tmp_sql = array(); $tmp_sql_ok = 0;
                        if($user_is_in_race['user_id'] == $_SESSION['userid']) {
                            for($x=0;$x!=count($tmp);$x++) { $tmp1 = explode(";", $tmp[$x]); $tmp_sql[] = 'DELETE FROM game_busy WHERE user_id="' . $tmp1[0] . '"'; }
                            $tmp_sql[] = 'DELETE FROM game_rennen WHERE id="' . $user_is_in_race['id'] . '"';
                        } else {
                            for($x=0;$x!=count($tmp);$x++) { $tmp1 = explode(";", $tmp[$x]); if($tmp1[0] != $_SESSION['userid']) { if(!empty($x)) { $tmp_new_drivers .= "#"; } $tmp_new_drivers .= $tmp1[0] . ';' . $tmp1[1]; } }
                            $tmp_sql[] = 'DELETE FROM game_busy WHERE user_id="' . $_SESSION['userid'] . '"';
                            $tmp_sql[] = 'UPDATE game_rennen SET drivers="' . $tmp_new_drivers . '" WHERE id="' . $user_is_in_race['id'] . '"';
                        }
                        $tmp_sql[] = 'UPDATE game_user SET money="' . ($user_info['money'] + $user_is_in_race['einsatz']) . '" WHERE id="' . $_SESSION['userid'] . '"';
                        for($x=0;$x!=count($tmp_sql);$x++) { if(@mysql_query($tmp_sql[$x])) { $tmp_sql_ok++; } }
                        if($tmp_sql_ok == count($tmp_sql)) {
                            $ERROR['power'] = true; $tmp_nr = "07";
                        } else { $ERROR['power'] = true; $tmp_nr = "05"; }
                    } else {
                        $tmp_content = loadTemplate( DIR_T_H_GAME, 'rennen_question', EXT_TEMPS );
                        $tmp_vars = array(      '{RENNEN_VLU_QUESTION}'     => '{RENNEN_QUST_01}',
                                                '{RENNEN_VLU_YES_URL}'      => 'index.php?c=rennen&d=cancel&check=1',
                                                '{RENNEN_VLU_NO_URL}'       => 'index.php?c=rennen'         );
                    }
                } else { $ERROR['power'] = true; $tmp_nr = "24"; }
            } else { $ERROR['power'] = true; $tmp_nr = "02"; }
            break;

        case 'raceit':
            if(!empty($FormVars['rid'])) {
                if($tmp_user_is_on_race == FALSE) {
                    $anzahl = @mysql_num_rows(@mysql_query('SELECT * FROM game_busy WHERE user_id="' . $_SESSION['userid'] . '" LIMIT 1'));
                    if(empty($anzahl)) {
                        if(!empty($user_info['now_car'])) {
                            while($tmp_rn = @mysql_fetch_array($rennen)) { if($tmp_rn['id'] == $FormVars['rid']) { $rennen_info = $tmp_rn; break(1); } }
                            if($user_info['ruf'] <= $rennen_info['max_ruf'] && $user_info['ansehen'] <= $rennen_info['max_ansehen'] && $user_info['style'] <= $rennen_info['max_style']) {
                                $car_info = @mysql_fetch_array(@mysql_query('SELECT * FROM game_garage WHERE id="' . $user_info['now_car'] . '" LIMIT 1'));
                                $cinfo = @mysql_fetch_array(@mysql_query('SELECT * FROM game_cars WHERE id="' . $car_info['car_id'] . '" LIMIT 1'));
                                if($cinfo['klasse'] <= $rennen_info['klasse']) {
                                    $strecken_info = @mysql_fetch_array(@mysql_query('SELECT * FROM game_strecken WHERE id="' . $rennen_info['strecken_id'] . '" LIMIT 1'));
        							if($user_info['money']>=($rennen_info['einsatz'] + $tmp_gebuehr))	{
        								if($car_info['car_tank'] >= ceil((round($rennen_info['lenght'] * $strecken_info['runden'], 0) / 10))) {
        									$tmp_new_drivers = $rennen_info['drivers'] . '#' . $_SESSION['userid'] . ';' . $user_info['now_car'];
        									$tmp_sql = array(); $tmp_sql_ok = 0;
        									$tmp_sql[] = 'UPDATE game_rennen SET drivers="' . $tmp_new_drivers . '" WHERE id="' . $rennen_info['id'] . '"';
        									$tmp_sql[] = 'UPDATE game_user SET money="' . ($user_info['money'] - ($rennen_info['einsatz'] + $tmp_gebuehr)) . '" WHERE id="' . $_SESSION['userid'] . '"';
        									$tmp_sql[] = 'INSERT INTO game_busy VALUES("", "' . $_SESSION['userid'] . '", "' . $rennen_info['time'] . '", "8", "0", "0", "0")';
        									for($x=0;$x!=count($tmp_sql);$x++) { if(@mysql_query($tmp_sql[$x])) { $tmp_sql_ok++; } }
        									if($tmp_sql_ok == count($tmp_sql)) {
        										$ERROR['power'] = true; $tmp_nr = "06";
        									} else { $ERROR['power'] = true; $tmp_nr = "06"; }
        								} else { $ERROR['power'] = true; $tmp_nr = "04"; }
        							} else { $ERROR['power'] = true; $tmp_nr = "18"; }
    							} else { $ERROR['power'] = true; $tmp_nr = "21"; }
                            } else { $ERROR['power'] = true; $tmp_nr = "20"; }
                        } else { $ERROR['power'] = true; $tmp_nr = "03"; }
                    } else { $ERROR['power'] = true; $tmp_nr = "17"; }
                } else { $ERROR['power'] = true; $tmp_nr = "02"; }
            }
            break;

        case 'show':
            while($tmp_rn = @mysql_fetch_array($rennen)) { if($tmp_rn['id'] == $FormVars['rid']) { $rennen_info = $tmp_rn; } }
            if(!empty($rennen_info['user_id'])) {
                $hoster_info = @mysql_fetch_array(@mysql_query('SELECT * FROM game_user WHERE id="' . $rennen_info['user_id'] . '" LIMIT 1'));
                $tmp_content = loadTemplate( DIR_T_H_GAME, 'rennen_show', EXT_TEMPS );
                $tmp_bild = DIR_T_I_SIGNS . 'strecke_' . $tmp_rn['id'] . '.jpg';
                if(file_exists($tmp_bild)) { $tmp_bild = '<img src="' . $tmp_bild . '" border="0">'; } else { $tmp_bild = '{RENNEN_NO_BILD}'; }
                $tmp_driver = '';
                $tmp = explode("#", $rennen_info['drivers']);
                for($x=0,$d=1;$x!=count($tmp);$x++,$d++) {
                    $tmp1 = explode(";", $tmp[$x]);
                    $ur_info = @mysql_fetch_array(@mysql_query('SELECT game_user.id AS id, game_user.nick AS nick, game_garage.car_id AS car_id, game_garage.id AS gid FROM game_user INNER JOIN game_garage ON game_user.now_car=game_garage.id WHERE game_user.id="' . $tmp1[0] . '" LIMIT 1'));
                    $cr_info = @mysql_fetch_array(@mysql_query('SELECT name_id FROM game_cars WHERE id="' . $ur_info['car_id'] . '" LIMIT 1'));
                    $tn_info = mysql_fetch_array(mysql_query('SELECT * FROM game_incars WHERE garage_id="' . $tmp1[1] . '" LIMIT 1'));
                    $strecken_info = @mysql_fetch_array(@mysql_query('SELECT * FROM game_strecken WHERE id="' . $rennen_info['strecken_id'] . '" LIMIT 1'));
                    $t = explode("#", $tn_info['tuned']);
                    $tmptund = 0; for($i=0;$i!=count($t);$i++) { $ttt = explode(';', $t[$i]); if($ttt[0] != 'w') { $tmptund++; } }
                    $tmp_tuned = round(($tmptund / count($TUNE)) * 100, 0);
                    $tmp_driver .= '<tr><td width="10%" align="center">' . $d . '.</td><td width="30%" align="left"><a href="index.php?c=profil&id=' . $ur_info['id'] . '">' . $ur_info['nick'] . '</a></td><td width="30%" align="center"><a href="index.php?c=autohaus&d=details&cid=' . $cr_info['name_id'] . '">' . $CARNAME[$cr_info['name_id']] . '</a></td><td width="30%" align="center">' . $tmp_tuned . '%</td></tr>';
                }
                if($rennen_info['ready2go']) { $tmp_ready2go = '{RENNEN_SHOW_FULL2GO}'; }
                if(count($tmp) < $rennen_info['drivers_max'] && $tmp_user_is_on_race == FALSE) { $tmp_button = '<input type="submit" value="{RENNEN_SHOW_BTN_DRIVE}" class="button" onClick="return confirm(\'Bei diesem Rennen wirklich teilnehmen?\'); submit();">'; } else { $tmp_button = ''; }
                $klassen = array( 'A', 'B', 'C', 'D', 'E' );
                $tmp_vars = array(  '{RENNEN_VLU_SHOW_BILD}'    => $tmp_bild,
                                    '{RENNEN_VLU_NAME}'         => $strecken_info['name'],
                                    '{RENNEN_VLU_LENGHT}'       => number_format($strecken_info['lenght'],1,",",".") . ' m',
                                    '{RENNEN_VLU_STARTS}'       => $strecken_info['starts'],
                                    '{RENNEN_VLU_TRAFFIC}'      => $strecken_info['traffic'] . '%',
                                    '{RENNEN_VLU_RENNSTART}'    => date("d.m.Y - H:i", $rennen_info['time']) . $tmp_ready2go,
                                    '{RENNEN_VLU_HOSTER}'       => $hoster_info['nick'],
                                    '{RENNEN_VLU_MAXDRIVER}'    => $rennen_info['drivers_max'],
                                    '{RENNEN_VLU_RUNDEN}'       => $rennen_info['runden'],
                                    '{RENNEN_VLU_EINSATZ}'      => number_format($rennen_info['einsatz'],2,",",".") . $DEFAULTS['game']['waehrung'],
                                    '{RENNEN_VLU_GEBUEHR}'      => number_format($tmp_gebuehr,2,",",".") . $DEFAULTS['game']['waehrung'],
                                    '{RENNEN_VLU_MAXRUF}'       => $rennen_info['max_ruf'],
                                    '{RENNEN_VLU_MAXANSEHEN}'   => $rennen_info['max_ansehen'],
                                    '{RENNEN_VLU_MAXSTYLE}'     => $rennen_info['max_style'],
                                    '{RENNEN_VLU_KLASSE}'       => $klassen[$rennen_info['klasse']],
                                    '{RENNEN_VLU_SHOW_DRIVER}'  => $tmp_driver,
                                    '{RENNEN_VLU_BTN_RACE}'     => $tmp_button,
                                    '{RENNEN_VLU_RACEID}'       => $rennen_info['id']
                                 );
            } else { $ERROR['power'] = true; $tmp_nr = "01"; }
            break;

        default:
            $anzahl = @mysql_num_rows($rennen);
            if(!empty($anzahl)) {
                $tmp_content = loadTemplate( DIR_T_H_GAME, 'rennen_opened', EXT_TEMPS );
                $tmp_rennen_content = '';
                while($rennen_info = @mysql_fetch_array($rennen)) {
                    if(date('d.m.Y') != date('d.m.Y', $rennen_info['time'])) { $tmp_start = date('d.m.Y', $rennen_info['time']); } else { $tmp_start = date('H:i', $rennen_info['time']); }
                    $strecken_info = @mysql_fetch_array(@mysql_query('SELECT * FROM game_strecken WHERE id="' . $rennen_info['strecken_id'] . '" LIMIT 1'));
					$racedrv = explode('#', $rennen_info['drivers']);
					$tmp_startnow = '';
                    if($rennen_info['user_id'] == $_SESSION['userid'] && $rennen_info['time'] >= (time() + 120) && count($racedrv) >= 2) { $tmp_startnow = '<a href="index.php?c=rennen&d=start&rid=' . $rennen_info['id'] . '"><img src="' . DIR_T_I_ICONS . 'race.gif" border="0"></a>'; }
                    $tmp = explode('#', $rennen_info['drivers']);
                    $drivers = count($tmp);
                    $tmp_showrace = '<a href="index.php?c=rennen&d=show&rid=' . $rennen_info['id'] . '"><img src="' . DIR_T_I_ICONS . 'show.gif" border="0"></a>';
                    $tmp_rennen_content .= '<tr><td width="15%" align="center">' . $tmp_start . '</td><td width="20%" align="left">&nbsp;' . $strecken_info['name'] . '</td><td width="15%" align="center">' . $rennen_info['runden'] . '</td><td width="10%" align="center">' . $drivers . '/' . $rennen_info['drivers_max'] . '</td><td width="15%" align="center">' . number_format($rennen_info['einsatz'],2,",",".") . $DEFAULTS['game']['waehrung'] . '</td><td width="15%" align="center">' . number_format($tmp_gebuehr,2,",",".") . $DEFAULTS['game']['waehrung'] . '</td><td width="10%" align="left" valign="middle">' . $tmp_showrace . '&nbsp;' . $tmp_startnow . '</td></tr>';
                }
                $tmp_vars = array(  '{RENNEN_VLU_START}'        => '<a href="index.php?c=rennen&sort=start">{RENNEN_STARTZEITPUNKT}</a>',
                                    '{RENNEN_VLU_STRECKE}'      => '<a href="index.php?c=rennen&sort=strecke">{RENNEN_STRECKE}</a>',
                                    '{RENNEN_VLU_RUNDEN}'       => '<a href="index.php?c=rennen&sort=runden">{RENNEN_RUNDEN}</a>',
                                    '{RENNEN_VLU_FAHRER}'       => '<a href="index.php?c=rennen&sort=maxfahrer">{RENNEN_FAHRER}</a>',
                                    '{RENNEN_VLU_EINSATZ}'      => '<a href="index.php?c=rennen&sort=einsatz">{RENNEN_EINSATZ}</a>',
                                    '{RENNEN_VLU_GEBUEHR}'      => '{RENNEN_GEBUEHR}',
                                    '{RENNEN_OPENED_CONTENT}'   => $tmp_rennen_content                                                      );
            } else { $tmp_content = '{RENNEN_NO_RACES}'; }
            break;
    }

    if($ERROR['power']) {
        // Fehlermeldung übergeben bei einem Fehler
        $vars['error'] = array( '{ERROR_MESSAGE}' => '{RENNEN_ERROR_' . $tmp_nr . '}');
    } else {
        // Template laden
        $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'rennen', EXT_TEMPS );
    }
    // Platzhalter füllen
    $vars['content']        =   array( '{CONTENT}' => $tmp_section_content, '{RENNEN_NAVIGATION}' => $tmp_navigation, '{RENNEN_CONTENT}' => $tmp_content );
    $vars['content']        =   array_merge($vars['content'], $tmp_vars, $LANG['game']['rennen']);
} else {$vars['content']        =   array( '{CONTENT}' => $LANG['root']['verweigert']);}

?>

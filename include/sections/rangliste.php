<?php

if($_SESSION['logged']) {
    // Initialisierung der Suche  
    $tmp_vars = array(); $tmp_sort = FALSE; $z = 1;
    if(strtolower($FormVars['sort']) == 'nickname') { $FormVars['sort'] = 'nick'; $tmp_sort = TRUE; $tmp_dir = 'ASC'; }
    if(strtolower($FormVars['sort']) == 'ansehen') { $FormVars['sort'] = 'ansehen'; $tmp_sort = TRUE; $tmp_dir = 'DESC'; }
    if(strtolower($FormVars['sort']) == 'style') { $FormVars['sort'] = 'style'; $tmp_sort = TRUE; $tmp_dir = 'DESC'; }
    if(strtolower($FormVars['sort']) == 'ruf') { $FormVars['sort'] = 'ruf'; $tmp_sort = TRUE; $tmp_dir = 'DESC'; }
    if(strtolower($FormVars['sort']) == 'siege') { $FormVars['sort'] = 'wins'; $tmp_sort = TRUE; $tmp_dir = 'DESC'; }
    if(strtolower($FormVars['type']) == 'club') { $tmp_userang = FALSE; } else { $tmp_userang = TRUE; }
    if(empty($FormVars['type']) && empty($FormVars['sort'])) { $FormVars['sort'] = 'ansehen'; $tmp_sort = TRUE; $tmp_dir = 'DESC'; }

    // Suche vorbereiten und ausführen
    if($tmp_userang) {
        $tmp_ergebnis = '<tr><td width="5%" align="center" height="30">{RANGLISTE_COUNTER}</td><td width="35%" align="left"><a href="index.php?c=rangliste&sort=nickname">{RANGLISTE_NICKNAME}</a></td><td width="20%" align="left"><a href="index.php?c=rangliste&sort=ansehen">{RANGLISTE_ANSEHEN}</a></td><td width="20%" align="left"><a href="index.php?c=rangliste&sort=style">{RANGLISTE_STYLE}</a></td><td width="10%" align="left"><a href="index.php?c=rangliste&sort=ruf">{RANGLISTE_RUF}</a></td><td width="10%" align="left"><a href="index.php?c=rangliste&sort=siege">{RANGLISTE_SIEGE}</a></td></tr>';
        $sql = 'SELECT * FROM game_user ORDER BY ' . $FormVars['sort'] . ' ' . $tmp_dir;
        $result = @mysql_query($sql);
        while($data = @mysql_fetch_array($result)) {
            $tmp_style = 0;
            $tmp_tune_info = @mysql_fetch_array(@mysql_query('SELECT game_incars.tuned AS tuned FROM game_incars WHERE garage_id="' . $data['now_car'] . '" LIMIT 1'));
            $tmp2 = explode('#', $tmp_tune_info['tuned']); for($i=0;$i!=count($tmp2);$i++) { $ttmp2 = explode(';', $tmp2[$i]); if($ttmp2[0] != 'w') { $tteilinfo = @mysql_fetch_array(@mysql_query('SELECT style FROM game_tuning WHERE name_id="' . $ttmp2[0] . '" && kat_id="' . $i . '" LIMIT 1')); $tmp_style += $tteilinfo['style']; } }
            $tmp_ergebnis .= '<tr><td width="5%" align="center">' . $z . '.</td><td width="35%" align="left"><a href="index.php?c=profil&id=' . $data['id'] . '">' . $data['nick'] . '</a></td><td width="20%" align="left">' . $data['ansehen'] . '</td><td width="20%" align="left">' . $tmp_style . '</td><td width="10%" align="left">' . $data['ruf'] . '</td><td width="10%" align="left">' . $data['wins'] . '</td></tr>';
            $z++;
        }
        $tmp_vars['{RANGLISTE_TYPE}'] = '<a href="index.php?c=rangliste&type=club">' . $LANG['game']['rangliste']['{RANGLISTE_TYPE_01}'] . ' </a>';
    } else {
        $rslt = @mysql_query('SELECT * FROM game_club ORDER BY name ASC');
        $anzahl = @mysql_num_rows($rslt);
        if(!empty($anzahl)) {
            $tmp_ergebnis = '<tr><td width="5%" align="center" height="30">{RANGLISTE_COUNTER}</td><td width="35%" align="left">{RANGLISTE_CLUBNAME}</td><td width="20%" align="left">{RANGLISTE_ANSEHEN}</td><td width="20%" align="left">{RANGLISTE_STYLE}</td><td width="10%" align="left">{RANGLISTE_RUF}</td><td width="10%" align="left">{RANGLISTE_MEMBER}</td></tr>';
            $tmp_rangliste = array();
            while($tmp_data = @mysql_fetch_array($rslt)) {
                $tmp_werte = array( 0,0,0,0,0,'' );
                $tmp = explode('#', $tmp_data['member']);
                for($x=0;$x!=count($tmp);$x++) {
                    $ttmp = explode(':', $tmp[$x]);
                    $userdata = @mysql_fetch_array(@mysql_query('SELECT * FROM game_user WHERE id="' . $ttmp[0] . '" LIMIT 1'));
                    $tmp_werte[0] += $userdata['ruf'];
                    $tmp_werte[1] += $userdata['ansehen'];
                    $tmp_tune_info = @mysql_fetch_array(@mysql_query('SELECT game_incars.tuned AS tuned FROM game_incars WHERE garage_id="' . $userdata['now_car'] . '" LIMIT 1'));
                    $tmp2 = explode('#', $tmp_tune_info['tuned']);
                    for($i=0;$i!=count($tmp2);$i++) {
                        $ttmp2 = explode(';', $tmp2[$i]);
                        if($ttmp2[0] != 'w') {
                            $tteilinfo = @mysql_fetch_array(@mysql_query('SELECT style FROM game_tuning WHERE name_id="' . $ttmp2[0] . '" && kat_id="' . $i . '" LIMIT 1'));
                            $tmp_werte[2] += $tteilinfo['style'];
                        }
                    }

                    $tmp_werte[3]++;
                    $tmp_werte[4] = $tmp_data['id'];
                    $tmp_werte[5] = $tmp_data['name'];
                }
                $tmp_sorting[] = $tmp_werte[1];
                $tmp_rangliste[] = $tmp_werte;
            }
            rsort($tmp_sorting);
            $already = array();
            $z = 1;
            for($i=0;$i!=count($tmp_sorting);$i++) {
                for($x=0;$x!=count($tmp_rangliste);$x++) {
                    if($tmp_sorting[$i] == $tmp_rangliste[$x][1]) {
                        $reinmit = TRUE;
                        for($o=0;$o!=count($already);$o++) {
                            if($already[$o] == $tmp_rangliste[$x][4]) {
                                $reinmit = FALSE;
                                break(2);
                            }
                        }
                        if($reinmit) {
                            $already[] = $tmp_rangliste[$x][4];
                            $tmp_ergebnis .=         '<tr>
                                                        <td width="5%" align="center">' . $z . '.</td>
                                                        <td width="35%" align="left"><a href="index.php?c=clubprofil&cid=' . $tmp_rangliste[$x][4] . '">' . $tmp_rangliste[$x][5] . '</a></td>
                                                        <td width="20%" align="left">' . $tmp_rangliste[$x][1] . '</td>
                                                        <td width="20%" align="left">' . $tmp_rangliste[$x][2] . '</td>
                                                        <td width="10%" align="left">' . $tmp_rangliste[$x][0] . '</td>
                                                        <td width="10%" align="left">' . $tmp_rangliste[$x][3] . '</td>
                                                      </tr>';
                            $z++;
                        }
                    }
                }
            }
        } else { $tmp_ergebnis = '<tr><td width="100%" align="center" height="50">{RANGLISTE_NO_CLUBS}</td></tr>'; }
        $tmp_vars['{RANGLISTE_TYPE}'] = '<a href="index.php?c=rangliste">' . $LANG['game']['rangliste']['{RANGLISTE_TYPE_02}'] . ' </a>';
    }
    // Template laden
    $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'rangliste', EXT_TEMPS );
    // Platzhalter füllen
    $vars['content']        =   array( '{CONTENT}' => $tmp_section_content, '{RANGLISTE_ERGEBNIS}' => $tmp_ergebnis );
    $vars['content']        =   array_merge($vars['content'], $LANG['game']['rangliste'], $tmp_vars);
} else {$vars['content']        =   array( '{CONTENT}' => $LANG['root']['verweigert']);}

?>

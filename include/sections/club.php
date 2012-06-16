<?php

// Zugriff nur für eingeloggte Benutzer
if($_SESSION['logged']) {
    // Maximum der Nachrichten in der DB pro Club
    $tmp_max_messages = 8;
    $gebaudekosten = array(  // Kosten je Stufe
                             '5000',   // Verwaltung
                             '2500'   // Tresor
                          );
    // Initialisierung
    $tmp_vars = array(); $got_club = FALSE; $tmp_sql = array();
    $userinfo = @mysql_fetch_array(@mysql_query('SELECT * FROM game_user WHERE id="' . $_SESSION['userid'] . '" LIMIT 1'));
    $userbusy_rslt = @mysql_query('SELECT * FROM game_busy WHERE user_id="' . $_SESSION['userid'] . '" LIMIT 1');
    $userbusy_count = @mysql_num_rows($userbusy_rslt);
    $tmp_club = @mysql_query('SELECT * FROM game_club');
    $tmp_club_count = @mysql_num_rows($tmp_club);
    if(!empty($tmp_club_count)) {
        while($tmp_data = @mysql_fetch_array($tmp_club)) {
            $tmp = explode('#', $tmp_data['member']);
            for($x=0;$x!=count($tmp);$x++) {
                $ttmp = explode(':', $tmp[$x]);
                if($ttmp[0] == $_SESSION['userid']) { $got_club = TRUE; $user_clubinfo = $tmp_data; break(2); }
            }
        }
        @mysql_data_seek($tmp_club, 0);
    }
    $apply_anzahl = @mysql_num_rows(@mysql_query('SELECT * FROM game_club_bewerbung WHERE club_id="' . $user_clubinfo['id'] . '"'));
    if(!empty($apply_anzahl)) { $tmp_applys = '<font color="orange">{CLUB_NAV_07}</font>'; } else { $tmp_applys = '{CLUB_NAV_07}'; }
    $board_anzahl = @mysql_num_rows(@mysql_query('SELECT * FROM game_club_board WHERE club_id="' . $user_clubinfo['id'] . '"'));
    // Navigation zusammenstellen
    $tmp_content_name = 'club_main';
    $tmp_member = explode('#', $user_clubinfo['member']);
    for($x=0;$x!=count($tmp_member);$x++) {
        $tmp_navigation = '';
        $tmp_info = explode(':', $tmp_member[$x]);
        if($tmp_info[0] == $_SESSION['userid']) {
            $now_user_rank = $tmp_info[1];
            $tmp_navigation .= '<a href="index.php?c=club&d=kasse">{CLUB_NAV_01}</a>';
            if($tmp_info[1] >= 2) {
                $tmp_navigation .= ' | <a href="index.php?c=club&d=member">{CLUB_NAV_03}</a>';
                $tmp_navigation .= ' | <a href="index.php?c=club&d=optionen">{CLUB_NAV_04}</a>';
                $tmp_navigation .= ' | <a href="index.php?c=club&d=bewerbungen">' . $tmp_applys . '</a>';
            } else { $tmp_navigation .= ' | <a href="index.php?c=club&d=member">{CLUB_NAV_02}</a>'; }
            $tmp_navigation .= ' | <a href="index.php?c=club&d=board">{CLUB_NAV_06} (' . $board_anzahl . ')</a>';
            if($tmp_info[1] != 3) { $tmp_navigation .= ' | <a href="index.php?c=club&d=exit">{CLUB_NAV_05}</a>'; }
            break(1);
        }
    }
    // Die Aktionsweiche
    switch($FormVars['d']) {
        case 'optionen':
            if($got_club) {
                if($now_user_rank >= 2) {
                    // Initialisieren
                    $clubinfo = $user_clubinfo;
                    $tmp_logo_kosten = 500;
                    $tmp_name_kosten = 3000;
                    $tmp_gebaeude_kosten = 0;
                    $tmp_gebs = explode('#', $clubinfo['buildings']);
                    for($x=0;$x!=count($tmp_gebs);$x++) {
                        $ttmp = explode(':', $tmp_gebs[$x]);
                        if($ttmp[0] == 0) { $now_verw = $ttmp[1]; if(empty($FormVars['p_geb_verwaltung'])) { $FormVars['p_geb_verwaltung'] = 0; } else { $tmp_gebaeude_kosten += ($gebaudekosten[$x] * $FormVars['p_geb_verwaltung']); } }
                        if($ttmp[0] == 1) { $now_tresor = $ttmp[1]; if(empty($FormVars['p_geb_tresor'])) { $FormVars['p_geb_tresor'] = 0; } else { $tmp_gebaeude_kosten += ($gebaudekosten[$x] * $FormVars['p_geb_tresor']); } }
                    }
                    $tmp_verwaltung_op = ''; for($x=0;$x<=5;$x++) { if(empty($x)) { $tmp_verwaltung_op .= '<option selected>{CLUB_OPTION_NO_ERW}</option>'; } else { if($x == $FormVars['p_geb_verwaltung']) { $tmp_sel = ' selected'; } else { $tmp_sel = ''; } $tmp_verwaltung_op .= '<option value="' . $x . '"' . $tmp_sel . '>' . $x . '{CLUB_OPTION_MEMBER}</option>'; } }
                    $tmp_tresor_op = ''; for($x=0,$g=0;$x<=5;$x++,$g+=2500) { if(empty($x)) { $tmp_tresor_op .= '<option selected>{CLUB_OPTION_NO_ERW}</option>'; } else { if($x == $FormVars['p_geb_tresor']) { $tmp_sel = ' selected'; } else { $tmp_sel = ''; } $tmp_tresor_op .= '<option value="' . $x . '"' . $tmp_sel . '>' . number_format($g,2,",",".") . $DEFAULTS['game']['waehrung'] . '</option>'; } }
                    if(!empty($FormVars['check'])) {
                        switch($FormVars['check']) {
                            case '1':
                                if($clubinfo['konto'] >= $tmp_name_kosten) {
                                    $edited = FALSE;
                                    if(!empty($FormVars['p_clubname']) && $FormVars['p_clubname'] != $clubinfo['name']) { $edited = TRUE; $tmp_edit_name = 'name="' . $FormVars['p_clubname'] . '"'; }
                                    if(!empty($FormVars['p_clubtag']) && $FormVars['p_clubtag'] != $clubinfo['tag']) { if($edited) { $tmp_edit_name .= ', '; } $edited = TRUE; $tmp_edit_name = 'tag="' . $FormVars['p_clubtag'] . '"'; }
                                    if($edited) {
                                        $tmp_new_konto = $clubinfo['konto'] - $tmp_name_kosten;
                                        $tmp_sql[] = 'UPDATE game_club SET konto="' . $tmp_new_konto . '", ' . $tmp_edit_name . ' WHERE id="' . $clubinfo['id'] . '"';
                                        for($x=0;$x!=count($tmp_sql);$x++) { if(@mysql_query($tmp_sql[$x])) { $tmp_sql_ok++; } }
                                        if($tmp_sql_ok == count($tmp_sql)) {
                                            $ERROR['power'] = true; $tmp_nr = "34";
                                        } else { $ERROR['power'] = true; $tmp_nr = "06"; }
                                    }
                                } else { $ERROR['power'] = true; $tmp_nr = "10"; }
                                break;

                            case '2':
                                if($clubinfo['konto'] >= $tmp_logo_kosten) {
                                    if(!empty($FormVars['p_geb_verwaltung']) && !empty($FormVars['p_geb_tresor'])) {
                                        $tmp_sql_ok = 0;
                                        $new_konto = $clubinfo['konto'] - $tmp_gebaeude_kosten;
                                        $new_buildings = '';
                                        $tmp_gebs = explode('#', $clubinfo['buildings']);
                                        for($x=0;$x!=count($tmp_gebs);$x++) {
                                            $ttmp = explode(':', $tmp_gebs[$x]);
                                            if(!empty($x)) { $new_buildings .= '#'; }
                                            $new_wert = $ttmp[1];
                                            if($ttmp[0] == 0) { $new_wert += $FormVars['p_geb_verwaltung']; }
                                            if($ttmp[0] == 1) { $new_wert += $FormVars['p_geb_tresor']; }
                                            $new_buildings .= $ttmp[0] . ':' . $new_wert;
                                        }
                                        $tmp_sql[] = 'UPDATE game_club SET konto="' . $new_konto . '", buildings="' . $new_buildings . '" WHERE id="' . $clubinfo['id'] . '"';
                                        for($x=0;$x!=count($tmp_sql);$x++) { if(@mysql_query($tmp_sql[$x])) { $tmp_sql_ok++; } }
                                        if($tmp_sql_ok == count($tmp_sql)) {
                                            $ERROR['power'] = true; $tmp_nr = "33";
                                        } else { $ERROR['power'] = true; $tmp_nr = "06"; }
                                    }
                                } else { $ERROR['power'] = true; $tmp_nr = "10"; }
                                break;

                            case '3':
                                if($clubinfo['konto'] >= $tmp_logo_kosten) {
                                    $new_konto = 0;
                                    if(!empty($_FILES['p_logo']['tmp_name'])) {
                                        $tmp_fileok = FALSE;
                                        $datai = getimagesize($_FILES['p_logo']['tmp_name']);
                                        if($datai[2] == 1) { $tmp_fileok = true; $ext = EXT_AVAIMG2;}
                                        if($datai[2] == 2) { $tmp_fileok = true; $ext = EXT_AVAIMG1;}
                                        if($tmp_fileok) {
                                            if($datai[0] <= $DEFAULTS['game']['clublogo_max_w'] && $datai[1] <= $DEFAULTS['game']['clublogo_max_h']) {
                                                if(filesize($_FILES['p_logo']['tmp_name']) <= $DEFAULTS['game']['clublogo_max_size']) {
                                                    if(@copy($_FILES['p_logo']['tmp_name'], DIR_TEMP . time() . $ext)) {
                                                        @unlink( DIR_AVATARS . 'club_' . $clubinfo['id'] . EXT_AVAIMG1 );
                                                        @unlink( DIR_AVATARS . 'club_' . $clubinfo['id'] . EXT_AVAIMG2 );
                                                        if(move_uploaded_file($_FILES['p_logo']['tmp_name'], DIR_AVATARS . 'club_' . $clubinfo['id'] . $ext)){
                                                            $ERROR['power'] = true; $tmp_nr = "31";
                                                            @mysql_query('UPDATE game_club SET konto="' . $new_konto . '" WHERE id="' . $clubinfo['id'] . '"');
                                                        } else { $ERROR['power'] = true; $tmp_nr = "06"; }
                                                    } else { $ERROR['power'] = true; $tmp_nr = "30"; }
                                                } else { $ERROR['power'] = true; $tmp_nr = "29"; }
                                            } else { $ERROR['power'] = true; $tmp_nr = "28"; }
                                        } else { $ERROR['power'] = true; $tmp_nr = "27"; }
                                    } else { $ERROR['power'] = true; $tmp_nr = "32"; }
                                } else { $ERROR['power'] = true; $tmp_nr = "10"; }
                                break;

                            case '4':
                                if(!empty($FormVars['p_delete'])) {
                                    $tmp_msg_kat = 4;
                                    $tmp_msg_id = 5;
                                    $tmp_msg_vars = array(  );
                                    $tmp_send_msg = array2text( loadTemplate( DIR_LANGUAGE . PAGE_LANGUAGE . '/system/', $MSG[$tmp_msg_kat][$tmp_msg_id], EXT_TEXT ), $tmp_msg_vars );
                                    $tmp_sql[] = 'INSERT INTO game_nachrichten VALUES(NULL, "0", "' . $_SESSION['userid'] . '", "' . $BETREFF[$tmp_msg_kat][$tmp_msg_id] . '", "' . $tmp_send_msg . '", "' . time() . '", "1", "0")';
                                    $tmp_sql[] = 'DELETE FROM game_club_bewerbung WHERE club_id="' . $clubinfo['id'] . '"';
                                    $tmp_sql[] = 'DELETE FROM game_club_board WHERE club_id="' . $clubinfo['id'] . '"';
                                    $tmp_sql[] = 'DELETE FROM game_club WHERE id="' . $clubinfo['id'] . '"';
                                    for($x=0;$x!=count($tmp_sql);$x++) { if(@mysql_query($tmp_sql[$x])) { $tmp_sql_ok++; } }
                                    if($tmp_sql_ok == count($tmp_sql)) {
                                        $ERROR['power'] = TRUE; $tmp_nr = '26';
                                    } else { $ERROR['power'] = TRUE; $tmp_nr = '06'; }
                                } else { $ERROR['power'] = TRUE; $tmp_nr = '25'; }
                                break;

                            case '5':
                                if(!empty($FormVars['p_beschreibung'])) {
                                    $tmp_sql_ok = 0;
                                    if(empty($FormVars['p_accept_apply'])) { $tmp_check = 0; } else { $tmp_check = 1; }
                                    $tmp_sql[] = 'UPDATE game_club SET about="' . $FormVars['p_beschreibung'] . '", new_accept="' . $tmp_check . '" WHERE id="' . $clubinfo['id'] . '"';
                                    for($x=0;$x!=count($tmp_sql);$x++) { if(@mysql_query($tmp_sql[$x])) { $tmp_sql_ok++; } }
                                    if($tmp_sql_ok == count($tmp_sql)) {
                                        $ERROR['power'] = TRUE; $tmp_nr = '34';
                                    } else { $ERROR['power'] = TRUE; $tmp_nr = '06'; }
                                } else { $ERROR['power'] = TRUE; $tmp_nr = '21'; }
                                break;
                        }
                    }
                    if($clubinfo['konto'] >= $tmp_name_kosten) { $tmp_name_kosten = '<font color="green">' . number_format($tmp_name_kosten,2,",",".") . $DEFAULTS['game']['waehrung'] . '</font>'; } else { $tmp_name_kosten = '<font color="red">' . number_format($tmp_name_kosten,2,",",".") . $DEFAULTS['game']['waehrung'] . '</font>'; }
                    if($clubinfo['konto'] >= $tmp_logo_kosten) { $tmp_logo_kosten = '<font color="green">' . number_format($tmp_logo_kosten,2,",",".") . $DEFAULTS['game']['waehrung'] . '</font>'; } else { $tmp_logo_kosten = '<font color="red">' . number_format($tmp_logo_kosten,2,",",".") . $DEFAULTS['game']['waehrung'] . '</font>'; }
                    if($clubinfo['konto'] >= $tmp_gebaeude_kosten) { $tmp_gebaeude_kosten = '<font color="green">' . number_format($tmp_gebaeude_kosten,2,",",".") . $DEFAULTS['game']['waehrung'] . '</font>'; } else { $tmp_gebaeude_kosten = '<font color="red">' . number_format($tmp_gebaeude_kosten,2,",",".") . $DEFAULTS['game']['waehrung'] . '</font>'; }
                    if(!empty($clubinfo['new_accept'])) { $tmp_apply = ' checked'; } else { $tmp_apply = ''; }
                    $tmp_content = loadTemplate( DIR_T_H_GAME, 'club_optionen', EXT_TEMPS );
                    $tmp_vars = array(  '{CLUB_TOPIC}'          => '{CLUB_OPTION_TOPIC}',
                                        '{CLUB_CONTENT}'        => $tmp_content,
                                        '{CLUB_VLU_NAVIGATION}' => $tmp_navigation,
                                        '{CLUB_VLU_LOGO_KOSTEN}'=> $tmp_logo_kosten,
                                        '{CLUB_VLU_NAME_KOSTEN}'=> $tmp_name_kosten,
                                        '{CLUB_VLU_GEB_KOSTEN}' => $tmp_gebaeude_kosten,
                                        '{CLUB_VLU_VERW_OP}'    => $tmp_verwaltung_op,
                                        '{CLUB_VLU_TRESOR_OP}'  => $tmp_tresor_op,
                                        '{CLUB_VLU_NAME}'       => $clubinfo['name'],
                                        '{CLUB_VLU_TAG}'        => $clubinfo['tag'],
                                        '{CLUB_VLU_ABOUT}'      => $clubinfo['about'],
                                        '{CLUB_VLU_APPLY}'      => $tmp_apply,
                                        '{CLUB_VLU_GEB_VERW}'   => $FormVars['p_geb_verwaltung'],
                                        '{CLUB_VLU_GEB_TRESOR}' => $FormVars['p_geb_tresor']          );
                } else { $ERROR['power'] = TRUE; $tmp_nr = '18'; }
            } else { $ERROR['power'] = TRUE; $tmp_nr = '16'; }
            break;

        case 'bewerbungen':
            if($got_club) {
                if($now_user_rank >= 2) {
                    // Initialisieren
                    $clubinfo = $user_clubinfo;
                    $tmp_read_bewerbung = '';
                    $tmp_qry = @mysql_query('SELECT * FROM game_club_bewerbung WHERE club_id="' . $clubinfo['id'] . '"');
                    $tmp_anzahl = @mysql_num_rows($tmp_qry);
                    if(!empty($FormVars['check'])) {
                        if(!empty($FormVars['p_aktion']) && !empty($FormVars['p_aktion_id'])) {
                            for($x=0;$x!=count($FormVars['p_aktion']);$x++) {
                                @mysql_data_seek($tmp_qry, 0);
                                if($FormVars['p_aktion'][$x] == 'read') {
                                    while($tmp_data = @mysql_fetch_array($tmp_qry)) {
                                        if($tmp_data['id'] == $FormVars['p_aktion_id'][$x]) {
                                            $tmp_user = @mysql_fetch_array(@mysql_query('SELECT nick FROM game_user WHERE id="' . $tmp_data['user_id'] . '" LIMIT 1'));
                                            $tmp_read_bewerbung .= '<table border="1" cellpadding="0" cellspacing="0" bordercolor="#333333" width="80%"><tr><td width="100%"><div style="margin:2px;">{CLUB_BEWERB_WRITEN}' . $tmp_user['nick'] . '</div></td></tr><tr><td width="100%"><div style="margin:5px;">' . nl2br($tmp_data['nachricht']) . '</div></td></tr></table><BR />';
                                        }
                                    }
                                } elseif($FormVars['p_aktion'][$x] == 'no') {
                                    $tmp_msg_kat = 4;
                                    $tmp_msg_id = 3;
                                    $tmp_msg_vars = array( '{CLUB}' => $clubinfo['name'] );
                                    $tmp_send_msg = array2text( loadTemplate( DIR_LANGUAGE . PAGE_LANGUAGE . '/system/', $MSG[$tmp_msg_kat][$tmp_msg_id], EXT_TEXT ), $tmp_msg_vars );
                                    @mysql_query('INSERT INTO game_nachrichten VALUES(NULL, "0", "' . $FormVars['p_aktion_id'][$x] . '", "' . $BETREFF[$tmp_msg_kat][$tmp_msg_id] . '", "' . $tmp_send_msg . '", "' . time() . '", "1", "0")');
                                    @mysql_query('DELETE FROM game_club_bewerbung WHERE id="' . $FormVars['p_aktion_id'][$x] . '" LIMIT 1');
                                } elseif($FormVars['p_aktion'][$x] == 'yes') {
                                    $tmp_member = explode('#', $clubinfo['member']);
                                    $new_member = ''; $write_it = FALSE;
                                    while($tmp_data = @mysql_fetch_array($tmp_qry)) {
                                        if($tmp_data['id'] == $FormVars['p_aktion_id'][$x]) {
                                            $already_in = FALSE;
                                            for($i=0;$i!=count($tmp_member);$i++) {
                                                $tmp_info = explode(':', $tmp_member[$i]);
                                                if($tmp_info[0] == $tmp_data['user_id']) { $already_in = TRUE; }
                                                if(!empty($i)) { $new_member .= '#'; }
                                                $new_member .= $tmp_info[0] . ':' . $tmp_info[1];
                                            }
                                            if(!$already_in) { $write_it = TRUE; $new_member .= '#' . $tmp_data['user_id'] . ':0'; }
                                        }
                                    }
                                    if($write_it) {
                                        $tmp_msg_kat = 4;
                                        $tmp_msg_id = 4;
                                        $tmp_msg_vars = array( '{CLUB}' => $clubinfo['name'] );
                                        $tmp_send_msg = array2text( loadTemplate( DIR_LANGUAGE . PAGE_LANGUAGE . '/system/', $MSG[$tmp_msg_kat][$tmp_msg_id], EXT_TEXT ), $tmp_msg_vars );
                                        @mysql_query('INSERT INTO game_nachrichten VALUES(NULL, "0", "' . $FormVars['p_aktion_id'][$x] . '", "' . $BETREFF[$tmp_msg_kat][$tmp_msg_id] . '", "' . $tmp_send_msg . '", "' . time() . '", "1", "0")');
                                        @mysql_query('UPDATE game_club SET member="' . $new_member . '" WHERE id="' . $clubinfo['id'] . '"');
                                        @mysql_query('DELETE FROM game_club_bewerbung WHERE id="' . $FormVars['p_aktion_id'][$x] . '" LIMIT 1');
                                    }
                                }
                            }
                        }
                    }
                    $tmp_qry = @mysql_query('SELECT * FROM game_club_bewerbung WHERE club_id="' . $clubinfo['id'] . '"');
                    $tmp_anzahl = @mysql_num_rows($tmp_qry);
                    if(!empty($tmp_anzahl)) {
                        while($tmp_data = @mysql_fetch_array($tmp_qry)) {
                            $tmp_user = @mysql_fetch_array(@mysql_query('SELECT id, nick FROM game_user WHERE id="' . $tmp_data['user_id'] . '" LIMIT 1'));
                            $tmp_bewerbungen .= '<tr><td width="35%" align="center">' . date("d.m.Y - H:i", $tmp_data['sendtime']) . ' Uhr</td><td width="30%" align="center"><a href="index.php?c=profil&id=' . $tmp_user['id'] . '">' . $tmp_user['nick'] . '</a></td><td width="35%" align="center"><input type="hidden" name="p_aktion_id[]" value="' . $tmp_data['id'] . '"><select name="p_aktion[]" class="dropdown"><option value="read">{CLUB_BEWERB_READ}</option><option value="yes">{CLUB_BEWERB_ACCEPT}</option><option value="no">{CLUB_BEWERB_DENAIL}</option></select></td></tr>';
                        }
                        $tmp_button = '';
                    } else { $tmp_button = ' disabled'; $tmp_bewerbungen = '<tr><td width="100%" colspan="3" align="center">&nbsp;</td></tr><tr><td width="100%" colspan="3" align="center">{CLUB_NO_BEWERBUNGEN}</td></tr><tr><td width="100%" colspan="3" align="center">&nbsp;</td></tr>'; }
                    $tmp_content = loadTemplate( DIR_T_H_GAME, 'club_bewerbung', EXT_TEMPS );
                    $tmp_vars = array(  '{CLUB_TOPIC}'          => '{CLUB_BEWERB_TOPIC}',
                                        '{CLUB_CONTENT}'        => $tmp_content,
                                        '{CLUB_VLU_NAVIGATION}' => $tmp_navigation,
                                        '{CLUB_VLU_BEWERBUNGEN}'=> $tmp_bewerbungen,
                                        '{CLUB_VLU_READ}'       => nl2br($tmp_read_bewerbung),
                                        '{CLUB_BEWERB_ACTIVE}'  => $tmp_button        );
                } else { $ERROR['power'] = TRUE; $tmp_nr = '18'; }
            } else { $ERROR['power'] = TRUE; $tmp_nr = '16'; }
            break;

        case 'board':
            if($got_club) {
                // Initialisieren
                $clubinfo = $user_clubinfo;
                $msg_rslt = mysql_query('SELECT * FROM game_club_board WHERE club_id="' . $clubinfo['id'] . '"');
                $tmp_board_content = '';
                $tmp_write_msg = '<a href="index.php?c=club&d=board&b=write">{CLUB_BOARD_WRITE}</a>';
                $tmp_member_content = ''; $tmp_button = '';
                if(!empty($FormVars['did'])) {
                    while($tmp_data = @mysql_fetch_array($msg_rslt)) { if($tmp_data['id'] == $FormVars['did']) { $msg_data = $tmp_data; break(1); } }
                    $sql = 'DELETE FROM game_club_board WHERE id="' . $msg_data['id'] . '"';
                    if(@mysql_query($sql)) {
                        $ERROR['power'] = TRUE; $tmp_nr = '24';
                    } else { $ERROR['power'] = TRUE; $tmp_nr = '06'; }
                }
                if(!empty($FormVars['rid'])) {
                    while($tmp_data = @mysql_fetch_array($msg_rslt)) { if($tmp_data['id'] == $FormVars['rid']) { $msg_data = $tmp_data; break(1); } }
                    $tmp_this_vars = array( '{MESSAGE_BETREFF}' => '<u>' . $msg_data['betreff'] . '</u>', '{MESSAGE_MESSAGE}' => nl2br($msg_data['msg']) );
                    $tmp_board_content = array2text( loadTemplate( DIR_T_H_GAME, 'club_board_read', EXT_TEMPS ), $tmp_this_vars );
                }
                if($FormVars['b'] == 'write') {
                    if(!empty($FormVars['check'])) {
                        if(!empty($FormVars['p_betreff']) && !empty($FormVars['p_nachricht'])) {
                            if(count($msg_rslt) <= $tmp_max_messages) {
                                $sql = 'INSERT INTO game_club_board VALUES("", "' . time() . '", "' . $clubinfo['id'] . '", "' . $_SESSION['userid'] . '", "' . $FormVars['p_betreff'] . '", "' . $FormVars['p_nachricht'] . '")';
                                if(@mysql_query($sql)) {
                                    $ERROR['power'] = TRUE; $tmp_nr = '23';
                                } else { $ERROR['power'] = TRUE; $tmp_nr = '06'; }
                            } else { $ERROR['power'] = TRUE; $tmp_nr = '22'; }
                        } else { $ERROR['power'] = TRUE; $tmp_nr = '21'; }
                    } else {
                        if(count($msg_rslt) >= $tmp_max_messages) { $tmp_hinweis = '<font color="red">{CLUB_BOARD_WRT_OK_NO}</font>'; }
                        $tmp_this_vars = array( '{CLUB_BOARD_WRT_OK}' => $tmp_hinweis );
                        $tmp_board_content = array2text( loadTemplate( DIR_T_H_GAME, 'club_board_write', EXT_TEMPS ), $tmp_this_vars );
                        $tmp_write_msg = '';
                    }
                }
                $tmp_rslt = @mysql_query('SELECT * FROM game_club_board WHERE club_id="' . $clubinfo['id'] . '" LIMIT ' . $tmp_max_messages);
                $anzahl = @mysql_num_rows($tmp_rslt);;
                if(!empty($anzahl)) {
                    while($tmp_data = @mysql_fetch_array($tmp_rslt)) {
                        $authorinfo = @mysql_fetch_array(@mysql_query('SELECT nick FROM game_user WHERE id="' . $tmp_data['user_id'] . '" LIMIT 1'));
                        $tmp_time = date("d.m.Y", $tmp_data['zeit']);
                        if($tmp_time = date("d.m.Y")) { $tmp_time = date("H:i", $tmp_data['zeit']) . ' Uhr'; }
                        $tmp_messages = '<tr><td width="25%" align="center">' . $tmp_time . '</td><td width="25%" align="center"><a href="index.php?c=profil&id=' . $tmp_data['user_id'] . '">' . $authorinfo['nick'] . '</a></td><td width="25%" align="center"><a href="index.php?c=club&d=board&rid=' . $tmp_data['id'] . '">' . $tmp_data['betreff'] . '</a></td><td width="25%" align="center"><a href="index.php?c=club&d=board&rid=' . $tmp_data['id'] . '">[L]</a>&nbsp;<a href="index.php?c=nachrichten&d=write&uid=' . $tmp_data['user_id'] . '">[N]</a>&nbsp;<a href="index.php?c=club&d=board&did=' . $tmp_data['id'] . '">[X]</a></td></tr>';
                    }
                } else { $tmp_messages = '<tr><td width="100%" colspan="4" align="center">&nbsp;</td></tr><tr><td width="100%" align="center" colspan="4">{CLUB_BOARD_NO_MSG}</td></tr><tr><td width="100%" colspan="4" align="center">&nbsp;</td></tr>'; }
                $tmp_content = loadTemplate( DIR_T_H_GAME, 'club_board', EXT_TEMPS );
                $tmp_vars = array(  '{CLUB_TOPIC}'          => '{CLUB_BOARD_TOPIC}',
                                    '{CLUB_CONTENT}'        => $tmp_content,
                                    '{CLUB_BOARD_CONTENT}'  => $tmp_board_content,
                                    '{CLUB_VLU_NAVIGATION}' => $tmp_navigation,
                                    '{CLUB_VLU_WRITE}'      => $tmp_write_msg,
                                    '{CLUB_VLU_MESSAGES}'   => $tmp_messages       );
            } else { $ERROR['power'] = TRUE; $tmp_nr = '16'; }
            break;

        case 'kick':
            if($got_club) {
                if($now_user_rank >= 2) {
                    if(!empty($FormVars['kid'])) {
                        $clubinfo = $user_clubinfo; $tmp_sql_ok = 0;
                        $user_id_in_club = FALSE; $tmp_new_member = '';
                        $tmp_member = explode('#', $user_clubinfo['member']);
                        for($x=0;$x!=count($tmp_member);$x++) { $tmp_info = explode(':', $tmp_member[$x]); if($tmp_info[0] == $FormVars['kid']) { $user_id_in_club = TRUE; } else { if(!empty($x)) { $tmp_new_member .= '#'; } $tmp_new_member .= $tmp_info[0] . ':' . $tmp_info[1]; } }
                        if($user_id_in_club) {
                            if($now_user_rank >= 2) {
                                $tmp_msg_kat = 4;
                                $tmp_msg_id = 2;
                                $tmp_msg_vars = array( '{CLUB}' => $clubinfo['name'] );
                                $tmp_send_msg = array2text( loadTemplate( DIR_LANGUAGE . PAGE_LANGUAGE . '/system/', $MSG[$tmp_msg_kat][$tmp_msg_id], EXT_TEXT ), $tmp_msg_vars );
                                $tmp_sql[] = 'INSERT INTO game_nachrichten VALUES(NULL, "0", "' . $FormVars['kid'] . '", "' . $BETREFF[$tmp_msg_kat][$tmp_msg_id] . '", "' . $tmp_send_msg . '", "' . time() . '", "1", "0")';
                                $tmp_sql[] = 'UPDATE game_club SET member="' . $tmp_new_member . '" WHERE id="' . $clubinfo['id'] . '"';
                                for($x=0;$x!=count($tmp_sql);$x++) { if(@mysql_query($tmp_sql[$x])) { $tmp_sql_ok++; } }
                                if($tmp_sql_ok == count($tmp_sql)) {
                                    $ERROR['power'] = TRUE; $tmp_nr = '20';
                                } else { $ERROR['power'] = TRUE; $tmp_nr = '06'; }
                            } else { $ERROR['power'] = TRUE; $tmp_nr = '18'; }
                        } else { $ERROR['power'] = TRUE; $tmp_nr = '09'; }
                    }
                } else { $ERROR['power'] = TRUE; $tmp_nr = '18'; }
            } else { $ERROR['power'] = TRUE; $tmp_nr = '16'; }
            break;

        case 'member':
            if($got_club) {
                // Initialisieren
                $clubinfo = $user_clubinfo;
                $tmp_member_content = ''; $tmp_button = '';
                $tmp_houses = explode('#', $clubinfo['buildings']);
                for($x=0;$x!=count($tmp_houses);$x++) { $tmp_info = explode(':', $tmp_houses[$x]); if($tmp_info[0] == 0) { $tmp_size_stufe = $tmp_info[1]; break(1); } }
                $tmp_member = explode('#', $clubinfo['member']);
                for($x=0,$z=1;$x!=count($tmp_member);$x++,$z++) {
                    $tmp_info = explode(':', $tmp_member[$x]);
                    $memberinfo = @mysql_fetch_array(@mysql_query('SELECT id, nick FROM game_user WHERE id="' . $tmp_info[0] . '" LIMIT 1'));
                    $tmp_aktionen = '<a href="index.php?c=nachrichten&d=write&uid=' . $memberinfo['id'] . '" title="» {CLUB_ALT_MSG}">{CLUB_MEMBER_MSG}</a>';
                    if($now_user_rank >= 2) {
                        $tmp_rank = '<select name="p_rank[]" class="dropdown">';
                        $anzahl = (count($LANG['game']['club_ranks']) - 1);
                        for($i=0;$i!=$anzahl;$i++) {
                            if($tmp_info[1] == $i) { $tmp_rsel = ' selected'; } else { $tmp_rsel = ''; }
                            $tmp_rank .= '<option value="' . $i . '"' . $tmp_rsel . '>' . $LANG['game']['club_ranks'][$i] . '</option>';
                        }
                        if(empty($x) || $now_user_rank == 3) { if($tmp_info[1] == $anzahl) { $tmp_asel = ' selected'; } else { $tmp_asel = ''; } $tmp_rank .= '<option value="' . $anzahl . '"' . $tmp_asel . '>' . $LANG['game']['club_ranks'][$anzahl] . '</option>'; }
                        if($tmp_info[0] != $_SESSION['userid'] && $tmp_info[1] != 3) { $tmp_aktionen .= '&nbsp;<a href="index.php?c=club&d=kick&kid=' . $memberinfo['id'] . '" title="» {CLUB_ALT_KICK}">{CLUB_MEMBER_KICK}</a>'; }
                        $tmp_rank .= '</select>';
                    } else { $anzahl = count($LANG['game']['club_ranks']); for($i=0;$i!=$anzahl;$i++) { if($tmp_info[1] == $i) { $tmp_rank = $LANG['game']['club_ranks'][$i]; break(1); } } }
                    $tmp_member_content .= '<tr><td width="10%" align="right" height="18">' . $z . '.</td><td width="30%" align="left" height="18">&nbsp;<a href="index.php?c=profil&id=' . $memberinfo['id'] . '">' . $memberinfo['nick'] . '</a></td><td width="30%" align="left" height="18">' . $tmp_rank . '</td><td width="30%" align="left" height="18">' . $tmp_aktionen .'</td></tr>';
                }
                if($now_user_rank >= 2) { $tmp_button = '<input type="submit" value="{CLUB_MEMBER_BTN_SAVE}" class="button">'; }
                $tmp_sizemax = $tmp_size_stufe;
                $tmp_sizenow = count($tmp_member);
                if(!empty($FormVars['check'])) {
                    if(!empty($FormVars['p_rank'])) {
                        if($now_user_rank >= 2) {
                            $tmp_member_rank = ''; for($x=0;$x!=count($tmp_member);$x++) { $tmp_info = explode(':', $tmp_member[$x]); if(!empty($x)) { $tmp_member_rank .= '#'; } $tmp_member_rank .= $tmp_info[0] . ':' . $FormVars['p_rank'][$x]; }
                            $tmp_sql[] = 'UPDATE game_club SET member="' . $tmp_member_rank . '" WHERE id="' . $clubinfo['id'] . '"';
                            $tmp_sql_ok = 0;
                            for($x=0;$x!=count($tmp_sql);$x++) { if(@mysql_query($tmp_sql[$x])) { $tmp_sql_ok++; } }
                            if($tmp_sql_ok == count($tmp_sql)) {
                                $ERROR['power'] = TRUE; $tmp_nr = '19';
                            } else { $ERROR['power'] = TRUE; $tmp_nr = '06'; }
                        } else { $ERROR['power'] = TRUE; $tmp_nr = '18'; }
                    } else { $ERROR['power'] = TRUE; $tmp_nr = '00'; }
                }
                $tmp_content = loadTemplate( DIR_T_H_GAME, 'club_member', EXT_TEMPS );
                $tmp_vars = array(  '{CLUB_TOPIC}'          => '{CLUB_MEMBER_TOPIC}',
                                    '{CLUB_CONTENT}'        => $tmp_content,
                                    '{CLUB_VLU_NAVIGATION}' => $tmp_navigation,
                                    '{CLUB_MEMBER_CONTENT}' => $tmp_member_content,
                                    '{CLUB_VLU_BUTTON}'     => $tmp_button,
                                    '{CLUB_SIZE_NOW}'       => $tmp_sizenow,
                                    '{CLUB_SIZE_MAX}'       => $tmp_sizemax         );
            } else { $ERROR['power'] = TRUE; $tmp_nr = '16'; }
            break;

        case 'kasse':
            if($got_club) {
                // Initialisieren
                $clubinfo = $user_clubinfo;
                $tmp_member_op = '';
                $auzahlen_ok = FALSE;
                if(!isset($FormVars['p_member'])) { $FormVars['p_member'] = 0; }
                $tmp_houses = explode('#', $clubinfo['buildings']);
                for($x=0;$x!=count($tmp_houses);$x++) { $tmp_info = explode(':', $tmp_houses[$x]); if($tmp_info[0] == 1) { $tmp_tresor_stufe = $tmp_info[1]; break(1); } }
                $tmp_member = explode('#', $clubinfo['member']);
                for($x=0;$x!=count($tmp_member);$x++) {
                    $tmp_info = explode(':', $tmp_member[$x]);
                    $memberinfo = @mysql_fetch_array(@mysql_query('SELECT id, nick FROM game_user WHERE id="' . $tmp_info[0] . '" LIMIT 1'));
                    if($tmp_info[0] == $_SESSION['userid'] && $tmp_info[1] >= 1) { $auzahlen_ok = TRUE; }
                    if(empty($FormVars['p_member']) && empty($x)) { $tmp_active_out = ' disabled'; $tmp_member_op = '<option value="0" selected>{CLUB_KASSE_CHOOSE}</option>'; } else { $tmp_active_out = ''; if($tmp_info[0] == $FormVars['p_member']) { $tmp_msel = ' selected'; } else { $tmp_msel = ''; } }
                    $tmp_member_op .= '<option value="' . $memberinfo['id'] . '"' . $tmp_msel . '>' . $memberinfo['nick'] . '</option>';
                }
                $tmp_file = DIR_T_I_DESIGN . 'club_kasse' . EXT_AVAIMG1;
                if(@file_exists($tmp_file)) { $tmp_pic = '<table border="1" cellpadding="0" cellspacing="0" bordercolor="#333333" width="150" height="160"><tr><td width="100%" align="center"><img src="' . $tmp_file . '" border="0"></td></tr></table>'; break(1); } else { $tmp_pic = '<table border="1" cellpadding="0" cellspacing="0" bordercolor="#333333" width="150" height="160"><tr><td width="100%" align="center">{CLUB_NO_PIC}</td></tr></table>'; }
                $tmp_tag = '[' . $clubinfo['tag'] . ']';
                $tmp_name = $clubinfo['name'];
                $tmp_about = $clubinfo['about'];
                $tmp_max_tresor = $tmp_tresor_stufe * 2500;
                $tmp_now_tresor = $clubinfo['konto'];
                if($auzahlen_ok) { $tmp_member_drdw = ''; } else { $tmp_member_drdw = ' disabled'; }
                if($FormVars['check'] == 1) {
                    if(empty($userbusy_count)) {
                        $result = @mysql_query('SELECT * FROM game_user WHERE id="' . $FormVars['p_member'] . '" LIMIT 1');
                        $anzahl = @mysql_num_rows($result);
                        if(!empty($anzahl)) {
                            if(!empty($FormVars['p_auszahlen']) && is_numeric($FormVars['p_auszahlen']) && $FormVars['p_auszahlen'] > 0) {
                                if($tmp_now_tresor >= $FormVars['p_auszahlen']) {
                                    $tmp_sql_ok = 0;
                                    $tmp_data = @mysql_fetch_array($result);
                                    $tmp_sql[] = 'UPDATE game_user SET money="' . ($tmp_data['money'] + $FormVars['p_auszahlen']) . '" WHERE id="' . $tmp_data['id'] . '"';
                                    $tmp_sql[] = 'UPDATE game_club SET konto="' . ($clubinfo['konto'] - $FormVars['p_auszahlen']) . '" WHERE id="' . $clubinfo['id'] . '"';
                                    $tmp_msg_kat = 4;
                                    $tmp_msg_id = 1;
                                    $tmp_msg_vars = array( '{MONEY}' => number_format($FormVars['p_auszahlen'],2,",",".") . $DEFAULTS['game']['waehrung'], '{CLUB}' => $clubinfo['name'] );
                                    $tmp_send_msg = array2text( loadTemplate( DIR_LANGUAGE . PAGE_LANGUAGE . '/system/', $MSG[$tmp_msg_kat][$tmp_msg_id], EXT_TEXT ), $tmp_msg_vars );
                                    $tmp_sql[] = 'INSERT INTO game_nachrichten VALUES(NULL, "0", "' . $FormVars['p_member'] . '", "' . $BETREFF[$tmp_msg_kat][$tmp_msg_id] . '", "' . $tmp_send_msg . '", "' . time() . '", "1", "0")';
                                    for($x=0;$x!=count($tmp_sql);$x++) { if(@mysql_query($tmp_sql[$x])) { $tmp_sql_ok++; } }
                                    if($tmp_sql_ok == count($tmp_sql)) {
                                        $ERROR['power'] = TRUE; $tmp_nr = '12';
                                    } else { $ERROR['power'] = TRUE; $tmp_nr = '06'; }
                                } else { $ERROR['power'] = TRUE; $tmp_nr = '10'; }
                            } else { $ERROR['power'] = TRUE; $tmp_nr = '11'; }
                        } else { $ERROR['power'] = TRUE; $tmp_nr = '09'; }
                    } else { $ERROR['power'] = TRUE; $tmp_nr = '04'; }
                }
                if($FormVars['check'] == 2) {
                    if(empty($userbusy_count)) {
                        if(!empty($FormVars['p_einzahlen']) && is_numeric($FormVars['p_einzahlen']) && $FormVars['p_einzahlen'] > 0) {
                            if($userinfo['money'] >= $FormVars['p_einzahlen']) {
                                if($tmp_max_tresor >= ($clubinfo['konto'] + $FormVars['p_einzahlen'])) {
                                    $tmp_sql_ok = 0;
                                    $tmp_data = @mysql_fetch_array($result);
                                    $tmp_sql[] = 'UPDATE game_user SET money="' . ($userinfo['money'] - $FormVars['p_einzahlen']) . '" WHERE id="' . $userinfo['id'] . '"';
                                    $tmp_sql[] = 'UPDATE game_club SET konto="' . ($clubinfo['konto'] + $FormVars['p_einzahlen']) . '" WHERE id="' . $clubinfo['id'] . '"';
                                    for($x=0;$x!=count($tmp_sql);$x++) { if(@mysql_query($tmp_sql[$x])) { $tmp_sql_ok++; } }
                                    if($tmp_sql_ok == count($tmp_sql)) {
                                        $ERROR['power'] = TRUE; $tmp_nr = '15';
                                    } else { $ERROR['power'] = TRUE; $tmp_nr = '06'; }
                                } else { $ERROR['power'] = TRUE; $tmp_nr = '17'; }
                            } else { $ERROR['power'] = TRUE; $tmp_nr = '14'; }
                        } else { $ERROR['power'] = TRUE; $tmp_nr = '13'; }
                    } else { $ERROR['power'] = TRUE; $tmp_nr = '04'; }
                }
                $tmp_content = loadTemplate( DIR_T_H_GAME, 'club_kasse', EXT_TEMPS );
                $tmp_vars = array(  '{CLUB_TOPIC}'          => '{CLUB_KASSE_TOPIC}',
                                    '{CLUB_CONTENT}'        => $tmp_content,
                                    '{CLUB_VLU_NAVIGATION}' => $tmp_navigation,
                                    '{CLUB_VLU_TAG}'        => $tmp_tag,
                                    '{CLUB_VLU_NAME}'       => $tmp_name,
                                    '{CLUB_VLU_MEMBER_OP}'  => $tmp_member_op,
                                    '{CLUB_VLU_BILD}'       => $tmp_pic,
                                    '{CLUB_VLU_KASSENOW}'   => number_format($tmp_now_tresor,2,",",".") . $DEFAULTS['game']['waehrung'],
                                    '{CLUB_VLU_KASSEMAX}'   => number_format($tmp_max_tresor,2,",",".") . $DEFAULTS['game']['waehrung'],
                                    '{CLUB_VLU_ABOUT}'      => $tmp_about,
                                    '{CLUB_VLU_KASSERECHT}' => $tmp_member_drdw,
                                    '{CLUB_ACTIVE_OUT}'     => $tmp_active_out,
                                    '{CLUB_VLU_MEMBER}'     => $FormVars['p_member']         );
            } else { $ERROR['power'] = TRUE; $tmp_nr = '16'; }
            break;

        case 'myclub':
            if($got_club) {
                // Initialisieren
                $clubinfo = $user_clubinfo;
                $tmp_file[] = DIR_AVATARS . 'club_' . $clubinfo['id'] . EXT_AVAIMG1;
                $tmp_file[] = DIR_AVATARS . 'club_' . $clubinfo['id'] . EXT_AVAIMG2;
                for($x=0;$x!=count($tmp_file);$x++) { if(@file_exists($tmp_file[$x])) { $tmp_logo = '<img src="' . $tmp_file[$x] . '" border="0">'; break(1); } else { $tmp_logo = '{CLUB_NO_LOGO}'; } }
                $tmp_tag = '[' . $clubinfo['tag'] . ']';
                $tmp_name = $clubinfo['name'];
                $tmp_about = $clubinfo['about'];
                $tmp_content = loadTemplate( DIR_T_H_GAME, 'club_overview', EXT_TEMPS );
                $tmp_vars = array(  '{CLUB_TOPIC}'          => '{CLUB_MAIN_TOPIC}',
                                    '{CLUB_CONTENT}'        => $tmp_content,
                                    '{CLUB_VLU_NAVIGATION}' => $tmp_navigation,
                                    '{CLUB_VLU_TAG}'        => $tmp_tag,
                                    '{CLUB_VLU_NAME}'       => $tmp_name,
                                    '{CLUB_VLU_LOGO}'       => $tmp_logo,
                                    '{CLUB_VLU_ABOUT}'      => nl2br($tmp_about)         );
            } else { $ERROR['power'] = TRUE; $tmp_nr = '16'; }
            break;

        case 'new':
            if(empty($userbusy_count)) {
                if(!$got_club) {
                    // Übergabewerte auf standard setzen wenn nicht gegeben
                    if(!isset($FormVars['p_clubsize'])) { $FormVars['p_clubsize'] = 0; }
                    $tmp_kosten = $DEFAULTS['game']['founding'];
                    $tmp_kosten += (2 * $DEFAULTS['game']['founding_extra']);
                    $tmp_dauer = $WORKTIME[3];
                    if(!empty($FormVars['check'])) {
                        if(empty($userbusy_count)) {
                            if(!empty($FormVars['p_clubname'])) {
                                if(!empty($FormVars['p_clubtag'])) {
                                    if($userinfo['money'] >= $tmp_kosten) {
                                        // Gebäude definieren [GEBÄUDEID:STUFE#GEBÄUDEID:STUFE]
                                        $tmp_buildings = '0:3#1:1';
                                        // Mitglieder definieren [USERID:RANG#USERID:RANG]
                                        $tmp_member = $_SESSION['userid'] . ':3';
                                        // Beschreibung zusammenstellen
                                        $tmp_about = '[' . $FormVars['p_clubtag'] . '] - ' . $FormVars['p_clubname'];
                                        // Endzeitpunkt berechnen
                                        $tmp_ende = time() + $tmp_dauer;
                                        // In die Datenbank schreiben
                                        $tmp_do_after = 'INSERT INTO game_club VALUES(\"\", \"' . $FormVars['p_clubtag'] . '\", \"' . $FormVars['p_clubname'] . '\", \"' . $tmp_about . '\", \"' . $DEFAULTS['game']['founding_bonus'] . '\", \"' . $tmp_member . '\", \"' . $tmp_buildings . '\", \"0\")';
                                        $tmp_msg_kat = 4;
                                        $tmp_msg_id = 0;
                                        $tmp_msg_vars = array( '{CLUB}' => $FormVars['p_clubname'] );
                                        $tmp_send_msg = array2text( loadTemplate( DIR_LANGUAGE . PAGE_LANGUAGE . '/system/', $MSG[$tmp_msg_kat][$tmp_msg_id], EXT_TEXT ), $tmp_msg_vars );
                                        $tmp_do_after .= '|INSERT INTO game_nachrichten VALUES(NULL, \"0\", \"' . $_SESSION['userid'] . '\", \"' . $BETREFF[$tmp_msg_kat][$tmp_msg_id] . '\", \"' . $tmp_send_msg . '\", \"' . time() . '\", \"1\", \"0\")';
                                        $sql = 'INSERT INTO game_busy VALUES(NULL, "' . $_SESSION['userid'] . '", "' . $tmp_ende . '", "3", "' . $tmp_kosten . '", "0", "' . $tmp_do_after . '")';
                                        if(@mysql_query($sql)) {
                                            $ERROR['power'] = TRUE; $tmp_nr = '07';
                                        } else { $ERROR['power'] = TRUE; $tmp_nr = '06'; }
                                    } else { $ERROR['power'] = TRUE; $tmp_nr = '03'; }
                                } else { $ERROR['power'] = TRUE; $tmp_nr = '05'; }
                            } else { $ERROR['power'] = TRUE; $tmp_nr = '02'; }
                        } else { $ERROR['power'] = TRUE; $tmp_nr = '04'; }
                    }
                    $tmp_content_name = 'club_new';
                    if($userinfo['money'] >= $tmp_kosten) { $tmp_kosten = '<font color="green">' . number_format($tmp_kosten,2,",",".") . $DEFAULTS['game']['waehrung'] . '</font>'; } else { $tmp_kosten = '<font color="red">' . number_format($tmp_kosten,2,",",".") . $DEFAULTS['game']['waehrung'] . '</font>'; }
                    $tmp_vars = array(  '{CLUB_VLU_NAME}'       => $FormVars['p_clubname'],
                                        '{CLUB_VLU_KOSTEN}'     => $tmp_kosten,
                                        '{CLUB_VLU_DAUER}'      => gibDauer($tmp_dauer)         );
                } else { $ERROR['power'] = TRUE; $tmp_nr = '01'; }
            } else { $ERROR['power'] = TRUE; $tmp_nr = '04'; }
            break;

        default:
            $ERROR['power'] = TRUE; $tmp_nr = '00';
            break;
    }
    if($ERROR['power'] == TRUE) {
        // Fehlermeldung übergeben bei einem Fehler
        $vars['error'] = array( '{ERROR_MESSAGE}' => '{CLUB_ERROR_' . $tmp_nr . '}');
    } else {
        // Content laden
        $tmp_section_content = loadTemplate( DIR_T_H_GAME, $tmp_content_name, EXT_TEMPS );
    }
    // Platzhalter füllen
    $vars['content']        =   array( '{CONTENT}' => $tmp_section_content, );
    $vars['content']        =   array_merge($vars['content'], $tmp_vars, $LANG['game']['club']);
} else {$vars['content']        =   array( '{CONTENT}' => $LANG['root']['verweigert']);}

?>

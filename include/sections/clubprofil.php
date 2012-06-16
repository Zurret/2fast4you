<?php

if($_SESSION['logged']) {
    // Initialisierung der Suche
    $tmp_vars = array();
    $tmp_member = 0;
    $tmp_member_value = '';
    $user_is_here = FALSE;
    $user_is_in_club = FALSE;
    if(isset($FormVars['cid'])) {
        $rslt = @mysql_query('SELECT * FROM game_club WHERE id="' . $FormVars['cid'] . '" LIMIT 1');
        $anzahl = @mysql_num_rows($rslt);
        if(!empty($anzahl)) {
            $clubdata = @mysql_fetch_array($rslt);
            $user_got_open_apply = @mysql_num_rows(@mysql_query('SELECT * FROM game_club_bewerbung WHERE user_id="' . $_SESSION['userid'] . '" LIMIT 1'));
            $tmp_m = explode('#', $clubdata['member']);
            for($x=0,$z=1;$x!=count($tmp_m);$x++,$z++) {
                $ttmp = explode(':', $tmp_m[$x]);
                $userinfo = @mysql_fetch_array(@mysql_query('SELECT id, nick FROM game_user WHERE id="' . $ttmp[0] . '" LIMIT 1'));
                $tmp_member_value .= '<tr><td width="10%" align="right">' . $z . '.</td><td width="35%" align="left">&nbsp;<a href="index.php?c=profil&id=' . $userinfo['id'] . '">' . $userinfo['nick'] . '</a></td><td width="35%" align="center">' . $LANG['game']['club_ranks'][$ttmp[1]] . '</td><td width="20%" align="left"><a href="index.php?c=nachrichten&d=write&uid=' . $userinfo['id'] . '">{CLUBPROFIL_ABKZ_MSG}</a></td></tr>';
                if($ttmp[0] == $_SESSION['userid']) { $user_is_here = TRUE; }
                $tmp_member++;
            }
            $tmp = explode('#', $clubdata['buildings']);
            for($x=0;$x!=count($tmp);$x++) { $ttmp = explode(':', $tmp[$x]); if($ttmp[0] == 0) { $tmp_maxmember = $ttmp[1]; } }
            $tmp_file[] = DIR_AVATARS . 'club_' . $clubdata['id'] . EXT_AVAIMG1;
            $tmp_file[] = DIR_AVATARS . 'club_' . $clubdata['id'] . EXT_AVAIMG2;
            for($x=0;$x!=count($tmp_file);$x++) { if(@file_exists($tmp_file[$x])) { $tmp_logo = '<img src="' . $tmp_file[$x] . '" border="0">'; break(1); } else { $tmp_logo = '{CLUBPROFIL_NO_LOGO}'; } }
            if(!empty($clubdata['about'])) { $tmp_about = $clubdata['about']; } else { $tmp_about = '{CLUBPROFIL_NO_ABOUT}'; }
            $apply_rslt = @mysql_query('SELECT * FROM game_club_bewerbung WHERE user_id="' . $_SESSION['userid'] . '" LIMIT 1');
            $erste_apply = @mysql_num_rows($apply_rslt);
            if(count($tmp_m) < $tmp_maxmember && !$user_is_here && empty($clubdata['new_accept'])) {
                if(empty($user_got_open_apply)) {
                    $tmp_all = @mysql_query('SELECT member FROM game_club');
                    while($tmp_all_data = @mysql_fetch_array($tmp_all)) { $tmp = explode('#', $tmp_all_data['member']); for($x=0,$z=1;$x!=count($tmp);$x++,$z++) { $ttmp = explode(':', $tmp[$x]); if($ttmp[0] == $_SESSION['userid']) { $user_is_in_club = TRUE; break(2); } } }
                    if(!$user_is_in_club) {
                        if($FormVars['d'] == 'apply') { $tmp_bewerbung = loadTemplate( DIR_T_H_GAME, 'clubprofil_bewerben', EXT_TEMPS ); } else { $tmp_bewerbung = '<a href="index.php?c=clubprofil&d=apply&cid={CLUBPROFIL_VLU_CID}">{CLUBPROFIL_BEWERBUNG}</a>'; }
                        if(!empty($FormVars['check']) && $FormVars['d'] == 'apply') {
                            if(!empty($FormVars['p_bewerbungstext'])) {
                                $tmp_sql_ok = 0;
                                if(!empty($erste_apply)) {
                                    $tmp_dt = @mysql_fetch_array($apply_rslt);
                                    $tmp_sql[] = 'UPDATE game_club_bewerbung SET nachricht="' . $FormVars['p_bewerbungstext'] . '", club_id="' . $clubdata['id'] . '", sendtime="' . time() . '" WHERE id="' . $tmp_dt['id'] . '")';
                                } else {
                                    $tmp_sql[] = 'INSERT INTO game_club_bewerbung VALUES("", "' . $_SESSION['userid'] . '", "' . $clubdata['id'] . '", "' . $FormVars['p_bewerbungstext'] . '", "' . time() . '")';
                                }
                                for($x=0;$x!=count($tmp_sql);$x++) { if(@mysql_query($tmp_sql[$x])) { $tmp_sql_ok++; } }
                                if($tmp_sql_ok == count($tmp_sql)) {
                                    $ERROR['power'] = TRUE; $tmp_nr = '03';
                                } else { $ERROR['power'] = TRUE; $tmp_nr = '02'; }
                            } else { $ERROR['power'] = TRUE; $tmp_nr = '01'; }
                        }
                    }
                } else { $ERROR['power'] = TRUE; $tmp_nr = '04'; }
            }
            if(!empty($erste_apply)) { $tmp_hinweis = '<font color="red">{CLUBPROFIL_HINWEIS}</font>'; } else { $tmp_hinweis = ''; }
            $tmp_vars = array(  '{CLUBPROFIL_VLU_TITEL}'        => '[' . $clubdata['tag'] . '] - ' . $clubdata['name'],
                                '{CLUBPROFIL_VLU_BILD}'         => $tmp_logo,
                                '{CLUBPROFIL_VLU_ABOUT}'        => nl2br($tmp_about),
                                '{CLUBPROFIL_VLU_BEWERBUNG}'    => $tmp_bewerbung,
                                '{CLUBPROFIL_VLU_APPLY_HINWEIS}'=> $tmp_hinweis,
                                '{CLUBPROFIL_VLU_CID}'          => $clubdata['id'],
                                '{CLUBPROFIL_VLU_MEMBER}'       => $tmp_member_value          );
        } else { $ERROR['power'] = TRUE; $tmp_nr = '01'; }
    } else { $ERROR['power'] = TRUE; $tmp_nr = '00'; }
    // Template laden
    if($ERROR['power']) {
        $vars['error'] = array( '{ERROR_MESSAGE}' => '{CLUBPROFIL_ERROR_' . $tmp_nr . '}');
    } else {
        $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'clubprofil', EXT_TEMPS );
    }
    // Platzhalter füllen
    $vars['content']        =   array( '{CONTENT}' => $tmp_section_content, '{CLUBPROFIL_ERGEBNIS}' => $tmp_ergebnis );
    $vars['content']        =   array_merge($vars['content'], $tmp_vars, $LANG['game']['clubprofil']);
} else {$vars['content']        =   array( '{CONTENT}' => $LANG['root']['verweigert']);}

?>

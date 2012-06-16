<?php

if($_SESSION['logged']) {
    // Dafür sorgen das genügend Jobs vorhanden sind ..
    $sql = 'SELECT * FROM game_userjobs WHERE user_id="0"';
    $result = @mysql_query($sql);
    $anzahl = @mysql_num_rows($result);
    if(empty($anzahl)) { $DEFAULTS['game']['free_jobs'] = 50; }
    if($anzahl <= $DEFAULTS['game']['free_jobs']) {
        for($x=$anzahl;$x!=$DEFAULTS['game']['free_jobs'];$x++) {
            $tmp_jid = rand(0, (count($JOBNAMES)-1));
            $sql = 'INSERT INTO game_userjobs VALUES("", "0", "0", "' . $tmp_jid . '", "1", "0", "0")';
            @mysql_query($sql);
        }
    }
    $tmp_vars = array();
    switch($FormVars['d']) {
        case 'fireit':
            $sql = 'SELECT * FROM game_busy WHERE user_id="' . $_SESSION['userid'] . '" LIMIT 1';
            $result = @mysql_query($sql);
            $anzahl = @mysql_num_rows($result);
            if(empty($anzahl)) {
                $tmp_if = @mysql_fetch_array(@mysql_query('SELECT game_userjobs.job_get AS jget, job_id FROM game_userjobs WHERE user_id="' . $_SESSION['userid'] . '"'));
                if(($tmp_if['jget'] + (3600 * 24)) <= time()) {
                    $sql = 'DELETE FROM game_userjobs WHERE user_id="' . $_SESSION['userid'] . '"';
                    $tmp_msg_kat = 0;
                    $tmp_msg_id = 2;
                    $tmp_msg_vars = array();
                    $tmp_send_msg = addcslashes( array2text( loadTemplate( DIR_LANGUAGE . PAGE_LANGUAGE . '/system/', $MSG[$tmp_msg_kat][$tmp_msg_id], EXT_TEXT ), $tmp_msg_vars ), "\"'");
                    $sql2 = 'INSERT INTO game_nachrichten VALUES(NULL, "0", "' . $_SESSION['userid'] . '", "' . $BETREFF[$tmp_msg_kat][$tmp_msg_id] . '", "' . $tmp_send_msg . '", "' . time() . '", "1", "0")';
                    if(@mysql_query($sql) && @mysql_query($sql2)) {
                        $ERROR['power'] = true; $tmp_nr = '08';
                    } else { $ERROR['power'] = true; $tmp_nr = '06'; }
                } else { $ERROR['power'] = true; $tmp_nr = '05'; }
            } else { $ERROR['power'] = true; $tmp_nr = '09'; }
            break;

        case 'getit':
            $anzahl = @mysql_num_rows(@mysql_query('SELECT * FROM game_userjobs WHERE user_id="' . $_SESSION['userid'] . '" LIMIT 1'));
            if(empty($anzahl)) {
                if(isset($FormVars['jid'])) {
                    $sql = 'SELECT * FROM game_userjobs WHERE user_id="0" && job_id="' . $FormVars['jid'] . '" LIMIT 1';
                    $result = @mysql_query($sql);
                    $anzahl = @mysql_num_rows($result);
                    if(!empty($anzahl)) {
                        $data = @mysql_fetch_array($result);
                        $sql = 'UPDATE game_userjobs SET user_id="' . $_SESSION['userid'] . '", job_get="' . time() . '", job_last="' . time() . '" WHERE id="' . $data['id'] . '"';
                        $tmp_msg_kat = 0;
                        $tmp_msg_id = 0;
                        $tmp_msg_vars = array( '{ARBEIT}'  => $JOBNAMES[$FormVars['jid']], '{LOHN}'    => number_format($JOBLOHN[$FormVars['jid']][0],2,",",".") . $DEFAULTS['game']['waehrung'] );
                        $tmp_send_msg = addcslashes( array2text( loadTemplate( DIR_LANGUAGE . PAGE_LANGUAGE . '/system/', $MSG[$tmp_msg_kat][$tmp_msg_id], EXT_TEXT ), $tmp_msg_vars ), "\"'");
                        @mysql_query('INSERT INTO game_nachrichten VALUES(NULL, "0", "' . $_SESSION['userid'] . '", "' . $BETREFF[$tmp_msg_kat][$tmp_msg_id] . '", "' . $tmp_send_msg . '", "' . time() . '", "1", "0")');
                        if(@mysql_query($sql)) {
                            $ERROR['power'] = true; $tmp_nr = '07';
                        } else { $ERROR['power'] = true; $tmp_nr = '06'; }
                    } else { $ERROR['power'] = true; $tmp_nr = '04'; }
                } else { $ERROR['power'] = true; $tmp_nr = '03'; }
            } else { $ERROR['power'] = true; $tmp_nr = '02'; }
            break;

        case 'details':
            $sql = 'SELECT * FROM game_userjobs WHERE user_id="0" && job_id="' . $FormVars['jid'] . '" LIMIT 1';
            $result1 = @mysql_query($sql);
            $anzahl1 = @mysql_num_rows($result1);
            if(empty($anzahl1)) { $tmp_desabled = 'disabled'; } else { $tmp_desabled = ''; }
            $tmp_bild = DIR_T_I_SIGNS . 'job_' . $FormVars['jid'] . '.jpg';;
            if(file_exists($tmp_bild)) { $tmp = getimagesize($tmp_bild); $tmp_bild = '<img src="' . $tmp_bild . '" border="0">'; $tmp_bildwh = $tmp[2]; } else { $tmp_bild = $LANG['game']['jobs']['{JOBS_NO_BILD}']; $tmp_bildwh = 'width="400" height="200"'; }
            $tmp_vars = array(      '{JOBS_VLU_BERUFBILD}'      => $tmp_bild,
                                    '{JOBS_VLU_BILDWH}'         => $tmp_bildwh,
                                    '{JOBS_VLU_NAME}'           => $JOBNAMES[$FormVars['jid']],
                                    '{JOBS_VLU_DISABLED}'       => $tmp_desabled,
                                    '{JOBS_VLU_HOURLOHN}'       => number_format($JOBLOHN[$FormVars['jid']][0],2,",",".") . $DEFAULTS['game']['waehrung'],
                                    '{JOBS_VLU_TAGESLOHN}'      => number_format(($JOBLOHN[$FormVars['jid']][0] * 10),2,",",".") . $DEFAULTS['game']['waehrung'],
                                    '{JOBS_VLU_JOBID}'          => $FormVars['jid']
                             );
            // Template laden
            $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'jobboerse_details', EXT_TEMPS );
            break;

        default:
            $anzahl = @mysql_num_rows(@mysql_query('SELECT * FROM game_userjobs WHERE user_id="' . $_SESSION['userid'] . '" LIMIT 1'));
            if(empty($anzahl)) { $tmp_vars = array( '{JOBS_VLU_FIRE}' => '' ); } else { $tmp_vars = array( '{JOBS_VLU_FIRE}' => '' /*' Button um Job zu kündigen -> <tr><form action="index.php?c=jobboerse&d=fireit" method="POST"><td width="100%" align="center" colspan="3"><input class="txtfeld" type="submit" value="' . $LANG['game']['jobs']['{JOBS_FIRE}'] . '"></td></form></tr>' */ ); }
            $anzahl = count($JOBNAMES);
            if(!empty($anzahl)) {
                $tmp_ergebnis = '';
                for($x=0;$x!=$anzahl;$x++) {
                    $sql = 'SELECT * FROM game_userjobs WHERE job_id="' . $x . '" && user_id!="0" ORDER BY job_get ASC';
                    $tmp_work = @mysql_num_rows(@mysql_query($sql));
                    $sql = 'SELECT * FROM game_userjobs WHERE job_id="' . $x . '" && user_id="0"';
                    $tmp_free = @mysql_num_rows(@mysql_query($sql));
                    $tmp_jobname = '<a href="index.php?c=jobboerse&d=details&jid=' . $x . '">' . $JOBNAMES[$x] . '</a>';
                    $tmp_ergebnis .= '<tr><td width="33%" align="left">' . $tmp_jobname . '</td><td width="33%" align="center">' . $tmp_free . '</td><td width="34%" align="center">' . $tmp_work . '</td></tr>';
                }
            } else { $tmp_ergebnis .= '<tr><td width="100%" align="center" colspan="4">{JOBS_NO_JOBS}</td></tr>'; }
            // Template laden
            $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'jobboerse', EXT_TEMPS );
            break;
    }
    $vars['error'] = array( '{ERROR_MESSAGE}' => '{JOBS_ERROR_' . $tmp_nr . '}');

    // Platzhalter füllen
    $vars['content']        =   array( '{CONTENT}' => $tmp_section_content, '{JOBS_BERUFE_CONTENT}' => $tmp_ergebnis );
    $vars['content']        =   array_merge($vars['content'], $LANG['game']['jobs'], $tmp_vars);
} else {$vars['content']        =   array( '{CONTENT}' => $LANG['root']['verweigert']);}

?>

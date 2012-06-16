<?php

    // Fortfahren mit der eigentlichen Funktion ..
    $tmp_vars = array();
    $sql = 'SELECT * FROM game_userjobs WHERE user_id="' . $_SESSION['userid'] . '" LIMIT 1';
    $result = @mysql_query($sql);
    $anzahl = @mysql_num_rows($result);;
    if(!empty($anzahl)) {
        $data = @mysql_fetch_array($result);
        // Will der Benutzer arbeiten gehen?
        if(!empty($FormVars['check'])) {
            if($FormVars['p_work'] >= 1 && $FormVars['p_work'] <= 10) {
                $sql = 'SELECT * FROM game_user WHERE id="' . $_SESSION['userid'] . '" LIMIT 1';
                $result = @mysql_query($sql);
                $anzahl = @mysql_num_rows($result);
                if(!empty($anzahl)) {
                    $userinfo = @mysql_fetch_array($result);
                    $sql = 'SELECT * FROM game_busy WHERE user_id="' . $_SESSION['userid'] . '" LIMIT 1';
                    $result = @mysql_query($sql);
                    $anzahl = @mysql_num_rows($result);
                    if(empty($anzahl)) {
                        $tmp_sql = array(); $mp_sql_ok = 0;
                        $tmp_do_after = 'UPDATE game_userjobs SET job_exp=\"' . ($data['job_exp'] + (rand(2,8) * $FormVars['p_work'])) . '\", job_last=\"' . time() . '\" WHERE id=\"' . $data['id'] . '\"';
                        $tmp_sql[] = 'INSERT INTO game_busy VALUES("", "' . $_SESSION['userid'] . '", "' . (time() + (3600 * $FormVars['p_work']) + $WORKTIME[5]) . '", "4", "' . ($JOBLOHN[$data['job_id']][$data['job_level']-1] * $FormVars['p_work']) . '", "1", "' . $tmp_do_after . '")';
                        for($x=0;$x!=count($tmp_sql);$x++) { if(@mysql_query($tmp_sql[$x])) { $tmp_sql_ok++; } }
                        if(count($tmp_sql) == $tmp_sql_ok) {
                            $ERROR['power'] = true; $tmp_nr = "06";
                        } else { $ERROR['power'] = true; $tmp_nr = "05"; }
                    } else { $ERROR['power'] = true; $tmp_nr = "04"; }
                } else { $ERROR['power'] = true; $tmp_nr = "03"; }
            } else { $ERROR['power'] = true; $tmp_nr = "02"; }
        }
        // Fortschritt des Berufsziels errechnen
        $z_now_exp  = $data['job_exp'] + $JOBLEVEL[$data['job_id']][$data['job_level']-1];
        $z_max_exp  = $JOBLEVEL[$data['job_id']][count($JOBLEVEL[$data['job_id']])-1];
        $z_prozent_now = round(($z_now_exp / $z_max_exp) * 100, 0);
        $z_prozent_rest = 100 - $z_prozent_now;
        // Fortschritt bis Beförderung errechnen
        $b_now_exp = $data['job_exp'];
        $b_max_exp = $JOBLEVEL[$data['job_id']][$data['job_level']];
        $b_prozent_now = round(($b_now_exp / $b_max_exp) * 100, 0);
        $b_prozent_rest = 100 - $b_prozent_now;
        // Ohne Berechnungen fortfahren
        $sql = 'SELECT * FROM game_busy WHERE user_id="' . $_SESSION['userid'] . '" LIMIT 1';
        $result = @mysql_query($sql);
        $anzahl = @mysql_num_rows($result);
        if(empty($anzahl)) {
            $tmp_dauer = '<option selected value="1">1 h</option>';
            for($x=2;$x<=10;$x++) { $tmp_dauer .= '<option value="' . $x . '">' . $x . ' h</option>'; }
            $tmp_content = array2text( loadTemplate( DIR_T_H_GAME, 'arbeit_go2work', EXT_TEMPS ), array( '{ARBEIT_VLU_ARBEITSZEIT}' => $tmp_dauer ) );

        } else { $tmp_content = ''; }
        $tmp_vars = array(  '{ARBEIT_VLU_NAME}'         => $JOBNAMES[$data['job_id']],
                            '{ARBEIT_VLU_GET}'          => date("d.m.Y", $data['job_get']),
                            '{ARBEIT_VLU_EXP}'          => $data['job_exp'],
                            '{ARBEIT_VLU_LOHN}'         => number_format($JOBLOHN[$data['job_id']][$data['job_level']-1],2,",",".") . $DEFAULTS['game']['waehrung'],
                            '{ARBEIT_VLU_FIN_NOW}'      => $z_prozent_now,
                            '{ARBEIT_VLU_FIN_REST}'     => $z_prozent_rest,
                            '{ARBEIT_VLU_LVL_NOW}'      => ($data['job_level'] - 1),
                            '{ARBEIT_VLU_LVL_MAX}'      => count($JOBLEVEL[$data['job_id']]) - 1,
                            '{ARBEIT_VLU_FIN_LVL_NOW}'  => $b_prozent_now,
                            '{ARBEIT_VLU_FIN_LVL_MAX}'  => $b_prozent_rest,
                            '{ARBEIT_VLU_DAYLOHN}'      => number_format((10 * $JOBLOHN[$data['job_id']][$data['job_level']]),2,",",".") . $DEFAULTS['game']['waehrung'],
                            '{ARBEIT_GO2WORK_CONTENT}'  => $tmp_content
                         );
    } else { $ERROR['power'] = true; $tmp_nr = "01"; }

    if($ERROR['power']) {
        // Fehlermeldung übergeben bei einem Fehler
        $vars['error'] = array( '{ERROR_MESSAGE}' => '{ARBEIT_ERROR_' . $tmp_nr . '}');
    } else {
        // Template laden
        $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'arbeit', EXT_TEMPS );
    }

    // Platzhalter füllen
    $vars['content']        =   array( '{CONTENT}' => $tmp_section_content );
    $vars['content']        =   array_merge($vars['content'], $tmp_vars, $LANG['game']['arbeit']);

?>

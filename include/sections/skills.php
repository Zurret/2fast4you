<?php

    // Benötigte Informationen laden
    $sql = 'SELECT * FROM game_userskills';
    $result = @mysql_query($sql);
    $anzahl = @mysql_num_rows($result);
    $tmp_vars = array();
    $tmp_content = '';
    $user_got = FALSE;
    @mysql_data_seek($result, 0);
    while($data = @mysql_fetch_array($result)) { if($data['user_id'] == $_SESSION['userid']) { $tmp_skills = $data; $user_got = TRUE; break(1); } }
    if($user_got) {
        $tmp = explode('#', $tmp_skills['skl_werte']);
        for($i=0;$i!=count($tmp);$i++) {
            $ttmp = explode(':', $tmp[$i]);
            $tmp_loaded = loadTemplate( DIR_T_H_GAME, 'skills_table', EXT_TEMPS );
            $tmp_mx = count($SKILLLEVELS) - 1;
            for($x=0;$x!=$tmp_mx;$x++) {
                if($ttmp[1] <= $SKILLLEVELS[$x]) {
                    for($e=0;$e!=count($SKILLLEVELS);$e++) {
                        if($SKILLLEVELS[$e] <= $ttmp[1]) {
                            $tmp_skl_max = $SKILLVALUES[$ttmp[0]][$e];
                        }
                    }
                    $tmp_pzt_now = round(($ttmp[2] / $tmp_skl_max) * 100, 0);
                    $tmp_pzt_max = 100 - $tmp_pzt_now;
                    break(1);
                }
            }
            $tmp_info = array(  '{SKILLS_VLU_TOPIC}'        => $SKILLNAMES[$ttmp[0]],
                                '{SKILLS_VLU_LVL_NOW}'      => $ttmp[1],
                                '{SKILLS_VLU_PZT_NOW}'      => $tmp_pzt_now,
                                '{SKILLS_VLU_PZT_REST}'     => $tmp_pzt_max,
                                '{SKILLS_VLU_EXP_NOW}'      => $ttmp[2],
                                '{SKILLS_VLU_EXP_MAX}'      => $tmp_skl_max                     );
            $tmp_content .= array2text( $tmp_loaded, $tmp_info );
        }
    } else { $tmp_content = '<tr><td width="100%" align="center" height="50">{SKILLS_NO_SKILLS}</td></tr>'; }

    // Template laden
    $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'skills', EXT_TEMPS );

    // Platzhalter füllen
    $vars['content']        =   array( '{CONTENT}' => $tmp_section_content, '{SKILLS_CONTENT}' => $tmp_content );
    $vars['content']        =   array_merge($vars['content'], $tmp_vars, $LANG['game']['skills']);

?>

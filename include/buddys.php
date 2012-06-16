<?php

// Wenn Benutzer eingeloggt, die Buddys initialisieren.
if($_SESSION['logged']) {
    require( DIR_LANGUAGE . PAGE_LANGUAGE . '/buddys' . EXT_CODE );
    require( DIR_LANGUAGE . PAGE_LANGUAGE . '/busy' . EXT_CODE );
    $result = @mysql_query('SELECT * FROM game_buddys WHERE user_id="' . $_SESSION['userid'] . '"');
    $anzahl = @mysql_num_rows($result);
    if(!empty($anzahl)) {
        $data = @mysql_fetch_array($result);
        $buddys = array();
        $buddys_on = array();
        $buddys_off = array();
        $tmp = explode(';', $data['buddys']);
        for($x=0;$x!=count($tmp);$x++) { $buddys[] = $tmp[$x]; }
        arsort($buddys);
        $tmp_time = (time() - ($DEFAULTS['game']['online_user'] * 60));
        for($x=0;$x!=count($buddys);$x++) {
            $work_rslt = @mysql_query('SELECT * FROM game_busy WHERE user_id="' . $buddys[$x] . '" LIMIT 1');
            $userinfo = @mysql_fetch_array(@mysql_query('SELECT * FROM game_user WHERE id="' . $buddys[$x] . '" LIMIT 1'));
            $buddy_on_work = @mysql_num_rows($work_rslt);
            if(!empty($buddy_on_work)) {
                $buddy_work = @mysql_fetch_array($work_rslt);
                $buddy_time = ceil(($buddy_work['ende'] - time()) / 60);
                if($buddy_time > 15) { $buddy_time = '>15m'; } else { $buddy_time .= 'm'; }
                $buddy_working = '<img src="' . DIR_T_I_ICONS . 'busy.gif" border="0" title="' . $buddy_time . ' » ' . $LANG['game']['busy'][$buddy_work['work_on']] . '">';
            } else { $buddy_working = ''; }
            if($userinfo['last_action'] >= $tmp_time) {
                $buddys_on[] = '<tr><td width="10%" align="center" valign="middle" height="20"><div style="margin: 2px;"><img src="' . DIR_T_I_ICONS . 'on.gif" border="0" title="» Online"></div></td><td width="55%" align="left" valign="middle" height="20"><div style="margin: 2px;"><a href="index.php?c=profil&id=' . $userinfo['id'] . '">' . $userinfo['nick'] . '</a></div></td><td width="35%" align="right" valign="middle" height="20"><div style="margin-right: 2px;">' . $buddy_working . '&nbsp;<a href="index.php?c=nachrichten&d=write&uid=' . $userinfo['id'] . '"><img src="' . DIR_T_I_ICONS . 'msg_on.gif" border="0" title="» {BUDDYS_MSG}"></a></div></td></tr>';
            } else {
                $buddys_off[] = '<tr><td width="10%" align="center" valign="middle" height="20"><div style="margin: 2px;"><img src="' . DIR_T_I_ICONS . 'off.gif" border="0" title="» Offline"></div></td><td width="55%" align="left" valign="middle" height="20"><div style="margin: 2px;"><a href="index.php?c=profil&id=' . $userinfo['id'] . '">' . $userinfo['nick'] . '</a></div></td><td width="35%" align="right" valign="middle" height="20"><div style="margin-right: 2px;">' . $buddy_working . '&nbsp;<a href="index.php?c=nachrichten&d=write&uid=' . $userinfo['id'] . '"><img src="' . DIR_T_I_ICONS . 'msg_off.gif" border="0" title="» {BUDDYS_MSG}"></a></div></td></tr>';
            }
        }
        $tmp_buddys = ''; $output = array_merge( $buddys_on, $buddys_off );
        for($x=0;$x!=count($output);$x++) { $tmp_buddys .= $output[$x]; }
        // Busy Dialog einschalten/ausschalten
        $BUDDYS['power']  = true;
        $vars['buddys']  =   array_merge( array(  '{BUDDYS_BUDDYS}'     => $tmp_buddys
                                               ), $LANG['buddys'] );
    }
} else { $BUDDYS['power'] = false; }

?>

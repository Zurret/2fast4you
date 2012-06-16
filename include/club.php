<?php

    require( DIR_LANGUAGE . PAGE_LANGUAGE . '/club_menu' . EXT_CODE );

    $got_club = FALSE;
    $tmp_club = @mysql_query('SELECT * FROM game_club');
    $tmp_club_count = @mysql_num_rows($tmp_club);
    if(!empty($tmp_club_count)) {
        while($tmp_data = @mysql_fetch_array($tmp_club)) {
            $tmp = explode('#', $tmp_data['member']);
            for($x=0;$x!=count($tmp);$x++) {
                $ttmp = explode(':', $tmp[$x]);
                if($ttmp[0] == $_SESSION['userid']) { $got_club = TRUE; break(2); }
            }
        }
    }

    if($got_club) {
        $tmp_clubnav = '<tr><td width="100%" align="center" height="20"><a href="index.php?c=club&d=myclub">{CLUB_SNAV_01}</a></td></tr>';
    } else {
        $tmp_clubnav = '<tr><td width="100%" align="center" height="20"><a href="index.php?c=club&d=new">{CLUB_SNAV_02}</a></td></tr>';
    }

    $tmp_clubnav .= '<tr><td width="100%" align="center" height="20"><a href="index.php?c=rangliste&type=club">{CLUB_SNAV_03}</a></td></tr>';

    $vars['club']  =   array_merge( array(  '{CLUB_NAVIGATION}'     => $tmp_clubnav
                                     ), $LANG['game']['clubmenu'] );

?>

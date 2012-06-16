<?
    include_once( 'include/functions.php' );
    include_once( 'include/settings.php' );
    include_once( 'include/msgsystem.php' );

    // Einstellungen laden ..
    include("../include/mysql.php");
    include("_inc.php");

    $abfrage=@mysql_query("SELECT bank,id FROM game_user WHERE bank!=0")or die(mysql_error());
    while ($check = mysql_fetch_object($abfrage)) {
        $alt = $check->bank;
        $neu = ceil(geld2zinsen($check->bank));
        mysql_query('UPDATE game_user SET bank="'.$neu.'" WHERE id='.$check->id);
        $tmp_msg_kat = 2;
        $tmp_msg_id = 1;
        $tmp_msg_vars = array( '{MONEY}' => number_format($alt,2,",",".") . $DEFAULTS['game']['waehrung'], '{NEW_MONEY}' => number_format($neu,2,",",".") . $DEFAULTS['game']['waehrung'] );
        $tmp_send_msg = array2text( loadTemplate( '../' . DIR_LANGUAGE . PAGE_LANGUAGE . '/system/', $MSG[$tmp_msg_kat][$tmp_msg_id], EXT_TEXT ), $tmp_msg_vars );
        @mysql_query('INSERT INTO game_nachrichten VALUES(NULL, "0", "' . $check->id . '", "' . $BETREFF[$tmp_msg_kat][$tmp_msg_id] . '", "' . $tmp_send_msg . '", "' . time() . '", "1", "0")');
    }


    /* $qry = mysql_query("SELECT preis, verkauft, verkauft_vortag FROM game_sprit WHERE id=1") or die(mysql_error());
    $ab = mysql_fetch_array($qry);

    $qry2 = mysql_query("SELECT id FROM game_sprit_preise ORDER BY id LIMIT 0,1") or die(mysql_error());
    $ab2 = mysql_fetch_array($qry2);

    mysql_query('DELETE FROM game_sprit_preise WHERE id="'.$ab2['id'].'"') or die(mysql_error());

    if($ab['verkauft']!=0 && $ab['verkauft_vortag']!=0){
    	$p= $ab['preis']*($ab['verkauft']/$ab['verkauft_vortag']/1.7);
    	mysql_query('UPDATE game_sprit SET preis="'.round($p,3).'",verkauft_vortag="'.$ab['verkauft'].'", verkauft=0 WHERE id=1') or die(mysql_error());
    	mysql_query('INSERT INTO game_sprit_preise VALUES("","'.$p.'","'.date("d.m.Y",time()).'")') or die(mysql_error());
    }else{
    	mysql_query('INSERT INTO game_sprit_preise VALUES("","'.($ab['preis']+1).'","'.date('d.m.Y',time()).'")') or die(mysql_error());
    	mysql_query('UPDATE game_sprit SET verkauft_vortag="'.$ab['verkauft'].'", verkauft=0 WHERE id=1') or die(mysql_error());

    }
    include("tankstelle_grafik.php"); */




    // Sponsorbonus auszahlen
    $result = @mysql_query('SELECT * FROM game_sponsoren WHERE user_id!=0');
    $anzahl = @mysql_num_rows($result);
    if(!empty($anzahl)) {
        while($sdta = @mysql_fetch_array($result)) {
            $udata = @mysql_fetch_array(@mysql_query('SELECT bank FROM game_user WHERE id="' . $sdta['user_id'] . '" LIMIT 1'));
            $basis = $sdta['sprs_basis'];
            $bonus = $sdta['sprs_bonus'] * $sdta['sprs_now_wins'];
            $all_bonus = round($basis / 7, 0) + $bonus;
            $tmp_msg_kat = 3;
            $tmp_msg_id = 1;
            $tmp_msg_vars = array( '{SIEGE}' => $sdta['sprs_now_wins'], '{BONUS}' => number_format($bonus,2,",",".") . $DEFAULTS['game']['waehrung'], '{BASIS}' => number_format($basis,2,",",".") . $DEFAULTS['game']['waehrung'],'{BETRAG}' => number_format($all_bonus,2,",",".") . $DEFAULTS['game']['waehrung'] );
            $tmp_send_msg = array2text( loadTemplate( '../' . DIR_LANGUAGE . PAGE_LANGUAGE . '/system/', $MSG[$tmp_msg_kat][$tmp_msg_id], EXT_TEXT ), $tmp_msg_vars );
            $tmp_sql[] = 'INSERT INTO game_nachrichten VALUES(NULL, "0", "' . $sdta['user_id'] . '", "' . $BETREFF[$tmp_msg_kat][$tmp_msg_id] . '", "' . $tmp_send_msg . '", "' . time() . '", "1", "0")';
            $tmp_sql[] = 'UPDATE game_user SET bank="' . ($udata['bank'] + $all_bonus) . '" WHERE id="' . $sdta['user_id'] . '"';
            $tmp_sql[] = 'UPDATE game_sponsoren SET sprs_now_wins="0" WHERE id="' . $sdta['id'] . '"';
        }
        for($x=0;$x!=count($tmp_sql);$x++) { @mysql_query($tmp_sql[$x]); }
    }




mysql_close($tmp_connection);

?>
<?php

    // Die letzten Aktionzeitpunkt des Benutzers merken
    @mysql_query( 'UPDATE game_user SET last_action="'.time().'" WHERE id="'.$_SESSION['userid'].'"' );

    // Garage dem Benutzer geben wenn keine vorhanden ist
    if(!empty($_SESSION['userid'])) { $anzahl = @mysql_num_rows(@mysql_query('SELECT * FROM game_garage WHERE user_id="' . $_SESSION['userid'] . '" LIMIT 1')); if(empty($anzahl)) { @mysql_query('INSERT INTO game_garage VALUES("", "' . $_SESSION['userid'] . '", "0", "0", "0", "0")'); } }

    // Jobs aktuell mit den Levels halten ..
    $sql = 'SELECT * FROM game_userjobs';
    $result = @mysql_query($sql);
    $anzahl = @mysql_num_rows($result);
    if(!empty($anzahl)) {
        while($data = @mysql_fetch_array($result)) {
            if($JOBLEVEL[$data['job_id']][$data['job_level']] <= $data['job_exp']) {
                @mysql_query('UPDATE game_userjobs SET job_exp="' . ($data['job_exp'] - $JOBLEVEL[$data['job_id']][$data['job_level']]) . '", job_level="' . ($data['job_level'] + 1) . '" WHERE id="' . $data['id'] . '"');
                $tmp_msg_kat = 0;
                $tmp_msg_id = 1;
                $tmp_msg_vars = array( '{LOHN}' => number_format($JOBLOHN[$data['job_id']][$data['job_level']],2,",",".") . $DEFAULTS['game']['waehrung'] );
                $tmp_send_msg = addcslashes( array2text( loadTemplate( DIR_LANGUAGE . PAGE_LANGUAGE . '/system/', $MSG[$tmp_msg_kat][$tmp_msg_id], EXT_TEXT ), $tmp_msg_vars ), "\"'");
                @mysql_query('INSERT INTO game_nachrichten VALUES(NULL, "0", "' . $data['user_id'] . '", "' . $BETREFF[$tmp_msg_kat][$tmp_msg_id] . '", "' . $tmp_send_msg . '", "' . time() . '", "1", "0")');
            }
        }
    }

    // Fähigkeiten nicht zu groß werden lassen ..
    $sql = 'SELECT * FROM game_userskills';
    $result = @mysql_query($sql);
    $anzahl = @mysql_num_rows($result);
    if(!empty($anzahl)) {
        while($data = @mysql_fetch_array($result)) {
            $tmp_edited = '';
            $tmp = explode('#', $data['skl_werte']);
            for($i=0;$i!=count($tmp);$i++) {
                $ttmp = explode(':', $tmp[$i]);
                $tmp_mx = count($SKILLVALUES[$ttmp[0]]) - 1;
                for($x=$tmp_mx;$x>=0;$x--) {
                    if($ttmp[1] >= $SKILLLEVELS[$x]) {
                        if($ttmp[2] >= $SKILLVALUES[$ttmp[0]][$SKILLLEVELS[$x]]) {
                            $ttmp[1]++;
                            $ttmp[2] -= $SKILLVALUES[$ttmp[0]][$x];
                            if($ttmp[2] <= $SKILLVALUES[$ttmp[0]][$SKILLLEVELS[$x]]) { break(1); }
                        }
                    }
                }
                if(!empty($i)) { $tmp_edited .= '#'; }
                $tmp_edited .= $ttmp[0] . ':' . $ttmp[1] . ':' . $ttmp[2];
            }
            @mysql_query('UPDATE game_userskills SET skl_werte="' . $tmp_edited . '" WHERE id="' . $data['id'] . '"');
        }
    }

    // Inaktive Benutzer die 2 Wochen lang nicht eingeloggt waren zu den löschenden Accounts setzen
    $tmp_ultimatedate = time() - (14 * (24 * 3600));
    $tmp_deletedate = time() + (24 * 3600);
    $result = @mysql_query('SELECT * FROM game_user WHERE now_login<="' . $tmp_ultimatedate . '"');
    $anzahl = @mysql_fetch_array($result);
    if(!empty($anzahl)) { while($data = @mysql_fetch_array($result)) { $schon = @mysql_num_rows(@mysql_query('SELECT * FROM game_delete WHERE user_id="' . $data['id'] . '" LIMIT 1')); if(empty($schon)) { @mysql_query('INSERT INTO game_delete VALUES("", "' . $data['id'] . '", "' . $tmp_deletedate . '")'); } } }

    // Tuninginfo setzen wenn nicht vorhanden!
    $result = @mysql_query('SELECT * FROM game_garage');
    $tmp_ad = ''; for($x=0;$x!=count($TUNE);$x++) { if(!empty($x)) { $tmp_ad .= '#'; } $tmp_ad .= 'w;100'; }
    while($data = @mysql_fetch_array($result)) {
        $rslt = @mysql_query('SELECT * FROM game_incars WHERE garage_id="' . $data['id'] . '" LIMIT 1');
        $anzl = @mysql_num_rows($rslt);
        if(!empty($anzl)) {
            $sqlq = @mysql_fetch_array($rslt);
            if(empty($sqlq)) { @mysql_query('UPDATE game_incars SET tuned="' . $tmp_ad . '" WHERE garage_id="' . $data['id'] . '"'); }
        } else { @mysql_query('INSERT INTO game_incars VALUES("", "' . $data['user_id'] . '", "' . $data['id'] . '", "' . $tmp_ad . '")'); }
    }

    // Beendete Auktionen den Bietern gutschreiben oder dem Anbieter wieder zurückgeben
    $tsql = 'SELECT game_ubay.id AS id, bieter_id, ende, startpreis, tuning_id, user_id, tunname_id, zustand FROM game_ubay';
    $tresult = @mysql_query($tsql);
    $tanzahl = @mysql_num_rows($tresult);
    if(!empty($tanzahl)) {
        while($ubay = @mysql_fetch_array($tresult)) {
            if($ubay['ende'] <= time()) {
                if(!empty($ubay['bieter_id'])) {
                    $tmp_ok = 0;
                    // Verkaufspreis dem Anbieter gutschreiben, wenn Verkäufer noch exesitiert
                    $sql = 'SELECT game_user.money AS money FROM game_user WHERE id="' . $ubay['user_id'] . '"';
                    $result1 = @mysql_query($sql);
                    $anzahl = @mysql_num_rows($result1);
                    if(!empty($anzahl)) { $anbieter_info = @mysql_fetch_array($result1); $sql = 'UPDATE game_user SET money="' . ($anbieter_info['money'] + $ubay['startpreis']) . '" WHERE id="' . $ubay['user_id'] . '"';
                    if(@mysql_query($sql)) { $tmp_ok++; } }
                    // Artikel dem Höchstbietendem ins Lager legen
                    $sql = 'INSERT INTO game_lager VALUES("", "' . $ubay['bieter_id'] . '", "' . $ubay['tuning_id'] . '", "' . $ubay['zustand'] . '")';
                    if(@mysql_query($sql)) { $tmp_ok++; }
                    // Nachricht an den Käufer schicken
                    $tmp_msg_kat = 5;
                    $tmp_msg_id = 2;
                    $tmp_msg_vars = array( '{ARTIKEL}' => $TUNENAME[$ubay['tuning_id']][$ubay['tunname_id']], '{MONEY}' => number_format($ubay['startpreis'],2,",",".") . $DEFAULTS['game']['waehrung'] );
                    $tmp_send_msg = array2text( loadTemplate( DIR_LANGUAGE . PAGE_LANGUAGE . '/system/', $MSG[$tmp_msg_kat][$tmp_msg_id], EXT_TEXT ), $tmp_msg_vars );
                    $sql = 'INSERT INTO game_nachrichten VALUES(NULL, "0", "' . $ubay['bieter_id'] . '", "' . $BETREFF[$tmp_msg_kat][$tmp_msg_id] . '", "' . $tmp_send_msg . '", "' . time() . '", "1", "0")';
                    if(@mysql_query($sql)) { $tmp_ok++; }
                    // Nachricht an den Verkäufer schicken
                    $tmp_msg_kat = 5;
                    $tmp_msg_id = 0;
                    $tmp_msg_vars = array( '{ARTIKEL}' => $TUNENAME[$ubay['tuning_id']][$ubay['tunname_id']], '{MONEY}' => number_format($ubay['startpreis'],2,",",".") . $DEFAULTS['game']['waehrung'] );
                    $tmp_send_msg = array2text( loadTemplate( DIR_LANGUAGE . PAGE_LANGUAGE . '/system/', $MSG[$tmp_msg_kat][$tmp_msg_id], EXT_TEXT ), $tmp_msg_vars );
                    $sql = 'INSERT INTO game_nachrichten VALUES(NULL, "0", "' . $ubay['user_id'] . '", "' . $BETREFF[$tmp_msg_kat][$tmp_msg_id] . '", "' . $tmp_send_msg . '", "' . time() . '", "1", "0")';
                    if(@mysql_query($sql)) { $tmp_ok++; }
                    // Artikel aus der uBay-Tabelle entfernen
                    $sql = 'DELETE FROM game_ubay WHERE id="' . $ubay['id'] . '"';
                    if(@mysql_query($sql)) { $tmp_ok++; }
                    #if($tmp_ok == 5) { echo "<font color='green'>Alles OK</font>"; } else { echo "<font color='red'>Etwas ist Falsch!</font>"; }
                } else {
                    // Guthaben gutschreiben
                    $userdata = @mysql_fetch_array(@mysql_query('SELECT money FROM game_user WHERE id="' . $ubay['user_id'] . '" LIMIT 1'));
                    $sql = 'UPDATE game_user SET money="' . ($userdata['money'] + $ubay['startpreis']) . '" WHERE id="' . $ubay['user_id'] . '"';
                    @mysql_query($sql);
                    // Artikel wieder ins Lager legen
                    $sql = 'INSERT INTO game_lager VALUES("", "' . $ubay['user_id'] . '", "' . $ubay['tuning_id'] . '", "' . $ubay['zustand'] . '")';
                    @mysql_query($sql);
                    // Artikel aus uBay entfernen
                    $sql = 'DELETE FROM game_ubay WHERE id="' . $ubay['id'] . '"';
                    @mysql_query($sql);
                    // Nachricht an den Verkäufer schicken
                    $tmp_msg_kat = 5;
                    $tmp_msg_id = 1;
                    $tmp_msg_vars = array();
                    $tmp_send_msg = array2text( loadTemplate( DIR_LANGUAGE . PAGE_LANGUAGE . '/system/', $MSG[$tmp_msg_kat][$tmp_msg_id], EXT_TEXT ), $tmp_msg_vars );
                    $sql = 'INSERT INTO game_nachrichten VALUES(NULL, "0", "' . $ubay['user_id'] . '", "' . $BETREFF[$tmp_msg_kat][$tmp_msg_id] . '", "' . $tmp_send_msg . '", "' . time() . '", "1", "0")';
                    if(@mysql_query($sql)) { $tmp_ok++; }
                }
            }
        }
    }


	/*
	// Inaktive User nach 5 Tagen löschen!
	$sql = 'SELECT * FROM game_delete WHERE user_id="' . $_SESSION['userid'] . '" LIMIT 1';
	$result = @mysql_query($sql);
    $anzahl = @mysql_num_rows($result);
    if(empty($anzahl)) {
	    $sql = 'SELECT * FROM game_user WHERE last_action<="' . (time() - (5 * (24 * 3600))) . '"';
	    $result = @mysql_query($sql);
	    $anzahl = @mysql_num_rows($result);
	    if(!empty($anzahl)) {
	        while($data = @mysql_fetch_array($result)) {
	            if($data['delete'] <= time()) {
	                $tmp_sql = array();
	                $tmp_sql[] = 'INSERT INTO game_delete VALUES(NULL, "' . $data['id'] . '", "' . (time() + (24 * 3600) * 3) . '")';
	                for($x=0;$x!=count($tmp_sql);$x++) { @mysql_query($tmp_sql[$x]); }
	            }
	        }
	    }
	}
	*/
	
	// Ausgelaufene Sponsoren entfernen
	$sql = 'SELECT * FROM game_sponsoren';
	$result = @mysql_query($sql);
	$anzahl = @mysql_num_rows($result);
	if(!empty($anzahl)) {
		while($data = @mysql_fetch_array($result)) {
			if($data['sprs_get'] + ($data['sprs_dauer'] * (24 * 3600 * 7)) <= time() && $data['user_id'] != 0) {
				@mysql_query('DELETE FROM game_sponsoren WHERE id="' . $data['id'] . '" LIMIT 1');	
			}
		}			
	}
?>

<?php
if($_SESSION['logged']) {
    // Template laden
    $tmp_section_bank    = loadTemplate( DIR_T_H_GAME, 'bank', EXT_TEMPS );
    //eingabe check
    if(isset($FormVars['g']) && $FormVars['g']!=0){
    $ERROR['power'] = true;
    	if(is_numeric($FormVars['g'])===TRUE){
    		if($FormVars['g']>0){
				$qry = mysql_query("SELECT money,bank, bank_freigabe FROM game_user WHERE id='".$_SESSION['userid']."'");
    			$ab = mysql_fetch_array($qry);
    			if(isset($FormVars['e'])){	
    				if($ab['money']>=$FormVars['g']){
    					mysql_query('UPDATE game_user SET bank="'.floor($ab['bank']+$FormVars['g']).'", money="'.floor($ab['money']-$FormVars['g']).'", bank_freigabe="'.(time()+$WORKTIME[2]).'"  WHERE id="'.$_SESSION['userid'].'"');
                        $tmp_msg_kat = 2;
                        $tmp_msg_id = 0;
                        $tmp_msg_vars = array( '{MONEY}' => number_format($FormVars['g'],2,",",".") . $DEFAULTS['game']['waehrung'], '{SPERRE}' => ($WORKTIME[2] / 3600) . 'h' );
                        $tmp_send_msg = array2text( loadTemplate( DIR_LANGUAGE . PAGE_LANGUAGE . '/system/', $MSG[$tmp_msg_kat][$tmp_msg_id], EXT_TEXT ), $tmp_msg_vars );
                        @mysql_query('INSERT INTO game_nachrichten VALUES(NULL, "0", "' . $_SESSION['userid'] . '", "' . $BETREFF[$tmp_msg_kat][$tmp_msg_id] . '", "' . $tmp_send_msg . '", "' . time() . '", "1", "0")');
                        $error_m="OK_GO_IN";
					}else{
						$error_m="USER_NO_MONEY";
					}
    			}elseif(isset($FormVars['a'])){	
					if($ab['bank']>=$FormVars['g']){
						if($ab['bank_freigabe']<=time()){
    						mysql_query('UPDATE game_user SET bank="'.floor($ab['bank']-$FormVars['g']).'", money="'.floor($ab['money']+$FormVars['g']).'"  WHERE id="'.$_SESSION['userid'].'"');
                            $tmp_msg_kat = 2;
                            $tmp_msg_id = 2;
                            $tmp_msg_vars = array( '{MONEY}' => number_format($FormVars['g'],2,",",".") . $DEFAULTS['game']['waehrung'] );
                            $tmp_send_msg = array2text( loadTemplate( DIR_LANGUAGE . PAGE_LANGUAGE . '/system/', $MSG[$tmp_msg_kat][$tmp_msg_id], EXT_TEXT ), $tmp_msg_vars );
                            @mysql_query('INSERT INTO game_nachrichten VALUES(NULL, "0", "' . $_SESSION['userid'] . '", "' . $BETREFF[$tmp_msg_kat][$tmp_msg_id] . '", "' . $tmp_send_msg . '", "' . time() . '", "1", "0")');
                            $error_m="OK_GO_OUT";
						}else{
							$error_m="GESPERRT";
						}
    				}else{
						$error_m="BANK_NO_MONEY";
					}
    			} else { 
					$error_m="USER_NO_MONEY"; 
				}
    		} else { $error_m="TO_LOW"; }
    	} else { $error_m="NO_NUMBER"; }
    } else { $error_m="NO_INSERT"; }
    $vars['error'] = array( '{ERROR_MESSAGE}' => $LANG['bank']['BANK_ERROR_'.$error_m]);

    // Daten aus db Laden
    $qry = mysql_query("SELECT bank FROM game_user WHERE id='".$_SESSION['userid']."'");
    $ab = mysql_fetch_array($qry);

    // Platzhalter füllen
    $vars['content']        =   array(
                                        '{CONTENT}'         => $tmp_section_bank ,
    									'{BANK_KONTO}'		=> $LANG['bank']['BANK_KONTO'],
    									'{BANK_INHALT}'		=> number_format($ab['bank'],2,",","."),
    									'{BANK_WAEHRUNG}'	=> $DEFAULTS['game']['waehrung'],
    									'{BANK_TOPIC}'		=> $LANG['bank']['BANK_TOPIC'],
    									'{BANK_EINZAHLEN}'	=> $LANG['bank']['BANK_ZAHLIN'],
    									'{BANK_ABHEBEN}'	=> $LANG['bank']['BANK_ZAHLAUS'],
    									'{BANK_TEXT}'		=> loadTemplate( DIR_LANGUAGE . PAGE_LANGUAGE, '/bank', EXT_TEXT )
                                     );
} else {$vars['content']        =   array( '{CONTENT}' => $LANG['root']['verweigert']);}

?>

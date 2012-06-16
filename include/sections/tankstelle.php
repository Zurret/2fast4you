<?php

if($_SESSION['logged']) {
    // Template laden
    $tmp_section_tanke    = loadTemplate( DIR_T_H_GAME, 'tankstelle', EXT_TEMPS );

    if(isset($FormVars['t'])){
			$qry = mysql_query("SELECT id FROM game_busy WHERE user_id='".$_SESSION['userid']."'");
    		$ab = mysql_fetch_array($qry);
		if(!isset($ab['id'])){
    		if(isset($FormVars['s']) && !empty($FormVars['s'])){
    			if(is_numeric($FormVars['s'])===TRUE){
    				if($FormVars['s']>0){
    					$qry = mysql_query("SELECT game_garage.id as id,money,now_car,car_id FROM game_user INNER JOIN game_garage ON game_user.now_car=game_garage.id WHERE game_user.id='".$_SESSION['userid']."'");
						$ab = mysql_fetch_array($qry);
					
						$qry_tank = mysql_query("SELECT car_tank FROM game_garage WHERE id='".$ab['now_car']."'");
						$ab_tank = mysql_fetch_array($qry_tank);
						
						$qry_tank_m = mysql_query("SELECT tank_max FROM game_cars WHERE id='".$ab['car_id']."'");
						$ab_tank_m = mysql_fetch_array($qry_tank_m);
						
						$qry_s = mysql_query("SELECT preis FROM game_sprit WHERE id=1");
    					$ab_s = mysql_fetch_array($qry_s);
						
    					$s = floor($FormVars['s']);
    					if(($ab_tank_m['tank_max']-$ab_tank['car_tank'])>=$s){
    						$qry_s = mysql_query("SELECT preis, verkauft FROM game_sprit WHERE id=1");
    						$ab_s = mysql_fetch_array($qry_s);
    				 		if(($ab_s['preis']*$s)<=$ab['money']){
                            	$do_after = 'UPDATE game_sprit SET verkauft=\''.($ab_s['verkauft']+$s).'\' WHERE id=1|UPDATE game_garage SET car_tank=\''.($ab_tank['car_tank']+$s).'\' WHERE id=\''.$ab['id'].'\'';
                            	$sql = 'INSERT INTO game_busy VALUES("", "' . $_SESSION['userid'] . '", "' . (time() + ($WORKTIME[1] + ($FormVars['s'] * 3))) . '", "1", '.ceil($ab_s['preis']*$s).', "0", "' . $do_after . '")';
                            	mysql_query($sql);
                            	$error_m="OK";
    						}else{
    							$error_m="NO_MONEY";
    						}
    					}else{
    						$error_m="TO_MUCH";
    					}
    				}else{
    					$error_m="TO_LOW";
    				}
    			}else{
    				$error_m="NO_NUMBER";
    			}
    		}else{
    		$error_m="NO_INSERT";
    		}
		}else{
			 $error_m="BUSY";
		}
    	$ERROR['power'] = true;
    	$vars['error'] = array( '{ERROR_MESSAGE}' => $LANG['game']['tankstelle']['TANKSTELLE_ERROR_'.$error_m]);
 	}

    $qry = mysql_query("SELECT now_car,car_id FROM game_user INNER JOIN game_garage ON game_user.now_car=game_garage.id WHERE game_user.id='".$_SESSION['userid']."'");
    $ab = mysql_fetch_array($qry);

	$qry_tank = mysql_query("SELECT car_tank FROM game_garage WHERE id='".$ab['now_car']."'");
    $ab_tank = mysql_fetch_array($qry_tank);
	
	$qry_tank_m = mysql_query("SELECT tank_max FROM game_cars WHERE id='".$ab['car_id']."'");
    $ab_tank_m = mysql_fetch_array($qry_tank_m);
	

    $qry_s = mysql_query("SELECT preis FROM game_sprit WHERE id=1");
    $ab_s = mysql_fetch_array($qry_s);

	//diagramm

	if(isset($FormVars['d'])){
		$d = "<img src=\"templates/images/diagramme/t_p.png\" />";
	}else{
		$d = "<a href=\"?c=tanke&d=1\">Preis&uuml;bersicht</a>";
	}

    // Platzhalter füllen
    $vars['content']        =   array(
                                        '{CONTENT}'         			=> $tmp_section_tanke ,
    									'{TANKSTELLE_SPRIT_ANZEIGE}'	=> $LANG['game']['tankstelle']['TANKSTELLE_SPRIT_ANZEIGE'],
    									'{TANKSTELLE_TANKEN}'			=> $LANG['game']['tankstelle']['TANKSTELLE_TANKEN'],
    									'{TANKSTELLE_SPRIT_TANK}'		=> $ab_tank['car_tank'],
    									'{TANKSTELLE_SPRIT_CAR}'		=> $ab_tank_m['tank_max'],
    									'{TANKSTELLE_TEXT}'				=> loadTemplate( DIR_LANGUAGE . PAGE_LANGUAGE, '/tankstelle', EXT_TEXT ),
                                        '{TANKSTELLE_AKTPPREIS}'        => $LANG['game']['tankstelle']['TANKSTELLE_DERPREIS'],
                                        '{TANKSTELLE_PREIS}'			=> number_format($ab_s['preis'],3,",",".")." ".$DEFAULTS['game']['waehrung'],
                                        '{TANKSTELLE_DIAGRAMM}'		    => $d,
										'{TANKSTELLE_TOPIC}'		    => $LANG['game']['tankstelle']['TANKSTELLE_TOPIC'],
                                     );
} else {$vars['content']        =   array( '{CONTENT}' => $LANG['root']['verweigert']);}

?>

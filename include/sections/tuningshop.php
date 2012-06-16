<?php

// Nur eingeloggte Benutzer haben Zugriff auf diese Optionen
if($_SESSION['logged']) {
    $tmp_vars = array();
    switch($FormVars['d']) {
        case 'buy':
            $anzahl = @mysql_num_rows(@mysql_query('SELECT * FROM game_busy WHERE user_id="' . $_SESSION['userid'] . '" LIMIT 1'));
            if(empty($anzahl)) {
                if(isset($FormVars['tid'])) {
                    $sql = 'SELECT * FROM game_tuning WHERE id="' . $FormVars['tid'] . '" LIMIT 1';
                    $result = @mysql_query($sql);
                    $anzahl = @mysql_num_rows($result);
                    if(!empty($anzahl)) {
                        $tinfo = @mysql_fetch_array($result);
                        $uinfo = @mysql_fetch_array(@mysql_query('SELECT * FROM game_user WHERE id="' . $_SESSION['userid'] . '" LIMIT 1'));
                        if($uinfo['money'] >= $tinfo['preis']) {
                            if($uinfo['ansehen'] >= $tinfo['min_ansehen']) {
                                if($uinfo['ruf'] >= $tinfo['min_ruf']) {
                                    $tmp_sql = array(); $tmp_sql_ok = 0;
                                    $tmp_sql[] = 'UPDATE game_user SET money="' . ($uinfo['money'] - $tinfo['preis']) . '" WHERE id="' . $_SESSION['userid'] . '"';
                                    $tmp_sql[] = 'INSERT INTO game_lager VALUES("", "' . $_SESSION['userid'] . '", "' . $tinfo['id'] . '", "100")';
                                    for($x=0;$x!=count($tmp_sql);$x++) { if(@mysql_query($tmp_sql[$x])) { $tmp_sql_ok++;} }
                                    if(count($tmp_sql) == $tmp_sql_ok) { $ERROR['power'] = true; $tmp_nr = '08'; } else { $ERROR['power'] = true; $tmp_nr = '07'; }
                                } else { $ERROR['power'] = true; $tmp_nr = '06'; }
                            } else { $ERROR['power'] = true; $tmp_nr = '05'; }
                        } else { $ERROR['power'] = true; $tmp_nr = '04'; }
                    } else { $ERROR['power'] = true; $tmp_nr = '03'; }
                } else { $ERROR['power'] = true; $tmp_nr = '02'; }
            } else { $ERROR['power'] = true; $tmp_nr = '09'; }
            break;

        case 'kat':
            if(isset($FormVars['kid'])) {
                $sql = 'SELECT * FROM game_tuning WHERE kat_id="' . $FormVars['kid'] . '"';
                $result = @mysql_query($sql);
                $anzahl = @mysql_num_rows($result);
                if(!empty($anzahl)) {
                    $tmp_tshop_content = '';
                    while($data = @mysql_fetch_array($result)) {
                        $tmp_pic = DIR_T_I_SIGNS . 'tune_teil_' . $data['name_id'] . '.jpg';
                        if(file_exists($tmp_pic)) { $tmp_bildpfad = '<img src="' . $tmp_pic . '" border="0">'; $info = getimagesize($tmp_pic); $tmp_bildinfo = $info[2]; } else { $tmp_bildpfad = '{SHOP_TSHOP_NO_BILD}'; $tmp_bildinfo = 'width="125" height="100"'; }
                        $tmp_loaded_text = loadTemplate( DIR_T_H_GAME, 'shops_tuningshop_kategorie', EXT_TEMPS );
                        $tmp_notfor = '';
                        $tmp_nf = explode(";", $data['notfor']);
                        for($x=0;$x!=count($tmp_nf);$x++) {
                            if(!empty($x)) { $tmp_notfor .= ', ';}
                            $tmp_notfor .= '<a href="index.php?c=autohaus&d=details&cid=' . $tmp_nf[$x] . '">' . $CARNAME[$tmp_nf[$x]] . '</a>';
                        }
                        $uinfo = @mysql_fetch_array(@mysql_query('SELECT game_user.money AS guthaben FROM game_user WHERE id="' . $_SESSION['userid'] . '" LIMIT 1'));
                        if($uinfo['guthaben'] >= $data['preis']) {$tmp_btndslbed = ''; } else { $tmp_btndslbed = 'disabled '; }
                        $klasse = array( 'A', 'B', 'C', 'D', 'E');
                        $tmp_tshop_content .= array2text( $tmp_loaded_text, array(        '{SHOP_TSHOP_VLU_ARTIKELNAME}'    => $TUNENAME[$data['kat_id']][$data['name_id']],
                                                                                          '{SHOP_TSHOP_VLU_ARTID}'          => $data['id'],
                                                                                          '{SHOP_TSHOP_VLU_BILD}'           => $tmp_bildpfad,
                                                                                          '{SHOP_TSHOP_VLU_BILD_GR}'        => $tmp_bildinfo,
                                                                                          '{SHOP_TSHOP_VLU_RUF}'            => $data['min_ruf'],
                                                                                          '{SHOP_TSHOP_VLU_ANSEHEN}'        => $data['min_ansehen'],
                                                                                          '{SHOP_TSHOP_VLU_KLASSE}'         => $klasse[$data['min_klasse']],
                                                                                          '{SHOP_TSHOP_VLU_STYLE}'          => '+ ' . $data['style'],
                                                                                          '{SHOP_TSHOP_VLU_GEWICHT}'        => '+ ' . $data['gewicht'] . ' kg',
                                                                                          '{SHOP_TSHOP_VLU_PS}'             => '+ ' . $data['ps'],
                                                                                          '{SHOP_TSHOP_VLU_KMH}'            => '+ ' . $data['kmh'] . ' km/h',
                                                                                          '{SHOP_TSHOP_VLU_0100}'           => '- ' . $data['go_speed'] . ' km/h',
                                                                                          '{SHOP_TSHOP_VLU_NOT_FOR}'        => $tmp_notfor,
                                                                                          '{SHOP_TSHOP_VLU_BUTTON}'         => $tmp_btndslbed,
                                                                                          '{SHOPT_TSHOP_VLU_PREIS}'         => ' ' . number_format($data['preis'],2,",",".") . $DEFAULTS['game']['waehrung']
                                                                                ));
                    }
                } else { $tmp_vars = array( '{SHOP_TSHOP_CONTENT}' => '{SHOP_TSHOP_NO_ARTIKEL}' ); }
            } else { $ERROR['power'] = true; $tmp_nr = '01'; }
            // Template laden
            $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'shops_tuningshop_koverview', EXT_TEMPS );
            break;

        default:
            $anzahl = round(count($TUNE) / 2);
            if(!empty($anzahl)) {
                $tmp_cnt = 0;
                for($x=0;$x!=$anzahl;$x++) {
                    $tmp_1 = $x; $tmp_2 = $anzahl + $x;
                    if(empty($tmp_cnt)) { $tmp_tshop_content .= '<tr>'; }
                    if(!empty($TUNE[$tmp_1])) { $tmp_tshop_content .= '<td width="50%" align="left"><a href="index.php?c=tuningshop&d=kat&kid=' . $tmp_1 . '">' . $TUNE[$tmp_1] . '</a></td>'; $tmp_cnt++; }
                    if(!empty($TUNE[$tmp_2])) { $tmp_tshop_content .= '<td width="50%" align="left"><a href="index.php?c=tuningshop&d=kat&kid=' . $tmp_2 . '">' . $TUNE[$tmp_2] . '</a></td>'; $tmp_cnt++; }
                    if($tmp_cnt == 2) { $tmp_tshop_content .= '</tr>'; $tmp_cnt = 0; }
                }
            } else { $tmp_vars = array( '{SHOP_TSHOP_CONTENT}' => '{SHOP_TSHOP_NO_ARTIKEL}' ); }
            // Template laden
            $tmp_section_content    = loadTemplate( DIR_T_H_GAME, 'shops_tuningshop_overview', EXT_TEMPS );
            break;
    }

    // Fehlermeldung ausgeben wenn benötigt
    $vars['error'] = array( '{ERROR_MESSAGE}' => '{SHOP_TSHOP_ERROR_' . $tmp_nr . '}');

    // Platzhalter füllen
    $vars['content']        =   array( '{CONTENT}' => $tmp_section_content, '{SHOP_TSHOP_CONTENT}' => $tmp_tshop_content );
    $vars['content']        =   array_merge($vars['content'], $LANG['game']['tshop'], $tmp_vars );
} else {$vars['content']        =   array( '{CONTENT}' => $LANG['root']['verweigert']);}

?>

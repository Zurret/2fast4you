<?php
require( DIR_LANGUAGE . PAGE_LANGUAGE . '/stadt' . EXT_CODE );

$sql = 'SELECT game_user.now_car AS now_car, game_garage.id AS garage_id, game_garage.car_id AS car_id FROM game_user INNER JOIN game_garage ON game_user.now_car=game_garage.id WHERE game_user.id="' . $_SESSION['userid'] . '" LIMIT 1';
$result = @mysql_query($sql);
$anzahl = @mysql_num_rows($result);
$got_car = FALSE;
if(!empty($anzahl)) { $tda = @mysql_fetch_array($result); if($tda['now_car'] == $tda['garage_id'] && !empty($tda['car_id'])) { $got_car = TRUE; } }

$stadt_links = '<tr><td width="100%" align="center" height="20"><a href="index.php?c=autohaus">'.$LANG['stadt']['CITY_CAR_SHOP'] . '</a></td></tr>';
if($got_car) { $stadt_links .= '<tr><td width="100%" align="center" height="20"><a href="index.php?c=tanke">'.$LANG['stadt']['CITY_GAS_STATION'] . '</a></td></tr>'; }
if($got_car) { $stadt_links .= '<tr><td width="100%" align="center" height="20"><a href="index.php?c=werkstatt">'.$LANG['stadt']['CITY_GARAGE'] . '</a></td></tr>'; }
$stadt_links .= '<tr><td width="100%" align="center" height="20"><a href="index.php?c=bank">'.$LANG['stadt']['CITY_BANK'] . '</a></td></tr>';
if($got_car) { $stadt_links .= '<tr><td width="100%" align="center" height="20"><a href="index.php?c=rennen">'.$LANG['stadt']['CITY_RACE'] . '</a></td></tr>'; }
$stadt_links .= '<tr><td width="100%" align="center" height="20"><a href="index.php?c=lehrgang">'.$LANG['stadt']['CITY_SCHOOL'] . '</a></td></tr>';
$stadt_links .= '<tr><td width="100%" align="center" height="20"><a href="index.php?c=sponsoren">'.$LANG['stadt']['CITY_SPONSOREN'] . '</a></td></tr>';
$stadt_links .= '<tr><td width="100%" align="center" height="20"><a href="index.php?c=jobboerse">'.$LANG['stadt']['CITY_JOBBOERSE'] . '</a></td></tr>';
$vars['stadt']  =   array(      '{CITY_MENU}'           =>  $LANG['stadt']['CITY_MENU'],
                                '{CITY_LINKS}'          =>  $stadt_links
                          );

?>

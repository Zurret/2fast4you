<?php
require( DIR_LANGUAGE . PAGE_LANGUAGE . '/sonstiges' . EXT_CODE );

$sql = 'SELECT game_user.now_car AS now_car, game_garage.id AS garage_id, game_garage.car_id AS car_id FROM game_user INNER JOIN game_garage ON game_user.now_car=game_garage.id WHERE game_user.id="' . $_SESSION['userid'] . '" LIMIT 1';
$result = @mysql_query($sql);
$anzahl = @mysql_num_rows($result);
$got_car = FALSE;
if(!empty($anzahl)) { $tda = @mysql_fetch_array($result); if($tda['now_car'] == $tda['garage_id'] && !empty($tda['car_id'])) { $got_car = TRUE; } }

$other_links = '<tr><td width="100%" align="center" height="20"><a href="index.php?c=rangliste">{OTHER_RANGLISTE}</a></td></tr>';
$other_links .= '<tr><td width="100%" align="center" height="20"><a href="index.php?c=rekorde">{OTHER_REKORDE}</a></td></tr>';
#if($got_car) { $other_links .= '<tr><td width="100%" align="center" height="20"><a href="index.php?c=strecken">{OTHER_STRECKEN}</a></td></tr>'; }
$other_links .= '<tr><td width="100%" align="center" height="20"><a href="index.php?c=statistik">{OTHER_STATISTIK}</a></td></tr>';
$other_links .= '<tr><td width="100%" align="center" height="20"><a href="index.php?c=online">{OTHER_USERONLINE}</a></td></tr>';

$vars['sonstige']  =   array_merge( array(
                                            '{OTHER_LINKS}'          =>  $other_links
                                          ), $LANG['sonstiges']);

?>

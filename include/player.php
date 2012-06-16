<?php
require( DIR_LANGUAGE . PAGE_LANGUAGE . '/player' . EXT_CODE );

$is_premium = FALSE;
#$is_premium = TRUE;


$player_links = '';
$player_links .= '<tr><td width="100%" align="center" height="20"><a href="index.php?c=usertools">{PLAYER_CONFIG}</a></td></tr>';
$player_links .= '<tr><td width="100%" align="center" height="20"><a href="index.php?c=nachrichten">{PLAYER_MESSAGES}</a></td></tr>';
if($is_premium == TRUE) { $player_links .= '<tr><td width="100%" align="center" height="20"><a href="index.php?c=premium">{PLAYER_PREMIUM}</a></td></tr>'; }

$vars['usertools']  =   array_merge( array(
                                            '{PLAYER_LINKS}'          =>  $player_links
                                          ), $LANG['player']
                                   );

?>

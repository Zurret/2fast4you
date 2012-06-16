<?php
require( DIR_LANGUAGE . PAGE_LANGUAGE . '/shops' . EXT_CODE );



$shops_links = '<tr><td width="100%" align="center" height="20"><a href="index.php?c=ubay">{SHOP_NAV_01}</a></td></tr>';
$shops_links .= '<tr><td width="100%" align="center" height="20"><a href="index.php?c=tuningshop">{SHOP_NAV_02}</a></td></tr>';


$vars['shops'] = array_merge( array(
                                    '{SHOP_LINKS}'          =>  $shops_links
                                   ), $LANG['shops'] );







?>

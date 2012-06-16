<?php

// Template laden
$tmp_section_content    = loadTemplate( DIR_T_H_MAIN, 'anleitung', EXT_TEMPS );
if(!isset($FormVars['a']) || $FormVars['a']==""){

	$kat="Allgemein";
}else{
	$kat=$FormVars['a'];
}
$kat = str_replace(" ", "", strtolower($kat));
$kat = str_replace(";", "", $kat);
$kat = str_replace("&", "", $kat);
$kat = str_replace("ö", "oe", $kat);
$kat = str_replace("ü", "ue", $kat);
$kat = str_replace("ä", "ae", $kat);
// Platzhalter füllen
$vars['content']        =   array(
                                    '{CONTENT}'         => $tmp_section_content,
									'{ANLEITUNG_INDEX}'	=>$LANG['main']['anleitung']['ANLEITUNG_INDEX'],
									'{ANLEITUNG_ALLGEMEIN}'	=>"<a href=\"index.php?c=anleitung&a=".$LANG['main']['anleitung']['ANLEITUNG_ALLGEMEIN']."\">".$LANG['main']['anleitung']['ANLEITUNG_ALLGEMEIN']."</a>",
									'{ANLEITUNG_GELD}'	=>"<a href=\"index.php?c=anleitung&a=".$LANG['main']['anleitung']['ANLEITUNG_KAUFEN']."\">".$LANG['main']['anleitung']['ANLEITUNG_KAUFEN']."</a>",
									'{ANLEITUNG_KAUFEN}'	=>"<a href=\"index.php?c=anleitung&a=".$LANG['main']['anleitung']['ANLEITUNG_GELD']."\">".$LANG['main']['anleitung']['ANLEITUNG_GELD']."</a>",
									'{ANLEITUNG_TUNING}'	=>"<a href=\"index.php?c=anleitung&a=".$LANG['main']['anleitung']['ANLEITUNG_TUNING']."\">".$LANG['main']['anleitung']['ANLEITUNG_TUNING']."</a>",
									'{ANLEITUNG_RENNEN}'	=>"<a href=\"index.php?c=anleitung&a=".$LANG['main']['anleitung']['ANLEITUNG_RENNEN']."\">".$LANG['main']['anleitung']['ANLEITUNG_RENNEN']."</a>",
									'{ANLEITUNG_SPONSOR}'	=>"<a href=\"index.php?c=anleitung&a=".$LANG['main']['anleitung']['ANLEITUNG_SPONSOR']."\">".$LANG['main']['anleitung']['ANLEITUNG_SPONSOR']."</a>",
									'{ANLEITUNG_SKILLS}'	=>"<a href=\"index.php?c=anleitung&a=".$LANG['main']['anleitung']['ANLEITUNG_SKILLS']."\">".$LANG['main']['anleitung']['ANLEITUNG_SKILLS']."</a>",
									'{ANLEITUNG_CONTENT}'	=> nl2br(loadTemplate( DIR_LANGUAGE.PAGE_LANGUAGE."/anleitung/", $kat, EXT_TEXT )),
									'{ANLEITUNG_TOPIC}'		=>$LANG['main']['anleitung']['TOPIC']

                                 );

?>

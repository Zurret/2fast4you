<?php

// Template laden
$tmp_section_content    = loadTemplate( DIR_T_H_MAIN, 'update', EXT_TEMPS );
$tmp_section_table    = loadTemplate( DIR_T_H_MAIN, 'update_table', EXT_TEMPS );

//updates aus db holen

	$abfrage=@mysql_query("SELECT zeit,inhalt FROM main_updates")or die(mysql_error());
	while ($check = mysql_fetch_object($abfrage)) {
		$tmp_section_content = array2text($tmp_section_content,array('{UPDATE_TABLE}'=>$tmp_section_table,'{UPDATE_INDEX_TABLE}'=>$check->inhalt,'{UPDATE_DATE_TABLE}'=>date("H:i d.m.Y",$check->zeit)));
	}

// Platzhalter füllen
$vars['content']        =   array(
                                    '{CONTENT}'         => $tmp_section_content,
									'{UPDATE_TABLE}'	=>'',
									'{UPDATE_INDEX}'	=>$LANG['main']['update']['UPDATE_INDEX'],
									'{UPDATE_DATE}'		=>$LANG['main']['update']['UPDATE_DATE'],
									'{UPDATE_TOPIC}'		=>$LANG['main']['update']['TOPIC']
                                 );

?>

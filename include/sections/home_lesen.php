<?php
$tmp_section_content="<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"black\" width=\"100%\" height=\"26\"><tr><td width=\"100%\" align=\"center\" class=\"ueberschift\" height=\"26\">{HOME_TOPIC}</td></tr></table>";
// Template laden
$tmp_section_content    .= loadTemplate( DIR_T_H_MAIN, 'home', EXT_TEMPS );
$tmp_section_comment    = loadTemplate( DIR_T_H_MAIN, 'home_comment_list', EXT_TEMPS );



//news daten aus db holen
$abfrage=@mysql_query("SELECT titel,nachricht,zeit,nick,kategorie FROM main_news INNER JOIN game_user ON main_news.user_id=game_user.id WHERE main_news.id=".$FormVars['nid'])or die(mysql_error());
$ergebnis = mysql_fetch_array($abfrage);
	// Platzhalt ersetzen
	
	$qry = mysql_query("SELECT count(*) AS anzahl FROM main_comments WHERE news_id=".$FormVars['nid']);
	$ab = mysql_fetch_array($qry);
	

	$tmp_section_content =array2text($tmp_section_content,array('{HOME_NTOPIC}'=>$ergebnis['titel'],'{HOME_CONTENT}'=>nl2br($ergebnis['nachricht']),'{HOME_DATE}'=>date("H:i d.m.Y",$ergebnis['zeit']),'{HOME_KAT}'=>$ergebnis['kategorie'],'{HOME_USER}'=>$ergebnis['nick'],'{HOME_COMMENT}'=>$ab['anzahl'].$LANG['main']['home']['HOME_COMMENTS']));

// Comments einfügen

$abfrage=@mysql_query("SELECT main_comments.id AS id,zeit,text,nick FROM main_comments INNER JOIN game_user ON main_comments.user_id=game_user.id WHERE news_id=".$FormVars['nid']." ORDER BY zeit DESC")or die(mysql_error());
while ($check = mysql_fetch_object($abfrage)) {
	$tmp_section_content=$tmp_section_content.$tmp_section_comment;
	$tmp_section_content = array2text($tmp_section_content,array('{HOME_COMMENT_LIST_USER}'=>$check->nick,'{HOME_COMMENT_LIST_TEXT}'=>$check->text,'{HOME_COMMENT_LIST_DATE}'=>$LANG['main']['home']['HOME_WRITE_DAY'].date("H:i d.m.Y",$check->zeit)));

	//Comments melden funktion

	if($_SESSION['logged']===TRUE){
		$tmp_section_content = array2text($tmp_section_content,array('{HOME_COMMENT_INFORM}'=>"<a href=\"?c=home_lesen&nid=".$FormVars['nid']."&hcount=".$FormVars['hcount']."&c_id=".$check->id."\"><img src=\"templates/images/design/news/x.png\" alt=\"Kommentar melden\" border=\"0\"/></a>"));
	}

}

//comment schrieben und melden

if($_SESSION['logged']===TRUE){
	//Comments melden
	if(isset($FormVars['c_id']) && $FormVars['c_id']!=""){
	
		$abfrage=@mysql_query("SELECT user_id FROM main_comments WHERE id=".$FormVars['c_id'])or die(mysql_error());
		$ergebnis = mysql_fetch_array($abfrage);
		
		if(isset($ergebnis['user_id'])){
		
			mysql_query('INSERT INTO game_log VALUES("", "'.$ergebnis['user_id'].'", "'.$_SESSION['userid'].'", "'.getenv('REMOTE_ADDR').'", "'.getenv("HTTP_REFERER").'", "'.time().'", "Comment meldung.")') or die(mysql_error());
			$error_m="OK";
		}else{
			 $error_m="NOT_FOUND";
		}
		$ERROR['power'] = true;
		$vars['error'] = array( '{ERROR_MESSAGE}' => $LANG['main']['home']['HOME_COMMENT_INFORM_'.$error_m]);
	}
	//check ob was geschrieben wird
		if($FormVars['kat']=="Schreiben"){
			if($FormVars['t']!=""){
				mysql_query('INSERT INTO main_comments  VALUES("", "'.$FormVars['nid'].'", "'.$_SESSION['userid'].'", "'.nl2br($FormVars['t']).'", "'.time().'")') or die(mysql_error());
				$error_m="OK";
			}else{
				$error_m="NO_TEXT";
			}
			$ERROR['power'] = true; 
			$vars['error'] = array( '{ERROR_MESSAGE}' => $LANG['main']['home']['HOME_COMMENT_ERROR_'.$error_m]);
		}
	//temp laden
		$tmp_section_content=$tmp_section_content.loadTemplate( DIR_T_H_MAIN, 'home_write_comment', EXT_TEMPS );
		$tmp_section_content = array2text($tmp_section_content,array('{HOME_NID}'=>$FormVars['nid'],'{HOME_HCOUNT}'=>$FormVars['hcount']));
}
// Platzhalter füllen
$vars['content']        =   array(
                                    '{CONTENT}'				=> $tmp_section_content,
									'{HOME_COMMENT_LIST}'	=>'',
									'{HOME_COMMENT_INFORM}'	=>'',
									'{HOME_TOPIC}'		=>$LANG['main']['home']['TOPIC']
                                 );
?>

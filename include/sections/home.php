<?php

// Template laden
$tmp_section_home    = loadTemplate( DIR_T_H_MAIN, 'home', EXT_TEMPS );
//initialisieren

$tmp_section_content="{HOME_NEXT_TABEL}";
//news zeiger setzen
if(!isset($FormVars['hcount'])){
	$zeiger=0;
}else{
	$zeiger=$FormVars['hcount'];
}

$tmp_section_content.="<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"black\" width=\"100%\" height=\"26\"><tr><td width=\"100%\" align=\"center\" class=\"ueberschift\" height=\"26\">{HOME_TOPIC}</td></tr></table>";

//news daten aus db holen
$abfrage=@mysql_query("SELECT main_news.id AS id,titel,nachricht,zeit,nick,kategorie FROM main_news INNER JOIN game_user ON main_news.user_id=game_user.id ORDER BY main_news.id DESC LIMIT ".$zeiger.",10")or die(mysql_error());
while ($check = mysql_fetch_object($abfrage)) {
	// Platzhalt ersetzen

	$qry = mysql_query("SELECT count(*) AS anzahl FROM main_comments WHERE news_id=".$check->id);
	$ab = mysql_fetch_array($qry);
	
	$tmp_section_content =$tmp_section_content.$tmp_section_home;

	if($_SESSION['logged']===TRUE){
		$content=substr($check->nachricht, 0, 100) . '...';
	}else{
		$content=$check->nachricht;
	}
	$tmp_section_content =array2text($tmp_section_content,array('{HOME_NTOPIC}'=>$check->titel,'{HOME_CONTENT}'=>nl2br($content),'{HOME_DATE}'=>date("H:i d.m.Y",$check->zeit),'{HOME_USER}'=>$check->nick,'{HOME_COMMENT}'=>"<a href=\"?c=home_lesen&hcount=".$zeiger."&nid=".$check->id."\">".$ab['anzahl'].$LANG['main']['home']['HOME_COMMENTS']."</a>",'{HOME_KAT}'=>$check->kategorie));

}

	//news BACK und NEXT setzen
	
	$qry = mysql_query("SELECT count(*) AS anzahl FROM main_news");
	$ab = mysql_fetch_array($qry);
	if(($zeiger+9)<$ab['anzahl'] || ($zeiger-9)>=0){
		//temp für newsnavi laden und ersetzen
		$tmp_section_content =$tmp_section_content.loadTemplate( DIR_T_H_MAIN, 'home_navi', EXT_TEMPS );
		//navi einfügen
		if(($zeiger+9)<$ab['anzahl']){
			$tmp_section_content =array2text($tmp_section_content,array('{HOME_NEXT}'=>"<a href=\"?c=home&hcount=".($zeiger+10)."\">".$LANG['main']['home']['HOME_NEXT']." --&gt;</a>"));
		}
		if(($zeiger-9)>=0){
			$tmp_section_content =array2text($tmp_section_content,array('{HOME_BACK}'=>"<a href=\"?c=home&hcount=".($zeiger-10)."\">&lt;-- ".$LANG['main']['home']['HOME_BACK']."</a>"));
		}
	}

// Platzhalter füllen
$vars['content']        =   array(
                                    '{CONTENT}'         => $tmp_section_content,
									'{HOME_NEXT_TABEL}'	=>'',
									'{HOME_NEWS}'		=>'',
									'{HOME_NAVI}'		=>'',
									'{HOME_BACK}'		=>'',
									'{HOME_NEXT}'		=>'',
									'{HOME_TOPIC}'		=>$LANG['main']['home']['TOPIC']
                                 );

?>

<?php

    // Alle Screenshots suchen und anzeigen
    $tmp_dir = DIR_SCREENSHOTS;
    $ha = opendir($tmp_dir);
    $tmp_ergebnis = ''; $tmp_u = 1; $anzahl = 0;
    if($_SESSION['logged']) { $tmp_max_thumbs = 2; } else { $tmp_max_thumbs = 3; }
    while($file = readdir($ha)) {
        if(!ereg('thumb_', $file)) {
            if($file != '..' && $file != '.') {
                $file = str_replace('thumb_', '', $file);
                $tmp_full = DIR_SCREENSHOTS . $file;
                $tmp_full_thumb = DIR_SCREENSHOTS . 'thumb_' . $file;
                $info = getimagesize($tmp_full);
                if($info[2] == 1 || $info[2] == 2) {
                    $tmp_prozent = floor(100 / $tmp_max_thumbs);
                    if(!file_exists($tmp_full_thumb)) { @makeThumbnail($tmp_full, $tmp_full_thumb, 150); }
                    if($tmp_u == 1) { $tmp_ergebnis .= '<tr>'; }
                    $tmp_ergebnis .= '<td width="' . $tmp_prozent . '%" align="center" height="250"><a href="' . $tmp_full . '" target="_blank" title="' . $file . '"><img src="' . $tmp_full_thumb . '" border="1"></a></td>';
                    if($tmp_u == $tmp_max_thumbs) { $tmp_u = 0; $tmp_ergebnis .= '</tr>'; }
                    $tmp_u++;
                    $anzahl++;
                }
            }
        }
    }
    closedir($ha);
    if(empty($anzahl)) { $tmp_ergebnis = '<tr><td width="100%" align="center" height="50">{SCREENSHOTS_NO_SCREENS}</td></tr>'; }

    // Template laden
    $tmp_section_content    = loadTemplate( DIR_T_H_MAIN, 'screenshots', EXT_TEMPS );

    // Platzhalter füllen
    $vars['content']        =   array( '{CONTENT}' => $tmp_section_content, '{SCREENSHOTS_ERGEBNIS}' => $tmp_ergebnis );
    $vars['content']        =   array_merge($vars['content'], $LANG['main']['screenshots']);

?>

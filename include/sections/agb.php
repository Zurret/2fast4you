<?php

// Impressumtext laden ..
$tmp_content = loadTemplate( DIR_LANGUAGE . PAGE_LANGUAGE . '/', 'agb', EXT_TEXT );

// Template laden
$tmp_section_content    = loadTemplate( DIR_T_H_MAIN, 'agb', EXT_TEMPS );

// Platzhalter füllen
$vars['content']        =   array(
                                    '{CONTENT}'             => $tmp_section_content,
                                    '{AGB_TOPIC}'     => $LANG['main']['agb']['topic'],
                                    '{AGB_CONTENT}'   => $tmp_content,
                                    '' => ''
                                 );

?>

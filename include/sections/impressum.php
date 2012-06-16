<?php

// Impressumtext laden ..
$tmp_content = loadTemplate( DIR_LANGUAGE . PAGE_LANGUAGE . '/', 'impressum', EXT_TEXT );

// Template laden
$tmp_section_content    = loadTemplate( DIR_T_H_MAIN, 'impressum', EXT_TEMPS );

// Platzhalter füllen
$vars['content']        =   array(
                                    '{CONTENT}'             => $tmp_section_content,
                                    '{IMPRESSUM_TOPIC}'     => $LANG['main']['impressum']['topic'],
                                    '{IMPRESSUM_CONTENT}'   => $tmp_content,
                                    '' => ''
                                 );

?>

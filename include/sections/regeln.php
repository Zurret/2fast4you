<?php

// Impressumtext laden ..
$tmp_content = loadTemplate( DIR_LANGUAGE . PAGE_LANGUAGE . '/', 'regeln', EXT_TEXT );

// Template laden
$tmp_section_content    = loadTemplate( DIR_T_H_MAIN, 'regeln', EXT_TEMPS );

// Platzhalter f�llen
$vars['content']        =   array(
                                    '{CONTENT}'             => $tmp_section_content,
                                    '{REGELN_TOPIC}'     => $LANG['main']['regeln']['topic'],
                                    '{REGELN_CONTENT}'   => $tmp_content,
                                    '' => ''
                                 );

?>

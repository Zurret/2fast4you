<?php

// Das W�rterbuch f�r die Konfigurationen
$LANG['game']['usertools']      =       array(
                                              '{USERTOOLS_TOPIC}'                           => 'Konfiguration',
                                              '{USERTOOLS_MENU_01}'                         => 'Account',
                                              '{USERTOOLS_MENU_02}'                         => 'Buddys',
                                              '{USERTOOLS_MENU_01_ABOUT}'                   => 'Accountinformationen bearbeiten.',
                                              '{USERTOOLS_MENU_02_ABOUT}'                   => 'Buddys verwalten.',
                                              '{USERTOOLS_BUDDYS_TOPIC}'                    => 'Meine Buddys',
                                              '{USERTOOLS_BUDDYS_FIELD_TOPIC}'              => 'Meine Buddys: {BUDDYS_GOT}/{BUDDYS_MAX}',
                                              '{USERTOOLS_BUDDYS_DELETE}'                   => '[X]',
                                              '{USERTOOLS_BUDDYS_ADD_BUDDY}'                => 'Buddy Hinzuf�gen',
                                              '{USERTOOLS_BUDDYS_SHOW_THEM}'                => 'Ich als Buddy',
                                              '{USERTOOLS_BUDDYS_DELETE_ALL}'               => 'Alle Buddys entfernen',
                                              '{USERTOOLS_BUDDYS_DELETED}'                  => '<i>Gel�scht</i>',
                                              '{USERTOOLS_BUDDYS_NO_BUDDYS}'                => 'Es sind keine Buddys vorhanden!',
                                              '{USERTOOLS_BUDDYS_DELETE_ERROR_01}'          => 'Alle Ihre Buddys wurden entfernt!',
                                              '{USERTOOLS_BUDDYS_DELETE_ERROR_02}'          => 'Konnte keine Buddys entfernen!<br />Versuchen Sie sp�ter nochmal!',
                                              '{USERTOOLS_BUDDYS_DELETE_ERROR_03}'          => 'Es sind keine Buddys zum Entfernen vorhanden!',
                                              '{USERTOOLS_BUDDYS_DELETE_ERROR_04}'          => 'Es k�nnen nur eigene Buddys entfernt werden!',
                                              '{USERTOOLS_BUDDYS_DELETE_ERROR_05}'          => 'Konnte Buddy nicht entfernen!<br />Versuchen Sie es sp�ter nochmal!',
                                              '{USERTOOLS_BUDDYS_DELETE_ERROR_06}'          => 'Buddy wurde erfolgreich entfernt!',
                                              '{USERTOOLS_BUDDYS_ADD_TOPIC}'                => 'Buddy hinzuf�gen',
                                              '{USERTOOLS_BUDDYS_ADD_UEBERSICHT}'           => 'Zur �bersicht',
                                              '{USERTOOLS_BUDDYS_ADD_NICKNAME}'             => 'Benutzername:',
                                              '{USERTOOLS_BUDDYS_ADD_BTN_ADD}'              => 'Hinzuf�gen',
                                              '{USERTOOLS_BUDDYS_ADD_DELETE_ERROR_01}'      => 'Benutzername eingeben!',
                                              '{USERTOOLS_BUDDYS_ADD_DELETE_ERROR_02}'      => 'Sie k�nnen sich selber nicht als Buddy hinzuf�gen!',
                                              '{USERTOOLS_BUDDYS_ADD_DELETE_ERROR_03}'      => 'Benutzer konnte nicht gefunden werden!',
                                              '{USERTOOLS_BUDDYS_ADD_DELETE_ERROR_04}'      => 'Sie k�nnen nicht mehr als '.$DEFAULTS['game']['start_buddys'].' Buddys hinzuf�gen!',
                                              '{USERTOOLS_BUDDYS_ADD_DELETE_ERROR_05}'      => 'Benutzer ist bereits als Ihr Buddy markiert!',
                                              '{USERTOOLS_BUDDYS_ADD_DELETE_ERROR_06}'      => 'Konnte Benutzer nicht als Buddy hinzuf�gen!<br />Versuchen Sie es sp�ter nochmal!',
                                              '{USERTOOLS_BUDDYS_ADD_DELETE_ERROR_07}'      => 'Benutzer wurde als Buddy markiert!',
                                              '{USERTOOLS_BUDDYS_IBUDDY_TOPIC}'             => 'Ich als Buddy',
                                              '{USERTOOLS_BUDDYS_IBUDDY_UEBERSICHT}'        => 'Zur �bersicht',
                                              '{USERTOOLS_BUDDYS_IBUDDY_THEY}'              => 'Benutzer die Sie als Buddy markiert haben: {USERTOOLS_BUDDY_IBUDDY_COUNTER}',
                                              '{USERTOOLS_BUDDY_IBUDDY_NO_USERS}'           => 'Sie hat kein Benutzer als Buddy markiert!',
                                              '{USERTOOLS_ACCOUNT_TOPIC}'                   => 'Accountkonfigurationen',
                                              '{USERTOOLS_ACCOUNT_LINK_00}'                 => '�bersicht',
                                              '{USERTOOLS_ACCOUNT_LINK_01}'                 => 'Passwort �ndern',
                                              '{USERTOOLS_ACCOUNT_LINK_02}'                 => 'Avatar hochladen',
                                              '{USERTOOLS_ACCOUNT_LINK_03}'                 => 'Accountaufgabe',
                                              '{USERTOOLS_ACCOUNT_NICKNAME}'                => 'Benutzername:',
                                              '{USERTOOLS_ACCOUNT_EMAIL}'                   => 'E-Mail:',
                                              '{USERTOOLS_ACCOUNT_LAST_LOGIN}'              => 'Letzter Login:',
                                              '{USERTOOLS_ACCOUNT_MONEY}'                   => 'Guthaben:',
                                              '{USERTOOLS_ACCOUNT_GARAGEN}'                 => 'Garagen:',
                                              '{USERTOOLS_ACCOUNT_STYLE}'                   => 'Style:',
                                              '{USERTOOLS_ACCOUNT_ANSEHEN}'                 => 'Ansehen:',
                                              '{USERTOOLS_ACCOUNT_RUF}'                     => 'Ruf:',
                                              '{USERTOOLS_ACCOUNT_SIEGE}'                   => 'Siege:',
                                              '{USERTOOLS_ACCOUNT_CLUB}'                    => 'Club:',
                                              '{USERTOOLS_ACCOUNT_INTELLIGENZ}'             => 'Intelligenz:',
                                              '{USERTOOLS_ACCOUNT_GESCHICKLICHKEIT}'        => 'Geschicklichkeit:',
                                              '{USERTOOLS_ACCOUNT_FAHRKENNTNISSE}'          => 'Fahrkenntnisse:',
                                              '{USERTOOLS_ACCOUNT_KAUFKENNTNISSE}'          => 'Kaufkenntnisse:',
                                              '{USERTOOLS_ACCOUNT_SPONSORKENNTNISSE}'       => 'Sponsorkenntnisse:',
                                              '{USERTOOLS_ACCOUNT_REPERATURKENNTNISSE}'     => 'Reperaturkenntnisse:',
                                              '{USERTOOLS_ACCOUNT_SPRITKENNTNISSE}'         => 'Spritkenntnisse:',
                                              '{USERTOOLS_ACCOUNT_LACKIERKENNTNISSE}'       => 'Lackierkenntnisse:',
                                              '{USERTOOLS_ACCOUNT_NO_AVATAR}'               => 'Kein Avatar<br />vorhanden!<br /><br />'.$DEFAULTS['game']['avatar_max_w'].'x'.$DEFAULTS['game']['avatar_max_h'].' Pixel<br />max. '.($DEFAULTS['game']['avatar_max_size']/1024).' KB',
                                              '{USERTOOLS_ACCOUNT_WERBELINK}'               => 'Dein Werbe-Link:',
                                              '{USERTOOLS_ACCOUNT_WERBETIPP}'               => 'Tipp: Verteile den Link im Chat, in Foren, in Messengern oder an Deine Freunde.<br />Der Link ist nicht dazu gedacht, ihn wild zu posten oder damit zu spammen.<br />Wer dies dennoch macht, wird kommentarlos gel�scht!',
                                              '{USERTOOLS_ACCOUNT_NO_CLUB}'                 => 'Kein Club',

                                              '{USERTOOLS_ACCOUNT_DELETE_TOPIC}'            => 'Accountaufgabe',
                                              '{USERTOOLS_ACCOUNT_DELETE_BTN_DELETE}'       => 'Account freigeben',
                                              '{USERTOOLS_ACCOUNT_DELETE_BTN_CANCEL}'       => 'L�schung stoppen',
                                              '{USERTOOLS_ACCOUNT_DELETE_DELETION}'         => 'L�schung: ',
                                              '{USERTOOLS_ACCOUNT_DELETE_HINWEIS}'          => 'Wenn Sie den Account zur L�schung freigeben,<br />wird dieser nach '.($DEFAULTS['game']['account_delete'] / 3600).' Stunden gel�scht!',
                                              '{USERTOOLS_ACCOUNT_DELETE_ERROR_01}'         => 'Konnte Account nicht zur L�schung freigeben!',
                                              '{USERTOOLS_ACCOUNT_DELETE_ERROR_02}'         => 'Account wurde zur L�schung freigegeben!',
                                              '{USERTOOLS_ACCOUNT_DELETE_ERROR_03}'         => 'Konnte Accountl�schung nicht stoppen!',
                                              '{USERTOOLS_ACCOUNT_DELETE_ERROR_04}'         => 'Accountl�schung wurde gestoppt!',

                                              '{USERTOOLS_ACCOUNT_AVATAR_TOPIC}'            => 'Avatar hochladen',
                                              '{USERTOOLS_ACCOUNT_AVATAR_NOW}'              => 'Aktuelles Avatar',
                                              '{USERTOOLS_ACCOUNT_AVATAR_UPLOAD}'           => 'Avatar hochladen:',
                                              '{USERTOOLS_ACCOUNT_AVATAR_BTN_UPLOAD}'       => 'Hochladen',
                                              '{USERTOOLS_ACCOUNT_AVATAR_MAX_PIC}'          => 'max. '.$DEFAULTS['game']['avatar_max_w'].'x'.$DEFAULTS['game']['avatar_max_h'].' Pixel | max. '.($DEFAULTS['game']['avatar_max_size']/1024).' KB | Nur *.jpg/*.gif!',
                                              '{USERTOOLS_ACCOUNT_AVATAR_ERROR_01}'         => 'Avatar w�hlen!',
                                              '{USERTOOLS_ACCOUNT_AVATAR_ERROR_02}'         => 'Falsches Bildformat!',
                                              '{USERTOOLS_ACCOUNT_AVATAR_ERROR_03}'         => 'Bildbreite ist zu gro�!',
                                              '{USERTOOLS_ACCOUNT_AVATAR_ERROR_04}'         => 'Bildh�he ist zu gro�!',
                                              '{USERTOOLS_ACCOUNT_AVATAR_ERROR_05}'         => 'Bildgr��e ist zu gro�!',
                                              '{USERTOOLS_ACCOUNT_AVATAR_ERROR_06}'         => 'Konnte Avatar nicht hochladen!',
                                              '{USERTOOLS_ACCOUNT_AVATAR_ERROR_07}'         => 'Upload ist nicht vollst�ndig!',
                                              '{USERTOOLS_ACCOUNT_AVATAR_ERROR_08}'         => 'Avatar wurde erfolgreich hochgeladen!',
                                              '{USERTOOLS_ACCOUNT_PWCHANGE_TOPIC}'          => 'Passwort �ndern',
                                              '{USERTOOLS_ACCOUNT_PWCHANGE_HINWEIS}'        => 'Das neue Passwort ist nach der �nderung sofort g�ltig!',
                                              '{USERTOOLS_ACCOUNT_PWCHANGE_BTN_CHANGE}'     => 'Passwort �ndern',
                                              '{USERTOOLS_ACCOUNT_PWCHANGE_NOWPW}'          => 'Atuelles Passwort:',
                                              '{USERTOOLS_ACCOUNT_PWCHANGE_NEWPW}'          => 'Neues Passwort:',
                                              '{USERTOOLS_ACCOUNT_PWCHANGE_NEWPW_WH}'       => 'Neues Passwort wh.:',
                                              '{USERTOOLS_ACCOUNT_PWCHANGE_ERROR_01}'       => 'Aktuelles Passwort eintragen!',
                                              '{USERTOOLS_ACCOUNT_PWCHANGE_ERROR_02}'       => 'Neues Passwort eintragen!',
                                              '{USERTOOLS_ACCOUNT_PWCHANGE_ERROR_03}'       => 'Neues Passwort wiederholen!',
                                              '{USERTOOLS_ACCOUNT_PWCHANGE_ERROR_04}'       => 'Neues Passwort ist nicht identisch mit der wiederholung!',
                                              '{USERTOOLS_ACCOUNT_PWCHANGE_ERROR_05}'       => 'Konnte Passwort nicht �ndern!<br />Versuchen Sie es sp�ter nochmal!',
                                              '{USERTOOLS_ACCOUNT_PWCHANGE_ERROR_06}'       => 'Passwort wurde erfolgreich ge�ndert!',
                                              'position'                => ' - Konfiguration'
                                           );


?>

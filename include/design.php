<?php

// Wenn Benutzer eingeloggt, dann Spielseite laden. Ansonsten Hauptseite laden.
if($_SESSION['logged']) {

    // Initialisieren
    $tmp_vars = array();

    // Sprachedateien laden
    require_once( DIR_LANGUAGE . PAGE_LANGUAGE . '/game' . EXT_CODE );

    // Error anzeigen?
    if($ERROR['power']) { $tmp_error_on_off = loadTemplate( DIR_T_H_GAME, 'error', EXT_TEMPS); } else { $tmp_error_on_off = NULL; }

    // Herausforderung anzeigen?
    if($EVENT['power']) { $tmp_event_on_off = loadTemplate( DIR_T_H_GAME, 'event', EXT_TEMPS); } else { $tmp_event_on_off = NULL; }

    // Heruasforderung anzeigen?
    if($BUDDYS['power']) { $tmp_buddys_on_off = loadTemplate( DIR_T_H_GAME, 'buddys', EXT_TEMPS); } else { $tmp_buddys_on_off = NULL; }

    // Busy anzeigen?
    if($BUSY['power']) { $tmp_busy_on_off = loadTemplate( DIR_T_H_GAME, 'busy', EXT_TEMPS); } else { $tmp_busy_on_off = NULL; }

    // Grundgerüst laden
    if($_SESSION['logtime'] != time()) {
      $PAGE = loadTemplate( DIR_T_H_DESIGN, 'design_game', EXT_HTMLS );
    } else {
      $PAGE = loadTemplate( DIR_T_H_DESIGN, 'design_main', EXT_HTMLS );
      $tmp_vars = array( '{DESIGN_SUBTABLE_LEFT}' => $tmp_sub_on_off );
    }

    // Seitenteile laden
    $tmp_vars = array_merge( $tmp_vars, array(
                                                '{DESIGN_HEADER}'               => loadTemplate( DIR_T_H_DESIGN, 'header', EXT_HTMLS),
                                                '{DESIGN_NAVIGATION}'           => loadTemplate( DIR_T_H_DESIGN, 'navigation', EXT_HTMLS),
                                                '{DESIGN_NAV_01}'               => loadTemplate( DIR_T_H_DESIGN, 'stadt', EXT_HTMLS),
                                                '{DESIGN_NAV_02}'               => loadTemplate( DIR_T_H_DESIGN, 'shops', EXT_HTMLS),
                                                '{DESIGN_NAV_03}'               => loadTemplate( DIR_T_H_DESIGN, 'club', EXT_HTMLS),
                                                '{DESIGN_NAV_04}'               => loadTemplate( DIR_T_H_DESIGN, 'sonstiges', EXT_HTMLS),
                                                '{DESIGN_NAV_05}'               => '',  // Platz für ein weiteres Menüfeld
                                                '{DESIGN_NAV_06}'               => loadTemplate( DIR_T_H_DESIGN, 'wetter', EXT_HTMLS),
                                                '{DESIGN_NAV_07}'               => loadTemplate( DIR_T_H_DESIGN, 'userinfo', EXT_HTMLS),
                                                '{DESIGN_NAV_08}'               => loadTemplate( DIR_T_H_DESIGN, 'privat', EXT_HTMLS),
                                                '{DESIGN_NAV_09}'               => loadTemplate( DIR_T_H_DESIGN, 'player', EXT_HTMLS),
                                                '{DESIGN_NAV_10}'               => loadTemplate( DIR_T_H_DESIGN, 'buddys', EXT_HTMLS),
                                                '{DESIGN_ADS_LS}'               => '',  // Werbefläche: Links unter den Menüs
                                                '{DESIGN_ADS_CT}'               => '',  // Werbefläche: Mitte unter der Navigation
                                                '{DESIGN_ADS_RS}'               => '',  // Werbefläche: Rechts unter den Menüs
                                                '{DESIGN_FOOTER}'               => loadTemplate( DIR_T_H_DESIGN, 'footer', EXT_HTMLS),
                                                '{PAGE_POSITION}'               => $tmp_position,
                                                '{HEADER}'                      => loadTemplate( DIR_T_H_GAME, 'header', EXT_TEMPS),
                                                '{NAVIGATION}'                  => loadTemplate( DIR_T_H_GAME, 'navigation', EXT_TEMPS),
                                                '{STADT}'                       => loadTemplate( DIR_T_H_GAME, 'stadt', EXT_TEMPS),
                                                '{SHOPS}'                       => loadTemplate( DIR_T_H_GAME, 'shops', EXT_TEMPS),
                                                '{CLUB}'                        => loadTemplate( DIR_T_H_GAME, 'club', EXT_TEMPS),
                                                '{ERROR}'                       => $tmp_error_on_off,
                                                '{EVENT}'                       => $tmp_event_on_off,
                                                '{BUSY}'                        => $tmp_busy_on_off,
                                                '{SONSTIGES}'                   => loadTemplate( DIR_T_H_GAME, 'sonstiges', EXT_TEMPS),
                                                '{WETTER}'                      => loadTemplate( DIR_T_H_GAME, 'wetter', EXT_TEMPS),
                                                '{RENNEN}'                      => loadTemplate( DIR_T_H_GAME, 'rennen', EXT_TEMPS),
                                                '{USERINFO}'                    => loadTemplate( DIR_T_H_GAME, 'userinfo', EXT_TEMPS),
                                                '{PRIVAT}'                      => loadTemplate( DIR_T_H_GAME, 'privat', EXT_TEMPS),
                                                '{USERTOOLS}'                   => loadTemplate( DIR_T_H_GAME, 'player', EXT_TEMPS),
                                                '{BUDDYS}'                      => $tmp_buddys_on_off,
                                                '{FOOTER}'                      => loadTemplate( DIR_T_H_GAME, 'footer', EXT_TEMPS)
                                             ));

    $vars['page'] = array(
                            '{ROOT_HOME}'               => $LANG['root']['nav_home'],
                            '{ROOT_ANLEITUNG}'          => $LANG['root']['nav_anleitung'],
                            '{ROOT_UPDATES}'            => $LANG['root']['nav_updates'],
                            '{ROOT_SCREENSHOTS}'        => $LANG['root']['nav_screenshots'],
                            '{ROOT_FORUM}'              => $LANG['root']['nav_forum'],
                            '{ROOT_LOGOUT}'             => $LANG['root']['nav_logout'],
                            '{ROOT_AGB}'                => $LANG['root']['nav_agb'],
                            '{ROOT_REGELN}'             => $LANG['root']['nav_regeln'],
                            '{ROOT_IMPRESSUM}'          => $LANG['root']['nav_impressum']
                         );

} else {

    // Sprachedateien laden
    require_once( DIR_LANGUAGE . PAGE_LANGUAGE . '/main' . EXT_CODE );

    // Grundgerüst laden
    $PAGE = loadTemplate( DIR_T_H_DESIGN, 'design_main', EXT_HTMLS );

    // Sub Navigation anzeigen?
    if($SUBNAVI['power']) { $tmp_sub_on_off = loadTemplate( DIR_T_H_DESIGN, 'subtable_left', EXT_HTMLS); } else { $tmp_sub_on_off = NULL; }

    // Error anzeigen?
    if($ERROR['power']) { $tmp_error_on_off = loadTemplate( DIR_T_H_MAIN, 'error', EXT_TEMPS); } else { $tmp_error_on_off = NULL; }

    // Seitenteile laden
    $tmp_vars = array(
                        '{DESIGN_HEADER}'               => loadTemplate( DIR_T_H_DESIGN, 'header', EXT_HTMLS),
                        '{DESIGN_NAVIGATION}'           => loadTemplate( DIR_T_H_DESIGN, 'navigation', EXT_HTMLS),
                        '{DESIGN_SUBTABLE_LEFT}'        => $tmp_sub_on_off,
                        '{DESIGN_NAV_01}'               => loadTemplate( DIR_T_H_DESIGN, 'action', EXT_HTMLS),
                        '{DESIGN_ADS_LS}'               => '',  // Werbefläche: Links unter den Menüs
                        '{DESIGN_ADS_CT}'               => '',  // Werbefläche: Mitte unter der Navigation
                        '{DESIGN_FOOTER}'               => loadTemplate( DIR_T_H_DESIGN, 'footer', EXT_HTMLS),
                        '{DESIGN_ACTION}'               => loadTemplate( DIR_T_H_DESIGN, $SUBNAVI['filename'], EXT_HTMLS),
                        '{PAGE_POSITION}'               => $tmp_position,
                        '{HEADER}'                      => loadTemplate( DIR_T_H_MAIN, 'header', EXT_TEMPS),
                        '{NAVIGATION}'                  => loadTemplate( DIR_T_H_MAIN, 'navigation', EXT_TEMPS),
                        '{ERROR}'                       => $tmp_error_on_off,
                        '{FOOTER}'                      => loadTemplate( DIR_T_H_MAIN, 'footer', EXT_TEMPS)
                     );

    $vars['page'] = array(
                            '{ROOT_HOME}'               => $LANG['root']['nav_home'],
                            '{ROOT_ANLEITUNG}'          => $LANG['root']['nav_anleitung'],
                            '{ROOT_UPDATES}'            => $LANG['root']['nav_updates'],
                            '{ROOT_SCREENSHOTS}'        => $LANG['root']['nav_screenshots'],
                            '{ROOT_FORUM}'              => $LANG['root']['nav_forum'],
                            '{ROOT_LOGIN}'              => $LANG['root']['nav_login'],
                            '{ROOT_AGB}'                => $LANG['root']['nav_agb'],
                            '{ROOT_REGELN}'             => $LANG['root']['nav_regeln'],
                            '{ROOT_IMPRESSUM}'          => $LANG['root']['nav_impressum']
                         );

}

$vars['other'] = array(
                                '{PAGE_TITEL}'              => $LANG['root']['titel'],
                                '{PAGE_CSS_TAG}'            => PAGE_CSS_TAG,
                                '{PAGE_ICON_TAG}'           => PAGE_ICON_TAG,
                                '{PAGE_META_TAG}'           => PAGE_META_TAG,
                                '' => ''
                      );

// Alle vorhandenen Platzhalter in einem Array zusammenfassen
$fullvars = array_merge(        $tmp_vars,
                                $vars['error'],
                                $vars['busy'],
                                $vars['buddys'],
                                $vars['event'],
                                $vars['page'],
                                $vars['navigation'],
                                $vars['stadt'],
                                $vars['shops'],
                                $vars['club'],
                                $vars['sonstige'],
                                $vars['content'],
                                $vars['wetter'],
                                $vars['rennen'],
                                $vars['userinfo'],
                                $vars['privat'],
                                $vars['usertools'],
                                $vars['footer'],
                                $vars['other']          );

// Platzhalter mit Inhalt füllen
$PAGE = array2text($PAGE, $fullvars);

// Seite ausgeben
echo $PAGE;                 

?>

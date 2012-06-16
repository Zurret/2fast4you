--
-- Tabellenstruktur für Tabelle `game_banned`
--

CREATE TABLE IF NOT EXISTS `game_banned` (
  `id` int(10) NOT NULL auto_increment,
  `nick` varchar(20) NOT NULL default '',
  `email` varchar(30) NOT NULL default '',
  `grund` varchar(255) NOT NULL default '',
  `time` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `game_banned`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game_buddys`
--

CREATE TABLE IF NOT EXISTS `game_buddys` (
  `id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL default '0',
  `buddys` text NOT NULL,
  `time` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `game_buddys`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game_busy`
--

CREATE TABLE IF NOT EXISTS `game_busy` (
  `id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL default '0',
  `ende` int(10) NOT NULL default '0',
  `work_on` int(5) NOT NULL default '0',
  `money` int(10) NOT NULL default '0',
  `money_add` int(1) NOT NULL default '0',
  `do_after` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `game_busy`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game_cars`
--

CREATE TABLE IF NOT EXISTS `game_cars` (
  `id` int(10) NOT NULL auto_increment,
  `name_id` int(5) NOT NULL default '0',
  `preis` int(7) NOT NULL default '0',
  `ps` int(3) NOT NULL default '0',
  `max_speed` int(3) NOT NULL default '0',
  `go_speed` float NOT NULL default '0',
  `tank_max` int(2) NOT NULL default '0',
  `gewicht` int(4) NOT NULL default '0',
  `klasse` int(1) NOT NULL default '0',
  `min_ruf` int(5) NOT NULL default '0',
  `min_ansehen` int(5) NOT NULL default '0',
  `usetzung` float NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Daten für Tabelle `game_cars`
--

INSERT INTO `game_cars` (`id`, `name_id`, `preis`, `ps`, `max_speed`, `go_speed`, `tank_max`, `gewicht`, `klasse`, `min_ruf`, `min_ansehen`, `usetzung`) VALUES
(4, 3, 25800, 131, 212, 10.1, 70, 1415, 2, 150, 184, 0.000364852),
(3, 2, 20650, 102, 185, 12.9, 55, 1280, 1, 103, 144, 0.000401107),
(5, 4, 36700, 180, 227, 9.6, 70, 1700, 3, 201, 276, 0.000396621),
(6, 5, 74800, 335, 250, 6.8, 90, 1855, 4, 299, 398, 0.000479171),
(7, 8, 26635, 105, 185, 12.4, 70, 1552, 2, 105, 147, 0.000327341),
(8, 9, 20525, 150, 206, 8.9, 55, 1317, 3, 170, 220, 0.000395527),
(9, 10, 110250, 338, 250, 6.1, 90, 2439, 4, 300, 400, 0.000439148),
(10, 11, 12795, 70, 165, 14.5, 44, 1110, 0, 0, 0, 0.000356799),
(11, 12, 26390, 147, 216, 9.5, 52, 1393, 1, 166, 213, 0.000391175),
(12, 13, 35975, 184, 224, 9.7, 61, 1360, 2, 201, 278, 0.000512073),
(13, 15, 46405, 330, 241, 8, 60, 1700, 4, 298, 395, 0.000422328),
(14, 16, 14975, 100, 184, 11, 45, 1101, 0, 30, 90, 0.00038984),
(15, 18, 25650, 145, 215, 9.8, 59, 1369, 2, 162, 211, 0.000405015),
(16, 21, 11540, 60, 155, 14.8, 47, 950, 0, 0, 0, 0.000364729),
(17, 27, 25300, 129, 208, 10, 63, 1435, 1, 149, 182, 0.000350767),
(18, 28, 30350, 150, 221, 8.8, 63, 1490, 2, 170, 223, 0.000345675),
(19, 31, 15620, 90, 175, 11.9, 50, 1195, 0, 15, 55, 0.000349705),
(20, 33, 26955, 155, 217, 9.2, 65, 1424, 2, 172, 227, 0.000390742),
(21, 37, 22290, 150, 208, 9, 55, 1290, 1, 170, 222, 0.000408343),
(22, 38, 26450, 166, 214, 8.9, 64, 1430, 2, 222, 244, 0.000403128),
(23, 39, 25640, 146, 208, 8.4, 50, 1175, 3, 160, 209, 0.000407263),
(24, 42, 22283, 115, 188, 10.9, 54, 1240, 1, 107, 151, 0.000394442),
(25, 43, 36180, 150, 212, 10.8, 62, 1466, 2, 169, 222, 0.000431183),
(26, 44, 49010, 190, 226, 9, 70, 1975, 3, 213, 291, 0.000337839),
(27, 45, 86652, 332, 250, 7.8, 88, 2010, 4, 296, 399, 0.000393688),
(28, 46, 14490, 75, 165, 13.4, 47, 1040, 0, 0, 20, 0.000377063),
(29, 48, 18990, 135, 204, 9.6, 50, 1345, 2, 151, 187, 0.000375979),
(30, 51, 14940, 98, 177, 13.1, 60, 1329, 0, 18, 65, 0.000376924),
(31, 52, 28140, 139, 203, 9.8, 62, 1499, 1, 149, 199, 0.000354585),
(32, 55, 42500, 333, 200, 9.3, 82, 1870, 4, 297, 400, 0.000454086),
(33, 56, 10300, 60, 158, 15.4, 50, 985, 0, 0, 0, 0.00036603),
(34, 57, 31140, 133, 201, 10.5, 70, 1485, 1, 152, 187, 0.00036694),
(35, 59, 32590, 211, 235, 8.4, 66, 1660, 3, 236, 303, 0.000416615),
(36, 61, 12700, 98, 183, 10.5, 50, 1055, 0, 20, 75, 0.000380578),
(37, 62, 26650, 170, 219, 9, 68, 1340, 2, 219, 240, 0.00044552),
(38, 63, 22850, 135, 195, 11.1, 60, 1365, 1, 150, 185, 0.000428356),
(39, 64, 30800, 170, 200, 10.8, 83, 1780, 3, 217, 234, 0.00040247),
(40, 69, 26600, 170, 220, 8.2, 62, 1433, 3, 225, 241, 0.000379575),
(41, 70, 54150, 337, 236, 7.5, 68, 1689, 4, 300, 400, 0.000519797);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game_club`
--

CREATE TABLE IF NOT EXISTS `game_club` (
  `id` int(10) NOT NULL auto_increment,
  `tag` varchar(5) NOT NULL default '',
  `name` varchar(30) NOT NULL default '',
  `about` text NOT NULL,
  `konto` int(10) NOT NULL default '0',
  `member` text NOT NULL,
  `buildings` text NOT NULL,
  `new_accept` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `game_club`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game_club_bewerbung`
--

CREATE TABLE IF NOT EXISTS `game_club_bewerbung` (
  `id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL default '0',
  `club_id` int(5) NOT NULL default '0',
  `nachricht` text NOT NULL,
  `sendtime` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `game_club_bewerbung`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game_club_board`
--

CREATE TABLE IF NOT EXISTS `game_club_board` (
  `id` int(10) NOT NULL auto_increment,
  `zeit` int(10) NOT NULL default '0',
  `club_id` int(5) NOT NULL default '0',
  `user_id` int(10) NOT NULL default '0',
  `betreff` varchar(20) NOT NULL default '',
  `msg` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `game_club_board`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game_delete`
--

CREATE TABLE IF NOT EXISTS `game_delete` (
  `id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL default '0',
  `delete` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `game_delete`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game_email_activation`
--

CREATE TABLE IF NOT EXISTS `game_email_activation` (
  `id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL default '0',
  `activationcode` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `game_email_activation`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game_garage`
--

CREATE TABLE IF NOT EXISTS `game_garage` (
  `id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL default '0',
  `car_id` int(5) NOT NULL default '0',
  `car_tank` int(2) NOT NULL default '0',
  `zustand` int(3) NOT NULL default '0',
  `time` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `game_garage`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game_incars`
--

CREATE TABLE IF NOT EXISTS `game_incars` (
  `id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL default '0',
  `garage_id` int(5) NOT NULL default '0',
  `tuned` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `game_incars`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game_lager`
--

CREATE TABLE IF NOT EXISTS `game_lager` (
  `id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL default '0',
  `tuning_id` int(5) NOT NULL default '0',
  `zustand` int(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `game_lager`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game_log`
--

CREATE TABLE IF NOT EXISTS `game_log` (
  `id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL default '0',
  `melder_id` int(10) NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '',
  `ref` text NOT NULL,
  `time` int(10) NOT NULL default '0',
  `action` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `game_log`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game_nachrichten`
--

CREATE TABLE IF NOT EXISTS `game_nachrichten` (
  `id` int(10) NOT NULL auto_increment,
  `absender_id` int(10) NOT NULL default '0',
  `empfaenger_id` int(10) NOT NULL default '0',
  `betreff` varchar(25) NOT NULL default '',
  `nachricht` text NOT NULL,
  `time` int(10) NOT NULL default '0',
  `neu` int(1) NOT NULL default '0',
  `melden` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `game_nachrichten`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game_rekorde`
--

CREATE TABLE IF NOT EXISTS `game_rekorde` (
  `id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL default '0',
  `strecken_id` int(2) NOT NULL default '0',
  `runden` int(2) NOT NULL default '0',
  `time` float NOT NULL default '0',
  `zeit` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `game_rekorde`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game_rennen`
--

CREATE TABLE IF NOT EXISTS `game_rennen` (
  `id` int(10) NOT NULL auto_increment,
  `strecken_id` int(1) NOT NULL default '0',
  `user_id` int(10) NOT NULL default '0',
  `max_ruf` int(5) NOT NULL default '0',
  `max_ansehen` int(5) NOT NULL default '0',
  `max_style` int(5) NOT NULL default '0',
  `klasse` int(1) NOT NULL default '0',
  `runden` int(2) NOT NULL default '0',
  `drivers` text NOT NULL,
  `drivers_max` int(2) NOT NULL default '0',
  `time` int(10) NOT NULL default '0',
  `einsatz` int(5) NOT NULL default '0',
  `ready2go` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `game_rennen`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game_rennen_ende`
--

CREATE TABLE IF NOT EXISTS `game_rennen_ende` (
  `id` int(10) NOT NULL auto_increment,
  `ende` int(10) NOT NULL default '0',
  `strecke` int(5) NOT NULL default '0',
  `dauer` int(10) NOT NULL default '0',
  `gewinn` int(8) NOT NULL default '0',
  `plazierung` text NOT NULL,
  `rennergebnis` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `game_rennen_ende`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game_sponsoren`
--

CREATE TABLE IF NOT EXISTS `game_sponsoren` (
  `id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL default '0',
  `sprs_time` int(10) NOT NULL default '0',
  `sprs_id` int(10) NOT NULL default '0',
  `sprs_name` varchar(30) NOT NULL default '',
  `sprs_basis` int(8) NOT NULL default '0',
  `sprs_bonus` int(8) NOT NULL default '0',
  `sprs_dauer` int(2) NOT NULL default '0',
  `sprs_min_wins` int(5) NOT NULL default '0',
  `sprs_now_wins` int(3) NOT NULL default '0',
  `sprs_get` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `game_sponsoren`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game_sprit`
--

CREATE TABLE IF NOT EXISTS `game_sprit` (
  `id` int(11) NOT NULL auto_increment,
  `preis` float NOT NULL default '0',
  `verkauft` int(10) NOT NULL default '0',
  `verkauft_vortag` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `game_sprit`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game_sprit_preise`
--

CREATE TABLE IF NOT EXISTS `game_sprit_preise` (
  `id` int(10) NOT NULL auto_increment,
  `preis` float NOT NULL default '0',
  `datum` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `game_sprit_preise`
--

INSERT INTO `game_sprit_preise` (`id`, `preis`, `datum`) VALUES
(1, 0, '03.05.2008');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game_strecken`
--

CREATE TABLE IF NOT EXISTS `game_strecken` (
  `id` int(10) NOT NULL default '0',
  `name` varchar(25) NOT NULL default '',
  `lenght` int(5) NOT NULL default '0',
  `traffic` int(3) NOT NULL default '0',
  `type` int(1) NOT NULL default '0',
  `starts` int(5) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `game_strecken`
--

INSERT INTO `game_strecken` (`id`, `name`, `lenght`, `traffic`, `type`, `starts`) VALUES
(1, 'City Trade Center', 3580, 93, 0, 76),
(2, 'Chinatown', 16892, 87, 0, 14),
(3, 'Eastpick City', 11917, 82, 0, 15),
(4, 'Mountain Cruiser', 7283, 44, 1, 9),
(5, 'Top Verticle', 6988, 11, 1, 49),
(6, 'Castle Zith', 13097, 53, 1, 12),
(7, 'Vallay Bitut', 10340, 72, 2, 10),
(8, 'Cornfield Course', 19832, 33, 2, 15),
(9, 'Bizzard County', 5553, 41, 2, 22),
(10, 'Faster Forest', 9108, 22, 3, 15),
(11, 'Forest Woodler', 15876, 47, 3, 23),
(12, 'Wooden Field', 4921, 69, 3, 15),
(13, 'Highway 47', 16053, 63, 4, 10),
(14, 'Route 66', 19991, 6, 4, 46),
(15, 'Speedway', 9770, 10, 4, 38);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game_tuning`
--

CREATE TABLE IF NOT EXISTS `game_tuning` (
  `id` int(10) NOT NULL auto_increment,
  `kat_id` int(5) NOT NULL default '0',
  `name_id` int(5) NOT NULL default '0',
  `preis` int(5) NOT NULL default '0',
  `gewicht` int(4) NOT NULL default '0',
  `style` int(3) NOT NULL default '0',
  `ps` int(2) NOT NULL default '0',
  `kmh` int(2) NOT NULL default '0',
  `go_speed` float NOT NULL default '0',
  `notfor` varchar(20) NOT NULL default '',
  `min_ruf` int(5) NOT NULL default '0',
  `min_ansehen` int(5) NOT NULL default '0',
  `min_klasse` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=73 ;

--
-- Daten für Tabelle `game_tuning`
--

INSERT INTO `game_tuning` (`id`, `kat_id`, `name_id`, `preis`, `gewicht`, `style`, `ps`, `kmh`, `go_speed`, `notfor`, `min_ruf`, `min_ansehen`, `min_klasse`) VALUES
(1, 0, 0, 200, 4, 0, 2, 1, 0.2, '10;3;4;27', 0, 0, 0),
(2, 0, 1, 300, 3, 2, 4, 3, 0.2, '5;28;38;61', 20, 50, 1),
(3, 1, 0, 150, 1, 7, 0, 0, 0, '70;9', 0, 0, 0),
(4, 1, 1, 250, 2, 12, 0, 0, 0, '61;2;33', 60, 100, 1),
(5, 2, 0, 350, 7, 6, 5, 2, 0.2, '15;28;43;44', 5, 20, 0),
(6, 2, 1, 500, 3, 18, 12, 8, 0.3, '51;61;4;69', 35, 130, 1),
(7, 3, 0, 300, 10, 0, 0, 0, 0, '44;18;8;27', 0, 40, 0),
(8, 3, 1, 450, 8, 4, 0, 0, 0, '3;45;39;63', 80, 0, 1),
(9, 4, 0, 600, 2, 0, 10, 6, 0.3, '51;37;46', 80, 130, 0),
(10, 4, 1, 950, 1, 2, 19, 9, 0.4, '5;59;42', 160, 250, 1),
(11, 5, 0, 400, 15, 1, 0, 6, 0, '10;18;43;21', 20, 72, 0),
(12, 5, 1, 650, 11, 3, 0, 11, 0.1, '27;3;38', 95, 62, 1),
(13, 5, 2, 860, 13, 3, 0, 15, 0.2, '33;52', 120, 160, 1),
(14, 6, 0, 180, 6, 4, 0, 0, 0, '11;28;43', 0, 0, 0),
(15, 6, 1, 300, 4, 9, 0, 0, 0, '39', 20, 38, 1),
(16, 7, 0, 480, 6, 6, 0, 0, 0, '16;18;39;64', 10, 0, 0),
(17, 7, 1, 620, 8, 16, 0, 0, 0, '63;55;21', 20, 60, 1),
(18, 8, 0, 620, 19, 0, 0, 9, 0.2, '8;12;70', 0, 0, 0),
(19, 8, 1, 1020, 16, 0, 0, 21, 0.4, '2;57;63;', 200, 298, 2),
(24, 10, 0, 670, 25, 13, 0, 0, 0, '48;46;9;52', 12, 33, 0),
(22, 9, 0, 320, 4, 6, 0, 1, 0, '39;69;12', 10, 43, 0),
(23, 9, 1, 460, 6, 15, 0, 3, 0.1, '5', 35, 69, 1),
(25, 10, 1, 1000, 23, 26, 0, 0, 0, '42', 38, 122, 2),
(26, 11, 0, 360, 2, 1, 0, 4, 0.1, '57', 20, 53, 1),
(27, 30, 0, 4000, 9, 0, 0, 0, 0.2, '37;46', 75, 50, 1),
(28, 30, 1, 8750, 13, 0, 0, 2, 0.4, '37;46', 145, 85, 2),
(29, 12, 0, 1000, 20, 10, 20, 10, 0.5, '10;70;57', 200, 300, 1),
(30, 12, 1, 1850, 28, 15, 35, 15, 0.7, '39;51;69;4', 260, 450, 3),
(31, 29, 0, 200, 2, 4, 0, 0, 0, '44', 25, 5, 0),
(32, 29, 1, 375, 3, 0, 0, 2, 0, '69;70', 50, 40, 1),
(33, 13, 0, 130, 1, 3, 0, 0, 0, '2', 0, 0, 0),
(34, 13, 1, 320, 1, 6, 0, 0, 0, '28;8;3;61', 20, 99, 1),
(35, 13, 2, 560, 1, 13, 0, 0, 0, '13;38;39', 60, 170, 2),
(36, 28, 0, 5000, 18, 0, 5, 8, 0.2, '16;42;46', 100, 115, 0),
(37, 28, 1, 12000, 22, 0, 10, 16, 0.3, '8;13;21', 180, 145, 1),
(38, 14, 0, 310, 4, 0, 3, 2, 0.1, '2', 0, 0, 0),
(39, 14, 1, 740, 3, 0, 5, 4, 0.2, '3;64', 110, 180, 1),
(42, 26, 0, 200, 1, 2, 0, 0, 0, '10', 0, 5, 0),
(43, 26, 1, 400, 2, 4, 0, 0, 0, '42', 20, 15, 0),
(44, 26, 2, 600, 3, 4, 0, 0, 0, '44', 40, 40, 1),
(45, 26, 3, 800, 4, 0, 0, 0, 0, '70', 60, 75, 1),
(46, 15, 0, 590, 17, 0, 9, 10, 0.3, '39;43;4', 100, 150, 0),
(47, 15, 1, 900, 25, 4, 16, 20, 0.5, '56;9;18;43', 160, 220, 1),
(48, 25, 0, 215, 8, 3, 0, 0, 0, '21', 35, 5, 0),
(49, 25, 1, 395, 6, 4, 0, 0, 0, '16', 80, 50, 1),
(50, 15, 2, 1700, 20, 6, 26, 24, 0.5, '4', 280, 360, 2),
(51, 15, 3, 2900, 31, 10, 36, 30, 0.7, '51;70;21', 400, 620, 4),
(52, 24, 0, 400, 1, 4, 0, 0, 0, '12', 0, 5, 0),
(53, 24, 1, 550, 1, 8, 0, 0, 0, '16;12', 25, 15, 1),
(54, 23, 0, 1250, 2, 12, 0, 0, 0, '43;44', 20, 7, 0),
(55, 23, 1, 1700, 1, 8, 0, 0, 0, '16;44', 25, 15, 1),
(56, 22, 0, 2500, 2, 0, 2, 3, 0.2, '44', 50, 80, 0),
(57, 21, 0, 75, 0, 2, 0, 0, 0, '61;62', 0, 0, 0),
(58, 21, 1, 125, 2, 0, 2, 3, 0.2, '44', 35, 25, 1),
(59, 20, 0, 250, 2, 3, 0, 0, 0, '16;48;63', 0, 0, 0),
(60, 20, 1, 350, 2, 5, 0, 0, 0, '10;38;4', 15, 20, 1),
(61, 19, 0, 500, 0, 0, 0, 0, 0.1, '56;9;2', 10, 40, 0),
(62, 18, 0, 500, 0, 0, 0, 2, 0, '28', 0, 0, 0),
(63, 18, 1, 1250, 0, 0, 0, 4, 0, '4;5;8', 45, 65, 0),
(64, 18, 2, 2155, 0, 0, 0, 8, 0, '56;9;2', 100, 75, 1),
(65, 17, 0, 200, 0, 0, 0, 1, 0.1, '33;56', 10, 0, 0),
(66, 17, 1, 475, 0, 0, 0, 2, 0.1, '15;39', 50, 45, 0),
(67, 16, 0, 600, 2, 10, 0, 0, 0, '11;30;33', 15, 10, 0),
(68, 16, 1, 900, 3, 20, 0, 0, 0, '7;20', 25, 20, 1),
(72, 27, 0, 170, 0, 12, 0, 0, 0, '44', 20, 18, 0),
(71, 27, 1, 280, 0, 18, 0, 2, 0, '8;39;62', 30, 26, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game_ubay`
--

CREATE TABLE IF NOT EXISTS `game_ubay` (
  `id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL default '0',
  `bieter_id` int(2) NOT NULL default '0',
  `tuning_id` int(5) NOT NULL default '0',
  `tunname_id` int(10) NOT NULL default '0',
  `ende` int(10) NOT NULL default '0',
  `startpreis` int(5) NOT NULL default '0',
  `gebote` int(3) NOT NULL default '0',
  `zustand` int(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `game_ubay`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game_user`
--

CREATE TABLE IF NOT EXISTS `game_user` (
  `id` int(10) NOT NULL auto_increment,
  `nick` varchar(20) NOT NULL default '',
  `pass` varchar(32) NOT NULL default '',
  `email` varchar(55) NOT NULL default '',
  `ip` varchar(15) NOT NULL default '',
  `last_login` int(10) NOT NULL default '0',
  `now_login` int(10) NOT NULL default '0',
  `last_action` int(10) NOT NULL default '0',
  `now_car` int(4) NOT NULL default '0',
  `now_tank` int(2) NOT NULL default '0',
  `garagen` int(1) NOT NULL default '0',
  `money` int(6) NOT NULL default '12500',
  `bank` int(6) NOT NULL default '0',
  `bank_freigabe` int(10) NOT NULL default '0',
  `style` int(5) NOT NULL default '0',
  `ansehen` int(5) NOT NULL default '0',
  `ruf` int(5) NOT NULL default '0',
  `intelligenz` int(3) NOT NULL default '15',
  `geschick` int(5) NOT NULL default '0',
  `club_id` int(5) NOT NULL default '0',
  `wins` int(4) NOT NULL default '0',
  `skin_path` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `game_user`
--

INSERT INTO `game_user` (`id`, `nick`, `pass`, `email`, `ip`, `last_login`, `now_login`, `last_action`, `now_car`, `now_tank`, `garagen`, `money`, `bank`, `bank_freigabe`, `style`, `ansehen`, `ruf`, `intelligenz`, `geschick`, `club_id`, `wins`, `skin_path`) VALUES
(1, 'admin', MD5('admin'), 'admin@domain.dom', '127.0.0.1', 1209811042, 1209835514, 1251412476, 0, 0, 0, 50000, 0, 1209747097, 0, 0, 0, 15, 0, 0, 0, '0');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game_userjobs`
--

CREATE TABLE IF NOT EXISTS `game_userjobs` (
  `id` int(10) NOT NULL auto_increment,
  `job_get` int(10) NOT NULL default '0',
  `user_id` int(10) NOT NULL default '0',
  `job_id` int(3) NOT NULL default '0',
  `job_level` int(3) NOT NULL default '0',
  `job_exp` int(5) NOT NULL default '0',
  `job_last` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `game_userjobs`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game_userskills`
--

CREATE TABLE IF NOT EXISTS `game_userskills` (
  `id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL default '0',
  `skl_last` int(10) NOT NULL default '0',
  `skl_werte` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `game_userskills`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game_werbung`
--

CREATE TABLE IF NOT EXISTS `game_werbung` (
  `id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL default '0',
  `werbe_id` int(10) NOT NULL default '0',
  `time` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `game_werbung`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `game_wetter`
--

CREATE TABLE IF NOT EXISTS `game_wetter` (
  `id` int(10) NOT NULL auto_increment,
  `temp` int(2) NOT NULL default '0',
  `wetter` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `game_wetter`
--

INSERT INTO `game_wetter` (`id`, `temp`, `wetter`) VALUES
(1, 18, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `main_comments`
--

CREATE TABLE IF NOT EXISTS `main_comments` (
  `id` int(10) NOT NULL auto_increment,
  `news_id` int(10) NOT NULL default '0',
  `user_id` int(10) NOT NULL default '0',
  `text` text NOT NULL,
  `zeit` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `main_comments`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `main_news`
--

CREATE TABLE IF NOT EXISTS `main_news` (
  `id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL default '0',
  `zeit` int(10) NOT NULL default '0',
  `titel` varchar(25) NOT NULL default '',
  `nachricht` text NOT NULL,
  `kategorie` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `main_news`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `main_updates`
--

CREATE TABLE IF NOT EXISTS `main_updates` (
  `id` int(10) NOT NULL auto_increment,
  `zeit` int(10) NOT NULL default '0',
  `inhalt` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `main_updates`
--


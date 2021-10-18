CREATE TABLE `utilizatori` (
  `id` int AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rol` enum('Autor','Admin') DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `creat_la` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizat_la` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `postari` (
 `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
 `id_utilizator` int DEFAULT NULL,
 `titlu` varchar(255) NOT NULL,
 `slug` varchar(255) NOT NULL UNIQUE,
 `vizualizari` int(11) NOT NULL DEFAULT '0',
 `imagine` varchar(255) NOT NULL,
 `continut` text NOT NULL,
 `publicat` tinyint(1) NOT NULL,
 `creat_la` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 `actualizat_la` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_utilizator`) REFERENCES `utilizatori` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1


INSERT INTO `utilizatori` (`id`, `username`, `email`, `rol`, `password`, `creat_la`, `actualizat_la`) VALUES
(1, 'Bogdan', 'bogdan@mymail.com', 'Admin', 'parolamea', '2021-04-16 12:52:58', '2021-04-16 12:52:58')


INSERT INTO `postari` (`id`, `id_utilizator`, `titlu`, `slug`, `vizualizari`, `imagine`, `continut`, `publicat`, `creat_la`, `actualizat_la`) VALUES
(1, 1, '5 Obiceiuri ce iti pot imbunatati viata', '5-obiceiuri-imbunatati-viata', 0, 'banner.jpg', 'Citeste in fiecare zi', 1, '2021-04-12 07:58:02', '2018-04-12 19:14:31'),
(2, 1, 'A doua postare pe blog', 'a-doua-postare', 0, 'banner.jpg', 'Aceasta este continutul celei de-a doua postari de pe site.', 0, '2021-04-13 11:40:14', '2021-04-13 13:04:36')


CREATE TABLE `subiecte` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nume` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL UNIQUE
)

CREATE TABLE `postari_subiecte` (
  `id_postare` int NOT NULL UNIQUE,
  `id_subiect` int NOT NULL
)

INSERT INTO `subiecte` (`id`, `nume`, `slug`) VALUES
(1, 'Inspiratie', 'inspiratie'),
(2, 'Motivatie', 'motivatie'),
(3, 'Jurnal', 'jurnal')

INSERT INTO `postari_subiecte` (`id_postare`, `id_subiect`) VALUES
(1, 1),
(2, 2)


DROP DATABASE IF EXISTS `Comparateur`;
CREATE DATABASE `Comparateur` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE Comparateur;
CREATE TABLE IF NOT EXISTS `Enseigne` (
  `id_ens` int(11) NOT NULL AUTO_INCREMENT,
  `nom_ens` varchar(50)  NOT NULL,
  `nom_dirg` varchar(50)  NOT NULL,
  `mdp` varchar(256)  NOT NULL,
  PRIMARY KEY (`id_ens`)
) ;


CREATE TABLE IF NOT EXISTS `Magasin` (
  `id_mag` int(11) NOT NULL AUTO_INCREMENT,
  `nom_m` varchar(40)  NOT NULL,
  `nom_resp` varchar(25)  NOT NULL,
  `taille` int(1) NOT NULL,
  `ville` varchar(50)  NOT NULL,
  `id_ens` int(11) NOT NULL,
  `mdp` varchar(256)  NOT NULL,
  PRIMARY KEY (`id_mag`)
) ;


CREATE TABLE IF NOT EXISTS `Produit` (
  `id_p` int(11) NOT NULL AUTO_INCREMENT,
  `ref` varchar(30),
  `nom_p` varchar(100)  NOT NULL,
  `type` varchar(50)  NOT NULL,
  `description` text ,
  PRIMARY KEY (`id_p`)
) ;


CREATE TABLE IF NOT EXISTS `Tarif` (
  `id_p` int(11) NOT NULL,
  `id_mag` int(11) NOT NULL,
  `prix` float(11) NOT NULL,
  `dispo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_p`,`id_mag`)
);


CREATE TABLE IF NOT EXISTS `Type` (
  `type` varchar(100)  NOT NULL,
  `rayon` varchar(100) NOT NULL,
  PRIMARY KEY (`type`)
);

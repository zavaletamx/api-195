# ************************************************************
# Sequel Pro SQL dump
# Versión 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: zavaletazea.dev (MySQL 5.7.33)
# Base de datos: kiapp169_dapps195
# Tiempo de Generación: 2021-03-19 17:47:50 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


CREATE DATABASE IF NOT EXIST `dapps195`;
USE `dapps195`;

# Volcado de tabla lista_deseos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `lista_deseos`;

CREATE TABLE `lista_deseos` (
  `usuario_id` int(11) unsigned NOT NULL,
  `producto_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`usuario_id`,`producto_id`),
  KEY `producto_id` (`producto_id`),
  CONSTRAINT `lista_deseos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `lista_deseos_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`producto_id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla producto
# ------------------------------------------------------------

DROP TABLE IF EXISTS `producto`;

CREATE TABLE `producto` (
  `producto_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `foto` varchar(120) DEFAULT NULL,
  `modelo` varchar(75) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `calificacion` tinyint(1) DEFAULT NULL,
  `precio` double DEFAULT NULL,
  `descripcion` text,
  PRIMARY KEY (`producto_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla usuario
# ------------------------------------------------------------

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `usuario_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tel` varchar(10) NOT NULL DEFAULT '',
  `pin` varchar(32) NOT NULL DEFAULT '',
  `userpic` varchar(500) DEFAULT NULL,
  `estatus` tinyint(1) unsigned NOT NULL,
  `fecha_registro` date NOT NULL,
  PRIMARY KEY (`usuario_id`),
  UNIQUE KEY `tel` (`tel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;

INSERT INTO `usuario` (`usuario_id`, `tel`, `pin`, `userpic`, `estatus`, `fecha_registro`)
VALUES
(1,'4422048329','e10adc3949ba59abbe56e057f20f883e',NULL,1,'2021-02-26'),
(2,'7551314460','25d55ad283aa400af464c76d713c07ad',NULL,1,'2021-02-26'),
(3,'4422075200','e10adc3949ba59abbe56e057f20f883e',NULL,1,'2021-02-26'),
(4,'4771426712','25f9e794323b453885f5181f1b624d0b',NULL,1,'2021-02-26'),
(5,'0000000000','e10adc3949ba59abbe56e057f20f883e',NULL,1,'2021-02-26'),
(6,'4461163432','acf06cdd9c744f969958e1f085554c8b',NULL,1,'2021-03-07'),
(7,'4424583351','733d7be2196ff70efaf6913fc8bdcabf',NULL,1,'2021-03-07'),
(8,'4421493707','e10adc3949ba59abbe56e057f20f883e',NULL,1,'2021-03-08'),
(9,'2222222220','e10adc3949ba59abbe56e057f20f883e',NULL,1,'2021-03-16'),
(10,'5557802059','e10adc3949ba59abbe56e057f20f883e',NULL,1,'2021-03-16'),
(11,'2228888888','d41d8cd98f00b204e9800998ecf8427e',NULL,1,'2021-03-16');

/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

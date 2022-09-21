-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         5.7.24 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando datos para la tabla sireh.estados: ~25 rows (aproximadamente)
/*!40000 ALTER TABLE `estados` DISABLE KEYS */;
INSERT INTO `estados` (`id_estado`, `estado`) VALUES
	(1, 'AMAZONAS'),
	(2, 'ANZOÁTEGUI'),
	(3, 'APURE'),
	(4, 'ARAGUA'),
	(5, 'BARINAS'),
	(6, 'BOLÍVAR'),
	(7, 'CARABOBO'),
	(8, 'COJEDES'),
	(9, 'DELTA AMACURO'),
	(10, 'FALCÓN'),
	(11, 'GUÁRICO'),
	(12, 'LARA'),
	(13, 'MÉRIDA'),
	(14, 'MIRANDA'),
	(15, 'MONAGAS'),
	(16, 'NUEVA ESPARTA'),
	(17, 'PORTUGUESA'),
	(18, 'SUCRE'),
	(19, 'TÁCHIRA'),
	(20, 'TRUJILLO'),
	(21, 'VARGAS'),
	(22, 'YARACUY'),
	(23, 'ZULIA'),
	(24, 'DISTRITO CAPITAL'),
	(25, 'DEPENDENCIAS FEDERALES');
/*!40000 ALTER TABLE `estados` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

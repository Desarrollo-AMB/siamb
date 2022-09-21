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

-- Volcando datos para la tabla sireh.grados_militares: ~56 rows (aproximadamente)
/*!40000 ALTER TABLE `grados_militares` DISABLE KEYS */;
INSERT INTO `grados_militares` (`Id`, `codigo_grado`, `siglas`, `descripcion`, `años_grado`, `grado_a_ascender`, `tipo_emp`, `grado_tentativo`) VALUES
	(1, '530', 'SD', 'SOLDADO DISTINGUIDO', NULL, '', 'ALI', ''),
	(2, '050', 'TC', 'TENIENTE CORONEL', 4, '', 'MIL', ''),
	(4, '320', 'E5', 'EXTERIOR 5TO AÑO', NULL, '', 'MEF', ''),
	(5, '450', 'SM/3', 'SARGENTO MAYOR DE TERCERA', 5, '', 'TRP', ''),
	(6, '520', 'CS', 'CABO SEGUNDO', NULL, '', 'ALI', ''),
	(7, '040', 'CO', 'CORONEL', 4, '', 'MIL', ''),
	(10, '240', 'C1', 'CADETE DE PRIMER AÑO', NULL, '', 'MEF', ''),
	(11, '510', 'CP', 'CABO PRIMERO', NULL, '', 'ALI', ''),
	(12, '549', 'AO', 'ASPIRANTE A OFICIAL', NULL, '', 'MEF', ''),
	(13, '440', 'SM/2', 'SARGENTO MAYOR DE SEGUNDA', 5, '', 'TRP', ''),
	(14, '090', 'TE', 'TENIENTE', 3, '', 'MIL', ''),
	(15, '030', 'GB', 'GENERAL DE BRIGADA', 3, '', 'MIL', ''),
	(18, '230', 'D2', 'CADETE DISTINGUIDO DE SEGUNDO AÑO', NULL, '', 'MEF', ''),
	(19, '430', 'SM/1', 'SARGENTO MAYOR DE PRIMERA', 4, '', 'TRP', ''),
	(20, '560', 'AA', 'ASPIRANTES AEROTECNICOS', NULL, '', 'MEF', ''),
	(21, '080', '1T', 'PRIMER TENIENTE', 5, '', 'MIL', ''),
	(22, '020', 'GD', 'GENERAL DE DIVISIÓN', 1, '', 'MIL', ''),
	(24, '220', 'DT', 'CADETE DISTINGUIDO DE SEGUNDO AÑO', NULL, '', 'MEF', ''),
	(25, '420', 'SA', 'SARGENTO AYUDANTE', 4, '', 'TRP', ''),
	(26, '550', 'AS', 'ASPIRANTE A SUB-OFICIAL', NULL, '', 'MEF', ''),
	(27, '070', 'CA', 'CAPITÁN', 5, '', 'MIL', ''),
	(29, '210', 'BM', 'BRIGADIER MAYOR TERCER AÑO', NULL, '', 'MEF', ''),
	(30, '470', 'S/2', 'SARGENTO SEGUNDO', 3, '', 'TRP', ''),
	(31, '410', 'SS', 'SARGENTO SUPERVISOR', 0, '', 'TRP', ''),
	(32, '540', 'SR', 'SOLDADO RASO', NULL, '', 'ALI', ''),
	(33, '060', 'MY', 'MAYOR', 4, '', 'MIL', ''),
	(35, '200', 'AM', 'ALFEREZ MAYOR', NULL, '', 'MEF', ''),
	(36, '330', 'A1', 'ALUMNO DE PRIMER AÑO', NULL, '', 'MEF', ''),
	(37, '460', 'S/1', 'SARGENTO PRIMERO', 5, '', 'TRP', ''),
	(38, '215', 'C4', 'CADETE PREGRADO CUARTO AÑO', NULL, '', 'MEF', ''),
	(39, '401', '5T', '5TO CIENCIA DE LA SALUD', NULL, '', 'MEF', ''),
	(40, '331', 'N1', 'ALUMNO DISTINGUIDO PRIMER AÑO', NULL, '', 'MEF', ''),
	(41, '321', 'A2', 'ALUMNO DE SEGUNDO AÑO', NULL, '', 'MEF', ''),
	(42, '314', 'A3', 'ALUMNO DE CURSO ESPECIAL', NULL, '', 'MEF', ''),
	(43, '310', 'A5', 'ALFEREZ MEDICO 1 QUINTO AÑO', NULL, '', 'MEF', ''),
	(44, '311', 'A6', 'ALFEREZ MEDICO 2 SEXTO AÑO', NULL, '', 'MEF', ''),
	(45, '312', 'BA', 'BRIGADIER AIII', NULL, '', 'MEF', ''),
	(46, '400', 'MP', 'CADETE PREGRADO 1.5 (1AÑO)', NULL, '', 'MEF', ''),
	(47, '231', 'X2', 'CADETE DE SEGUNDO AÑO', NULL, '', 'MEF', ''),
	(48, '221', 'C2', 'CADETE DE SEGUNDO AÑO', NULL, '', 'MEF', ''),
	(49, '201', 'AX', 'ALFEREZ AUXILIAR', NULL, '', 'MEF', ''),
	(50, '202', 'AL', 'ALFEREZ', NULL, '', 'MEF', ''),
	(51, '211', 'PB', 'PRIMER BRIGADIER TERCER AÑO', NULL, '', 'MEF', ''),
	(52, '212', 'BR', 'BRIGADIER TERCER AÑO', NULL, '', 'MEF', ''),
	(53, '213', 'SB', 'SUB-BRIGADIER TERCER AÑO', NULL, '', 'MEF', ''),
	(54, '214', 'C3', 'CADETE DE TERCER AÑO', NULL, '', 'MEF', ''),
	(55, '313', 'SU', 'SUB-BRIGADIER AIII', NULL, '', 'MEF', ''),
	(56, '203', 'AP', 'ALFEREZ PREGRADO', NULL, '', '', ''),
	(57, '15', 'MG', 'MAYOR GENERAL', 0, '', 'MIL', ''),
	(58, '10', 'GJ', 'GENERAL EN JEFE', 0, '', 'MIL', ''),
	(59, '241', 'D1', 'CADETE DISTINGUIDO DE PRIMER AÑO', NULL, '', 'MEF', ''),
	(60, '552', 'ABM', 'ALUMNO BRIGADIER MAYOR', NULL, '', 'MEF', ''),
	(61, '553', 'APB', 'ALUMNO PRIMER BRIGADIER', NULL, '', 'MEF', ''),
	(62, '554', 'ABR', 'ALUMNO BRIGADIER', NULL, '', 'MEF', ''),
	(63, '555', 'ASB', 'ALUMNO SUB-BRIGADIER', NULL, '', 'MEF', ''),
	(64, '559', 'ADTG', 'ALUMNO DISTINGUIDO', NULL, '', 'MEF', '');
/*!40000 ALTER TABLE `grados_militares` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

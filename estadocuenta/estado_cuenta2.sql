-- phpMyAdmin SQL Dump
-- version 3.3.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 20-07-2013 a las 18:05:52
-- Versión del servidor: 5.0.26
-- Versión de PHP: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `estado_cuenta`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afiliados`
--

DROP TABLE IF EXISTS `afiliados`;
CREATE TABLE IF NOT EXISTS `afiliados` (
  `id_afiliado` int(30) NOT NULL auto_increment COMMENT 'Codigo del funcionario',
  `nombres` varchar(50) character set latin1 NOT NULL COMMENT 'Nombre del funcionario',
  `apellidos` varchar(30) character set latin1 NOT NULL COMMENT 'Primer apellido del funcionario',
  `nro_documento` int(50) default NULL,
  `empresa` varchar(250) default NULL,
  `empresa_labora` varchar(250) default NULL,
  `municipio_labora` int(15) default NULL,
  `direccion_labora` varchar(250) default NULL,
  `direccion_residencia` varchar(250) character set latin1 default NULL COMMENT 'direccion del funcionario',
  `municipio_residencia` int(15) default NULL,
  `banco` varchar(250) default NULL,
  `tipo_cuenta` varchar(250) default NULL,
  `nro_cuenta` varchar(250) default NULL,
  `telefono_cel` varchar(30) default NULL COMMENT 'Telefono o celular del funcionario',
  `email` varchar(50) character set latin1 default NULL,
  `id_tipo_doc` varchar(3) character set latin1 default NULL,
  PRIMARY KEY  (`id_afiliado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=913 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria_usuarios`
--

DROP TABLE IF EXISTS `auditoria_usuarios`;
CREATE TABLE IF NOT EXISTS `auditoria_usuarios` (
  `idusuario` int(15) default '0',
  `direccion_ip` varchar(50) default NULL,
  `tabla` varchar(50) default NULL,
  `datos` longblob,
  `condicion` varchar(200) default NULL,
  `fecha` date default NULL,
  `accion` varchar(100) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `claves`
--
DROP VIEW IF EXISTS `claves`;
CREATE TABLE IF NOT EXISTS `claves` (
`nombres` varchar(50)
,`apellidos` varchar(30)
,`nro_documento` int(50)
,`clave` double(23,0)
,`md5` varbinary(32)
);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `divipola`
--

DROP TABLE IF EXISTS `divipola`;
CREATE TABLE IF NOT EXISTS `divipola` (
  `divipola` int(50) NOT NULL,
  `cod_depto` int(50) default NULL,
  `cod_mpio` int(50) default NULL,
  `depto` varchar(255) character set latin1 default NULL,
  `nom_poblad` varchar(255) character set latin1 default NULL,
  PRIMARY KEY  (`divipola`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadocuenta`
--

DROP TABLE IF EXISTS `estadocuenta`;
CREATE TABLE IF NOT EXISTS `estadocuenta` (
  `codigo` varchar(20) default NULL,
  `nombre` varchar(50) default NULL,
  `cedula` int(20) default NULL,
  `sal_apor` int(30) default NULL,
  `tipo` varchar(50) default NULL,
  `credito` varchar(15) default NULL,
  `fecha` varchar(15) default NULL,
  `val_cre` int(50) default NULL,
  `val_cuo` int(50) default NULL,
  `num_cuo` int(20) default NULL,
  `zero_tre` int(20) default NULL,
  `tre_ses` int(20) default NULL,
  `ses_nov` int(20) default NULL,
  `nov_cie` int(20) default NULL,
  `mas_cie` int(20) default NULL,
  `sal_cre` int(20) default NULL,
  `sal_ven` int(20) default NULL,
  `asociado` varchar(2) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientosaportes`
--

DROP TABLE IF EXISTS `movimientosaportes`;
CREATE TABLE IF NOT EXISTS `movimientosaportes` (
  `codigo` varchar(15) default '0',
  `nombre` varchar(50) default NULL,
  `cedula` varchar(15) default NULL,
  `fecha` varchar(15) default NULL,
  `comprob` varchar(15) default NULL,
  `valor` int(15) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientoscreditos`
--

DROP TABLE IF EXISTS `movimientoscreditos`;
CREATE TABLE IF NOT EXISTS `movimientoscreditos` (
  `codigo` varchar(15) default '0',
  `nombre` varchar(50) default NULL,
  `cedula` int(15) default NULL,
  `asociado` varchar(2) default NULL,
  `linea_cre` varchar(30) default NULL,
  `nro_cre` varchar(10) default NULL,
  `fecha` varchar(15) default NULL,
  `comprob` varchar(15) default NULL,
  `descrip` varchar(150) default NULL,
  `cuota` int(10) default NULL,
  `vr_pagado` int(30) default NULL,
  `capital` int(30) default NULL,
  `intereses` int(10) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `municipios_departamentos`
--
DROP VIEW IF EXISTS `municipios_departamentos`;
CREATE TABLE IF NOT EXISTS `municipios_departamentos` (
`divipola` int(50)
,`cod_depto` int(50)
,`cod_mpio` int(50)
,`depto` varchar(255)
,`nom_poblad` varchar(255)
);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paginas`
--

DROP TABLE IF EXISTS `paginas`;
CREATE TABLE IF NOT EXISTS `paginas` (
  `id_paginas` int(30) NOT NULL auto_increment,
  `paginas` varchar(50) character set latin1 default NULL,
  PRIMARY KEY  (`id_paginas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parametros`
--

DROP TABLE IF EXISTS `parametros`;
CREATE TABLE IF NOT EXISTS `parametros` (
  `id_parametro` int(30) NOT NULL auto_increment,
  `parametro` varchar(255) character set latin1 default NULL,
  `valor` varchar(150) character set latin1 default NULL,
  `descripcion` text character set latin1,
  PRIMARY KEY  (`id_parametro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

DROP TABLE IF EXISTS `permisos`;
CREATE TABLE IF NOT EXISTS `permisos` (
  `id_permisos` int(15) NOT NULL auto_increment,
  `id_paginas` int(30) default NULL,
  `id_tipo_usuario` int(15) default NULL,
  PRIMARY KEY  (`id_permisos`),
  KEY `id_paginas` USING BTREE (`id_paginas`),
  KEY `id_tipo_usuario` USING BTREE (`id_tipo_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 15360 kB; (`id_paginas`) REFER `coacep_estados/' AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_doc`
--

DROP TABLE IF EXISTS `tipo_doc`;
CREATE TABLE IF NOT EXISTS `tipo_doc` (
  `id_tipo_doc` varchar(3) NOT NULL,
  `tipo_doc` varchar(50) character set utf8 default NULL,
  PRIMARY KEY  (`id_tipo_doc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

DROP TABLE IF EXISTS `tipo_usuario`;
CREATE TABLE IF NOT EXISTS `tipo_usuario` (
  `id_tipo_usuario` int(30) NOT NULL auto_increment COMMENT 'Codigo del tipo de usuario',
  `tipo_usuario` varchar(30) NOT NULL COMMENT 'Tipo de Usuario - Administrador de la Empresa, Usuario Funcionario, Super Usuario',
  PRIMARY KEY  (`id_tipo_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(30) NOT NULL auto_increment,
  `usuario` varchar(20) default NULL,
  `password` varchar(200) default NULL,
  `id_tipo_usuario` int(30) default NULL,
  `id_afiliado` int(30) default NULL,
  `cambio_clave` varchar(3) default NULL,
  PRIMARY KEY  (`id_usuario`),
  KEY `id_tipo_usuario` USING BTREE (`id_tipo_usuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='InnoDB free: 15360 kB; (`id_tipo_usuario`) REFER `coacep_est' AUTO_INCREMENT=914 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `claves`
--
DROP TABLE IF EXISTS `claves`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `claves` AS select `afiliados`.`nombres` AS `nombres`,`afiliados`.`apellidos` AS `apellidos`,`afiliados`.`nro_documento` AS `nro_documento`,round((rand(20) * 1000000),0) AS `clave`,md5(round((rand(20) * 1000000),0)) AS `md5` from `afiliados`;

-- --------------------------------------------------------

--
-- Estructura para la vista `municipios_departamentos`
--
DROP TABLE IF EXISTS `municipios_departamentos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `municipios_departamentos` AS select `$$`.`divipola` AS `divipola`,`$$`.`cod_depto` AS `cod_depto`,`$$`.`cod_mpio` AS `cod_mpio`,ucase(`$$`.`depto`) AS `depto`,`$$`.`nom_poblad` AS `nom_poblad` from `divipola` `$$`;

--
-- Filtros para las tablas descargadas (dump)
--

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`id_paginas`) REFERENCES `paginas` (`id_paginas`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `permisos_ibfk_2` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipo_usuario` (`id_tipo_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

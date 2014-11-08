-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 24-05-2013 a las 18:50:45
-- Versión del servidor: 5.5.16
-- Versión de PHP: 5.3.8

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `skeleton_v2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cities`
--

DROP TABLE IF EXISTS `cities`;
CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D95DB16BF92F3E70` (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `cities`
--

INSERT INTO `cities` (`id`, `country_id`, `name`) VALUES
(1, 1, 'Bogota');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `countries`
--

INSERT INTO `countries` (`id`, `code`, `name`) VALUES
(1, 'COL', 'Colombia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_id` int(11) DEFAULT NULL,
  `label` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `url` longtext COLLATE utf8_unicode_ci NOT NULL,
  `in_menu` longtext COLLATE utf8_unicode_ci,
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2DEDCC6FD823E37A` (`section_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=51 ;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `section_id`, `label`, `url`, `in_menu`, `position`) VALUES
(1, 1, 'Builder_index', 'builder/index', 'NO', 3),
(2, 1, 'Builder_generateModule', 'builder/generatemodule', 'NO', 4),
(3, 12, 'Cities_index', 'cities/index', 'YES', 1),
(4, 2, 'Cities_form', 'cities/form', 'NO', 3),
(5, 2, 'Cities_getCitiesByCountry', 'cities/getcitiesbycountry', 'NO', 6),
(6, 2, 'Cities_getCitiesByUser', 'cities/getcitiesbyuser', 'NO', 7),
(7, 12, 'Countries_index', 'countries/index', 'YES', 1),
(8, 3, 'Countries_form', 'countries/form', 'NO', 3),
(9, 3, 'Countries_existCountry', 'countries/existcountry', 'NO', 5),
(10, 3, 'Countries_existCode', 'countries/existcode', 'NO', 6),
(11, 4, 'Home_index', 'home/index', 'NO', 2),
(12, 4, 'Home_forbbiden', 'home/forbbiden', 'NO', 3),
(13, 5, 'Login_index', 'login/index', 'NO', 2),
(14, 5, 'Login_auth', 'login/auth', 'NO', 3),
(15, 5, 'Login_logout', 'login/logout', 'NO', 4),
(16, 5, 'Login_resetPassword', 'login/resetpassword', 'NO', 5),
(17, 5, 'Login_setUp', 'login/setup', 'NO', 6),
(18, 5, 'Login_createPermissions', 'login/createpermissions', 'NO', 7),
(19, 5, 'Login_updatePermissions', 'login/updatepermissions', 'NO', 8),
(20, 11, 'Permissions_index', 'permissions/index', 'YES', 1),
(21, 6, 'Permissions_form', 'permissions/form', 'NO', 3),
(22, 6, 'Permissions_changeInMenu', 'permissions/changeinmenu', 'NO', 5),
(23, 6, 'Permissions_upPosition', 'permissions/upposition', 'NO', 6),
(24, 6, 'Permissions_downPosition', 'permissions/downposition', 'NO', 7),
(25, 11, 'Profiles_index', 'profiles/index', 'YES', 1),
(26, 7, 'Profiles_form', 'profiles/form', 'NO', 3),
(27, 7, 'Profiles_existProfile', 'profiles/existprofile', 'NO', 5),
(28, 7, 'Profiles_assignPermissions', 'profiles/assignpermissions', 'NO', 7),
(29, 7, 'Profiles_persistProfilePermission', 'profiles/persistprofilepermission', 'NO', 8),
(30, 11, 'Sections_index', 'sections/index', 'YES', 1),
(31, 8, 'Sections_form', 'sections/form', 'NO', 3),
(32, 8, 'Sections_existSection', 'sections/existsection', 'NO', 5),
(33, 8, 'Sections_permissions', 'sections/permissions', 'NO', 7),
(34, 8, 'Sections_getListPermissions', 'sections/getlistpermissions', 'NO', 8),
(35, 8, 'Sections_assignPermissions', 'sections/assignpermissions', 'NO', 9),
(36, 8, 'Sections_persistSectionPermission', 'sections/persistsectionpermission', 'NO', 10),
(37, 8, 'Sections_upPosition', 'sections/upposition', 'NO', 11),
(38, 8, 'Sections_downPosition', 'sections/downposition', 'NO', 12),
(39, 9, 'Users_index', 'users/index', 'YES', 1),
(40, 9, 'Users_form', 'users/form', 'NO', 3),
(41, 9, 'Users_existUser', 'users/existuser', 'NO', 5),
(42, 9, 'Users_myData', 'users/mydata', 'NO', 7),
(43, 9, 'Users_persistMyData', 'users/persistmydata', 'NO', 8),
(44, 9, 'Users_persistPassword', 'users/persistpassword', 'NO', 9),
(45, 9, 'Users_verifyPassword', 'users/verifypassword', 'NO', 10),
(46, 9, 'Users_getUsersAutocomplete', 'users/getusersautocomplete', 'NO', 11),
(47, 9, 'Users_getUsersByWorkshop', 'users/getusersbyworkshop', 'NO', 12),
(48, 9, 'UsersData_index', 'usersdata/index', 'YES', 13),
(49, 10, 'UsersData_form', 'usersdata/form', 'NO', 3),
(50, 10, 'UsersData_existUser', 'usersdata/existuser', 'NO', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profiles`
--

DROP TABLE IF EXISTS `profiles`;
CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` tinytext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8B3085305E237E06` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `profiles`
--

INSERT INTO `profiles` (`id`, `name`, `description`) VALUES
(1, 'Admin', 'This is the super admin.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profiles_permissions`
--

DROP TABLE IF EXISTS `profiles_permissions`;
CREATE TABLE IF NOT EXISTS `profiles_permissions` (
  `profiles_id` int(11) NOT NULL,
  `permissions_id` int(11) NOT NULL,
  PRIMARY KEY (`profiles_id`,`permissions_id`),
  KEY `IDX_ED3CCDE222077C89` (`profiles_id`),
  KEY `IDX_ED3CCDE29C3E4F87` (`permissions_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sections`
--

DROP TABLE IF EXISTS `sections`;
CREATE TABLE IF NOT EXISTS `sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  `icon` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Volcado de datos para la tabla `sections`
--

INSERT INTO `sections` (`id`, `label`, `position`, `icon`) VALUES
(1, 'Builder', 1, NULL),
(2, 'Cities', 2, NULL),
(3, 'Countries', 3, NULL),
(4, 'Home', 4, NULL),
(5, 'Login', 5, NULL),
(6, 'Permissions', 6, NULL),
(7, 'Profiles', 7, NULL),
(8, 'Sections', 8, NULL),
(9, 'Users', 9, NULL),
(10, 'UsersData', 10, NULL),
(11, 'System', 99, NULL),
(12, 'Location', 99, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `translations`
--

DROP TABLE IF EXISTS `translations`;
CREATE TABLE IF NOT EXISTS `translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `origin` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `idOrigin` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `field` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `translation` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) DEFAULT NULL,
  `profile_id` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `last_access` datetime DEFAULT NULL,
  `admin` int(11) DEFAULT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `creationDate` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E9E7927C74` (`email`),
  KEY `IDX_1483A5E98BAC62AF` (`city_id`),
  KEY `IDX_1483A5E9CCFA12B8` (`profile_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `city_id`, `profile_id`, `name`, `last_name`, `email`, `password`, `last_access`, `admin`, `language`, `creationDate`) VALUES
(1, 1, 1, 'Admin', 'Admin', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', '2013-05-24 18:40:15', 1, 'en-us', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_data`
--

DROP TABLE IF EXISTS `users_data`;
CREATE TABLE IF NOT EXISTS `users_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `identification` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_627ABD6DA76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `FK_D95DB16BF92F3E70` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);

--
-- Filtros para la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `FK_2DEDCC6FD823E37A` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`);

--
-- Filtros para la tabla `profiles_permissions`
--
ALTER TABLE `profiles_permissions`
  ADD CONSTRAINT `FK_ED3CCDE29C3E4F87` FOREIGN KEY (`permissions_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_ED3CCDE222077C89` FOREIGN KEY (`profiles_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_1483A5E9CCFA12B8` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`),
  ADD CONSTRAINT `FK_1483A5E98BAC62AF` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`);

--
-- Filtros para la tabla `users_data`
--
ALTER TABLE `users_data`
  ADD CONSTRAINT `FK_627ABD6DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

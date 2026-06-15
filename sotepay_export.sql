-- Database Export for sotepay
-- Generated at: 2026-06-15 15:31:44

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `cache` VALUES('laravel-cache-admin@sotepay.com|127.0.0.1','i:2;','1779131301');
INSERT INTO `cache` VALUES('laravel-cache-admin@sotepay.com|127.0.0.1:timer','i:1779131301;','1779131301');
INSERT INTO `cache` VALUES('laravel-cache-admin@zonasbdc.com|127.0.0.1','i:1;','1779131287');
INSERT INTO `cache` VALUES('laravel-cache-admin@zonasbdc.com|127.0.0.1:timer','i:1779131287;','1779131287');
INSERT INTO `cache` VALUES('soteweb-cache-admin@admin.com|127.0.0.1','i:1;','1781530907');
INSERT INTO `cache` VALUES('soteweb-cache-admin@admin.com|127.0.0.1:timer','i:1781530907;','1781530907');
INSERT INTO `cache` VALUES('soteweb-cache-gabriel@soteweb.com|127.0.0.1','i:2;','1781530897');
INSERT INTO `cache` VALUES('soteweb-cache-gabriel@soteweb.com|127.0.0.1:timer','i:1781530897;','1781530897');


DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
  `cliente_id` int NOT NULL AUTO_INCREMENT,
  `empresa` varchar(255) DEFAULT NULL,
  `titular` varchar(255) DEFAULT NULL,
  `ruc` varchar(15) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo',
  `observacion` text,
  PRIMARY KEY (`cliente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=latin1;

INSERT INTO `clientes` VALUES('1','Eagropecuario','Diego Barrios Fretes','-','+595 985 177110','die.arnold@gmail.com','Barrio Quiteria','Encarnación','Inactivo',NULL);
INSERT INTO `clientes` VALUES('2','Itapua Informa','Juan Solis','-','+595 992 364291','juangabrielss94@gmail.com','Barrio Pacu Cua','Encarnación','Inactivo',NULL);
INSERT INTO `clientes` VALUES('3','EncarnaciónNoticias','Juan Solis','-','+595 992 364291','juangabrielss94@gmail.com','Barrio Pacu Cua','Encarnación','Inactivo',NULL);
INSERT INTO `clientes` VALUES('4','La Aurelia','Juan Aquino','-','595 981 220 133','inmobiliaria@laaurelia.com.py','Ruta PY01 Mcal. López y Ángel R. Samudio ','Encarnación','Activo',NULL);
INSERT INTO `clientes` VALUES('5','Tirolandia - Ciudad Tirol','Malpertus S.A.','-',' 595 985 888007','redes@tirolandia.com.py','Ruta 6ta. KM 20 6000 ','Capitan Miranda','Inactivo',NULL);
INSERT INTO `clientes` VALUES('6','Aguavista-A+E  S.A.','Aguavista','80067046-9','0985 345 007','info@aguavista.com.py','Avda. Fulgencio Yegros - Barrio Guarani','San Juan Del Paraná','Activo',NULL);
INSERT INTO `clientes` VALUES('7','Financorp. GOV SA','David Ortiz','-','595 0972 79 79 71','contacto@financorp.com.py','Nicasio Insaurralde casi Avda. Brasilia','Asuncion','Activo',NULL);
INSERT INTO `clientes` VALUES('8','Venta Pais','Marcio Gimenez y Adrian Acuña','-','-','-','-','Encarnacion','Inactivo',NULL);
INSERT INTO `clientes` VALUES('9','EncarPress','Juan Solis','-','+595 992 364291','juangabrielss94@gmail.com','Barrio Pacu Cua','Encarnacion','Inactivo',NULL);
INSERT INTO `clientes` VALUES('10','GreenGlobe SA','Gustavo Fernandez y Nancy Cubilla','80128710-3','595 991 842497','greenglobe.enc@gmail.com','Antequera c/ Tomás Romero Pereira','Encarnacion','Inactivo',NULL);
INSERT INTO `clientes` VALUES('11','Politiweb','Juan Solis','-','+595 992 364291','juangabrielss94@gmail.com','Barrio Pacu Cua','Encarnacion','Inactivo',NULL);
INSERT INTO `clientes` VALUES('12','Soteweb','Gabriel Sotelo','1592463-7','+595985758031','dominios@soteweb.com','Los Ceibos casi avenida costanera 3','Encarnación','Inactivo',NULL);
INSERT INTO `clientes` VALUES('13','Del Sur Hotel Museo','Yessica Baez','-','-','-','Ruta 1 – Mariscal López - a la entrada del Barrio 8 de Diciembre','Encarnacion','Activo',NULL);
INSERT INTO `clientes` VALUES('14','Paraguay En Noticias','Juan Solis','-','+595 992 364291','juangabrielss94@gmail.com','Barrio Pacu Cua','Encarnacion','Inactivo',NULL);
INSERT INTO `clientes` VALUES('15','Norteazur','Fernando Acuña','3662004-1 ','+595 985 709663','sonia.arrua@norteazur.com y fernando.acuna@norteazur.com',' Calle Boquerón casi los Laureles – Cambyretá','Encarnación','Activo',NULL);
INSERT INTO `clientes` VALUES('16','RB EMPRENDIMIENTOS SA','Adriana Benitez','80060157-2','(071) 209 566','rbemprendimientos.sa@gmail.com','Carlos A Lopez y Tomas R Pereira','Encarnacion','Activo',NULL);
INSERT INTO `clientes` VALUES('17','Funam PY','Juan Azuaga','80069012-5','-','-','-','CDE','Inactivo',NULL);
INSERT INTO `clientes` VALUES('18','Radio Marandu','Rafael Silva','80094158-6','595 741 252 499','88.7@radiomarandu.com.py','Calle Coronel Rafael Franco Y Avda. Pedro Juan Caballero','Coronel Bogado','Activo',NULL);
INSERT INTO `clientes` VALUES('19','Panamericana S.A.','Olga Fischer','-','595 983 797214','ventas@panamericanasa.com','Carlos A. Lopez entre 25 de Mayo y Villarrica 1530','Encarnacion','Activo',NULL);
INSERT INTO `clientes` VALUES('20','Itapua Shop - Pucon - Aisen','Ricardo Pineda','-','0985 - 746 592','itapuashop@gmail.com','Juan L. Mallorquín 959','Encarnacion','Inactivo',NULL);
INSERT INTO `clientes` VALUES('21','Bohal Inversiones','Lic. Marlene','80068716-7','-','-','-','Hernandarias','Activo',NULL);
INSERT INTO `clientes` VALUES('22','Dos Rios SRL','Yessica Fleitas','80048550-5','(071) 201 874','-','Cerro Cora Tte y Honorio Gonzalez','Encarnacion','Activo',NULL);
INSERT INTO `clientes` VALUES('23','Gestar','Andrea Acuña','-','+595 985 766095','andrea@gestar.com.py','Honorio Gonzalez casi Avda Caballero','Encarnacion','Activo',NULL);
INSERT INTO `clientes` VALUES('24','Itapua Cross','Derlis Vargas','-','071 206649','-','Shopping Galería Florida – Local 12 Planta Baja','Encarnacion','Inactivo',NULL);
INSERT INTO `clientes` VALUES('25','Vargas Asesora','Derlis Vargas','-','595 983435755','-','Shopping Galería Florida – Local 12 Planta Baja','Encarnacion','Inactivo',NULL);
INSERT INTO `clientes` VALUES('26','Jessy Lens','Alelí Vargas','80054675-0','+595 985 908151','-','-','Encarnacion','Activo',NULL);
INSERT INTO `clientes` VALUES('27','TVS-Televisora del Sur','Germán Godoy TVS','80021169-3','204127','tvs_encarnacion@hotmail.com','Mcal. Estigarribia c/Villarrica','Encarnación','Activo','');
INSERT INTO `clientes` VALUES('28','Paraguay Bienes Raices','Cáceres y Schneider','-',' 595 985 721 111','-','avda.oswaldo tischler esquina Aviadores del Chaco','Encarnacion','Activo',NULL);
INSERT INTO `clientes` VALUES('29','Diocesis de Encarnación','Carlos','80030902-2','','-','-','Encarnacion','Activo',NULL);
INSERT INTO `clientes` VALUES('30','Cambyreta Informa','Jorge Almada','-','+595 985 920990','-','Barrio San Miguel Cambyreta','Encarnacion','Inactivo',NULL);
INSERT INTO `clientes` VALUES('31','Las Alas del Halcón','Hugo Neris','4872073-3','-','-','-','-','Inactivo',NULL);
INSERT INTO `clientes` VALUES('32','Productora 7 Puentes','Germán Godoy','-','-','-','-','Encarnación','Inactivo',NULL);
INSERT INTO `clientes` VALUES('33','Primera Iglesia Bautista','Autorrepuestos Peniel','-','-','-','-','-','Inactivo',NULL);
INSERT INTO `clientes` VALUES('34','BR&GAB','Ronny Bareiro','-','-','info@brgab.com','Posadas casi Independencia','Encarnación','Inactivo',NULL);
INSERT INTO `clientes` VALUES('35','Itapua Timing S.R.L','Juan Szopa','-','-','-','-','-','Inactivo',NULL);
INSERT INTO `clientes` VALUES('36','Tractoitapua','William Martínez','-','-','-','-','Encarnación','Inactivo',NULL);
INSERT INTO `clientes` VALUES('37','CONSUR S.R.L','Juan Szopa','-','-','-','-','-','Activo',NULL);
INSERT INTO `clientes` VALUES('38','Hotel Cuarajhy Pora','Alejandro Ojeda','-','-','-','-','-','Inactivo',NULL);
INSERT INTO `clientes` VALUES('39','Fiesta Chopp Capitán Meza','Hector Dallman','-','-','-','-','Capitán Meza','Inactivo',NULL);
INSERT INTO `clientes` VALUES('40','Itacom Group','Itacom Group','-','-','-','-','-','Inactivo',NULL);
INSERT INTO `clientes` VALUES('41','Manuel Benítez','Manuel Benitez','-','-','-','-','-','Inactivo',NULL);
INSERT INTO `clientes` VALUES('42','Blanca Szezerba','Blanca Szezerba','3730886','-','-','Barrio San Pedro','Encarnación','Inactivo',NULL);
INSERT INTO `clientes` VALUES('43','Diego Berdejo','Diego Berdejo','-','-','-','Barrio San Francisco','Encarnación','Inactivo',NULL);
INSERT INTO `clientes` VALUES('44','Rita Thiebeaud','Rita Thiebeaud','-','-','academica@unae.edu.py','Capitán Miranda','Encarnación','Inactivo',NULL);
INSERT INTO `clientes` VALUES('45','Teresa Tillería','Teresa Tillería','-','-','-','Barrio Sta maría','Encarnación','Inactivo',NULL);
INSERT INTO `clientes` VALUES('46','Glass y Co S.A','Edgar Castelli','-','-','-','-','-','Inactivo',NULL);
INSERT INTO `clientes` VALUES('47','Juan Pablo Prieto','Juan Pablo Prieto','-','-','-','-','-','Inactivo',NULL);
INSERT INTO `clientes` VALUES('48','Maria Simonelli','Maria Simonelli','-','-','-','-','-','Inactivo',NULL);
INSERT INTO `clientes` VALUES('49','Marcial Mezger','Marcial Mezger','-','-','-','-','-','Inactivo',NULL);
INSERT INTO `clientes` VALUES('50','Municipalidad de Nueva Alborada','Municipalidad de Nueva Alborada','-','-','-','-','-','Inactivo',NULL);
INSERT INTO `clientes` VALUES('51','Jose Rojas','Paola Cocco Diseños','-','-','-','-','-','Inactivo',NULL);
INSERT INTO `clientes` VALUES('52','Etopapaite.com','Carmen Benitez','-','-','-','Coronel Bogado','-','Inactivo',NULL);
INSERT INTO `clientes` VALUES('53','Rlv ingenieria','Ricardo Vera RLV','-','-','-','centro','Encarnacion','Inactivo',NULL);
INSERT INTO `clientes` VALUES('54','Lutique ','Lucia Lopez','-','-','-','-','-','Inactivo',NULL);
INSERT INTO `clientes` VALUES('55','Castor Rex SRL','Olga Fischer','-','-','-','-','-','Inactivo',NULL);
INSERT INTO `clientes` VALUES('56','La Mision Group','Olga Fischer','-','-','-','-','-','Inactivo',NULL);
INSERT INTO `clientes` VALUES('57','Vieyra Py','Hector Vieyra','-','-','-','-','-','Inactivo',NULL);
INSERT INTO `clientes` VALUES('58','Acopios Unión','Acopios Unión','-','-','acopioas@ausa.com.py','Capitan Meza','Itapua','Inactivo','');
INSERT INTO `clientes` VALUES('59','Concretar SRL','Aldo Aguilera','-','-','-','-','-','Inactivo',NULL);
INSERT INTO `clientes` VALUES('60','Ciencia y Deporte','David Insaurralde','-','-','-','-','-','Inactivo',NULL);
INSERT INTO `clientes` VALUES('61','Estacion 32','Hugo Stumps','-','-','-','-','-','Inactivo',NULL);
INSERT INTO `clientes` VALUES('62','Credigrow SAECA','Juan Aquino','80085579-5','+595 985 577490','creditos@credigrow.com.py','Ruta PY01 Mcal. López y Ángel R. Samudio','Encarnación','Inactivo',NULL);
INSERT INTO `clientes` VALUES('63','Parcrop E.A.S.','Yanina Baez','-','-','-','-','-','Inactivo',NULL);
INSERT INTO `clientes` VALUES('64','Detectar GPS','Cristian Acosta y Franco','-','-','-','-','-','Inactivo',NULL);
INSERT INTO `clientes` VALUES('65','Federacion Paraguaya de Ciclismo FPC','David Insaurralde',NULL,NULL,NULL,NULL,NULL,'Inactivo',NULL);
INSERT INTO `clientes` VALUES('66','Pepcol Foods','Franco Giovanni',NULL,'+1 (323) 210-9989',NULL,'Casteldefels ','Barcelona - España','Activo',NULL);
INSERT INTO `clientes` VALUES('70','DexStoore','DexStoore',NULL,NULL,NULL,NULL,'Asuncion','Inactivo',NULL);
INSERT INTO `clientes` VALUES('71','CENADE','Ricardo Lohse','80019296-6','+595 985 900023','admin@cenade.org.py','Barrio Kaaguy Rory','Encarnación','Inactivo',NULL);
INSERT INTO `clientes` VALUES('72','Parana Broker de Seguros SA','Jorge Castelví','80145712-2','0983918897','jorgecastelvi@gmail.com','Jovenes por la democracia Nº 1741','Encarnación','Activo',NULL);
INSERT INTO `clientes` VALUES('73','Phoenix GIA SA','Cristiane Baumann','80114812-0','+595 982715444','cristiane@bohalinvsa.com','Autopista Ruta Transchaco - Km 25,5','Villa Hayes','Activo',NULL);
INSERT INTO `clientes` VALUES('74','RL Comercial','Andrea Lugo','80104722-6','0985694129','rlsrl2010','Ruta 6 km 9.5','Encarnación','Activo',NULL);
INSERT INTO `clientes` VALUES('75','Bella Vista Hotel',' B.V.S.  S. A.','80053890-0',NULL,'reservas@bellavistahotel.com.py',NULL,'Encarnación','Activo',NULL);
INSERT INTO `clientes` VALUES('76','Marca Registrada','Cinthia Cuesta','','+595 985 951951','marcaregistrada@gmail.com',NULL,'Encarnación','Activo','Se traslado de otro hosting anterior, el proveedor brindó la copia de seguridad del wordpress y se restauró a nuestro hosting sin costo.\r\n');
INSERT INTO `clientes` VALUES('77','','Antonio Rivarola - Toño','','','',NULL,'Encarnación','Activo','');
INSERT INTO `clientes` VALUES('78','Itapua Al instante','Hugo Fernandez','','595982817918','',NULL,'Encarnación','Activo','Trabajaba en TVS, se hizo contacto desde allí.');
INSERT INTO `clientes` VALUES('79','Sevedi Alimentos','Prontopan SRL','80115794-3','0982349028','prontopancompras@gmail.com',NULL,'Obligado','Activo','A cargo de Rolando García como soporte TI.');


DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` VALUES('1','0001_01_01_000000_create_users_table','1');
INSERT INTO `migrations` VALUES('2','0001_01_01_000001_create_cache_table','1');
INSERT INTO `migrations` VALUES('3','0001_01_01_000002_create_jobs_table','1');
INSERT INTO `migrations` VALUES('4','2026_05_18_000000_create_tickets_table','2');
INSERT INTO `migrations` VALUES('5','2026_05_18_000001_add_solicitante_to_tickets_table','3');
INSERT INTO `migrations` VALUES('6','2026_05_18_000002_add_archivos_to_tickets_table','4');
INSERT INTO `migrations` VALUES('7','2026_05_19_000000_add_estado_to_pagos_table','5');
INSERT INTO `migrations` VALUES('8','2026_05_19_000001_create_reseller_tables','6');
INSERT INTO `migrations` VALUES('9','2026_05_19_000002_create_requirements_table','7');


DROP TABLE IF EXISTS `pagos`;
CREATE TABLE `pagos` (
  `pago_id` int NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `cliente_id` int DEFAULT NULL,
  `servicio` varchar(255) DEFAULT NULL,
  `monto` varchar(255) DEFAULT NULL,
  `periodicidad` enum('Único','Mensual','Anual') DEFAULT NULL,
  `fecha_proximo_pago` date DEFAULT NULL,
  `observacion` text,
  `estado` varchar(255) NOT NULL DEFAULT 'Pagado',
  `pool_id` bigint unsigned DEFAULT NULL,
  `porcion_recurso` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`pago_id`),
  KEY `fk_cliente_pago` (`cliente_id`),
  CONSTRAINT `fk_cliente_pago` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`cliente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=156 DEFAULT CHARSET=latin1;

INSERT INTO `pagos` VALUES('1','2022-01-11','18','Streaming Audio mes de Enero','71.760',NULL,NULL,'Por giros tigo al 0985758031','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('2','2022-01-13','40','Diseño motivo 25 años + plantilla .ppt firma correo y cumple','500.000','',NULL,'transferencia vía regional web','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('3','2022-01-26','19','Hosting Premium Anual 06/01/22 al 06/01/23 panamericanasa.com','772.000',NULL,NULL,'transferencia vía regional web','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('4','2022-02-01','64','Hosting Premium Anual 100 u$ Vto 02/02/2023','100 u$','Anual','2023-02-02','Se recibió vía paypal en cuenta dominios@soteweb.com','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('5','2022-02-02','59','Diseño Web + Hosting básico + email','1.200.000','',NULL,'transferencia vía regional web. Derlis Vargas','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('6','2022-02-03','60','Hosting Premium Anual 100 u$ Vto. 02/02.','350.000','Anual',NULL,'transferencia vía regional web. ','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('7','2022-02-14','20','Hosting Premium Anual 100 u$ Vto 09/01/2023. Dto. 10u$/mail','630.000',NULL,NULL,'Transferencia 350.000 Gs vía regional el 17/02 y 280.000 Gs el 13/03','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('8','2022-02-15','18','Streaming Audio Mes Febrero','69.500',NULL,NULL,'Por giros tigo al 0985758031','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('10','2022-03-18','18','Streaming Audio Mes Marzo','70.000',NULL,NULL,'Por giros tigo al 0985758031','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('11','2022-03-21','23','Hosting Starter Anual 55u$ + Correo Mini 60u$  + Registro gestar.com.py 200.000 Gs.','1.005.000',NULL,'2023-03-16','Transferencia Regional Web. Andrea Acuña','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('12','2022-04-08','27','Business Hosting Standard (06/04/2022-07/04/2023) 250u$/año tvs.com.py','1.750.000',NULL,NULL,'Efectivo en TVS. Factura de Soteweb.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('13','2022-04-08','27','Registro de dominio plantopia.com.py','220.000',NULL,NULL,'Efectivo en TVS. Factura de Soteweb.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('14','2022-04-16','18','Streamig Audio Mes Abril','69.500',NULL,NULL,'Por giros tigo al 0985758031','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('15','2022-04-26','22','Registro dominio anual + correo MINI 10GB. 130u$ total','897.000',NULL,'2023-04-26','transferencia a regional web. Factura Soteweb Nº 607','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('16','2022-04-28','26','Registro de dominio anual 220.000 Gs + Correo Mini 10 GB 110u$ jessylens.com.py ','973.500',NULL,'0001-11-30','Transferencia vía regional web. Factura soteweb Nº 608','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('17','2022-05-05','61','Streaming de Audio Veemesoft. Vto. 10/04/2022','120.000','',NULL,'Giros Tigo. Se pagó por 3 meses adelantado el 26/03/2022.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('18','2022-05-17','18','Streaming Audio Mes Mayo','70.000',NULL,NULL,'Por giros tigo al 0985758031','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('19','2022-06-07','21','Correo Micro 5GB (anual) + Registro anual bohalinvsa.com (05/06/2022 - 05/06/2023)','685.000',NULL,NULL,'Por transferencia bancaria a Regional Web. DNS en soteweb Correo en MX','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('20','2022-06-09','17','Hosting + plafatorma Plan Jose Paradiso 70u$/mes','955.000','Anual','2023-10-29','Transferencia 132 u$ a José vía paypal para que le llegue 140u$ el 18/06/2022. Solo tenemos el dominio, el hosting está en Jamit Solutions.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('21','2022-06-16','18','Streaming de Audio mes Junio','70.000',NULL,NULL,'Por giros tigo al 0985758031','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('22','2022-06-17','53','rlvingenieria.com + migadu mini: 12.99 + 19 u$/año','616.000','',NULL,'Transferencia a regional Web. Factura Soteweb Nº 614. Cambiado a MX route el 28/06/2022 a Plan Micro','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('23','2022-07-07','1','Correo Mini 5GB - Eagropecuario.com.py 60u$/año','224.000','Anual',NULL,'Envió por giros tigo 224.000 Gs por el 50%. se pudo cobrar 213.000 Gs.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('24','2022-07-21','18','Streaming Audio Mes Julio','70.000',NULL,NULL,'Cambiado de fastcast4u a solumedia. Pago recibido por giros tigo.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('25','2022-07-19','50','Hosting Básico 12u$Asura + Registro nic.py + Correo Mini (100u$+220mil)','900.000',NULL,'2023-07-19','Recibido vía regional web por hosting+registro+correomini','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('27','2022-08-09','13','Registro dominio anual 220.000 + Hosting Premium Asura 110u$','968.000','',NULL,'Efectivo cobrado en el hotel. 110u$+220.000Gs. c/factura Soteweb. Próximo año baja de plan a 66u$.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('28','2022-08-16','29','Hosting premium 100u$ c/dcto 20% a 80u$','526.000',NULL,'2023-08-14','Transferencia a regional web 526.000 Gs','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('29','2022-08-20','18','Streaming Audio Mes Agosto','69.000',NULL,NULL,'Envio por giros tigo al 0985758031','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('30','2022-09-06','1','Correo Mini 5GB - Eagropecuario.com.py 60u$/año','238.000','Anual','2023-07-07','Pago 2. Carga de Billetera tigo para cancelar el saldo.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('31','2022-09-21','30','Diseño y desarrollo cambyretainforma.com.py','1.000.000',NULL,NULL,'Entrega 1000000. falta 1000000. Registro nic.py incluído por 1 año.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('32','2022-10-04','15','Registro + Hosting en soteweb.com + Correo Mini 5GB norteazur.com','700.000','Anual','2023-09-26','Transferencia a regional Web 700.000 Gs.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('33','2022-10-14','1','Hosting Premium Asura 100 u$ anual eagropecuario.com.py','356.000',NULL,NULL,'Tranferencia 50% vía Regional Web','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('34','2022-10-22','2','Hosting Premium Asura 100 u$ anual itapuainforma.com','720.000',NULL,NULL,'Pago Efectivo en Más TV con factura Soteweb 634','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('35','2022-11-01','62','Actualización sitio web en credigrow.com.py. Host en donweb','2.200.000','Anual',NULL,'Transferencia vía regional web. Su hosting está en donweb.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('36','2022-11-02','30','Diseño y desarrollo cambyretainforma.com.py','500.000',NULL,NULL,'Transferencia a regional web. Falta 500000','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('37','2022-11-07','3','Hosting Premium Asura 100 u$ anual encarnacionnoticias.com','720.000','Anual','2023-10-22','Pago Efectivo en Más TV con factura Soteweb 637','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('38','2022-11-14','5','Hosting Premium Asura 110 u$ anual tirolandia.com.py','773.300','Anual','2023-11-14','Transferencia vía regional Web con factura Soteweb','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('39','2022-11-17','30','Diseño y desarrollo cambyretainforma.com.py','500000','Anual','2023-09-21','Pago Efectivo sin factura. Lugar: Ña Cloti empanadas.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('40','2022-12-01','18','Hosting Premium anual 100 u$','720000','Anual','2023-11-15','Depósito en cuenta de Regional Coronel Bogado.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('41','2022-12-13','20','Correo Mini 10 GB (18/11/2021 al 18/11/2022) pucon y aisen','795.000','Anual','2023-11-18','Transferencia vía Regional Web.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('42','2022-12-15','70','Diseño web dexstoore.com + hosting ilimitado','1.800.000','',NULL,'Transferencia 800mil primer pago 1millon segundo pago vía regional web.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('43','2022-12-21','1','Hosting Premium Asura 100 u$ anual eagropecuario.com.py','365.000','Anual','2023-10-14','Transferencia vía regional web. Pago completo.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('44','2023-01-03','10','Diseño web + registro + hosting básico greenglobesa.com.py','2.000.000','Anual','2024-01-03','Transferencia vía regional web','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('45','2023-01-11','4','Diseño web + hosting asura para laaurelia.com.py','1.200.000',NULL,NULL,'-','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('46','2023-01-31','19','Hosting premium panamericanasa.com 110u$ + 2 registro dominios castorrexsrl.com y lamisiongroupsrl.com 30u$c/u','1.258.000','Anual','2024-01-07','Pago en efectivo con entrega de factura en Castor Rex. Todos alojados en hosting panamericana.com. Dominios registrados en Asura.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('47','2023-02-17','60','Mail Ciencia y deporte. Plan Mini 100u$','400.000','Anual','2024-04-07','Transferencia via regional web.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('48','2023-03-04','14','Hosting Elite Asura 180u$ anual paraguayennoticias.com.py','1.305.000','Anual','2024-03-02','Pago vía giros Tigo. no se incluye registro de dominio. Se entregó factura Soteweb. Asociado al dominio aldovazquez.com','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('50','2023-03-20','20','Hosting Premium Ifastnet 90u$ asociado a pucon. aisen y cooperú. 10u$ dcto porque tiene correo.','650.000','Anual','2024-02-14','Facturado a Ricardo Pineda el 21/03/2023','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('51','2023-03-22','16','Diseño Web + Hosting básico + email rbemprendimientos.com.py 2.800.000 + 66u$ Correo','2.074.000',NULL,NULL,'Pagado vía transferencia y con factura soteweb 2.074.000 Gs 66u$ por el correo más una entrega por el diseño','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('52','2023-03-28','23','Hosting Starter Anual 55u$ + Correo Mini 60u$  + Registro gestar.com.py 200.000 Gs.','1.030.000','Anual','2024-03-16','-','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('53','2023-03-29','6','Hosting premium + soporte','1.303.000','Anual','2024-03-16','Pagado vía transferencia a regional web el 29/03','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('54','2023-03-29','65','Mail FPC. Plan Mini 10GB 100u$','250.000','Anual','2024-04-07','Pagó 250.000 Gs el 28/03/23 vía regional web.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('55','2023-04-11','27','Hostig Premium Ferozo + SSL - 140 u$','1.080.000','Anual','2024-04-04','Pago en efectivo con entrega de factura en TVS','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('56','2023-04-12','65','Mail FPC. Plan Mini 10GB 100u$','121.000','Anual','2024-04-07','Vía regional web. Saldo de 359.000 Gs.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('57','2023-04-13','4','Diseño web + hosting asura para laaurelia.com.py','1.200.000','Anual','2023-12-23','Transferencia vía regional web.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('58','2023-04-21','22','Registro dominio anual dosriossrl.com.py(25-04/23-25/04/24) + correo MINI 10GB. 130u$ total','949.000',NULL,'2024-04-26','Transferencia a regional web 949.000 Gs.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('59','2023-04-22','26','Registro de dominio 220.000 Gs + Correo Mini 10 GB por 6 meses (110 u$ /2 = 55u$)','652.000','Anual','2023-10-24','Transferencia. Factura soteweb Nº 676','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('60','2023-04-24','63','Diseño y desarrollo web para parcrop.com alojado en su hosting','1.170.455','',NULL,'Pago 50% por diseño y desarrollo web para parcrop.com. Se expidió factura Soteweb','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('63','2023-06-08','21','bohalinvsa.com 100u$/año. Dominio gestionado en Soteweb p/correo.','718000','Único',NULL,'Transferencia vía Regional web 100u$ - 718.000 Gs.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('64','2023-06-08','9','Hosting Básico 12u$Asura + Registro .com encarpress.com','584.000','Anual','2024-06-08','Pago en Efectivo 584.000 Gs. Factura Soteweb Nº 683 a nombre de Romina Godoy Villalba','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('65','2023-06-07','63','Diseño y desarrollo web para parcrop.com alojado en su hosting','1.170.455','',NULL,'Pago cancelación por diseño web del total de 2.500.000 Gs. Hacen retención de IVA por eso el monto es menos. Factura Soteweb Nº 681','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('66','2023-06-08','21','Correo Micro 5GB (anual) + Registro anual bohalinvsa.com (05/06/2023 - 05/06/2024)','718.000','Anual','2024-06-05','Transferencia vía Regional. Factura Soteweb Nº 684','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('67','2023-06-15','7','Diseño web y hosting premium para financorp.com.py','1.250.000','',NULL,'Transferencia vía Regional Web. Falta el 50%','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('68','2023-06-27','37','Actualización Sitio Web en consur.com.py - Sección Fortuner','350.000','',NULL,'Pago en Efectivo en consur. Factura Nº 689','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('69','2023-07-13','1','Correo Micro 5GB para eagropecuario.com.py 60u$ anual','219.000',NULL,NULL,'Pago por el 50%. Carga en Billetera Tigo al 0985758031 vía visión Banco. Sin factura.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('70','2023-07-17','7','Diseño web y hosting premium para financorp.com.py','1.250.000','Anual','2024-07-05','Transferencia vía web. Factura soteweb Nº 694','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('71','2023-07-19','16','Diseño Web + Hosting básico + email rbemprendimientos.com.py 2.800.000 + 66u$ Correo','1.207.800','Anual','2024-03-23','Pagado vía transferencia y con factura soteweb Nº 695. Cambio u$ a 7300Gs.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('72','2023-08-11','11','Hosting Básico 12u$Asura + Registro politiwebpy.com','584.000','Anual','2024-08-11','Pagado en efectivo con factura Soteweb Nº 700','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('73','2023-08-16','13','Hosting Standard + registro dominio delsurhotelmuseo.com.py','701.800','Anual','2024-08-09','Pagado via Transferencia Bancaria con factura Nº 701','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('74','2023-08-18','1','Correo Micro 5GB para eagropecuario.com.py 60u$ anual','219.000','Anual','2024-07-07','Pago por el 100%. Transferencia a cuenta Sudameris. Sin factura.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('75','2023-08-29','29','Hosting premium 100u$ c/dcto 20% a 80u$','572.800','Anual','2024-08-14','Transferencia a Sudameris Web 572800. No pidió boleta.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('76','2023-08-29','62','Positive SSL para credigrow.com.py + instalación','180.000',NULL,NULL,'Transferencia a Sudameris Web. Factura Nº 702','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('77','2023-08-31','8','Hosting Premium 100u$ + plataforma Woocommerce','1.000.000','Anual','2024-08-31','Transferencia a Sudameris Web. Factura Nº 703','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('78','2023-09-14','28','Hosting Premium 120u$ + Positive SSL 20u$','1.022.000','Anual','2024-09-16','Transferencia a Sudameris Web. Factura Nº 706','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('79','2023-09-25','25','Registro Dominio vargasasesora.com + Correo Mini 5G','0','Anual','2024-09-14','Hosteado en soteweb.com. Pago por mi cuenta por canje de servicios.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('80','2023-10-02','15','Registro + Hosting en soteweb.com + Correo Mini 5GB norteazur.com','730.000','Anual','2024-09-26','Transferencia a Sudameris. Factura a ser entregada en Norteazur.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('81','2023-10-19','1','Hosting Premium Asura 100 u$ anual eagropecuario.com.py','371.500','Anual','2023-11-19','Pagó la mitad de los 100u$ vía transferencia a cuenta Sudameris.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('82','2023-11-01','70','Registro de dominio dexstoore.com.py + Hosting Básico GB','1000000','Anual','2024-11-01','Había vencido el plan anterior, no renovó por lo que se cortó y se perdió el dominio .com. Se tuvo que registrar de nuevo un .com.py y subir todo de nuevo en un hosting de 12GB. Se dió 200.000 Gs a Franci por comisión por ventas. Se cobró 1millón porque aparte de la actualización se solicitó algunos cambios.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('83','2023-10-25','50','Registro de dominio nuevaalborada.gov.py + Hosting básico + correo 5GB','1.034.000 Gs','Anual','2024-07-19','Había vencido el 19-07-2023 pero no pagaron a tiempo, se pagó en octubre y se tuvo que volver a restaurar una copia anterior ya que el hosting había borrado todo lo que había anteriormente.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('84','2023-11-18','18','Hosting Premium (anual) -  radiomarandu.com.py (15/11/2023 - 15/11/2024)','740.000','Anual','2024-11-15','Pago vía depósito en cuenta de Francisco Sotelo de Visión Banco.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('85','2023-10-24','26','Actualizacion a Correo Giga 25 GB por 6 meses (160 u$ anual)','651200','Anual','2024-04-22','Tenía el plan de 100u$ y actualizó al plan de 160u$. Pagó la mitad 80u$. ','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('86','2023-12-22','4','Hosting Premium anual',' 814.000','Anual','2024-12-23','Pagado vía transferencia','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('87','2023-12-22','1','Hosting Premium Asura 100 u$ anual eagropecuario.com.py','367.500','Anual','2024-10-14','Segundo pago pendiente de lo anterior.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('88','2024-01-17','19','Hosting premium panamericanasa.com 110u$ + 2 registro dominios castorrexsrl.com y lamisiongroupsrl.com 30u$c/u','1.240.227','Anual','2025-01-07','Pago en efectivo con entrega de factura en Castor Rex. Todos alojados en hosting panamericana.com. Dominios registrados en Asura.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('89','2024-02-08','16','Hosting Premium anual + SSL Comodo','962.000','Anual','2025-02-02','El correo y dominio vence en otra fecha por separado. Se cambió por problemas con la subida FTP de Asura a Donweb. Factura soteweb Nº 738','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('90','2023-12-16','63','Diseño Web realcapital.cl','1.300.000','Único',NULL,'Pago por el 50% de diseño web en su mismo hosting asociado al dominio realcapital.cl. Factura soteweb Nº 729','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('91','2023-12-22','4','Hosting Premium Anual laaurelia.com.py ','814.000','Anual','2024-12-23','Pago vía transferencia. Factura Nº 730 Soteweb','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('92','2024-01-06','63','Diseño Web realcapital.cl','1.300.000','Único','2024-12-23','Pago por el 50% restante de diseño para realcapital.cl. Factura Soteweb Nº 731','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('93','2024-01-16','19','Hosting premium panamericanasa.com 110u$ + 2 registro dominios castorrexsrl.com y lamisiongroupsrl.com 30u$c/u','1.275.000','Anual','2024-11-15','Pago hosting panamericanasa.com 825.000 Gs + registro castorrexsrl.com 30u$ + registrolamisiongropsrl.com 30u$ (alojados en el hosting panamericana). Factura soteweb Nº 732','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('94','2024-03-20','19','Registro de dominio sadyfgroup.com','30 u$','Anual','2025-03-20','Dominio alojado en el hosting de panamericanasa.com','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('95','2024-02-28','66','Hosting Premium anual + Diseño Web pepcolfoods.com','150 u$','Anual','2025-02-28','Parte de pago por el diseño web, registro de dominio y hosting pepcolfoods.com. Envió el pago por western union','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('96','2024-03-06','66','Hosting Premium anual + Diseño Web pepcolfoods.com','50 u$','Anual','2025-02-28','Cancelación de los 200 u$ por diseño web mas hosting anual. Envio por western union.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('97','2024-03-26','6','Hosting Premium Anual ','803.000 Gs','Anual','2025-03-16','Pago tardío por tranferencia bancaria a cuenta de sudameris. Venció en 16 y pagaron el 26','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('98','2024-04-02','22','Registro dominio anual dosriossrl.com.py(25-04/24-25/04/25) + correo 25GB. 160u$ total','1.168.000','Anual','2025-04-25','Tenia el plan de 10GB, actualizó el 02 de abril al de 25GB, se le cobró adelantado por el plan ya que pasó al de 160u$. No se le cobra el dominio porque usa un solo correo y no suelen tener problemas ni piden asistencia.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('99','2024-04-09','16','Registro de dominio rbemprendimientos.com.py + Correo Mini Anual','701800','Anual','2025-03-23','El registro y correo vence en esta fecha. El hosting en otra fecha porque se habilitaron de forma separada.220.000 + 66 u$','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('100','2024-04-26','26','Registro de dominio 220.000 Gs + Correo Giga 25 GB (160 u$)','1388000','Anual','2025-04-25','Su plan actual es el Giga 25 que sale 160u$ más el registro de dominio. Antes de esto si tenian el plan más básico. 220.000 Gs + 1.168.000 Gs','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('101','2024-05-03','27','Hostig Premium Ferozo + SSL - 140 u$ + Soporte reinstalación WP','1022000','Anual','2025-04-04','Sitio hackeado y dañado, se volvió a reinstalar un WP con las noticias de los últimos dos meses. Factura Nº 754 a nombre de Orbe Multimedios, cobrado en Ogará efectivo. Gs (140u$) + 440.000 Gs (2 hs soporte técnico)','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('102','2024-05-03','71','Hosting Premium Anual 100u$ c/dcto 20%','592000','Anual','2025-04-25','El hosting habitual sale 100u$ se le hizo a 80u$ para colaborar. (hosting 80u$) + 166.000 (registro)','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('103','2024-05-06','23','Hosting Starter Anual 55u$ + Correo Mini 60u$ + Registro gestar.com.py 200.000 Gs.','1.046.400','Anual','2025-03-24','Pagó tarde con transferencia. Factura Soteweb Nº 757.\r\n200.000 + 404.800(55u$)+441.600(60u$)=1.406.400 Gs','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('104','2024-06-14','21','Correo Micro 5GB (anual) + Registro anual bohalinvsa.com (05/06/2024 - 05/06/2025)','750.000 Gs','Anual','2025-06-05','Pago por transferencia bancaria. Se contactó con Cris Baumann y Marlene. Se preparó factura para enviar a su local de Villa Hayes.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('105','2024-03-18','65','Diseño y Desarrollo Web Wordpress Nuevo','750.000 Gs','Único',NULL,'Rediseño de sitio web de la FPC por hackeo y cambio de hosting. Presupuesto Total: 1.500.000 Gs.\r\nSaldo 750.000 Gs.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('106','2024-07-02','65','Diseño y Desarrollo Web Wordpress Nuevo','800.000 Gs','Único',NULL,'Rediseño de sitio web de la FPC por hackeo y cambio de hosting. Presupuesto Total: 1.500.000 Gs.\r\nSaldo 0. Cancelado.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('107','2024-07-08','7','Hosting Premium Anual financorp.com.py','825.000','Anual','2025-07-05','Recibido vía transferencia bancaria en sudameris. Se envió boleta física por courrier.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('108','2024-08-05','50','Hosting Básico 12u$Asura + Registro nic.py + Correo Mini (100u$+220mil)','1.045.000','Anual','2025-07-19','Pagó por cheque banco río. Se le dió factura.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('109','2024-08-08','13','Hosting Standard + registro dominio delsurhotelmuseo.com.py','715.000','Anual','2025-08-09','Pagado via Transferencia Bancaria con factura electronica 009','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('110','2024-08-30','8','Hosting Premium 100u$','768.000 Gs','Anual','2025-08-31','Transfirió a Sudameris desde cuenta de SPI MG Markets EAS','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('111','2024-09-12','28','Hosting Premium 120u$ + Positive SSL 20u$','1.078.000','Anual','2025-09-16','Se cobró vía transferencia a sudameris. Factura 785.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('112','2024-09-12','25','Registro Dominio vargasasesora.com + Correo Mini 5G','0','Anual','2025-09-14','Hosteado en soteweb.com. Pago por mi cuenta por canje de servicios por contabilidad.\r\n','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('113','2024-09-13','29','Hosting premium 100u$ c/dcto 20% a 80u$','616.000','Anual','2025-08-14','Transferencia a Sudameris Web 616.000 Gs. Solicitó factura.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('114','2024-10-08','72','Hosting Básico 60u$Asura + Registro nic.py + Correo Mini (120u$+166mil)','1.096.000 (hosting + registro + Correo)','Anual','2025-10-08','Se cobró vía transferencia bancaria a Sudameris. Responsable Emanuel Castelvi de la UNAE. Estudiante de Análisis. ','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('115','2024-10-17','65','Hosting Básico 12 GB','390.000','Anual','2025-10-06','Pago David Insaurralde. Transferencia a cuenta sudameris 300.000 Gs + 90.000 Gs.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('116','2024-11-25','18','Hosting Premium (anual) -  radiomarandu.com.py (15/11/2024 - 15/11/2025)','780.000','Anual','2025-11-15','Pago vía transferencia a mi cuenta de Sudameris de cuenta Lorena Guadalupe Fleitas. ','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('117','2024-12-03','15','Registro + Hosting en soteweb.com + Correo Mini 5GB norteazur.com','772.500','Anual','2025-09-26','Transferencia a Sudameris. No se logró recuperar el dominio porque estaba en periodo de eliminación por lo que se registró en el nic.py el dominio norteazur.com.py','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('118','2024-12-23','4','Hosting Premium Anual laaurelia.com.py ','858.000','Anual','2025-12-23','Pago vía transferencia a Sudameris. Factura Nº 004 Virtual. Enviado a yohn.veia@laaurelia.com.py y creditos@credigrow.com.py','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('119','2025-01-24','73','Correo Micro 5GB (anual) + Registro anual phoenixgia.com.py (24/01/2025 - 24/01/2026)','790000','Anual','2026-01-24','Pago vía transferencia bancaria a Sudameris 790.000 Gs que son 100u$ a 7.900. Se pasó los datos vía email a cristiane@bohalinvsa.com. 100 u$ (plan 60u$ + registro)','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('120','2025-02-14','19','Hosting premium panamericanasa.com 110u$ + 3 registro dominios 30u$c/u','1.623.000','Anual','2026-01-07','Hosting asociado a panamericanasa.com. Los otros dominios están alojados en el mismo hosting que son: castorrexsrl.com, lamisiongroupsrl.com y sadyfgroup.com. El monto era de 110 + 30 + 30 + 30 = 200 x 7900 = 1.580.000 Gs. Pero se pagó 1.623.000 porque era con retención de IVA según manifestó el cliente. ','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('121','2025-02-24','66','Hosting Premium anual + dominio pepcolfoods.com','779.690 Gs','Anual','2026-02-28','Pago vía Western Unión. Recibido 779.690 equivalente a los 100 u$ anuales.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('122','2025-02-28','37','Instalación plugin Instagram Feed Pro','425.000','Único',NULL,'Cobrado en efectivo en caja de Consur. Se envió factura virtual a bianca.guerrero@consur.com.py','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('124','2025-03-06','16','Registro dominio rbemprendimientos.com.py + Correo Mini Anual + hosting + SSl','1768400','Anual','2026-03-23','Se unificaron los vencimientos al 23/03 de cada año ya que vencian de esta manera.\r\nHosting Premium 30 GB (anual)	2/2/2025	110 u$\r\nPositive SSL (anual)	2/02/2025	20 u$\r\nRegistro de Dominio (anual)	23/3/2025	220.000 Gs.\r\nCorreo Mini (anual)	23/3/2025	66 U$\r\nFactura digitral 0018 enviado por mail y cobrado por transferencia a Sudameris.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('126','2025-03-13','6','Hosting Premium (anual) - asociado al dominio aguavista.com.py ','869.000','Anual','2026-03-16','Pago recibido vía transferencia a Sudameris. Se envió factura virtual a Gustavo Araujo.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('127','2025-04-09','74','Registro de dominio 166.000 + Correo Mini10GB 110u$','1.046.000','Anual','2026-04-09','Se le gestionó y pagó el dominio, se habilito el plan de 10GB. Contacto técnico: Lisandro Pereira.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('128','2025-04-14','27','Hostig Premium Ferozo + SSL - 140 u$','1.120.000','Anual','2026-04-14','Transferencia recibida a cuenta Sudameris. Germán ya no está a cargo, respondó Angélica Pereira quién pasó comprobante.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('129','2025-04-21','23','Hosting Starter Anual 55u$ + Correo Mini 60u$ + Registro gestar.com.py 200.000 Gs.','1.118.000','Anual','2026-03-24','Pagó por transferencia. Factura digital soteweb Nº 028.\r\nHOSTING STARTER (ANUAL)55U$:439.065 + 1CORREO MICRO (ANUAL)60 U$ 478.935 + 1REGISTRO DE DOMINIO 200.000 = 1.118.000 Gs.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('130','2025-04-28','26','Registro de dominio (anual) + Correo Giga 25GB (anual) - 160 u$','1500000','Anual','2026-04-25','Pagado vía transferencia bancaria a sudameris. Se envió factura virtual Nº 031 a Carolina Fernandez de RRHH. 220.000 Gs + 1.280.000 Gs','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('131','2025-04-28','22','Registro dominio anual dosriossrl.com.py(25-04/25-25/04/26) + correo 25GB. 160u$ total','1.280.000 Gs','Anual','2026-04-25','Cobrado vía transferencia bancaria en sudameris. Factura digital Nº 30 enviada a Yessica.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('132','2025-06-17','72','Actualizacion a Correo Mini10GB hasta el vencimiento 08/10/2025','173.800','Único','2025-10-08','Se hizo el prorrateo y para actualizar del plan de 60U$ al plan de 110u$ debió pagar 22u$ hasta el 08/10/2025. A partir de allí deberá pagar 110u$ completos por el año siguiente.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('133','2025-06-25','21','Correo Micro 10GB (anual) + Registro anual bohalinvsa.com (05/06/2025 - 05/06/2026)','1096200','Anual','2026-06-05','Pago por transferencia bancaria. Se había vencido y pagaron tarde, como que se estaba llenando se pasó al plan de 10GB. El plan incluye correo 110u$ + registro dominio 30 u$ por año. Se envia factura digital a Cris Baumann.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('134','2025-07-04','7','HOSTING PREMIUM ANUAL financorp.com.py - (05/07/2025 - 05/07/2026)','858.000','Anual','2026-07-05','Recibido por transfererencia a sudameris 858.000 Gs correspondiente a 110u$ según el cambio del día. Se envió factura virtual número 0044.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('135','2025-07-25','75','Rediseño de Sitio web + traslado de hosting','2.400.000','Único',NULL,'Se diseñó en wordpress a partir de su diseño anterior joomla. La copia de seguridad fue proveído por Juan Vera y se subió a su hosting.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('136','2025-08-18','13','Hosting Standard + registro dominio delsurhotelmuseo.com.py','701.800','Anual','2025-08-09','Pagado via Transferencia Bancaria con factura Nº 777','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('137','2025-09-03','29','Hosting premium 100u$ c/dcto 20% a 80u$','583.200','Anual','2026-08-14','Transferencia a Sudameris Web 583.200 Gs. Se envió factura electrónica.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('138','2025-09-10','28','Hosting Premium 120u$ + Positive SSL 20u$','1022000','Anual','2026-09-16','Pago recibido vía transferencia a sudameris. Se envió factura electrónica Nº  001-001-0000014','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('139','2025-10-09','76','Hosting Básico Anual 12GB 66u$. Registro de dominio mrtv.com.py','629.980','Anual','2026-10-09','Transferencia bancaria. No pasó datos para factura.\r\nTotal Gs: 463.980 + 166.000 Gs = 629.980 Gs\r\n','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('140','2025-10-20','72','Hosting Básico 60u$Asura + Registro nic.py + Correo Micro (170u$+166mil)','1366200','Anual','2025-10-20','Se cobró vía transferencia bancaria a Sudameris. Responsable Emanuel Castelvi de la UNAE. Estudiante de Análisis. 0  (hosting + registro + Correo)','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('141','2025-11-14','18','Hosting Premium (anual) 66 u$ -  radiomarandu.com.py (14/11/2025 - 14/11/2026)','468600','Anual','2026-11-14','Pago vía transferencia a mi cuenta de Sudameris de cuenta Natalia Sosa. Estaba en Ifasnet y se cambió a Asura ya que solo usan una web básica y un correo que se trasladó al nuevo hosting.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('142','2025-12-29','4','Hosting Premium Anual laaurelia.com.py ','742500','Anual','2026-12-23','Pago recibido vía transferencia a Sudameris. Factura Nº 039 Virtual.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('143','2025-12-29','15','Registro + Hosting en soteweb.com + Correo Mini 5GB norteazur.com','726000','Anual','2026-12-25','Transferencia a Sudameris. Se envió factura Nro 043 de Soteweb','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('144','2026-01-27','77','SSD HP240 GB + Mantenimiento PC escritorio','250000','Único',NULL,'Pago recibido por transferencia.\r\n','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('145','2026-02-05','78','Unlimited Plan - itapuaalinstante.com.py + Registro de dominio','760000','Anual','2027-02-04','Se recibió pago vía transferencia a Sudameris.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('146','2026-02-19','72','Actualización a Correo Plan 25GB 160u$ hasta el vencimiento 20/10/2026','224250','Único','2026-10-20','Ajuste de Plan - Detalle de Prorrateo\r\nPlan 25GB 160u$/año realizada el 09/02/2026, se ha generado una diferencia hasta su próximo vencimiento en octubre.\r\nDías restantes de cobertura: 253 días (hasta el 20/10/2026).\r\nDiferencia de precio anual: 50 USD.\r\nMonto total a abonar: 34.66 USD o su equivalente en Gs al cambio del día.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('147','2026-02-24','66','Hosting Premium anual + dominio pepcolfoods.com 100u$','671000','Anual','2027-02-24','Pago recibido vía Western Union. Valor 100 u$. Cobrado 671.000 Gs.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('148','2026-03-26','6','Hosting Premium (anual) - asociado al dominio aguavista.com.py 110u$','720500','Anual','2027-03-16','Pago recibido por transferenia bancaria a cuenta de Sudameris.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('149','2026-04-08','74','Registro de dominio 166.000 + Correo Mini10GB 110u$. Contacto técnico: Lisandro Pereira.','1241680','Anual','2027-04-09','Vía transferencia a Sudameris. Pagó demás porque incluyó el IVA a todo aparentemente.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('150','2026-04-01','16','Hosting Premium 30 GB (anual)110 u$ + Positive SSL (anual) 20 u$ + Registro de Dominio (anual) 220.000 Gs. + Correo Mini (anual) 66 U$','1499880','Anual','2027-03-23','Vía transferencia bancaria a Sudameris.\r\n? Hosting Premium 30 GB (anual)	23/03/2026	110 u$\r\n? Positive SSL (anual)	23/03/2026	20 u$\r\n? Registro de Dominio (anual)	23/3/2026	220.000 Gs.\r\n? Correo Mini (anual)	23/3/2026	66 U$','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('151','2026-04-10','23','Hosting Starter Anual 55u$ + Correo Mini 60u$ + Registro gestar.com.py 200.000 Gs.','940000','Anual','2027-03-24','Recibido vía transferencia a sudameris.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('152','2026-04-17','27','Hostig Premium Ferozo + SSL - 140 u$','918400','Anual','2027-04-14','Recibido por transferencia Sudameris. Encargado Mirtha Rodriguez.','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('153','2026-04-27','22','Registro dominio anual dosriossrl.com.py(25-04/26-25/04/27) + correo 25GB. 160u$ total','1008000','Anual','2027-04-25','Pagó por transferencia a cuenta de sudameris. Se envió factura número 64. El dólar se cotizó a 6300 Gs en el día. ','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('154','2026-04-28','73','Correo Micro 5GB (anual) + Registro anual phoenixgia.com.py (24/01/2026 - 24/01/2027)','630000','Anual','2027-01-24','Observación:\r\nPago vía transferencia bancaria a Sudameris 630.000 Gs que son 100u$ a 6.300. Se pasó los datos vía email a cristiane@bohalinvsa.com. 100 u$ (plan 60u$ + registro)','Pagado',NULL,NULL);
INSERT INTO `pagos` VALUES('155','2026-04-29','26','Registro de dominio (anual) + Correo Giga 25GB (anual) - 160 u$','1236000','Anual','2027-04-24','Recibio vía transferencia bancaria a Sudameris. Factura 0065 enviada a Carolina Fernandez vía email y WhatsAPP.','Pagado',NULL,NULL);


DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



DROP TABLE IF EXISTS `pools`;
CREATE TABLE `pools` (
  `pool_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `proveedor_id` bigint unsigned NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `costo` decimal(12,2) NOT NULL DEFAULT '0.00',
  `periodicidad` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_compra` date DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `recurso_tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Almacenamiento (GB)',
  `recurso_capacidad` decimal(10,2) NOT NULL DEFAULT '0.00',
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Activo',
  `observacion` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`pool_id`),
  KEY `pools_proveedor_id_foreign` (`proveedor_id`),
  CONSTRAINT `pools_proveedor_id_foreign` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`proveedor_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



DROP TABLE IF EXISTS `presupuesto_items`;
CREATE TABLE `presupuesto_items` (
  `item_id` int NOT NULL AUTO_INCREMENT,
  `presupuesto_id` int NOT NULL,
  `producto_id` int DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `cantidad` decimal(10,2) DEFAULT '1.00',
  `precio_unitario` decimal(10,2) DEFAULT '0.00',
  `subtotal` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`item_id`),
  KEY `presupuesto_id` (`presupuesto_id`),
  CONSTRAINT `presupuesto_items_ibfk_1` FOREIGN KEY (`presupuesto_id`) REFERENCES `presupuestos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;

INSERT INTO `presupuesto_items` VALUES('17','4','29','Hosting Basic 12GB','1.00','60.00','60.00');
INSERT INTO `presupuesto_items` VALUES('18','4','26','Hosting Premium Anual 100u$','1.00','100.00','100.00');
INSERT INTO `presupuesto_items` VALUES('19','5','6','Hosting Premium (anual) - asociado al dominio aguavista.com.py','1.00','869000.00','869000.00');


DROP TABLE IF EXISTS `presupuestos`;
CREATE TABLE `presupuestos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cliente_id` int DEFAULT NULL,
  `cliente_prospecto` varchar(255) DEFAULT NULL,
  `fecha` date NOT NULL,
  `moneda` enum('GS','USD') DEFAULT 'GS',
  `total` decimal(15,0) DEFAULT '0',
  `estado` enum('Pendiente','Aceptado','Rechazado') DEFAULT 'Pendiente',
  `observacion` text,
  `detalles` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

INSERT INTO `presupuestos` VALUES('4',NULL,'Prontopan SRL','2026-03-06','USD','160','Pendiente','',NULL);
INSERT INTO `presupuestos` VALUES('5','6',NULL,'2026-03-12','GS','869000','Pendiente','',NULL);
INSERT INTO `presupuestos` VALUES('6','37',NULL,'2026-05-19','USD','0','Pendiente','Generado desde Requerimiento #1: Lentitud de sitio web y página de puntos','El cliente manifiesta que la página es lenta. Está hosteado en itacom, se le recomienda actualizar la versión de PHP. Preparar una reunión para presentar página de puntos.');


DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text,
  `periodicidad` enum('Único','Mensual','Trimestral','Semestral','Anual') DEFAULT 'Único',
  `tipo` enum('Producto','Servicio') DEFAULT 'Producto',
  `costo` decimal(15,0) DEFAULT '0',
  `precio` decimal(15,0) DEFAULT '0',
  `proveedor` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb3;

INSERT INTO `productos` VALUES('1','Correo Micro 5GB (anual) + Registro anual phoenixgia.com.py (24/01/2025 - 24/01/2026)','','Anual','Servicio','0','790000','Asura + NIC');
INSERT INTO `productos` VALUES('2','Hosting premium panamericanasa.com 110u$ + 3 registro dominios 30u$c/u','','Anual','Servicio','0','1623000','Asura + Ifastnet');
INSERT INTO `productos` VALUES('3','Hosting Premium anual + dominio pepcolfoods.com','','Anual','Servicio','0','779690','Asura/Soteweb');
INSERT INTO `productos` VALUES('4','Instalación plugin Instagram Feed Pro','','Único','Servicio','0','425000','Plugin Theme');
INSERT INTO `productos` VALUES('5','Registro dominio rbemprendimientos.com.py + Correo Mini Anual + hosting + SSl','','Anual','Servicio','0','1768400','Nic + Asura + Mxroute + comodo');
INSERT INTO `productos` VALUES('6','Hosting Premium (anual) - asociado al dominio aguavista.com.py ','','Anual','Servicio','0','869000','Asura');
INSERT INTO `productos` VALUES('7','Registro de dominio 166.000 + Correo Mini10GB 110u$','','Anual','Servicio','0','1046000','Nic + Mx route');
INSERT INTO `productos` VALUES('8','Hostig Premium Ferozo + SSL - 140 u$','','Anual','Servicio','0','1080000','Donweb + Comodo');
INSERT INTO `productos` VALUES('9','Hosting Starter Anual 55u$ + Correo Mini 60u$ + Registro gestar.com.py 200.000 Gs.','','Anual','Servicio','0','1046400','Asura + Mxroute + NIC');
INSERT INTO `productos` VALUES('10','Registro de dominio (anual) + Correo Giga 25GB (anual) - 160 u$','','Anual','Servicio','0','1500000','Nic + Mx route');
INSERT INTO `productos` VALUES('11','Registro dominio anual dosriossrl.com.py(25-04/25-25/04/26) + correo 25GB. 160u$ total','','Anual','Servicio','0','1280000','nic.py + Mxroute');
INSERT INTO `productos` VALUES('12','Actualizacion a Correo Mini10GB hasta el vencimiento 08/10/2025','','Único','Servicio','0','173800','Mxroute');
INSERT INTO `productos` VALUES('13','Correo Micro 10GB (anual) + Registro anual bohalinvsa.com (05/06/2025 - 05/06/2026)','','Anual','Servicio','0','1096200','Mx Route + asura');
INSERT INTO `productos` VALUES('14','HOSTING PREMIUM ANUAL financorp.com.py - (05/07/2025 - 05/07/2026)','','Anual','Servicio','0','858000','Asura');
INSERT INTO `productos` VALUES('15','Rediseño de Sitio web + traslado de hosting','','Único','Servicio','0','2400000','Aurea Tech');
INSERT INTO `productos` VALUES('16','Hosting Standard + registro dominio delsurhotelmuseo.com.py','','Anual','Servicio','0','701800','asura/nic');
INSERT INTO `productos` VALUES('17','Hosting premium 100u$ c/dcto 20% a 80u$','','Anual','Servicio','0','526000','Donweb');
INSERT INTO `productos` VALUES('18','Hosting Premium 120u$ + Positive SSL 20u$','','Anual','Servicio','0','1022000','DonWeb y Comodo');
INSERT INTO `productos` VALUES('19','Hosting Básico Anual 12GB 66u$. Registro de dominio mrtv.com.py','','Anual','Servicio','0','629980','Asura + NIC');
INSERT INTO `productos` VALUES('20','Hosting Básico 60u$Asura + Registro nic.py + Correo Micro (170u$+166mil)','','Anual','Servicio','0','1366200','Asura y Nic');
INSERT INTO `productos` VALUES('21','Hosting Premium (anual) 66 u$ -  radiomarandu.com.py (14/11/2025 - 14/11/2026)','','Anual','Servicio','0','468600','Asura');
INSERT INTO `productos` VALUES('22','Hosting Premium Anual laaurelia.com.py ','','Anual','Servicio','0','0','Asura');
INSERT INTO `productos` VALUES('23','Registro + Hosting en soteweb.com + Correo Mini 5GB norteazur.com','','Anual','Servicio','25000','360000','Ifastnet/MxRoute');
INSERT INTO `productos` VALUES('24','Diseño de Sitio Web basado en CMS Wordpress','Plantilla premium','Único','Producto','0','0','');
INSERT INTO `productos` VALUES('25','Registro anual de dominio .py','Gestión ante el nic para registro de dominio .com.py','Único','Producto','0','220000','');
INSERT INTO `productos` VALUES('26','Hosting Premium Anual 100u$','Espacio ilimitado, 20 BD, SSL','Único','Producto','0','0','');
INSERT INTO `productos` VALUES('27','SSD HP240 GB + Mantenimiento PC escritorio','','Único','Producto','0','250000','Soteweb');
INSERT INTO `productos` VALUES('28','Hosting Premium + Registro de dominio itapuaalinstante.com.py','Unlimited Plan - itapuaalinstante.com.py + Registro dominio .com.py (100 u$/año)','Anual','Servicio','0','760000','Asura y Nic');
INSERT INTO `productos` VALUES('29','Hosting Basic 12GB','12 GB Disco SSD 2x CPU 1GB RAM Ancho de Banda ilimitado 15 Base de datos 15 Dominios Adicionales No incluye Registro 15 Cuentas de Correo cPanel Full o Direct Admin Certificado SSL GRATIS Perl, Python, Ruby on Rails Soporta PHP 5.2 al 8.0','Anual','Servicio','0','100','Asura');
INSERT INTO `productos` VALUES('30','Hosting Premium c/dominio','Espacio ilimitado SSD\r\n10x CPU\r\nIlimitado GB RAM\r\nAncho de Banda ilimitado\r\n20 Bases de datos\r\n20 Dominios Adicionales\r\nRegistro .com .net .org\r\n100 Cuentas de Correo\r\ncPanel Full\r\no Direct Admin\r\nCertificado SSL GRATIS\r\nPerl, Python, Ruby on Rails\r\nSoporta PHP 5.2 al 8.0','Anual','Servicio','0','100','Asura');
INSERT INTO `productos` VALUES('31','Hosting Premium s/dominio','Espacio ilimitado SSD\r\n10x CPU\r\nIlimitado GB RAM\r\nAncho de Banda ilimitado\r\n20 Bases de datos\r\n20 Dominios Adicionales\r\nRegistro .com .net .org\r\n100 Cuentas de Correo\r\ncPanel Full\r\no Direct Admin\r\nCertificado SSL GRATIS\r\nPerl, Python, Ruby on Rails\r\nSoporta PHP 5.2 al 8.0','Anual','Servicio','0','80','Asura');


DROP TABLE IF EXISTS `proveedores`;
CREATE TABLE `proveedores` (
  `proveedor_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contacto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sitio_web` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observacion` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`proveedor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `proveedores` VALUES('1','Contabo',NULL,NULL,NULL,'https://contabo.com','para VPS','2026-05-19 16:23:16','2026-05-19 16:23:16');
INSERT INTO `proveedores` VALUES('2','Donweb',NULL,NULL,'soporte@donweb.com','https://donweb.com',NULL,'2026-05-19 16:23:57','2026-05-19 16:23:57');


DROP TABLE IF EXISTS `requerimientos`;
CREATE TABLE `requerimientos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `cliente_id` int DEFAULT NULL,
  `prospecto_nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prospecto_contacto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prospecto_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `prioridad` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Media',
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pendiente',
  `fecha_solicitud` date NOT NULL,
  `fecha_limite` date DEFAULT NULL,
  `estimacion_horas` decimal(8,2) DEFAULT NULL,
  `presupuesto_estimado` decimal(12,2) DEFAULT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `requerimientos_cliente_id_foreign` (`cliente_id`),
  CONSTRAINT `requerimientos_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`cliente_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `requerimientos` VALUES('1','37',NULL,NULL,NULL,'Lentitud de sitio web y página de puntos','El cliente manifiesta que la página es lenta. Está hosteado en itacom, se le recomienda actualizar la versión de PHP. Preparar una reunión para presentar página de puntos.','Media','Presupuestado','2026-05-05',NULL,NULL,NULL,'Ninguna.','2026-05-19 16:19:04','2026-05-19 16:19:30');


DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sessions` VALUES('NPTyQDsKAOHSyrOC3Sff452dSC9TDzJUZZD1ktMJ','1','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0','eyJfdG9rZW4iOiJqc2IzTWhvbmdRRzJKQzNmWmNEakFiVWh0c0dhTEpCcGFQcHM2ZjQwIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9kYXNoYm9hcmQiLCJyb3V0ZSI6ImRhc2hib2FyZCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==','1781533806');
INSERT INTO `sessions` VALUES('SeKo1Vdt4rGEJYGndXWMHuTPnDuUmnMikZKPTTh7','1','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0','eyJfdG9rZW4iOiI5VUs1V3lXcE9QV0hmcU00R1E5eWFQNUdWVUpBNWpENXl5QzhkMDg2IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjF9','1781532441');


DROP TABLE IF EXISTS `tickets`;
CREATE TABLE `tickets` (
  `ticket_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `codigo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cliente_id` int unsigned NOT NULL,
  `solicitante_nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `solicitante_telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `solicitante_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asunto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mensaje` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `archivo_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `archivo_nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prioridad` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Media',
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Abierto',
  `observaciones_admin` text COLLATE utf8mb4_unicode_ci,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ticket_id`),
  UNIQUE KEY `tickets_codigo_unique` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tickets` VALUES('1','TKT-0001','12',NULL,NULL,NULL,'Probando ticket de soporte desde la web.','Descripcion del sitio web de correo de outlook para que funcione si o si.',NULL,NULL,'Media','Resuelto','se le pidió que ya no moleste.','2026-05-18 19:09:31','2026-05-18 16:16:12');
INSERT INTO `tickets` VALUES('2','TKT-0002','62','Karina Delvalle','0985123123','','Actualización de sitio web','Agregar menús... tatatatatata..',NULL,NULL,'Media','Resuelto','','2026-05-18 19:21:26','2026-05-19 09:13:36');


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rol` varchar(50) NOT NULL DEFAULT 'gestor',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `usuarios` VALUES('1','soteadmin','$2y$12$54wWzh0lC/xATQVF0VNsR.CcG/RpoY0QtiC7xsNUwRJ/keTsbdXSm','Administrador','2025-12-31 08:28:09','administrador');
INSERT INTO `usuarios` VALUES('2','sotegestor','$2y$10$qI9k14b.iqo1l1xXUSNLeu9IJfVekj1d9ALXtPROnBf4fUeU1XhFe','Gestor Sote','2026-01-01 21:03:06','gestor');


SET FOREIGN_KEY_CHECKS=1;

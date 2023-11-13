

/*Table structure for table `academic_years` */

DROP TABLE IF EXISTS `academic_years`;

CREATE TABLE `academic_years` (
  `academic_year_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `academic_year` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`academic_year_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `academic_years` */

insert  into `academic_years`(`academic_year_id`,`academic_year`,`is_active`,`created_at`,`updated_at`) values 
(1,'2020-2021',0,NULL,NULL),
(2,'2021-2022',0,NULL,NULL),
(3,'2022-2023',1,NULL,NULL);



/*Table structure for table `enrols` */

DROP TABLE IF EXISTS `enrols`;

CREATE TABLE `enrols` (
  `enrol_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `academic_year_id` bigint(20) unsigned NOT NULL,
  `grade_level` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_returnee` tinyint(4) DEFAULT NULL,
  `learner_id` bigint(20) unsigned NOT NULL,
  `semester_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `track_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `strand_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `section_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`enrol_id`),
  KEY `enrols_academic_year_id_foreign` (`academic_year_id`),
  KEY `enrols_learner_id_foreign` (`learner_id`),
  CONSTRAINT `enrols_academic_year_id_foreign` FOREIGN KEY (`academic_year_id`) REFERENCES `academic_years` (`academic_year_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `enrols_learner_id_foreign` FOREIGN KEY (`learner_id`) REFERENCES `learners` (`learner_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `enrols` */

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `learners` */

DROP TABLE IF EXISTS `learners`;

CREATE TABLE `learners` (
  `learner_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `lrn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extension` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sex` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `birthplace` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_tongue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_indigenous` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `specify_indigenous` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_4ps` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `household_4ps_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barangay` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_lname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_fname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_mname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_extension` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_contact_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_maiden_lname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_maiden_fname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_maiden_mname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_maiden_extension` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_maiden_contact_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`learner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `learners` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(71,'2014_10_12_000000_create_users_table',1),
(72,'2014_10_12_100000_create_password_resets_table',1),
(73,'2019_08_19_000000_create_failed_jobs_table',1),
(74,'2019_12_14_000001_create_personal_access_tokens_table',1),
(75,'2023_02_09_191803_create_academic_years_table',1),
(76,'2023_02_09_191804_create_learners_table',1),
(77,'2023_02_09_191929_create_tracks_table',1),
(78,'2023_02_09_191943_create_strands_table',1),
(79,'2023_02_09_192001_create_sections_table',1),
(80,'2023_02_09_193438_create_enrols_table',1);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */


/*Table structure for table `sections` */

DROP TABLE IF EXISTS `sections`;

CREATE TABLE `sections` (
  `section_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `section` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sections` */

/*Table structure for table `strands` */

DROP TABLE IF EXISTS `strands`;

CREATE TABLE `strands` (
  `strand_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `strands` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`strand_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `strands` */

/*Table structure for table `tracks` */

DROP TABLE IF EXISTS `tracks`;

CREATE TABLE `tracks` (
  `track_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `track` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`track_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `tracks` */

insert  into `tracks`(`track_id`,`track`,`created_at`,`updated_at`) values 
(1,'ACADEMIC TRACK',NULL,NULL),
(2,'TVL TRACK',NULL,NULL),
(3,'SPORTS AND ARTS TRACK',NULL,NULL);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extension` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sex` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`user_id`,`username`,`lname`,`fname`,`mname`,`extension`,`sex`,`email`,`contact_no`,`role`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`) values 
(1,'admin','ABAPO','JADE MARK','P','','MALE','jademark@dev.com','1234','ADMINISTRATOR',NULL,'$2y$10$R5Z9fjvMkKZ9xO1/29BGU.jLI9pI/a7EgPQhMmeYhUHWWWj3/R5uW',NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

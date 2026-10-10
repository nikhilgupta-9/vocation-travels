-- City landing pages (visa-consultants/:city) become DB-driven instead of hardcoded in util/visa_cities.php.
-- services / faqs are stored as JSON since each city has a variable-length list of them and there is
-- no other feature that needs to query into individual service/faq rows.

CREATE TABLE IF NOT EXISTS `visa_cities` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `slug` VARCHAR(100) NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `city_order` INT(11) NOT NULL DEFAULT 0,
  `meta_title` VARCHAR(255) NOT NULL,
  `meta_description` TEXT NOT NULL,
  `meta_keywords` TEXT NULL,
  `hero_h1` VARCHAR(255) NOT NULL,
  `hero_tagline` TEXT NOT NULL,
  `intro_heading` VARCHAR(255) NOT NULL,
  `intro` TEXT NOT NULL,
  `services` LONGTEXT NOT NULL COMMENT 'JSON array of {title, desc, icon, country_link}',
  `faqs` LONGTEXT NOT NULL COMMENT 'JSON array of {q, a}',
  `status` ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `status_order` (`status`, `city_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

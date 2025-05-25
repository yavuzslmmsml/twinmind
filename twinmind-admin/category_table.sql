-- Kategori tablosu oluşturma
CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT NULL,
  `parent_id` INT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_parent_id` (`parent_id`),
  CONSTRAINT `fk_category_parent` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Örnek veriler
INSERT INTO `categories` (`name`, `description`, `parent_id`) VALUES 
('Yazılım Geliştirme', 'Yazılım geliştirme ile ilgili kurslar', NULL),
('Pazarlama', 'Pazarlama ile ilgili kurslar', NULL),
('Tasarım', 'Tasarım ile ilgili kurslar', NULL);

-- Alt kategoriler
INSERT INTO `categories` (`name`, `description`, `parent_id`) VALUES 
('Web Geliştirme', 'Web geliştirme ile ilgili kurslar', 1),
('Mobil Uygulama Geliştirme', 'Mobil uygulama geliştirme ile ilgili kurslar', 1),
('Dijital Pazarlama', 'Dijital pazarlama ile ilgili kurslar', 2),
('Sosyal Medya Pazarlama', 'Sosyal medya pazarlama ile ilgili kurslar', 2),
('Grafik Tasarım', 'Grafik tasarım ile ilgili kurslar', 3),
('UI/UX Tasarım', 'UI/UX tasarım ile ilgili kurslar', 3);

-- Alt alt kategoriler
INSERT INTO `categories` (`name`, `description`, `parent_id`) VALUES 
('HTML & CSS', 'HTML ve CSS ile ilgili kurslar', 4),
('JavaScript', 'JavaScript ile ilgili kurslar', 4),
('PHP', 'PHP ile ilgili kurslar', 4),
('iOS Geliştirme', 'iOS uygulama geliştirme ile ilgili kurslar', 5),
('Android Geliştirme', 'Android uygulama geliştirme ile ilgili kurslar', 5),
('SEO', 'SEO ile ilgili kurslar', 6),
('Google Ads', 'Google Ads ile ilgili kurslar', 6),
('Instagram Pazarlama', 'Instagram pazarlama ile ilgili kurslar', 7),
('Facebook Pazarlama', 'Facebook pazarlama ile ilgili kurslar', 7),
('Photoshop', 'Photoshop ile ilgili kurslar', 8),
('Illustrator', 'Illustrator ile ilgili kurslar', 8),
('Figma', 'Figma ile ilgili kurslar', 9),
('Sketch', 'Sketch ile ilgili kurslar', 9); 
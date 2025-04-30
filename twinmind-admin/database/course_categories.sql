CREATE TABLE IF NOT EXISTS `course_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `description` text,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `fk_parent_category` FOREIGN KEY (`parent_id`) REFERENCES `course_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert some initial categories
INSERT INTO `course_categories` (`name`, `parent_id`, `description`, `status`) VALUES
('Yazılım', NULL, 'Software development and programming courses', 'active'),
('Müzik', NULL, 'Music and audio courses', 'active'),
('Ekonomi', NULL, 'Economics and business courses', 'active');

-- Insert sub-categories for Yazılım
INSERT INTO `course_categories` (`name`, `parent_id`, `description`, `status`) VALUES
('Web', 1, 'Web development courses', 'active'),
('Oyun', 1, 'Game development courses', 'active'),
('Mobil', 1, 'Mobile app development courses', 'active');

-- Insert specific topics under Web
INSERT INTO `course_categories` (`name`, `parent_id`, `description`, `status`) VALUES
('HTML', 4, 'HTML and web markup', 'active'),
('CSS', 4, 'CSS and styling', 'active'),
('JavaScript', 4, 'JavaScript programming', 'active'),
('Node.js', 4, 'Node.js backend development', 'active'),
('PHP', 4, 'PHP web development', 'active'); 
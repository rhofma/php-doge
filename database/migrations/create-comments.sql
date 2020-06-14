CREATE TABLE `comments` (
 `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
 `post_id` int(11) NOT NULL,
 `name` varchar(255) NOT NULL,
 `message` text NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
);
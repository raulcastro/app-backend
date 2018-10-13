CREATE DATABASE bikes;

CREATE TABLE `app_info` (
  `title` varchar(512) DEFAULT NULL,
  `site_name` varchar(512) DEFAULT NULL,
  `url` varchar(512) DEFAULT NULL,
  `media` varchar(512) DEFAULT NULL,
  `content` varchar(1024) DEFAULT NULL,
  `description` varchar(1024) DEFAULT NULL,
  `keywords` varchar(512) DEFAULT NULL,
  `creator` varchar(512) DEFAULT NULL,
  `creator_url` varchar(512) DEFAULT NULL,
  `twitter` varchar(256) DEFAULT NULL,
  `facebook` varchar(256) DEFAULT NULL,
  `googleplus` varchar(256) DEFAULT NULL,
  `linkedin` varchar(256) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `lang` varchar(2) DEFAULT NULL,
  `youtube` varchar(256) DEFAULT NULL,
  `instagram` varchar(256) DEFAULT NULL,
  `location` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


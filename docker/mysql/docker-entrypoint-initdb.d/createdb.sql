USE url_shortening;

CREATE TABLE `short_links` (
    `id` int NOT NULL AUTO_INCREMENT,
    `target_url` longtext NOT NULL,
    PRIMARY KEY (`id`)
);
INSERT INTO `short_links` (`id`, `target_url`)
VALUES (1, 'https://www.google.com/'),
       (8888, 'https://github.com/'),
       (8889, 'https://stackoverflow.com/');

CREATE TABLE `short_link_logs` (
    `id` int NOT NULL AUTO_INCREMENT,
    `short_link_id` int NOT NULL,
    `user_ip` varchar(45) NOT NULL,
    `clicks` int NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    KEY `short_link_id` (`short_link_id`),
    CONSTRAINT `short_link_logs_ibfk_1` FOREIGN KEY (`short_link_id`) REFERENCES `short_links` (`id`)
);
INSERT INTO `short_link_logs` (`id`, `short_link_id`, `user_ip`, `clicks`)
VALUES (1, 8889, '192.168.65.1', 2),
       (2, 8888, '192.168.65.1', 2),
       (3, 1, '192.168.65.1', 1);



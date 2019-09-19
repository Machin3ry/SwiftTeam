

CREATE TABLE `hngi_users` (
  `swift_id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY  NOT NULL,
  `swift_firstname` varchar(225) NOT NULL,
  `swift_lastname` varchar(225) NOT NULL,
  `swift_email` varchar(225)  DEFAULT NULL,
  `swift_username` varchar(225)  DEFAULT NULL,
  `swift_password` varchar(225)  DEFAULT NULL, 
  `swift_hash` varchar(225)  DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/* Database Name :  flairm_test; */

CREATE TABLE `tbl_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orgn_id` int(11) NOT NULL,
  `contact_name` varchar(45) DEFAULT NULL,
  `contact_img` varchar(100) DEFAULT NULL,
  `contact_email` varchar(45) DEFAULT NULL,
  `contact_no` varchar(45) DEFAULT NULL,
  `contact_address` varchar(250) DEFAULT NULL,
  `created _at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


CREATE TABLE `tbl_organization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orgn_name` varchar(50) DEFAULT NULL,
  `orgn_logo` varchar(100) DEFAULT NULL,
  `orgn_email` varchar(45) DEFAULT NULL,
  `orgn_contact` varchar(45) DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

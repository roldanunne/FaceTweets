<?php defined('SYSPATH') OR die('No direct access allowed.');

return array
(
	/**
	 * MySQLi driver config information
	 *
	 * The following options are available for MySQLi:
	 *
	 * string   hostname     server hostname, or socket
	 * string   database     database name
	 * string   username     database username
	 * string   password     database password
	 * boolean  persistent   use persistent connections?
	 * array    ssl          ssl parameters as "key => value" pairs.
	 *                       Available keys: client_key_path, client_cert_path, ca_cert_path, ca_dir_path, cipher
	 * array    variables    system variables as "key => value" pairs
	 *
	 * Ports and sockets may be appended to the hostname.
	 *
	 * MySQLi driver config example:
	 *
	 */
	'default' => array
	(
 		'type'       => 'MySQLi',
 		'connection' => array(
			'hostname'   => 'localhost',
			'database'   => 'corporatekeys',
			'username'   => 'root',
 			'password'   => FALSE,
 			'persistent' => FALSE,
 			'ssl'        => NULL,
 		),
 		'table_prefix' => '',
 		'charset'      => 'utf8',
 		'caching'      => FALSE,
 	)
);

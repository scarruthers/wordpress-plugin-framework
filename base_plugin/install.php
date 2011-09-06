<?php

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

// mySQL date format: YYYY-MM-DD
// mySQL time format: HH:MM:SS

$sql = "CREATE TABLE " . CC_DATA . " (
	id mediumint(9) NOT NULL AUTO_INCREMENT,
	UNIQUE KEY id (id)
	);";

dbDelta( $sql );

echo "Table created.";

add_option("cc_version", CC_VERSION );

?>
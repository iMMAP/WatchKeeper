<?php

function getDB() {
	return pg_connect("host=HOST port=PORT dbname=DBNAME user=postgres password=PASS");
}
?>

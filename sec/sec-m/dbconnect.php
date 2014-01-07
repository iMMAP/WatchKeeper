<?php

function getDB() {
	return pg_connect("host=xxxxx port=xxxxx dbname=xxxxx user=xxxxx password=xxxxx");
}
?>
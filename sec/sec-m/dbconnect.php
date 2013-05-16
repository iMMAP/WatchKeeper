<?php

function getDB() {
	return pg_connect("host=210.56.8.110 port=5433 dbname=securitynews user=postgres password=!MM@P2011");
}
?>
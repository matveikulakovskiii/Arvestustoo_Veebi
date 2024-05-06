<?php
$username="root";
$password="";
$host="localhost";
$database="matvei";
$yhendus = new mysqli($host, $username, $password, $database);
$yhendus-> set_charset('UTF8');
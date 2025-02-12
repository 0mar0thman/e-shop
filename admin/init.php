<?php
include 'connect.php';

$tpl = 'includes/templates/';
$lng = 'includes/languages/';
$fun = 'includes/functions/';
$css = 'style/css/';
$js = 'style/js/';
$pages = 'pagesMember/';

include $fun . 'functions.php';
include $lng . 'english.php'; 
include $tpl . 'header.php';

if (!isset($noNavbar)) include $tpl . 'navbar.php';

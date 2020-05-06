<?php 

require_once __DIR__. '/vendor/autoload.php';
use function Controllers\getMainController;

session_start();
include "calendar.php";
startCalendar();
getMainController();

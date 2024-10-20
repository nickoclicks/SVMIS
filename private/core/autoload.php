<?php

require ("config.php");
require ("functions.php");
require ("database.php");
require ("controller.php");
require ("model.php");
require ("app.php");
require ("PHPMailer.php");
require ("SMTP.php");
require ("Exception.php");

use PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

spl_autoload_register(function($class_name)
{
  require "../private/models/" . ucfirst($class_name) . ".php";
});


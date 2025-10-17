<?php
session_start();
session_unset();
session_destroy();

// Redirect to your homepage
header('Location: http://localhost/baker_demo/index.php');
exit;

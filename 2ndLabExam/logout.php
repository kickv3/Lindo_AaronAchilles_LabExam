<?php
require 'includes/functions.php';

unset($_SESSION['user']);
session_regenerate_id(true);
setFlash('success', 'You have been logged out.');

header('Location: index.php');
exit;

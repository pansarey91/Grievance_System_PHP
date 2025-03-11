<?php
session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy all sessions
header("Location: login.html"); // Redirect to login page
exit();

<?php
session_start();
session_unset();    //Optional: clears all session variables
session_destroy();
header("Location: index.php"); 
exit();
?>
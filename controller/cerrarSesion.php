<?php
session_start();
session_unset();
session_destroy();
// Eliminar cookie de sesión persistente
setcookie('session_data', '', time() - 3600, '/');
header("Location: ../index.php");

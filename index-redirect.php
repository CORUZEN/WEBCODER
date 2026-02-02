<?php
/**
 * Redirect para a pasta public do Laravel
 * Coloque este arquivo na raiz de iagus.com.br como index.php
 */

header('Location: /public/index.php' . ($_SERVER['REQUEST_URI'] !== '/' ? $_SERVER['REQUEST_URI'] : ''));
exit;

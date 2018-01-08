<?php
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting('E_ALL');

require_once 'Model/Conexao.php';
require_once 'Model/Contato.php';
require_once 'Model/Filtro.php';
require_once 'Controller/ContatoControl.php';
require_once 'Controller/MenuControl.php';
require_once 'View/Formulario.php';
require_once 'View/Grade.php';
require_once 'View/Menu.php';
require_once 'View/iCampos.php';
require_once 'View/CampoTexto.php';
require_once 'View/CampoSelecao.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Agenda de contatos</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <h1>Agenda de Contatos - MVC</h1>
    <hr>
    <?php

    if ($_GET) {

        $class = isset($_GET['class']) ? $_GET['class'] : NULL;
        $method = isset($_GET['method']) ? $_GET['method'] : NULL;

        if (class_exists($class)) {

            $obj = isset($this) && $class == get_class($this) ? $this : new $class;

            if ($method) {

                if (method_exists($obj, $method)) {

                    $url = parse_url($_SERVER ['REQUEST_URI']);
                    parse_str($url['query'], $params);
                    $params = array_slice($params, 2);

                    if ($params) {
                        call_user_func_array(array($obj, $method), $params);
                    } else {
                        call_user_func(array($obj, $method));
                    }
                }
            }
        }
    } else {

        header('Location: ?class=MenuControl&method=listar');
    }
    ?>
</div>
</body>
</html>

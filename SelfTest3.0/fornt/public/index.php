<?php
// if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    header('Access-Control-Allow-Origin: *');
    include dirname(dirname(__DIR__)) . '/index.php';
// } else {
//     header('Location:/index.html');
//     echo '正在跳转，请稍后...';
// }
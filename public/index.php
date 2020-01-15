<?php
/**
if (isset($_POST['verify'])) {
    switch ($_POST['verify']) {
        case 'lalala':
            setcookie('Hello', 'World', time() + (60 * 60 * 24 * 30 * 12));
            header('location: /');
            break;
        case 'woshishabi';
            $color = ['red', 'green', 'yello', 'pink', 'grey', 'blue', 'purple'];
            for ($i = 0; $i < mt_rand(mt_rand(10, 100), mt_rand(100, 1000)); $i ++) {
                echo '<h1 style="display: inline-block; color: ' . $color[!shuffle($color)] . '">是的，你是傻逼。&emsp;&emsp;</h1>';
            }
            break;
        default:
            echo '请按照以下提示来确认您的身份';
            echo file_get_contents('verify.html');
    }
}else if (isset($_COOKIE['Hello']) && $_COOKIE['Hello'] == 'World') {
    readfile('home.html');
}else {
    readfile('verify.html');
}
*/
readfile('home.html');

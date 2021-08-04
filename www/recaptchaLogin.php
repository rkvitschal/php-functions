<?php
require_once '../config.php';

/////////////////////////////////////////////
// Exemplo de implantação para verificação //
// de reCAPTCHA v3 com PHP                 //
// Testado Windows 10 com PHP 7.3.29       //
// Utiliza cURL com SSL                    //
// Autor: Renan Kvitschal                  //
/////////////////////////////////////////////

?>
<!doctype html>
<html lang="pt-br">

<head>
    <title>Login form</title>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
        function onSubmit(token) {
            document.getElementById("login").submit();
        }
    </script>
</head>

<body>
    <form method="post" id="login">
        <input type="text" placeholder="Usuário" name="usuario"><br>
        <input type="password" placeholder="Senha" name="senha"><br>
        <button class="g-recaptcha" data-sitekey="<?php echo _RECAPTCHA_SITE_TOKEN_; ?>" data-callback='onSubmit' data-action='submit'>Entrar</button>
    </form>

    <?php
    //print_r($_POST);
    require_once '../classes/recaptcha.php';
    if (isset($_POST['g-recaptcha-response'])) {
        $rc = new Recaptcha();

        $rc->validar($_POST['g-recaptcha-response']);

        echo $rc->getJson();
        print_r($rc->getArray());

        if ($rc->validado) {
            echo "<p>Bem vindo!</p>";
        } else {
            echo "<p>Tente outra vez!</p>";
        }
    }
    ?>
</body>

</html>
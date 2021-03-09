<!DOCTYPE html>
<html>
    
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IngressoZapp</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="css/bulma.min.css" />
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<?php
$msg = $_GET['msg'];
?>
<body>
    <section class="hero is-success is-fullheight">
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="column is-4 is-offset-4">
                    <img src="../includes/logo.jpeg" alt="">
                    <div class="box">
                    <h3><?php echo $msg; ?></h3>
                        <form action="cadastrar.php" method="POST">
                        <div class="field">
                            <div class="control">
                                <p>Usuário</p>
                                <input type="text" class="input is-large" placeholder="Seu usuário" name="usuario" id="usuario" required>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <p>Senha</p>
                                <input type="text" class="input is-large" placeholder="Sua senha" name="senha" id="senha" required>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <p>Nome Completo</p>
                                <input type="text" class="input is-large" placeholder="Seu nome completo" name="nome" id="nome" required>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <p>Telefone</p>
                                <input type="text" class="input is-large" placeholder="Seu telefone" name="telefone" id="telefone" required>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <p>E-mail</p>
                                <input type="email" class="input is-large" placeholder="Seu e-mail" name="email" id="email" required>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <p>Cidade</p>
                                <input type="text" class="input is-large" placeholder="Sua cidade" name="cidade" id="cidade" required>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <p>Estado</p>
                                <input type="text" class="input is-large" placeholder="Seu estado" name="estado" id="estado" required>
                            </div>
                        </div>
                            <button type="submit" class="button is-block is-link is-large is-fullwidth">Cadastrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
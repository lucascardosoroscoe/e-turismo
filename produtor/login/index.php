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

    <body>
        <section class="hero is-success is-fullheight">
            <div class="hero-body">
                <div class="container has-text-centered">
                    <div class="column is-4 is-offset-4">
                        <img src="../includes/logo.jpeg" alt="">
                        <div class="box">
                            <form action="login.php" method="POST">
                                <div class="field">
                                    <div class="control">
                                        <p>Usuário:</p>
                                        <input name="usuario" name="text" class="input is-large" placeholder="Seu usuário" autofocus="">
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <p>Senha:</p>
                                        <input name="senha" class="input is-large" type="password" placeholder="Sua senha">
                                    </div>
                                </div>
                                <button type="submit" class="button is-block is-link is-large is-fullwidth">Entrar</button>
                            </form>
                            <br>
                            <p><a href='cadastro.php'>Não cadastrado como Produtor de Eventos IngressoZapp? Clique aqui e faça sua pré inscrição</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>

</html>
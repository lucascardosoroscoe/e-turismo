<?php
    include_once '../includes/header.php';
    $usuario        = $_GET['usuario'];
    $telefone        = $_GET['telefone'];
    $nome        = $_GET['nome'];
    $email        = $_GET['email'];
    session_start();
    /*session created*/
    $produtor  =  $_SESSION["usuario"];
    $validade =  $_SESSION["validade"];

if ($validade =! "VALIDO"){
    header('Location: https://ingressozapp.com/produtor/login/');
}
?>
<div class="row">
    <div class="col s12 m6 push-m3 ">
        <h3 class="light">Editar Vendedor</h3>
        <form action="editar_vendedor.php" method="get">
            <div class="input-field col s12">
                <input type="text" name="usuario" id="usuario" value="<?php echo $usuario ?> " required>
                <label for="usuario">Usuário</label>
            </div>
            <input type="hidden" name="produtor" value="<?php echo $produtor?>" required>
            <div class="input-field col s12">
                <input type="text" name="nome" id="nome" value="<?php echo $nome?>" required>
                <label for="nome">Nome</label>
            </div>
            <div class="input-field col s12">
                <input type="text" name="telefone" id="telefone" value="<?php echo $telefone ?> " required>
                <label for="telefone">Telefone</label>
            </div>
            <div class="input-field col s12">
                <input type="email" name="email" id="email" value="<?php echo $email?>" required>
                <label for="email">E-mail</label>
            </div>

            <button type="submit" name="btn-cadastrar" class="btn">Editar</button>
        </form>
        <br>
        <a href="https://ingressozapp.com/produtor/" class="btn">Voltar</a>
    </div>
</div>

<?php
    include_once '../includes/footer.php';
?>
<?php
    include_once '../includes/header.php';
    session_start();
    /*session created*/
    $produtor  =  $_SESSION["usuario"];
    $validade =  $_SESSION["validade"];
    $msg =  $_GET["msg"];
?>
<div class="row">
    <div class="col s12 m6 push-m3 ">
        <h3 class="light">Novo Vendedor</h3>
        <p><?php echo $msg?></p>
        <form action="create_vendedor.php" method="get">
            <div class="input-field col s12">
                <input type="text" name="usuario" id="usuario" required>
                <label for="usuario">Usuário</label>
            </div>
            <input type="hidden" name="produtor" value="<?php echo $produtor?>" required>
            <div class="input-field col s12">
                <input type="text" name="nome" id="nome" required>
                <label for="nome">Nome</label>
            </div>
            <div class="input-field col s12">
                <input type="text" name="telefone" id="telefone" required>
                <label for="telefone">Telefone</label>
            </div>
            <div class="input-field col s12">
                <input type="email" name="email" id="email" required>
                <label for="email">E-mail</label>
            </div>

            <button type="submit" name="btn-cadastrar" class="btn">Cadastrar</button>
        </form>
        <br>
        <a href="https://ingressozapp.com/produtor/" class="btn">Voltar</a>
    </div>
</div>

<?php
    include_once '../includes/footer.php';
?>
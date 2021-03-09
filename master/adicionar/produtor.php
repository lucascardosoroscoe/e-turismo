<?php
    include_once '../includes/header.php';
    $msg =  $_GET["msg"];
?>
<div class="row">
    <div class="col s12 m6 push-m3 ">
        <h3 class="light">Novo Produtor</h3>
        <p><?php echo $msg?></p>
        <form action="create_produtor.php" method="get">
            <div class="input-field col s12">
                <input type="text" name="usuario" id="usuario" required>
                <label for="usuario">Usuário</label>
            </div>
            <div class="input-field col s12">
                <input type="text" name="senha" id="senha" required>
                <label for="senha">Senha</label>
            </div>
            <div class="input-field col s12">
                <input type="text" name="nome" id="nome" required>
                <label for="nome">Nome Completo</label>
            </div>
            <div class="input-field col s12">
                <input type="text" name="telefone" id="telefone" required>
                <label for="telefone">Telefone</label>
            </div>
            <div class="input-field col s12">
                <input type="email" name="email" id="email" required>
                <label for="email">E-mail</label>
            </div>
            <div class="input-field col s12">
                <input type="text" name="cidade" id="cidade" required>
                <label for="cidade">Cidade</label>
            </div>
            <div class="input-field col s12">
                <input type="text" name="estado" id="estado" required>
                <label for="estado">Estado</label>
            </div>

            <button type="submit" name="btn-cadastrar" class="btn">Cadastrar</button>
        </form>
        <br>
        <a href="https://ingressozapp.com/master/" class="btn">Voltar</a>
    </div>
</div>

<?php
    include_once '../includes/footer.php';
?>
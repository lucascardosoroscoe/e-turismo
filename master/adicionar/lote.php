<?php
    include_once '../includes/header.php';
    session_start();
    /*session created*/
    $produtor  =  $_SESSION["usuario"];
    $validade =  $_SESSION["validade"];
    $evento =  $_GET["evento"];
?>
<div class="row">
    <div class="col s12 m6 push-m3 ">
        <h5>Nome do Evento: <?php echo $evento ?></h5>
        <h5>Criar Lote</h5>
        <form action="create_lote.php" method="get" id="create">
            <div class="input-field col s12">
                <input type="text" name="nome" id="nome" required>
                <label for="nome">Nome do Lote</label>
            </div>
            <input type="hidden" name="evento" id="evento" value="<?php echo $evento ?>" required>
            <div class="input-field col s12">
                <p>Sexo</p>
                <select name="sexo" form="create">
                    <option value="Masculino">Masculino</option>
                    <option value="Feminino">Feminino</option>
                    <option value="Unisex">Unissex</option>
                </select><br>
            </div>
            <div class="input-field col s12">
                <input type="number" name="valor" id="valor">
                <label for="valor">Valor</label>
            </div>
            <div class="input-field col s12">
                <input type="number" name="quantidade" id="quantidade">
                <label for="quantidade">Quantidade de Ingressos</label>
            </div>
        
            <button type="submit" name="btn-cadastrar" class="btn">Cadastrar Lote</button>
        </form>
        <br>
        <a href="https://ingressozapp.com/produtor/" class="btn">Voltar</a>
    </div>
</div>

<?php
    include_once '../includes/footer.php';
?>
<?php
    include_once '../includes/header.php';
    session_start();
    /*session created*/
    $produtor  =  $_SESSION["usuario"];
    $validade =  $_SESSION["validade"];
?>
<div class="row">
    <div class="col s12 m6 push-m3 ">
        <h3 class="light">Novo Evento</h3>
        <form action="create_evento.php" method="POST" enctype="multipart/form-data">
            <div class="input-field col s12">
                <input type="text" name="nome" id="nome" required>
                <label for="nome">Nome do Evento</label>
            </div>
            <input type="hidden" name="produtor" value="<?php echo $produtor?>" required>

            <input name="imagem" type="file" id="imagem"> 
            <label for="imagem">Imagem:</label>

            <div class="input-field col s12">
                <input type="date" name="data" id="data">
                <label for="data">Data</label>
            </div>
            <div class="input-field col s12">
                <input type="text" name="descricao" id="descricao">
                <label for="descricao">Descrição do Evento</label>
            </div>
        
            <button type="submit" name="btn-cadastrar" class="btn">Cadastrar Evento</button>
        </form>
        <br>
        <a href="https://ingressozapp.com/produtor/" class="btn">Voltar</a>
    </div>
</div>

<?php
    include_once '../includes/footer.php';
?>
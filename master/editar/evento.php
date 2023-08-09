<?php
    include_once '../includes/header.php';
    $nome        = $_GET['nome'];
    $descricao        = $_GET['descricao'];
    
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
        <h3 class="light">Editar Evento</h3>
        <form action="editar_evento.php" method="POST" enctype="multipart/form-data" id="evento">
            <div class="input-field col s12">
                <input type="text" name="nome" id="nome" value="<?php echo $nome ?> " required>
                <label for="nome">Nome do Evento</label>
            </div>
            <input type="hidden" name="produtor" value="<?php echo $produtor?>">
            <input name="imagem" type="file" id="imagem"> 
        
            <div class="input-field col s12">
                <input type="date" name="data" id="data">
                <label for="data">Data</label>
            </div>
            <div class="input-field col s12">
                <input type="text" name="descricao" id="descricao" value="<?php echo $descricao ?>">
                <label for="descricao">Descrição do Evento</label>
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
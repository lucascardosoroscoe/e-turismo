<?php
    include_once '../includes/header.php';
    include 'selecionar_categorias.php';
    session_start();
    /*session created*/
    $promoter  =  $_SESSION["promoter"];
    $evento =  $_SESSION["evento"];
?>
<div class="row">
    <div class="col s12 m6 push-m3 ">
        <h3 class="light">Novo Recebimento</h3>
        <p>Evento: <?php echo $evento;?></p>
        <p>Promoter: <?php echo $promoter;?></p>
        <form action="create_recebimento.php" id="create_recebimento" method="POST">
            <div class="input-field col s12">
                <input type="number" name="valor" id="valor" required>
                <label for="valor">Valor</label>  
            </div>
            <br><br>        
            <button type="submit" name="btn-cadastrar" class="btn">Cadastrar Recebimento</button>
        </form>
        <br>
        <a href="index.php" class="btn">Voltar</a>
    </div>
</div>

<?php
    include_once '../includes/footer.php';
?>
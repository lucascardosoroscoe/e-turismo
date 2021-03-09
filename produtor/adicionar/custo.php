<?php
    include_once '../includes/header.php';
    include 'selecionar_categorias.php';
    session_start();
    /*session created*/
    $produtor  =  $_SESSION["usuario"];
    $validade =  $_SESSION["validade"];
?>
<div class="row">
    <div class="col s12 m6 push-m3 ">
        <h3 class="light">Novo Custo</h3>
        <form action="create_custo.php" id="create_custo" method="POST">
            <select name="categoria" form="create_custo" required>
            <?php addCategoria($dados);?>

            <input type="hidden" name="produtor" value="<?php echo $produtor?>" required>

            <div class="input-field col s12">
                <input type="text" name="descricao" id="descricao" autocomplete="on">
                <label for="descricao">Descrição do Custo</label>
            </div>
            <div class="input-field col s12">
                <input type="number" name="valor" id="valor" required>
                <label for="valor">Valor</label>  
            </div>
            <h6 style="margin-left: 10px;">Status do Custo:</h6>
            <div class="input-field col s6 m6">
                <div>
                    <input type="radio" id="planejado" name="status" value="1" required>
                    <label style="font-size: 1.8rem;" for="planejado">Planejado</label><br>
                </div>
            </div>
            <div class="input-field col s6 m6">
                <div>
                    <input type="radio" id="pago" name="status" value="2" required>
                    <label style="font-size: 1.8rem;" for="pago">Pago</label><br>
                </div>
            </div>
            <br><br>
            
        
            <button type="submit" name="btn-cadastrar" class="btn">Cadastrar Custo</button>
        </form>
        <br>
        <a href="https://ingressozapp.com/produtor/" class="btn">Voltar</a>
    </div>
</div>

<?php
    include_once '../includes/footer.php';
?>
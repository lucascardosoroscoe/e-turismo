<?php
    include_once '../includes/header.php';
    $codigo        = $_GET['codigo'];
    $evento        = $_GET['evento'];
    $vendedor        = $_GET['vendedor'];
    $cliente        = $_GET['cliente'];
    $telefone        = $_GET['telefone'];
    $valor        = $_GET['valor'];
    $lote        = $_GET['lote'];
    $sexo        = $_GET['sexo'];
?>
<div class="row">
    <div class="col s12 m6 push-m3 ">
        <h3 class="light">Editar Ingresso</h3>
        <form action="editar_ingresso.php" method="get">
            <div class="input-field col s12">
                <input type="number" name="codigo" id="codigo"  value="<?php echo $codigo ?>" required>
                <label for="codigo">Código</label>
            </div>
            <div class="input-field col s12">
                <input type="text" name="evento" id="evento"  value="<?php echo $evento ?>" required>
                <label for="evento">Evento</label>
            </div>
            <div class="input-field col s12">
                <input type="text" name="vendedor" id="vendedor"  value="<?php echo $vendedor ?>" required>
                <label for="vendedor">Vendedor</label>
            </div>
            <div class="input-field col s12">
                <input type="text" name="cliente" id="cliente"  value="<?php echo $cliente ?>" required>
                <label for="cliente">Cliente</label>
            </div>
            <div class="input-field col s12">
                <input type="text" name="telefone" id="telefone"  value="<?php echo $telefone ?>" required>
                <label for="telefone">Telefone</label>
            </div>
            <div class="input-field col s12">
                <input type="text" name="valor" id="valor"  value="<?php echo $valor ?>" required>
                <label for="valor">Valor</label>
            </div>
            <div class="input-field col s12">
                <input type="text" name="lote" id="lote"  value="<?php echo $lote ?>" required>
                <label for="lote">Lote</label>
            </div>
            <div class="input-field col s12">
                <input type="text" name="sexo" id="sexo"  value="<?php echo $sexo ?>" required>
                <label for="sexo">Sexo</label>
            </div>
            <button type="submit" name="btn-cadastrar" class="btn">Editar</button>
        </form>
    </div>
</div>

<?php
    include_once '../includes/footer.php';
?>
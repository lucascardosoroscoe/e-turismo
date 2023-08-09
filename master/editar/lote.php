<?php
    include_once '../includes/header.php';
    include('../includes/db_valores.php');
    session_start();
    $validade =  $_SESSION["validade"];
    $nome        = $_GET['nome'];
    $evento    = $_GET['evento'];
    $sexo   = $_GET['sexo'];
    $valor        = $_GET['valor'];
    $quantidade        = $_GET['quantidade'];
if ($validade =! "VALIDO"){
    header('Location: https://ingressozapp.com/produtor/login/');
}

    $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);

    $consulta = "SELECT * FROM Lote WHERE evento='$evento' AND nome='$nome'";
    $gravacoes = mysqli_query($conexao, $consulta);

    $dados = array();

    while($linha = mysqli_fetch_assoc($gravacoes))
    {
        $dados[] = $linha; 
    }
    mysqli_close($conexao);

    $obj = $dados[0];
    $valor = $obj['valor'];
    $quantidade = $obj['quantidade'];
?>
<div class="row">
    <div class="col s12 m6 push-m3 ">
        <h5>Editar Lote</h5>
        <form action="editar_lote.php" method="get" id="create">
            <input type="hidden" name="nomeanterior" id="nomeanterior" value="<?php echo $nome ?>" required>
            <div class="input-field col s12">
                <input type="text" name="nome" id="nome" value="<?php echo $nome ?> " required>
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
                <input type="number" name="valor" id="valor" value="<?php echo $valor ?>" required>
                <label for="valor">Valor</label>
            </div>
            <div class="input-field col s12">
                <input type="number" name="quantidade" id="quantidade" value="<?php echo $quantidade ?>">
                <label for="quantidade">Quantidade de Ingressos</label>
            </div>
        
            <button type="submit" name="btn-cadastrar" class="btn">Editar Lote</button>
        </form>
        <br>
        <a href="https://ingressozapp.com/produtor/" class="btn">Voltar</a>
    </div>
</div>

<?php
    include_once '../includes/footer.php';
?>
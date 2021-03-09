<?php
    include_once '../includes/header.php';
    include 'selecionar_evento.php';

    session_start();
    /*session created*/
    $produtor  =  $_SESSION["usuario"];
    $validade =  $_SESSION["validade"];
    $evento = $_SESSION["evento"];
    $msg = $_GET["msg"];
    if ($validade == "VALIDO"){
    $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);

    $consulta = "SELECT * FROM Lote WHERE evento='$evento'";
    $gravacoes = mysqli_query($conexao, $consulta);

    $dados = array();

    while($linha = mysqli_fetch_assoc($gravacoes))
    {
        $dados[] = $linha; 
    }

    mysqli_close($conexao);
    } else {
        header('Location: https://ingressozapp.com/produtor/login/');
    }
?>
<div class="row">
    <div class="col s12 m6 push-m3 ">
        <select id="evento" onchange="selecionarEvento()">
        <option value="">Selecione o Evento</option>');
        <?php addEvento($dados2, $evento); ?>
        </select>

        <br>
        <h3>Lotes </h3>
        <p><?php echo $msg;?></p>
        <h3 id="eventoatual"><?php echo $evento;?></h3>
        <img src="../includes/adicionar.png" id="adicionar" class="icone"/>
        <img src="../includes/editar.png" id="editar"    class="icone"/>
        <img src="../includes/invalidar.png" id="excluir"   class="icone"/>
        <img src="../includes/revalidar.png" id="reativar"   class="icone"/>
        <img src="../includes/excluir.png" id="apagar"   class="icone"/>
        <table id="tabela">
            <thead>
                <tr>
                    <td>Nome do Lote</td>
                    <td>Valor</td>
                    <td>Sexo</td>
                    <td>Validade</td>
                    <td>Quantidade</td>
                </tr>
            </thead>
            <tbody>
            <?php
            $size = sizeof($dados);

            for ($i = 0; $i < $size; $i++){
                $obj = $dados[$i];
                //echo json_encode($primeiro);
                //echo "<br>";
                //imprime o conteúdo do objeto 
                echo "<tr>";
                echo ("<td>".$obj['nome']."</td>");
                echo ("<td>R$".$obj['valor'].",00</td>");
                echo ("<td>".$obj['sexo']."</td>");
                echo ("<td>".$obj['validade']."</td>");
                echo ("<td>".$obj['quantidade']."</td>");
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
        <p>Ao ser criado o Lote fica validado como "EM BREVE", enquanto o lote for validado dessa forma os vendedores não conseguem vender esse lote. Para deixa-lo "VALIDO" clique no ícone ✓, nesse momento o lote está disponível para venda. Após esgotados os ingressos, clique no ícone "X" para tornar o lote "ESGOTADO" e não permitir mais vendas.</p>
        <a href="https://ingressozapp.com/produtor/" class="btn">Voltar</a>
    </div>
</div>
<script type="text/javascript" src="visualizar.js"></script>
<?php
    include_once '../includes/footer.php';
?>
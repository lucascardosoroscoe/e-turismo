<?php
    include_once '../includes/header.php';
    include 'selecionar_custos.php';
    session_start();
    /*session created*/
    $evento = $_SESSION["evento"];
    $consulta = "SELECT Custos.id, Categorias.categoria, Custos.descricao, Custos.valor, Custos.status FROM Custos JOIN Categorias ON Custos.categoria = Categorias.id WHERE Custos.evento = '$evento'";

    $dados = selecionar($consulta);
?>
<div class="row">
    <div class="col s12 m6 push-m3 ">
    


        <select id="evento" onchange="selecionarEvento()">
        <option value="">Selecione o Evento</option>
        <?php addEvento($evento); ?>
        </select>

        <br>
        <h3>CUSTOS</h3>
        <img src="../includes/adicionar.png" id="adicionar" class="icone"/>
        <img src="../includes/invalidar.png" id="excluir"   class="icone"/>
        <img src="../includes/revalidar.png" id="reativar"   class="icone"/>
        <img src="../includes/visualizar.png" id="visualizar"   class="icone"/>
        <h4 id="CustosTotal"></h4>
        <h4 id="CustosPago"></h4>
        <h4 id="CustosPlanejado"></h4>
        <table id="tabela">
            <thead>
                <tr>
                    <td>Id</td>
                    <td>Categoria</td>
                    <td>Valor</td>
                    <td>Status</td>
                    <td>Descrição</td>
                </tr>
            </thead>
            <tbody>
            <?php
            $size = sizeof($dados);
            $somaCustosTotal = 0;
            $somaCustosPago = 0;
            $somaCustosPlanejado = 0;

            for ($i = 0; $i < $size; $i++){
                $obj = $dados[$i];
                
                //echo json_encode($primeiro);
                //echo "<br>";
                //imprime o conteúdo do objeto 
                echo "<tr>";
                echo ("<td>".$obj['id']."</td>");
                echo ("<td>".$obj['categoria']."</td>");
                echo ("<td>R$".number_format($obj['valor'], 2, ',', '.')."</td>");
                if ($obj['status'] == '1'){
                    $somaCustosTotal = $somaCustosTotal + $obj['valor'];
                    $somaCustosPlanejado = $somaCustosPlanejado + $obj['valor'];
                    echo ("<td>Planejado</td>");
                }else if($obj['status'] == '2'){
                    $somaCustosTotal = $somaCustosTotal + $obj['valor'];
                    $somaCustosPago = $somaCustosPago + $obj['valor'];
                    echo ("<td>Pago</td>");
                }else if($obj['status'] == '3'){
                    echo ("<td>Cancelado</td>");
                }
                echo ("<td>".$obj['descricao']."</td>");
                echo "</tr>";
                $count++;
            }
            ?>
            </tbody>
        </table>
        <p style="display: none;" id="somaCustosTotal"><?php echo number_format($somaCustosTotal, 2, ',', '.');?></p>
        <p style="display: none;" id="somaCustosPlanejado"><?php echo number_format($somaCustosPlanejado, 2, ',', '.');?></p>
        <p style="display: none;" id="somaCustosPago"><?php echo number_format($somaCustosPago, 2, ',', '.');?></p>
        <a href="https://ingressozapp.com/produtor/" class="btn">Voltar</a>
    </div>
</div>
<script type="text/javascript" src="visualizar.js"></script>
<?php
    include_once '../includes/footer.php';
?>
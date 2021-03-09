<?php
    session_start();
    /*session created*/
    $idProdutor = $_SESSION["usuario"];

    include_once '../../includes/header.php';
    $consulta = "SELECT * FROM Produto WHERE `usuario`='$idProdutor' ORDER BY `nome`";
    $dados = selecionar($consulta);
    $size = sizeof($dados);
    
?>
<div class="row">
    <div class="col s12 m6 push-m3 ">
        <h3>PRODUTOS</h3>
        <img src="../../includes/adicionar.png" id="adicionar" class="icone"/>
        <img src="../../includes/invalidar.png" id="excluir"   class="icone"/>
        <img src="../../includes/revalidar.png" id="reativar"   class="icone"/>
        <img src="../../includes/editar.png" id="editar"   class="icone"/>
        <table id="tabela">
            <thead>
                <tr>
                    <td>Nome</td>
                    <td>Valor</td>
                    <td>Validade</td>
                    <td>Estoque</td>
                </tr>
            </thead>
            <tbody>
                <?php

                for ($i = 0; $i < $size; $i++){
                    $obj = $dados[$i];
                    //echo json_encode($primeiro);
                    //echo "<br>";
                    //imprime o conteúdo do objeto 
                    echo "<tr>";
                    echo ("<td style='display:none;'>".$obj['idProduto']."</td>");
                    echo ("<td>".$obj['nome']."</td>");
                    echo ("<td>".$obj['valor']."</td>");
                    echo ("<td>".$obj['validade']."</td>");
                    echo ("<td>".$obj['estoque']."</td>");
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<script src="produtos.js"></script>

<?php
  
    include_once '../../includes/footer.php';
?>
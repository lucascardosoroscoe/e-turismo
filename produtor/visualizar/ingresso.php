<?php
    include_once '../includes/header.php';
    include 'selecionar_ingresso.php';
?>
<div class="row">
    <div class="col s12 m6 push-m3 ">
        <h3>INGRESSOS</h3>
        <img src="../includes/invalidar.png" id="excluir"   class="icone"/>
        <img src="../includes/revalidar.png" id="reativar"   class="icone"/>
        <img src="../includes/visualizar.png" id="visualizar"   class="icone"/>
        <table id="tabela">
            <thead>
                <tr>
                    <td>Código</td>
                    <td>Evento</td>
                    <td>Vendedor</td>
                    <td>Valor</td>
                    <td>Lote</td>
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
                echo ("<td>".$obj['codigo']."</td>"); 
                echo ("<td>".$obj['evento']."</td>"); 
                echo ("<td>".$obj['vendedor']."</td>");
                echo ("<td>".$obj['valor']."</td>");  
                echo ("<td>".$obj['lote']."</td>"); 
                echo "</tr>";
                $count++;
            }
            ?>
            </tbody>
        </table>
        <a href="https://ingressozapp.com/produtor/" class="btn">Voltar</a>
    </div>
</div>
<script>
    var table = document.getElementById("tabela"),rIndex,cIndex;
    var excluir = document.getElementById("excluir");
    var reativar = document.getElementById("reativar");
    var visualizar = document.getElementById("visualizar");
    var codigo = "codigo";
    var evento = "evento";
    var vendedor = "vendedor";
    var valor = "valor";


    // table rows
    for(var i = 1; i < table.rows.length; i++)
    {
        // row cells
        for(var j = 0; j < table.rows[i].cells.length - 1 ; j++)
        {
            table.rows[i].cells[j].onclick = function()
            {
                for(var x = 1; x < table.rows.length; x++){
                    table.rows[x].style.color = "#000000";
                }
                rIndex = this.parentElement.rowIndex;
                table.rows[rIndex].style.color = "#009000";
                pegarValor(rIndex);
            };
        }
    }
    function pegarValor(rIndex){
        codigo   = table.rows[rIndex].cells[0].innerHTML;
        evento   = table.rows[rIndex].cells[1].innerHTML;
        vendedor = table.rows[rIndex].cells[2].innerHTML;
        valor    = table.rows[rIndex].cells[5].innerHTML;
    }
    reativar.onclick = function (){
        window.location.replace("../reativar/ingresso.php?codigo="+codigo);
    }
    excluir.onclick = function (){
        window.location.replace("../invalidar/ingresso.php?codigo="+codigo);
    }
    visualizar.onclick = function (){
        window.location.replace("../detalhar/ingresso.php?codigo="+codigo);
    }


</script>

<?php
    include_once '../includes/footer.php';
?>
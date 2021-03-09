<?php
    include_once '../includes/header.php';
    include 'selecionar_evento.php';
?>
<div class="row">
    <div class="col s12 m6 push-m3 ">
        <br>
        <h3>EVENTOS</h3>
        <img src="../includes/adicionar.png" id="adicionar" class="icone"/>
        <img src="../includes/invalidar.png" id="excluir"   class="icone"/>
        <img src="../includes/revalidar.png" id="reativar"   class="icone"/>
        <img src="../includes/visualizar.png" id="visualizar"   class="icone"/>
        <table id="tabela">
            <thead>
                <tr>
                    <td>Nome do Evento</td>
                    <td>Data</td>
                    <td>Validade</td>
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
                echo ("<td>".$obj['data']."</td>");
                echo ("<td>".$obj['validade']."</td>");
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
var adicionar = document.getElementById("adicionar");
var excluir = document.getElementById("excluir");
var reativar = document.getElementById("reativar");
var visualizar = document.getElementById("visualizar");
var nome = "";

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
    nome = table.rows[rIndex].cells[0].innerHTML;
}

excluir.onclick = function (){
    window.location.replace("../invalidar/evento.php?nome="+nome);
}
adicionar.onclick = function (){
    window.location.replace("../adicionar/evento.php");
}
reativar.onclick = function (){
    window.location.replace("../reativar/evento.php?nome="+nome);
}
visualizar.onclick = function (){
    window.location.replace("../detalhar/evento.php?nome="+nome);
}
</script>
<?php
    include_once '../includes/footer.php';
?>
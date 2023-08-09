<?php
include('../../includes/verificarAcesso.php');
verificarAcesso(3);
include('../../includes/header.php');
$dataInicial = $_GET['dataInicial'];
$dataFinal = $_GET['dataFinal'];
if($dataFinal == ""){
    $dataFinal = date('Y-m-d', time() + (24*60*60));
}
if($dataInicial == ""){
    $dataInicial = date('Y-m-d', time() - (30*24*60*60));
}
$nomeSecretaria = $_SESSION["nomeSecretaria"];
$idSecretaria = $_SESSION["idSecretaria"];
?>
<div class="container-fluid">

    <div class="card mb-4">
        <div class="card-header">
            <?php 
            if($idEvento == ""){
                $nomeEvento = "Todos os Eventos";
            }
            echo ('<p style="font-size: x-large;"><img src="http://ingressozapp.com/app/img/logo.png" alt="IngressoZapp" srcset="" style="height:40px;">   Borderô IngressoZapp - '. $nomeEvento.'</p>');
            ?> 
        </div>
        <div class="card-body" style="background-color: #eee;border">
        <?php
            if($idEvento ==""){
                echo '<h2 class="text-center">Selecione o Evento</h2>';
            }else{
                $consulta = "SELECT Evento.nome, Evento.data, Produtor.nome as produtor, Produtor.telefone, Produtor.email, Produtor.CPF, Produtor.CEP, Produtor.endereco, Produtor.numero, Produtor.bairro, Produtor.cidade, Produtor.estado FROM `Evento`JOIN Produtor ON Produtor.id = Evento.produtor WHERE Evento.id = '$idEvento'";
                $dados = selecionar($consulta);
                $evento = $dados[0];
                $date1 = DateTime::createFromFormat('Y-m-d', $evento['data']);
                echo 'Evento: '. $evento['nome'] . ' ('. $date1->format('d/m/Y') .')';
                echo '<br>Realização: '. $evento['produtor']. ' (CPF: '.$evento['CPF'] .')';
                echo '<br>Contato: '. $evento['email']. ' (Celular: '.$evento['telefone'] .')';
                echo '<br>Endereço: '. $evento['endereco']. ', '.$evento['numero'] .', '.$evento['bairro'] .' - '.$evento['cidade'] .' '.$evento['estado'];
                echo '<div class="row">';
                    echo '<div class="col-md-12">';
                        echo '<div class="row">';
                            $consulta = "SELECT count(Ingresso.valor) AS contagem, sum(Ingresso.valor) AS soma FROM Ingresso JOIN Vendedor ON Ingresso.vendedor = Vendedor.id 
                            JOIN Cliente ON Ingresso.idCliente = Cliente.id
                            JOIN Lote ON Ingresso.lote =  Lote.id 
                            WHERE Ingresso.evento = '$idEvento' AND Ingresso.validade != 'CANCELADO'";
                            $dados = selecionar($consulta);
                            $contagem = $dados[0]['contagem'];
                            $soma = $dados[0]['soma'];
                            echo '<div class="col-md-6" style="margin-top: 10px; text-align:center;">';
                                echo '<h5>Numero de Ingressos: <span id="qIngressos">'.$contagem.'</h5>';
                            echo '</div>';
                            echo '<div class="col-md-6" style="margin-top: 10px; text-align:center;">';
                                echo '<h5>Total Faturado: <span id="total">R$'.$soma.',00</h5>';
                            echo '</div>';
                        echo '</div>';
                        
                        addTabelaVendas();
                    echo '</div>';
                echo '</div>';
                
            }
        ?>

        </div>
        <div class="card-footer" style="background-color: #eee;">
            OBS.: Os ingressos Impressos podem ser emitidos com o valor = R$0,00 mas ser vendidos por outros valores, tendo em vista que apenas o lote é exibido no ingresso, sem o valor.<br>
            Data de Emissão: <?php echo date('d/m/Y h:i');?> (Brasília)<br>
            https://ingressozapp.com/app/relatorios/bordero/?evento=<?php echo $idEvento;?>
        </div>
    </div>
</div>


<?php

    function addTabelaVendas(){
        global $idEvento, $contagem, $soma;
        if($idEvento != ""){
            echo('<div>');
                echo('<table id="dataTable" class="table  tablesorter table-hover" width="100%" cellspacing="0">');
                    echo('<thead>');
                        echo('<tr>');
                            echo('<th>Lote</th>');
                            echo('<th>Quantidade</th>');
                            echo('<th>Valor</th>');
                        echo('</tr>');
                    echo('</thead>');
                    echo('<tbody>');
                        
                            $consulta = "SELECT Lote.nome as lote, count(Ingresso.valor) AS contagem, sum(Ingresso.valor) AS soma FROM Ingresso JOIN Vendedor ON Ingresso.vendedor = Vendedor.id
                            JOIN Cliente ON Ingresso.idCliente = Cliente.id
                            JOIN Lote ON Ingresso.lote =  Lote.id 
                            WHERE Ingresso.evento = '$idEvento' AND Ingresso.validade != 'CANCELADO'
                            GROUP BY Lote.id";

                            addtabela($consulta);
                        
                            echo "<tr style='border-top: solid;'>";
                                echo ("<td>TOTAL</td>");
                                echo ("<td>".$contagem."</td>");
                                echo ("<td>R$".UsToBr($soma)."</td>"); 
                            echo "</tr>";
                    echo('</tbody>');
                echo('</table>'); 
            echo('</div>');
        }
    }

    function addtabela($consulta){
        global $tipoUsuario;
        $dados = selecionar($consulta);
        foreach ($dados as $obj) {
            echo "<tr>";
                echo ("<td>".$obj['lote']."</td>");
                echo ("<td>".$obj['contagem']."</td>");
                echo ("<td>R$".UsToBr($obj['soma'])."</td>"); 
            echo "</tr>";
        }
    }
    ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="../../js/graph.js"></script>
    <?php
    include('../../includes/footer.php');
?>
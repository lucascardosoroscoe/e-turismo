<?php
    include('../../includes/verificarAcesso.php');
    include('../../includes/header.php');
     
    $inputDataInicial = $_POST['inputDataInicial'];
    $inputDataFinal = $_POST['inputDataFinal'];
    $inputSenha = $_POST['inputSenha'];

    if($inputSenha == 'Rodney@258'){
        $consulta = "SELECT Lote.id as SKU, Lote.nome as Lote, Evento.id as idEvento, Evento.nome as evento, Evento.data 
        FROM Lote JOIN Evento ON Evento.id = Lote.evento 
        WHERE Evento.data >= '$inputDataInicial' AND Evento.data <= '$inputDataFinal'
        ORDER BY evento, SKU";
        $dados = selecionar($consulta);
        ?>
        <div class="container-fluid">
            <!-- Tabela dos veículos-->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table mr-1"></i>
                    Eventos
                    <div class="btn btnAdd" onclick="fnExcelReport('dataTable')" style="margin-left: 2px;"><i class="far fa-file-excel"></i> Exportar Excel</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-hover">
                        <table class="table tablesorter table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>idEvento</th>
                                    <th>Evento</th>
                                    <th>Data</th>
                                    <th>SKU</th>
                                    <th>Lote</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    addTabela($dados);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }else{
        $msg = "Senha Incorreta!!";
        header('Location: index.php?msg='.$msg);
    }
    
    function addTabela($dados){
        foreach ($dados as $obj) { 
            echo "<tr>";
                echo ("<td>".$obj['idEvento']."</td>"); 
                echo ("<td>".$obj['evento']."</td>");
                echo ("<td>".$obj['data']."</td>"); 
                echo ("<td>".$obj['SKU']."</td>");
                echo ("<td>".$obj['Lote']."</td>");             
            echo "</tr>";
        }
    }
    include('../../includes/footer.php');
?>
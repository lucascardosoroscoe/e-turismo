<?php
include_once '../includes/header.php';
session_start();
/*session created*/
$produtor  =  $_SESSION["usuario"];
$validade =  $_SESSION["validade"];

if ($validade == "VALIDO"){
     include('../includes/db_valores.php');

     $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
    

     $evento  = $_GET['Evento'];
     $vendedor   = $_GET['Vendedor'];
     $lote  = $_GET['Lote'];
     $sexo   = $_GET['Sexo'];
     $validade  = $_GET['Validade'];
     $soma = 0;
     $count = 0;

     if ($evento == "todos"){
          if ($vendedor == "todos"){
               if ($lote == "todos"){
                    if ($sexo == "todos"){
                         if ($validade == "todos"){
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND (validade='VALIDO' OR validade = 'INVALIDO')";
                         }else{
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND validade='$validade'";
                         }
                    }else{
                         if ($validade == "todos"){
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND sexo='$sexo' AND (validade='VALIDO' OR validade = 'INVALIDO')";
                         }else{
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND sexo='$sexo' AND validade='$validade'";
                         }
                    }
               }else{
                    if ($sexo == "todos"){
                         if ($validade == "todos"){
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND lote='$lote' AND (validade='VALIDO' OR validade = 'INVALIDO')";
                         }else{
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND lote='$lote' AND validade='$validade'";
                         }
                    }else{
                         if ($validade == "todos"){
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND lote='$lote' AND sexo='$sexo' AND (validade='VALIDO' OR validade = 'INVALIDO')";
                         }else{
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND lote='$lote' AND sexo='$sexo' AND validade='$validade'";
                         }
                    }
               }
          }else{
               if ($lote == "todos"){
                    if ($sexo == "todos"){
                         if ($validade == "todos"){
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND vendedor='$vendedor' AND (validade='VALIDO' OR validade = 'INVALIDO')";
                         }else{
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND vendedor='$vendedor' AND validade='$validade'";
                         }
                    }else{
                         if ($validade == "todos"){
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND vendedor='$vendedor' AND sexo='$sexo' AND (validade='VALIDO' OR validade = 'INVALIDO')";
                         }else{
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND vendedor='$vendedor' AND sexo='$sexo' AND validade='$validade'";
                         }
                    }
               }else{
                    if ($sexo == "todos"){
                         if ($validade == "todos"){
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND vendedor='$vendedor' AND lote='$lote' AND (validade='VALIDO' OR validade = 'INVALIDO')";
                         }else{
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND vendedor='$vendedor' AND lote='$lote' AND validade='$validade'";
                         }
                    }else{
                         if ($validade == "todos"){
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND vendedor='$vendedor' AND lote='$lote' AND sexo='$sexo' AND (validade='VALIDO' OR validade = 'INVALIDO')";
                         }else{
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND vendedor='$vendedor' AND lote='$lote' AND sexo='$sexo' AND validade='$validade'";
                         }
                    }
               }
          }
     }else{
          if ($vendedor == "todos"){
               if ($lote == "todos"){
                    if ($sexo == "todos"){
                         if ($validade == "todos"){
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND evento='$evento' AND (validade='VALIDO' OR validade = 'INVALIDO')";
                         }else{
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND evento='$evento' AND validade='$validade'";
                         }
                    }else{
                         if ($validade == "todos"){
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND evento='$evento' AND sexo='$sexo' AND (validade='VALIDO' OR validade = 'INVALIDO')";
                         }else{
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND evento='$evento' AND sexo='$sexo' AND validade='$validade'";
                         }
                    }
               }else{
                    if ($sexo == "todos"){
                         if ($validade == "todos"){
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND evento='$evento' AND lote='$lote' AND (validade='VALIDO' OR validade = 'INVALIDO')";
                         }else{
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND evento='$evento' AND lote='$lote' AND validade='$validade'";
                         }
                    }else{
                         if ($validade == "todos"){
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND evento='$evento' AND lote='$lote' AND sexo='$sexo' AND (validade='VALIDO' OR validade = 'INVALIDO')";
                         }else{
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND evento='$evento' AND lote='$lote' AND sexo='$sexo' AND validade='$validade'";
                         }
                    }
               }
          }else{
               if ($lote == "todos"){
                    if ($sexo == "todos"){
                         if ($validade == "todos"){
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND evento='$evento' AND vendedor='$vendedor' AND (validade='VALIDO' OR validade = 'INVALIDO')";
                         }else{
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND evento='$evento' AND vendedor='$vendedor' AND validade='$validade'";
                         }
                    }else{
                         if ($validade == "todos"){
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND evento='$evento' AND vendedor='$vendedor' AND sexo='$sexo' AND (validade='VALIDO' OR validade = 'INVALIDO')";
                         }else{
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND evento='$evento' AND vendedor='$vendedor' AND sexo='$sexo' AND validade='$validade'";
                         }
                    }
               }else{
                    if ($sexo == "todos"){
                         if ($validade == "todos"){
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND evento='$evento' AND vendedor='$vendedor' AND lote='$lote' AND (validade='VALIDO' OR validade = 'INVALIDO')";
                         }else{
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND evento='$evento' AND vendedor='$vendedor' AND lote='$lote' AND validade='$validade'";
                         }
                    }else{
                         if ($validade == "todos"){
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND evento='$evento' AND vendedor='$vendedor' AND lote='$lote' AND sexo='$sexo' AND (validade='VALIDO' OR validade = 'INVALIDO')";
                         }else{
                              $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND evento='$evento' AND vendedor='$vendedor' AND lote='$lote' AND sexo='$sexo' AND validade='$validade'";
                         }
                    }
               }
          }
     }
     
     $gravacoes = mysqli_query($conexao, $consulta);

     $dados = array();

     while($linha = mysqli_fetch_assoc($gravacoes)){
          $dados[] = $linha; 
     }

     mysqli_close($conexao);
}else {
     header('Location: https://ingressozapp.com/produtor/login/');
}
?>
<div class="row">
    <div class="col s12 m6 push-m3 ">
     
        <img src="../includes/logo.png" alt="" class="logo">
        <h5>Relatório de Quantidade de Ingressos</h5>
        <h6>Produtor: <?php echo $produtor; ?></h6> 
        <h6>Evento: <?php echo $evento; ?></h6> 
        <h6>Vendedor: <?php echo $vendedor; ?></h6> 
        <h6>Lote: <?php echo $lote; ?></h6> 
        <h6>Sexo: <?php echo $sexo; ?></h6> 
        <h6>Validade do Ingresso: <?php echo $validade; ?></h6> 
        
        
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
                $soma += floatval($obj['valor']);
                $count++;
            }
            ?>
            </tbody>
        </table>
        <?php
        $soma = number_format($soma, 2, ',', '.'); 
         echo ("<h5>Valor Total: R$".$soma."<br>Quantidade: ".$count." ingressos.</h5>"); 
        ?>
        <a href="https://ingressozapp.com/produtor/" class="btn">Voltar</a>
    </div>
</div>
<script>
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

</script>

<?php
    include_once '../includes/footer.php';
?>
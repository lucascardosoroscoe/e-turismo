<?php
if ($validade == "VALIDO"){
     include('../includes/db_valores.php');

     $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
    

     $evento  = $_POST['Evento'];
     $vendedor   = $_POST['Vendedor'];
     $lote  = $_POST['Lote'];
     $soma = 0;
     $count = 0;

     if ($evento == "todos"){
          if ($vendedor == "todos"){
               if ($lote == "todos"){
                    $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND (validade='VALIDO' OR validade = 'INVALIDO') ORDER BY `data`";
               }else{
                    $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND lote='$lote' AND (validade='VALIDO' OR validade = 'INVALIDO') ORDER BY `data`";
               }
          }else{
               if ($lote == "todos"){
                    $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND vendedor='$vendedor' AND (validade='VALIDO' OR validade = 'INVALIDO') ORDER BY `data`";

               }else{
                    $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND vendedor='$vendedor' AND lote='$lote' AND (validade='VALIDO' OR validade = 'INVALIDO') ORDER BY `data`";
               }
          }
     }else{
          if ($vendedor == "todos"){
               if ($lote == "todos"){
                    $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND evento='$evento' AND (validade='VALIDO' OR validade = 'INVALIDO') ORDER BY `data`";
               }else{
                    $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND evento='$evento' AND lote='$lote' AND (validade='VALIDO' OR validade = 'INVALIDO') ORDER BY `data`";
               }
          }else{
               if ($lote == "todos"){
                    $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND evento='$evento' AND vendedor='$vendedor' AND (validade='VALIDO' OR validade = 'INVALIDO') ORDER BY `data`";
               }else{
                    $consulta = "SELECT * FROM Ingresso WHERE produtor='$produtor' AND evento='$evento' AND vendedor='$vendedor' AND lote='$lote' AND (validade='VALIDO' OR validade = 'INVALIDO') ORDER BY `data`";
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
     header('Location: http://ingressozapp.com/produtor/login/');
}
?>
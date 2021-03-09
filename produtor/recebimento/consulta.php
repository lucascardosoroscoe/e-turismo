<?php

   


     function selecionar($consulta){
          $servidor = '127.0.0.1:3306';
          $senha ='ingressozapp';
          $usuario ='u989688937_ingressozapp';
          $bdados ='u989688937_ingressozapp';
          $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
          $gravacoes = mysqli_query($conexao, $consulta);
          $dados = array();

          while($linha = mysqli_fetch_assoc($gravacoes)){
               $dados[] = $linha; 
          }

          mysqli_close($conexao);

          
          return $dados;
          //return $consulta;
     }

     function addEvento($evento){
          global $produtor;
          $consulta = "SELECT * FROM Evento WHERE produtor='$produtor'";
      
          $dados = selecionar($consulta);
          $size = sizeof($dados);
          for ($i = 0; $i < $size; $i++){
              $obj = $dados[$i];
              //echo json_encode($primeiro);
              //echo "<br>";
              $nome = $obj['nome'];
              if ($nome == $evento){
                  echo ('<option value="'.$nome.'" selected>'.$nome.'</option>');
              }else{
                  echo ('<option value="'.$nome.'">'.$nome.'</option>');
              }
          }
     }

     function addVendedor($vendedor){
          global $produtor;
          $consulta = "SELECT * FROM `Vendedor` WHERE `produtor` = '$produtor'";
      
          $dados = selecionar($consulta);
          $size = sizeof($dados);
          for ($i = 0; $i < $size; $i++){
              $obj = $dados[$i];
              //echo json_encode($primeiro);
              //echo "<br>";
              $nome = $obj['usuario'];
              if ($nome == $vendedor){
                  echo ('<option value="'.$nome.'" selected>'.$nome.'</option>');
              }else{
                  echo ('<option value="'.$nome.'">'.$nome.'</option>');
              }
          }
      }
?>
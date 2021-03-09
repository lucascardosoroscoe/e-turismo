<?php
function carregarDadosNumeroIngressos($dados){
    $array = array();
    $ob = array(' ', 'Ingressos/dia', 'Total Ingressos');
    array_push($array, $ob);

    $size = sizeof($dados);
    $dataAnterior = "";
    $count = 0;
    $totalIngressos = 0;

    for ($i = 0; $i < $size; $i++){
         $obj = $dados[$i];
         $dataIngresso = $obj['data'];
         $dataIngresso = date('Y/m/d', strtotime($dataIngresso));
         //echo ("<br>" . $dataIngresso);
         $totalIngressos++;
         if ($dataAnterior == ""){$count++;}
         else if($dataAnterior == $dataIngresso){$count++;}
         else{
              $ob = array(dataFormatada($dataAnterior), $count, $totalIngressos);
              array_push($array, $ob);
              $count = 1; 
              $dataAnterior = date('Y/m/d', strtotime("+1 day",strtotime($dataAnterior)));
              
              while ($dataAnterior != $dataIngresso) {
                   $ob = array(dataFormatada($dataAnterior), '0', $totalIngressos);
                   array_push($array, $ob);
                   $dataAnterior = date('Y/m/d', strtotime("+1 day",strtotime($dataAnterior)));
              }
              
         }

         $dataAnterior = $dataIngresso;
    }
    
    $ob = array(dataFormatada($dataAnterior), $count, $totalIngressos);
    array_push($array, $ob);

    

    echo ('<div id="dados" style="display: none;">'.json_encode($array).'</div>');
    
}

function carregarDadosFaturamento($dados){
     $array = array();
     $ob = array(' ', 'Faturamento/dia', 'Soma Faturamento');
     array_push($array, $ob);

     $size = sizeof($dados);
     $dataAnterior = "";
     $count = 0;
     $soma = 0;
     $somaDia = 0;

     for ($i = 0; $i < $size; $i++){
          $obj = $dados[$i];
          $dataIngresso = $obj['data'];
          $valor = $obj['valor'];
          $dataIngresso = date('Y/m/d', strtotime($dataIngresso));
          //echo ("<br>" . $dataIngresso);

          $soma = $soma + $valor;
          if ($dataAnterior == ""){$count++; $somaDia = $somaDia + $valor; }
          else if($dataAnterior == $dataIngresso){$count++; $somaDia = $somaDia + $valor; }
          else{
               $ob = array(dataFormatada($dataAnterior), $somaDia, $soma);
               array_push($array, $ob);
               $count = 1; 
               $somaDia = 0;
               $dataAnterior = date('Y/m/d', strtotime("+1 day",strtotime($dataAnterior)));
               
               while ($dataAnterior != $dataIngresso) {
                    $ob = array(dataFormatada($dataAnterior), '0', $soma);
                    array_push($array, $ob);
                    $dataAnterior = date('Y/m/d', strtotime("+1 day",strtotime($dataAnterior)));
               }
               
          }

          $dataAnterior = $dataIngresso;
     }
     
     $ob = array(dataFormatada($dataAnterior), $somaDia, $soma);
     array_push($array, $ob);

     

     echo ('<div id="dados2" style="display: none;">'.json_encode($array).'</div>');
     
}

function carregarDadosVendasPromoters($dados){
     $array2 = array();
     $ob = array('A', 'Ingressos/vendedor');
     array_push($array2, $ob);

     $dados = ordenarPromoters($dados);

     $size = sizeof($dados);
     $dataAnterior = "";
     $count = 0;

     $vendedorAnterior = "";

     for ($i = 0; $i < $size; $i++){
          $vendedor = $dados[$i];
          //echo ("<br>" . $dataIngresso);
            
          if ($vendedor == $vendedorAnterior){$count++;}
          else if ($vendedor == ""){$count++;}
          else{
               $ob = array($vendedorAnterior, $count);
               array_push($array2, $ob);
               $count = 1;
          }

          $vendedorAnterior = $vendedor;
     }
     
     $ob = array($vendedorAnterior, $count);
     array_push($array2, $ob);

     

     echo ('<div id="dados3" style="display: none;">'.json_encode($array2).'</div>');
     
}

function ordenarPromoters($dados){
    $jsonObj = array();
    $size = sizeof($dados);
    
    for ($i = 0; $i < $size; $i++){
        $ingresso = $dados[$i];
        $vendedor = $ingresso['vendedor'];
        array_push($jsonObj, $vendedor);
    }
    $dados = $jsonObj;
    sort($dados);

    return $dados;
}

function carregarDadosVendasLotes($dados){
    $array = array();
    $ob = array('A', 'Ingressos/vendedor');
    array_push($array, $ob);

    $dados = ordenarLotes($dados);

    $size = sizeof($dados);
    $loteAnterior = "";
    $count = 0;


    for ($i = 0; $i < $size; $i++){
         $lote = $dados[$i];
         //echo ("<br>" . $dataIngresso);
           
         if ($lote == $loteAnterior){$count++;}
         else if ($lote == ""){$count++;}
         else{
              $ob = array($loteAnterior, $count);
              array_push($array, $ob);
              $count = 1;
         }

         $loteAnterior = $lote;
    }
    
    $ob = array($loteAnterior, $count);
    array_push($array, $ob);

    

    echo ('<div id="dados4" style="display: none;">'.json_encode($array).'</div>');
    
}

function ordenarLotes($dados){
   $jsonObj = array();
   $size = sizeof($dados);
   
   for ($i = 0; $i < $size; $i++){
       $ingresso = $dados[$i];
       $lote = $ingresso['lote'];
       array_push($jsonObj, $lote);
   }
   $dados = $jsonObj;
   sort($dados);

   return $dados;
}


function dataFormatada($data){
    $data = date('d/m/Y', strtotime($data));
    return $data;
}

?>
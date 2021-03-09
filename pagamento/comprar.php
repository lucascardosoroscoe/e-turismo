<html>
<head></head>
<body>
<?
$servidor = '127.0.0.1:3306';
$senha ='ingressozapp';
$usuario ='u989688937_ingressozapp';
$bdados ='u989688937_ingressozapp';

    $idOrdem = $_GET['id'];

    $consulta = "SELECT Lote.id as idLote, Lote.nome as descricao , Lote.valor, Item.quantidade FROM Item JOIN Ordem ON Item.ordem = Ordem.id JOIN Lote ON Lote.id = Item.referencia WHERE Ordem.id = '$idOrdem'";
    $dados = selecionar($consulta);
    //echo $consulta;
    echo json_encode($dados);
     /*
     *Montar Array Itens
     */
    
    $items = array();
    
    $size = sizeof($dados);
    for ($i = 0; $i < $size; $i++){
        
        $obj = $dados[$i];
        //echo json_encode($primeiro);
        //echo "<br>";
        $idLote = $obj['idLote'];
        $descricao = $obj['descricao'];
        $valor = number_format($obj['valor'], 2, '.', '');
        $valor = $valor * 100;
        $quantidade = $obj['quantidade'];
        //echo $descricao;

        $item = array(
            "Name" => "$descricao",
            "Description" => "$idLote",
            "UnitPrice" => "$valor",
            "Quantity" => "$quantidade",
            "Type" => "Asset",
            "Sku" => "ABC001",
            "Weight" => 10
        );

        array_push ($items , $item );
      
    }
    

    $itens = array(
        "Items" => $items
    );

    /*
     * Monta o Array de requisi��o
     */
    $request = array(
        
        "OrderNumber" => $idOrdem,
        "SoftDescriptor"=> "INGRESSOZAPP",

        "Cart" => $itens,
        
        "Payment" => array(
            "BoletoDiscount"=> 0,
            "DebitDiscount"=> 0,
            "Installments"=> null,
            "MaxNumberOfInstallments"=> null
        ),

        "Shipping" => array(
            "Type"=> "WithoutShipping"
        ),
        
    );

    /**
     * Envia a requisi��o para a Cielo
     */
    //$data_string = $json;
    $data_string = json_encode($request, true);

    //$ch = curl_init("https://apisandbox.cieloecommerce.cielo.com.br/1/sales"); //ambiente de  testes
    $ch = curl_init("https://cieloecommerce.cielo.com.br/api/public/v1/orders");      //ambiente de producao
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'MerchantId: 86a34811-e49f-4956-b506-069693ccb6d3'
    ));

    $result = curl_exec($ch);
    
    $result = json_decode($result, true);
    $url = $result['settings']['checkoutUrl'];
    //echo $url;
    header('Location: '.$url);



    function selecionar($consulta){
        global $servidor, $usuario, $senha, $bdados;
        
        $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
        
        $gravacoes = mysqli_query($conexao, $consulta);
        
        $dados = array();
        
        while($linha = mysqli_fetch_assoc($gravacoes))
        {
            $dados[] = $linha; 
        }
        return $dados;
    }
   
?>
</body>
</html>
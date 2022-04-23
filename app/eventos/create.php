<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(2);
    include('../includes/trello.php');
    require '../../vendor/autoload.php';

    use Automattic\WooCommerce\Client;

    $woocommerce = new Client(
        'https://ingressozapp.com', 
        'ck_e9ce6160638444022e13079c5d45ce47c18edd28', 
        'cs_f1360a97794e17ef19bc3fc2590787454020e5fa',
        [
            'wp_api' => true,
            'version' => 'wc/v3',
        ]
    );
    

    $produtor = $idUsuario;
    $consulta = "SELECT * FROM `Produtor` WHERE id = '$produtor'";
    $dados = selecionar($consulta);
    $nomeProdutor = $dados[0]['nome'];
    $telefoneProdutor = $dados[0]['telefone'];
    $cidadeProdutor = $dados[0]['cidade'];
    $estadoProdutor = $dados[0]['estado'];
    $nome = $_POST['inputName'];
    $slug = $_POST['slug'];
    $imagem      = $_FILES["inputImagem"];
    $descricao   = $_POST['inputDescricao'];
    $data        = $_POST['inputData'];


    if($imagem != NULL) { 
        $nomeFinal = time().'.jpg';
        if (move_uploaded_file($imagem['tmp_name'], $nomeFinal)) {
            $tamanhoImg = filesize($nomeFinal); 
    
            $mysqlImg = addslashes(fread(fopen($nomeFinal, "r"), $tamanhoImg)); 
        }
    }

    // Criar Evento
    $consulta = "insert into Evento (nome, slug, produtor, imagem, data, descricao) values ('$nome', '$slug', '$produtor', '$mysqlImg', '$data', '$descricao')";
    $msg = executar($consulta);
    if($msg != "Sucesso!"){
            $msg = "Erro ao criar Evento, por favor contate o suporte!!";
    }

    // Pegar Id do Evento
    $idEvento = getIdEvento();

    // Criar Evento no Wordpress
    $eventoWP =  criarEventoWP($nome, $descricao, $idEvento, $slug);
    // echo json_encode($eventoWP);
    $idWP = $eventoWP->id;
    atualizarIdWP($idEvento, $idWP);
    // Criar card no trello
    criarCardTrello();

    // Redirecionar Para Lotes
    header('Location: ../lotes/index.php?evento='.$idEvento);
 
    function atualizarIdWP($idEvento, $idWP){
        $consulta = "UPDATE `Evento` SET `idWP`= '$idWP' WHERE `id` = '$idEvento'";
        $msg = executar($consulta);
    }
    function criarEventoWP($nomeEvento, $descricao, $idEvento, $slug){
        global $woocommerce, $nomeFinal;
        $link = 'https://ingressozapp.com/app/eventos/'.$nomeFinal;
        $descricao = $descricao . '

        *Taxa de conveniência de 10% da plataforma.';
        $auxilio = 'Já comprou um ingresso e precisa da segunda via? <a href="https://ingressozapp.com/nao-recebi-ingresso/">Clique aqui</a> 
        Gostaria de Transferir a titularidade do seu ingresso? <a href="https://ingressozapp.com/troca-titularidade/">Clique aqui</a>
        Dúvidas sobre como comprar pelo site? <a href="https://ingressozapp.com/como-comprar/">Clique aqui</a>';
        $data = [
            'name' => $nomeEvento,
            'slug' => $slug,
            'sku' => $idEvento,
            'description' => $auxilio,
            'type' => 'variable',
            'regular_price' => '',
            'status' => 'publish',
            'short_description' => $descricao,
            'virtual' => true,
            'categories' => [
                [
                    'id' => 39
                ]
            ],
            'images' => [
                [
                    'src' => $link,
                ],
            ],
            'attributes' => [
                [
                    'name' => 'Lote',
                    'visible' => true,
                    'variation' => true,
                    'options' => [
                        'Lote 1', 
                        'Lote 2', 
                        'Lote 3'
                    ]
                ]
            ],
            
        ];
        // echo json_encode($data);
        return $woocommerce->post('products', $data);
    }

    function criarCardTrello(){
        global $nomeProdutor, $nome, $cidadeProdutor, $estadoProdutor, $telefoneProdutor, $descricao, $idEvento, $data, $idListaEventoCadastrado;
        $nomeCard = $nomeProdutor . " - " . $nome . ' (' . $cidadeProdutor . '-' . $estadoProdutor . ')';
        $descricaoCard = "
            telefone: $telefoneProdutor \n
            descrição do Evento: $descricao
            imagem: ingressozapp.com/app/getImagem.php?id=$idEvento
        "; 
        criarCard($nomeCard, $descricaoCard, $data, $idListaEventoCadastrado);
    }

    function getIdEvento(){
        global $nome, $produtor, $data, $descricao;
        $consulta = "SELECT id FROM Evento WHERE nome = '$nome' AND produtor = '$produtor' AND data = '$data' AND descricao = '$descricao'";
   
        $dados = selecionar($consulta);
        $idEvento = $dados[0]['id'];
        return $idEvento;
    }
?>
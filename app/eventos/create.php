<?php
    set_time_limit(120);
    // Verifica Acesso do Produtor á Página 
    include('../includes/verificarAcesso.php');
    verificarAcesso(2);

    // Composer + Conexão com o Woocommerce
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

    // Pega dados do Produtor //OK
    $produtor = $idUsuario;
    $consulta = "SELECT * FROM `Produtor` WHERE id = '$produtor'";
    $dados = selecionar($consulta);
    $nomeProdutor = $dados[0]['nome'];
    $telefoneProdutor = $dados[0]['telefone'];
    $cidadeProdutor = $dados[0]['cidade'];
    $estadoProdutor = $dados[0]['estado'];

    // Pegar dados do Evento //OK
    $nome = $_POST['inputName'];
    $slug = $_POST['slug'];
    $selectEstilo = $_POST['selectEstilo'];
    $imagem      = $_FILES["inputImagem"];
    $descricao   = $_POST['inputDescricao'];
    $data        = $_POST['inputData'];

    // Verifica se o Evento tem imagem e transforma no formato SQL. Pode ser o problema...
    if($imagem != NULL) { 
        $nomeFinal = time().'.jpg';
        if (move_uploaded_file($imagem['tmp_name'], $nomeFinal)) {
            $tamanhoImg = filesize($nomeFinal); 
            $mysqlImg = addslashes(fread(fopen($nomeFinal, "r"), $tamanhoImg)); 
        }
    }

    // verificar se já existe evento com o mesmo nome
    $consulta = "SELECT * FROM `Evento` WHERE `nome` = '$nome' AND validade = 'VALIDO'";
    $dados = selecionar($consulta);
    if($dados[0]['id'] == ""){
        // Criar Evento no App
        $consulta = "insert into Evento (nome, slug, produtor, imagem, data, descricao, idEstilo) values ('$nome', '$slug', '$produtor', '$mysqlImg', '$data', '$descricao', '$selectEstilo')";
        $msg = executar($consulta);
        if($msg != "Sucesso!"){
                $msg = "Erro ao salvar o evento no Banco de Dados, por favor contate o suporte!!";
                header('Location: ./index.php?msg='.$msg);

        }

        // Pegar Id do Evento
        $idEvento = getIdEvento();

        // Criar Evento no Wordpress
        try {
            $eventoWP =  criarEventoWP($nome, $descricao, $idEvento, $slug, $selectEstilo);
        } catch (\Throwable $th) {
        }

        header('Location: ../lotes/index.php?evento='.$idEvento);
    }else if($dados[0]['id'] == $idUsuario){
        $msg = "O evento " . $dados[0]['nome'] .' já está criado.';
        header('Location: ./index.php?msg='.$msg);
    }else{
        $msg = "Já existe um evento cadastrado na plataforma com esse nome e esse evento pertence a outro produtor";
        header('Location: ./index.php?msg='.$msg);

    }


    
    
 
    
    function selecionarEstilo($estilo){
        $consulta = "SELECT categoria FROM EstiloMusical WHERE id = '$estilo'";
        $dados = selecionar($consulta);
        return $dados[0]['categoria'];
    }
    function criarEventoWP($nomeEvento, $descricao, $idEvento, $slug, $estilo){
        global $woocommerce, $nomeFinal;
        $idEstilo = selecionarEstilo($estilo);
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
                ],
                [
                    'id' => $idEstilo
                ],
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
    }

    function getIdEvento(){
        global $nome, $produtor, $data, $descricao;
        $consulta = "SELECT id FROM Evento WHERE nome = '$nome' AND produtor = '$produtor' AND data = '$data' AND descricao = '$descricao'";
   
        $dados = selecionar($consulta);
        $idEvento = $dados[0]['id'];
        return $idEvento;
    }
?> 
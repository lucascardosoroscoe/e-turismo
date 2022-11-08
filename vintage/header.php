<?php
  include('../app/includes/verificarAcesso.php');
  $idEvento = 214;
  $consulta= "SELECT * FROM `Evento` WHERE id = $idEvento";
  $dados = selecionar($consulta);
  $nomeEvento = $dados[0]['nome'];
  $dataEvento = $dados[0]['data'];
  $descricaoEvento = $dados[0]['descricao'];
?>
<!DOCTYPE html>
  <html>
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <meta name="description" content="Eu já garanti meu ingresso, bora??? garanta o seu também." />
      <meta name="author" content="Lucas Cardoso Roscoe" />
      <meta property="og:description" content="Eu já garanti meu ingresso, bora??? Garanta o seu também."/>
      <meta property="og:title" content="<?php echo $nomeEvento ?> - IngressoZapp"/>
      <meta property="og:image" content="<?php echo $HTTP_HOST . "/app"?>/getImagem.php?id=<?php echo $idEvento;?>"/>
      <meta name="twitter:url" content="https://ingressozapp.com/evento/?evento=<?php echo $idEvento?>&promoter=<?php echo $promoter?>">
      <meta name="twitter:title" content="Eu já garanti meu ingresso, bora??? Garanta o seu também.">
      <meta name="twitter:image" content="<?php echo $HTTP_HOST . "/app"?>/getImagem.php?id=<?php echo $idEvento;?>">
      <title><?php echo $nomeEvento ?> - IngressoZapp</title>
      <link  rel="stylesheet" href="<?php echo $HTTP_HOST . "/app";?>/css/styles.css" />
    </head>

    <body>
<?php


setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

?>
<body class="sb-nav-fixed">
    <!-- Barra Topo do Site -->
      <nav class="sb-topnav navbar navbar-expand " style="height:100px; background-color:#000;">
        <!-- Título Site -->
        
          <a class="navbar-brand" href="<?php echo $HTTP_HOST . "/app";?>/index.php"><img src="<?php echo $HTTP_HOST . "/app";?>/img/logo.webp" alt="IngressoZapp" style="height:100px;"></a>
          <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
          </form>
          <div style="width:-webkit-fill-available;"></div>
          <img src="<?php echo $HTTP_HOST . "/app";?>getImagem.php?id=<?php echo $idEvento;?>" alt="Instagram" style="display:none;">
          <a href="https://www.instagram.com/ingressozapp/" target="_blank"><img src="<?php echo $HTTP_HOST . "/app";?>/img/instagram-logo.webp" alt="Instagram" style="height:60px;width:60px"></a>
      </nav>
    <!-- Menu Lateral Esquerda -->
      <div id="layoutSidenav" style="background-color: #333;">
        <div id="layoutSidenav_nav" style="display: none; position:relative;">
          <nav class="sb-sidenav accordion sb-sidenav-dark" style="display:none;" id="sidenavAccordion">
             <div class="sb-sidenav-menu">
              <div class="nav">
              <?php
                
                echo('<a class="nav-link" href="'.$HTTP_HOST . "/app".'/index.php"><div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>IngressoZapp</a>');
                if($tipoUsuario == 1 || $tipoUsuario == 2 || $tipoUsuario == 3){
                  echo('<div class="sb-sidenav-menu-heading">Principal</div>');

                  //Painel de Controle
                  echo('<a class="nav-link" href="'.$HTTP_HOST . "/app".'/ingresso.php"><div class="sb-nav-link-icon"><i class="fas fa-ticket-alt"></i></div>Emitir Ingresso</a>');
                  echo('<a class="nav-link" href="'.$HTTP_HOST . "/app".'/vendas"><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>Minhas Vendas</a>');


                  //Usuários
                    if($tipoUsuario == 1){
                      echo('<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">');
                        echo('<div class="sb-nav-link-icon"><i class="fas fa-user-friends"></i></div>Usuários<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>');
                      echo('</a>');
                      echo('<div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion"><nav class="sb-sidenav-menu-nested nav">');
                          echo('<a class="nav-link" href="'.$HTTP_HOST . "/app".'/produtores">Produtores</a>');
                          echo('<a class="nav-link" href="'.$HTTP_HOST . "/app".'/vendedores">Vendedores</a>');
                          echo('<a class="nav-link" href="'.$HTTP_HOST . "/app".'/clientes">Clientes</a>');
                      echo('</nav></div>');
                    }else if($tipoUsuario == 2){
                      echo('<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">');
                      echo('<div class="sb-nav-link-icon"><i class="fas fa-user-friends"></i></div>Usuários<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>');
                      echo('</a>');
                      echo('<div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion"><nav class="sb-sidenav-menu-nested nav">');
                        echo('<a class="nav-link" href="'.$HTTP_HOST . "/app".'/vendedores">Vendedores</a>');
                        echo('<a class="nav-link" href="'.$HTTP_HOST . "/app".'/clientes">Clientes</a>');
                      echo('</nav></div>');
                    }else if($tipoUsuario == 3){
                      echo('<a class="nav-link" href="'.$HTTP_HOST . "/app".'/clientes">Clientes</a>');
                    }
                    if($tipoUsuario == 2 || $tipoUsuario == 1){
                      //Eventos
                      echo('<a class="nav-link" href="'.$HTTP_HOST . "/app".'/eventos"><div class="sb-nav-link-icon"><i class="fas fa-gas-pump"></i></div>Eventos</a>');
                      echo('<a class="nav-link" href="'.$HTTP_HOST . "/app".'/lotes"><div class="sb-nav-link-icon"><i class="fas fa-gas-pump"></i></div>Lotes</a>');
                      
                      // Custos
                      echo('<a class="nav-link" href="'.$HTTP_HOST . "/app".'/custos"><div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>Custos</a>');

                      //Relatórios
                      echo('<a class="nav-link collapsed" href="#produtividade" data-toggle="collapse" data-target="#collapse" aria-expanded="false" aria-controls="collapse">');
                        echo('<div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>Relatórios<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>');
                      echo('</a>');
                      echo('<div class="collapse" id="collapse" aria-labelledby="headingOne" data-parent="#sidenavAccordion"><nav class="sb-sidenav-menu-nested nav">');
                        echo('<a class="nav-link" href="'.$HTTP_HOST . "/app".'/relatorios/vendaIngresso">Venda de Ingressos</a>');
                        // echo('<a class="nav-link" href="'.$HTTP_HOST . "/app".'/relatorios/financeiro">Financeiro</a>');
                        echo('<a class="nav-link" href="'.$HTTP_HOST . "/app".'/relatorios/recebimento">Recebimentos</a>');
                        echo('<a class="nav-link" href="'.$HTTP_HOST . "/app".'/relatorios/vendaBar">Vendas no Bar</a>');
                        if($tipoUsuario == 1){
                          echo('<a class="nav-link" href="'.$HTTP_HOST . "/app".'/relatorios/dashboard">Dashboard</a>');
                        }
                      
                      echo('</nav></div>');
                      if($tipoUsuario == 1){
                        echo('<a class="nav-link" href="'.$HTTP_HOST . "/app".'/relatorios/pix"><div class="sb-nav-link-icon"><i class="fab fa-sellsy"></i></div>Vendas Woocomerce</a>');
                      }
                      //Bar
                      echo('<div class="sb-sidenav-menu-heading">Bar</div>');
                      echo('<a class="nav-link" href="'.$HTTP_HOST . "/app".'/produtos"><div class="sb-nav-link-icon"><i class="fas fa-cocktail"></i></div>Produtos</a>');
                    }
                }else{
                  echo('<a class="nav-link" href="'.$HTTP_HOST . "/app".'/login/"><div class="sb-nav-link-icon"><i class="fas fa-user fa-fw"></i></div>Login</a>');
                }
                ?>
              </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logado como
                  <?php 
                    if($tipoUsuario == 1){
                      echo " Administrador:";
                    }else if($tipoUsuario == 2){
                      echo " Produtor";
                    }else if($tipoUsuario == 3){
                      echo " Promoter:";
                    }else if($tipoUsuario == 4){
                      echo " Cliente:";
                    }
                  ?>
                </div>
                <?php if($tipoUsuario != ''){echo $usuario;} ?>
            </div> 
          </nav>
        </div>


        <div id="layoutSidenav_content">
  <main class="fh">
<style>
  @media (min-width: 992px) {
    #layoutSidenav_content {
      padding-left: 0 !important;
    }
  }
</style>

<?php
  function selectEvento(){
    global $tipoUsuario, $idEvento, $idUsuario;
    
    if($tipoUsuario == 1){
      $consulta = "SELECT * FROM `Evento` WHERE validade = 'VALIDO' ORDER BY nome";
    }else if($tipoUsuario == 2){
      $consulta = "SELECT * FROM `Evento` WHERE `produtor`= '$idUsuario' AND validade = 'VALIDO'";
    }else if($tipoUsuario == 3){
      $consulta = "SELECT Evento.id, Evento.nome FROM Evento 
      JOIN Produtor ON Evento.produtor = Produtor.id
      JOIN ProdutorVendedor ON ProdutorVendedor.idProdutor = Produtor.id
      JOIN Vendedor ON ProdutorVendedor.idVendedor = Vendedor.id
      WHERE Vendedor.id = '$idUsuario' AND Produtor.validade = 'VALIDO' AND Evento.validade = 'VALIDO'";
    }
    $dados = selecionar($consulta);
    echo('<select class="form-control" name="selectEvento" id="selectEvento" onchange="selectevento(1)"  form="emitir" required>');
      echo('<option value="">Selecione o Evento</option>');
      foreach ($dados as $evento) {
        if($idEvento == $evento['id']){
          echo('<option value="'. $evento['id'] .'" selected>'. $evento['nome'] .'</option>');
        }else{
          echo('<option value="'. $evento['id'] .'">'. $evento['nome'] .'</option>');
        }
      }
    echo('</select>');
  }
  function selecEvento($idEvento){
    global $tipoUsuario, $idUsuario;
    
    if($tipoUsuario == 1){
      $consulta = "SELECT * FROM `Evento` WHERE validade = 'VALIDO' ORDER BY nome";
    }else if($tipoUsuario == 2){
      $consulta = "SELECT * FROM `Evento` WHERE `produtor`= '$idUsuario' AND validade = 'VALIDO'";
    }else if($tipoUsuario == 3){
      $consulta = "SELECT Evento.id, Evento.nome FROM Evento 
      JOIN Produtor ON Evento.produtor = Produtor.id
      JOIN ProdutorVendedor ON ProdutorVendedor.idProdutor = Produtor.id
      JOIN Vendedor ON ProdutorVendedor.idVendedor = Vendedor.id
      WHERE Vendedor.id = '$idUsuario' AND Produtor.validade = 'VALIDO' AND Evento.validade = 'VALIDO'";
    }
    $dados = selecionar($consulta);
    echo('<select class="form-control" name="selectEvento" id="selectEvento" onchange="selectevento(1)"  form="emitir" required>');
      echo('<option value="">Selecione o Evento</option>');
      foreach ($dados as $evento) {
        if($idEvento == $evento['id']){
          echo('<option value="'. $evento['id'] .'" selected>'. $evento['nome'] .'</option>');
        }else{
          echo('<option value="'. $evento['id'] .'">'. $evento['nome'] .'</option>');
        }
      }
    echo('</select>');
  }


  function selectLote(){
    global $idEvento, $idLote;
      $consulta = "SELECT * FROM `Lote` WHERE `evento`= '$idEvento' AND `validade`= 'DISPONÍVEL'";
    $dados = selecionar($consulta);
    echo('<select class="form-control" name="selectLote" id="selectLote"  form="comprar" style="height: 50px;" required>');
      echo('<option value="">Selecione o Lote</option>');
      foreach ($dados as $lote) {
        if($idLote == $lote['id']){
          echo('<option value="'. $lote['id'] .'" selected>'. $lote['nome'] .' - R$'. $lote['valor'] .',00</option>');
        }else{
          echo('<option value="'. $lote['id'] .'">'. $lote['nome'] .' - R$'. $lote['valor'] .',00</option>');
        }
      }
    echo('</select>');
  }

  function selecLote($idEvento, $i){
    global $idLote;
    $consulta = "SELECT * FROM `Lote` WHERE `evento`= '$idEvento' AND `validade`= 'DISPONÍVEL'";
    $dados = selecionar($consulta);
    echo('<select class="form-control" name="selectLote" id="selectLote" onchange="selectlote(1)" form="emitir'.$i.'" required>');
      echo('<option value="">Selecione o Lote</option>');
      foreach ($dados as $lote) {
        if($idLote == $lote['id']){
          echo('<option value="'. $lote['id'] .'" selected>'. $lote['nome'] .' - R$'. $lote['valor'] .',00</option>');
        }else{
          echo('<option value="'. $lote['id'] .'">'. $lote['nome'] .' - R$'. $lote['valor'] .',00</option>');
        }
      }
    echo('</select>');
  }
?>
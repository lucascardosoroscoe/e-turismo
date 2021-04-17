<!DOCTYPE html>
  <html>
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <meta name="description" content="IngressoZapp" />
      <meta name="author" content="Lucas Cardoso Roscoe" />
      <title>IngressoZapp</title>
      <link  rel="stylesheet" href="<?php echo $HTTP_HOST;?>/css/styles.css" />
      <link rel="stylesheet"  href="<?php echo $HTTP_HOST;?>/css/table.css">
      <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
      <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
      <!-- <link rel="stylesheet" href="style1.css">
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <script type="text/javascript" src="<?php echo $HTTP_HOST;?>/js/graph.js"></script> -->
    </head>

    <body>
<?php


setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

// if ($validade == "VALIDO"){}else{header('Location: ../../produtor/login/');}
?>
<body class="sb-nav-fixed">
    <!-- Barra Topo do Site -->
      <nav class="sb-topnav navbar navbar-expand " style="background-color: #fff;">
      <!-- navbar-dark bg-dark -->
        <!-- Título Site -->
        
          <a class="navbar-brand" href="<?php echo $HTTP_HOST;?>/index.php"><img src="<?php echo $HTTP_HOST;?>/img/logo.png" alt="Soluções2c" srcset="" style="height:40px;"></a>
        <!-- Botão do Menu -->
          <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Barra de Pesquisa -->
          <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <!-- <div class="input-group">
              <?php //selectEvento();?>
            </div> -->
          </form>
        <!-- Menu de Usuário -->
          <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">Configurações</a>
                <a class="dropdown-item" onclick="window.print()">Exportar PDF</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo $HTTP_HOST;?>/login">Sair</a>
              </div>
            </li>
          </ul>
      </nav>
    <!-- Menu Lateral Esquerda -->
      <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
          <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
              <div class="nav">
              <?php
                
                if($tipoUsuario == 1 || $tipoUsuario == 2 || $tipoUsuario == 3){
                  echo('<div class="sb-sidenav-menu-heading">Principal</div>');

                  //Painel de Controle
                  echo('<a class="nav-link" href="'.$HTTP_HOST.'/index.php"><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>Home</a>');
                  echo('<a class="nav-link" href="'.$HTTP_HOST.'/vendas.php"><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>Minhas Vendas</a>');


                  //Usuários
                    if($tipoUsuario == 1){
                      echo('<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">');
                        echo('<div class="sb-nav-link-icon"><i class="fas fa-user-friends"></i></div>Usuários<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>');
                      echo('</a>');
                      echo('<div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion"><nav class="sb-sidenav-menu-nested nav">');
                          echo('<a class="nav-link" href="'.$HTTP_HOST.'/produtores">Produtores</a>');
                          echo('<a class="nav-link" href="'.$HTTP_HOST.'/vendedores">Vendedores</a>');
                          echo('<a class="nav-link" href="'.$HTTP_HOST.'/clientes">Clientes</a>');
                      echo('</nav></div>');
                    }else if($tipoUsuario == 2){
                      echo('<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">');
                      echo('<div class="sb-nav-link-icon"><i class="fas fa-user-friends"></i></div>Usuários<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>');
                      echo('</a>');
                      echo('<div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion"><nav class="sb-sidenav-menu-nested nav">');
                        echo('<a class="nav-link" href="'.$HTTP_HOST.'/vendedores">Vendedores</a>');
                        echo('<a class="nav-link" href="'.$HTTP_HOST.'/clientes">Clientes</a>');
                      echo('</nav></div>');
                    }else if($tipoUsuario == 3){
                      echo('<a class="nav-link" href="'.$HTTP_HOST.'/clientes">Clientes</a>');
                    }
                    if($tipoUsuario == 2 || $tipoUsuario == 1){
                      //Eventos
                      echo('<a class="nav-link" href="'.$HTTP_HOST.'/eventos"><div class="sb-nav-link-icon"><i class="fas fa-gas-pump"></i></div>Eventos</a>');
                      echo('<a class="nav-link" href="'.$HTTP_HOST.'/lotes"><div class="sb-nav-link-icon"><i class="fas fa-gas-pump"></i></div>Lotes</a>');
                      //Relatórios
                      echo('<a class="nav-link collapsed" href="#produtividade" data-toggle="collapse" data-target="#collapse" aria-expanded="false" aria-controls="collapse">');
                        echo('<div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>Relatórios<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>');
                      echo('</a>');
                      echo('<div class="collapse" id="collapse" aria-labelledby="headingOne" data-parent="#sidenavAccordion"><nav class="sb-sidenav-menu-nested nav">');
                        echo('<a class="nav-link" href="'.$HTTP_HOST.'/relatorios/vendaIngressos">Venda de Ingressos</a>');
                        echo('<a class="nav-link" href="'.$HTTP_HOST.'/relatorios/vendaBar">Vendas no Bar</a>');
                        echo('<a class="nav-link" href="'.$HTTP_HOST.'/relatorios/recebimento">Recebimentos</a>');
                        echo('<a class="nav-link" href="'.$HTTP_HOST.'/relatorios/financeiro">Financeiro</a>');
                      echo('</nav></div>');


                      //Custos
                      echo('<div class="sb-sidenav-menu-heading">Financeiro</div>');
                      echo('<a class="nav-link" href="'.$HTTP_HOST.'/custos"><div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>Custos</a>');
                      echo('<a class="nav-link" href="'.$HTTP_HOST.'/recebimentos"><div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>Recebimentos</a>');

                      //Bar
                      echo('<div class="sb-sidenav-menu-heading">Bar</div>');
                      echo('<a class="nav-link" href="'.$HTTP_HOST.'/produtos"><div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>Cadastro de produtos</a>');
                      echo('<a class="nav-link" href="'.$HTTP_HOST.'/cardapio"><div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>Cadastro de Cardápio</a>');
                    }
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
  

<?php
  function selectEvento(){
    global $tipoUsuario, $idEvento, $idUsuario;
    
    if($tipoUsuario == 1){
      $consulta = "SELECT * FROM `Evento` WHERE validade = 'VALIDO'";
    }else if($tipoUsuario == 2){
      $consulta = "SELECT * FROM `Evento` WHERE `produtor`= '$idUsuario' AND validade = 'VALIDO'";
    }else if($tipoUsuario == 3){
      $consulta = "SELECT Evento.id, Evento.nome FROM Evento 
      JOIN Produtor ON Evento.produtor = Produtor.id
      JOIN Vendedor ON Produtor.id = Vendedor.produtor
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
    echo('<select class="form-control" name="selectLote" id="selectLote" onchange="selectlote(1)" form="emitir" required>');
      echo('<option value="">Selecione o Lote</option>');
      foreach ($dados as $lote) {
        if($idLote == $lote['id']){
          echo('<option value="'. $lote['id'] .'" selected>'. $lote['nome'] .'</option>');
        }else{
          echo('<option value="'. $lote['id'] .'">'. $lote['nome'] .'</option>');
        }
      }
    echo('</select>');
  }
?>
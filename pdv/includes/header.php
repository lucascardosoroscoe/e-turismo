<!DOCTYPE html>
  <html>
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <meta name="description" content="IngressoZapp" />
      <meta name="author" content="Lucas Cardoso Roscoe" />
      <title>IngressoZapp</title>
      <link  rel="stylesheet" href="<?php echo $HTTP_HOST . "/app";?>/css/styles.css" />
      <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">  -->   
      <link rel="stylesheet"  href="<?php echo $HTTP_HOST . "/app";?>/css/table.css">
      <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
      <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
      <!-- <link rel="stylesheet" href="style1.css">
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <script type="text/javascript" src="<?php echo $HTTP_HOST . "/app";?>/js/graph.js"></script> -->
    </head>

    <body>
<?php


setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

// if ($validade == "VALIDO"){}else{header('Location: ../../produtor/login/');}
?>
<body class="sb-nav-fixed">
    <!-- Barra Topo do Site -->
      <nav class="sb-topnav navbar navbar-expand bg-dark">
      <!-- navbar-dark bg-dark -->
        <!-- Título Site -->
        
          <a class="navbar-brand" href="<?php echo $HTTP_HOST . "/pdv";?>/index.php"><img src="<?php echo $HTTP_HOST . "/app";?>/img/logo.png" alt="IngressoZapp" srcset="" style="height:60px;"></a>
        <!-- Botão do Menu -->
          <button class="btn btn-link btn-sm order-1 order-lg-0 text-white" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Barra de Pesquisa -->
          <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <!-- <div class="input-group">
              <?php //selectEvento();?>
            </div> -->
          </form>
        <!-- Menu de Usuário --> 
          <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-primary" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw text-primary"></i></a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?php echo $HTTP_HOST . "/pdv";?>/config">Minha Conta</a>
                <a class="dropdown-item" onclick="window.print()">Exportar PDF</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo $HTTP_HOST . "/pdv";?>/login">Login</a>
              </div>
            </li>
          </ul>
      </nav>
    <!-- Menu Lateral Esquerda -->
      <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
          <nav class="sb-sidenav accordion bg-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
              <div class="nav">
              <?php
                
                echo('<a class="nav-link" href="'.$HTTP_HOST . "/pdv".'/index.php"><div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>IngressoZapp</a>');
                if($tipoUsuario == 1 || $tipoUsuario == 2 || $tipoUsuario == 3){
                  echo('<div class="sb-sidenav-menu-heading">Principal</div>');

                  //Painel de Controle
                  echo('<a class="nav-link" href="'.$HTTP_HOST . "/pdv".'/ingresso.php"><div class="sb-nav-link-icon"><i class="fas fa-ticket-alt"></i></div>Emitir Ingresso</a>');
                  echo('<a class="nav-link" href="'.$HTTP_HOST . "/pdv".'/vendas"><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>Minhas Vendas</a>');
                }else{
                  echo('<a class="nav-link" href="'.$HTTP_HOST . "/pdv".'/login/"><div class="sb-nav-link-icon"><i class="fas fa-user fa-fw"></i></div>Login</a>');
                }
                ?>
              </div>
            </div>
            <div class="sb-sidenav-footer text-primary">
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
      $consulta = "SELECT * FROM `Evento` WHERE validade = 'VALIDO' OR validade = 'INVALIDO' ORDER BY nome";
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
      $consulta = "SELECT * FROM `Evento` WHERE validade = 'VALIDO' OR validade = 'INVALIDO' ORDER BY nome";
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
    global $idEvento, $idLote, $tipoUsuario;
    if($tipoUsuario == '1' || $tipoUsuario == '2'){
      $consulta = "SELECT * FROM `Lote` WHERE `evento`= '$idEvento' AND (`validade`= 'DISPONÍVEL' OR `validade`= 'EXCLUSIVO')";
    }else{
      $consulta = "SELECT * FROM `Lote` WHERE `evento`= '$idEvento' AND `validade`= 'DISPONÍVEL'";
    }
    $dados = selecionar($consulta);
    echo('<select class="form-control" name="selectLote" id="selectLote" onchange="selectlote(1)" form="emitir" style="height: 50px;" required>');
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

  function selectCidade(){
    global $cidade;
    $consulta = "SELECT cidade, estado FROM `Evento` WHERE `validade`= 'DISPONÍVEL' ORDER BY estado, cidade";
    $dados = selecionar($consulta);
    echo('<select class="form-control" name="selectCidade" id="selectCidade" onchange="selectCidade()" required>');
      echo('<option value="">Selecione a Cidade</option>');
      foreach ($dados as $cidade) {
        if($cidade == $cidade['cidade']){
          echo('<option value="'. $cidade['cidade'] .'" selected>'. $cidade['estado'] .' - '. $cidade['cidade'] .'</option>');
        }else{
          echo('<option value="'. $cidade['cidade'] .'">'. $cidade['estado'] .' - '. $cidade['cidade'] .'</option>');
        }
      }
    echo('</select>');
  }

  function selecLote($idEvento, $i){
    global $idLote, $tipoUsuario;
    if($tipoUsuario == '1' || $tipoUsuario == '2'){
      $consulta = "SELECT * FROM `Lote` WHERE `evento`= '$idEvento' AND (`validade`= 'DISPONÍVEL' OR `validade`= 'EXCLUSIVO')";
    }else{
      $consulta = "SELECT * FROM `Lote` WHERE `evento`= '$idEvento' AND `validade`= 'DISPONÍVEL'";
    }
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
 
  function selectVendedor(){
    global $tipoUsuario, $idUsuario;
    
    if($tipoUsuario == 1){
      $consulta = "SELECT * FROM `Vendedor` WHERE validade = 'VALIDO' ORDER BY nome";
      selectVend($consulta);
    }else if($tipoUsuario == 2){
      $consulta = "SELECT * FROM `Vendedor` WHERE `produtor`= '$idUsuario' AND validade = 'VALIDO' ORDER BY nome";
      selectVend($consulta);
    }
   
  }

  function selectVend($consulta){
    global $idVendedor;
    $dados = selecionar($consulta);
    echo('<select class="form-control" name="selectVendedor" id="selectVendedor" onchange="selectVendedor(1)"  form="emitir" required>');
      echo('<option value="">Selecione o Vendedor</option>');
      foreach ($dados as $vendedor) {
        if($idVendedor == $vendedor['id']){
          echo('<option value="'. $vendedor['id'] .'" selected>'. $vendedor['nome'] .'</option>');
        }else{
          echo('<option value="'. $vendedor['id'] .'">'. $vendedor['nome'] .'</option>');
        }
      }
    echo('</select>');
  }

  function msgAutomatica(){
    global $msg;
    echo '<div class="row">';
      echo '<div class="col-md-12">';
        echo '<label class="small mb-1" for="inputMsg">Mensagem Automatizada</label>';
        echo '<input class="form-control py-4" type="text" id="inputMsg" name="inputMsg" onchange="modificarMsg()" placeholder="Digite a mensagem para enviar via contato" value="'.$msg.'"></input>';
      echo '</div>';
    echo '</div>';
  }
?>
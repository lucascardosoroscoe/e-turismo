<?php
include('./includes/verificarAcesso.php');
verificarAcesso(3);
include('./includes/header.php');
?>
<div class="container-fluid fh">
    <div class="row fh">
        <!-- Mapa -->
        <div class="col-xl-12 fh">
            <div class="card mb-4 fh">
                <div class="card-header">
                    <i class="fas fa-user"></i>
                    Bem Vindo ao IngressoZapp <?php if($tipoUsuario != ''){echo $usuario;} ?>!
                </div>
                
                <div class="row" style="display: flex;height:100%;">
                </div>
        </div>
    </div>
</div>

<?php
include('./includes/footer.php');
?>
<?php include('./header.php'); ?>
    <div class="container">
        <div class="row shadow-lg rounded-lg justify-content-center mt-5" style="padding-top: 15px;">
            <div class="col-lg-12" style="text-transform: uppercase;"><h3 class="white"><i class="far fa-calendar-alt"></i> PRÓXIMOS EVENTOS 
                <?php 
                    if($idProdutor != ""){
                        echo ' - ' . $nome;
                    }
                    
                ?>
            </h3></div>
            <?php exibirEventos($dados);?>  
        </div>
        <br><br>
    </div>
<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
<style>
    .white{
        color: #fff;
    }
    .img-eventos{
        width: 100%;
        height: 350px;
        object-fit: cover;
        object-position: center;
    }
    /* On screens that are 992px wide or less, go from four columns to two columns */
    @media (max-width: 992px) {
        .img-eventos {
            height: 600px;
        }
    }
    
</style>
<?php
function exibirEventos($dados){
    foreach ($dados as $evento) {

        echo '<div class="col-lg-3" style="height: 100%;margin-top:10px; margin-bottom:10px;">';
            echo '<a href="../evento?evento='.$evento['id'].'"><img src="../app/getImagem.php?id='.$evento['id'].'" alt="Imagem Evento" srcset="" class="img-eventos"></a>';
        echo '</div>';
    }
}
include('../app/includes/footer.php');
?>

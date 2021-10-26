<?php
include('../../includes/verificarAcesso.php');
verificarAcesso(1);
include('../../includes/header.php');
$id = $_GET['id'];
$consulta = "SELECT wp_wc_order_stats.order_id, wp_wc_order_stats.date_created, 
wp_wc_order_stats.net_total, wp_wc_order_stats.status, wp_wc_customer_lookup.email , 
wp_wc_customer_lookup.first_name, wp_wc_customer_lookup.last_name, wp_wc_customer_lookup.postcode,
wp_wc_order_product_lookup.product_qty, wp_woocommerce_order_items.order_item_name
FROM wp_wc_order_stats 
JOIN wp_wc_customer_lookup ON wp_wc_customer_lookup.customer_id = wp_wc_order_stats.customer_id 
JOIN wp_wc_order_product_lookup ON wp_wc_order_product_lookup.order_id = wp_wc_order_stats.order_id
JOIN wp_woocommerce_order_items ON wp_woocommerce_order_items.order_id =  wp_wc_order_stats.order_id
WHERE wp_wc_order_stats.order_id = $id AND wp_woocommerce_order_items.order_item_type = 'line_item'";
$dados = selecionar($consulta);
$obj = $dados[0];
?>     
    <div style='background-image: url("../img/fundoLogin.jpg"); background-size: cover;height: 100%;'>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Emitir Ingressos Pedido <?php echo $id;?> - R$<?php echo $obj['net_total'];?>,00</h3></div>
                        <div class="card-body">
                           <?php 
                                $nomeEvento = $obj['order_item_name'];
                                $consulta = "SELECT * FROM `Evento` WHERE `nome` = '$nomeEvento'";
                                $dados = selecionar($consulta);
                                $idEvento = $dados[0]['id'];
                                $nomeEvento = $dados[0]['nome'];
                                for ($i=1; $i <= $obj['product_qty']; $i++) { 
                                    echo '<div class="card">';
                                        echo '<form action="../../emitir.php" id="emitir'.$i.'" method="POST">';
                                            echo '<h3 class="title">'. $nomeEvento . ' - Ingresso nº '. $i .'</h3>';
                                            echo '<input class="form-control py-4" id="selectEvento"  name="selectEvento" type="hidden" value="'. $idEvento .'" required/>';
                                            echo '<div class="form-row">';
                                                echo '<div class="col-md-12">';
                                                    echo '<div class="form-group">';
                                                        echo '<label class="small mb-1" for="selectLote">Selecione o Lote*</label>';
                                                        selecLote($idEvento);
                                                    echo '</div>';
                                                echo '</div>';
                                            echo '</div>';
                                            echo '<input class="form-control py-4" id="inputNome"  name="inputNome" type="hidden" value="'. $obj['first_name'] .'" required/>';
                                            echo '<input class="form-control py-4" id="inputTelefone"  name="inputTelefone" type="hidden" value="'. $obj['last_name'] .'" required/>';
                                    
                                            echo '<div class="form-group mt-4 mb-0 btn btn-primary btn-block" onclick="checkForm('.$i.')">Emitir Ingresso</div>';
                                        echo '</form>';                                        
                                    echo '</div>';
                                }
 
                                echo '<a class="mt-4 mb-0 btn btn-primary btn-block" href="concluir.php?id='.$id.'">Concluir Emissão</a>';

                           ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    function checkForm(id) {
        // Fetching values from all input fields and storing them in variables.
        var inputTelefone = document.getElementById("inputTelefone").value;
        if(inputTelefone.length >= 11){
            document.getElementById("emitir"+id).submit();
        }else{
            $msg = 'Telefone inválido, complete o telefone com o DDD e os 9 dígitos principais';
            alert($msg);
        }
    }

    </script>
<?php
include('../../includes/footer.php');
?>
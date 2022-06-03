<?php
    echo '<div>';
        for ($codigo=401; $codigo < 1000; $codigo++) { 
            $aux = 'qr_img0.50j/php/qr_img.php?';
            $aux .= 'd='.$codigo.'&';
            $aux .= 'e=H&';
            $aux .= 's=4&';
            $aux .= 't=P';
            echo ('<img src="'.$aux.'" alt="" width="200px">');                            
        }
    echo '</div>';
?>

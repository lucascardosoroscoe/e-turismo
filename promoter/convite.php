<?php
    include_once '../promoter/includes/header.php';
session_start();
/*session created*/
$promoter  =  $_SESSION["promoter"];
$atividade =  $_SESSION["atividade"];
$produtor  =  $_SESSION["produtor"];
$evento =  $_SESSION["evento"];
if ($atividade == "VALIDO"){
    
    echo ('<div class="row">');
            echo ('<div class="col s12 m6 push-m3 ">');
                echo ('<img src="includes/logo.png"class="logo">');
                echo ('<h3>INGRESSOZAPP</h3>');
                echo ('<b>Envie seu convite exclusivo em grupos e por mensagem para que o cliente possa adquirir seu ingresso online:<br></b>');
                $id = getId($evento, $promoter);
                $link = 'https://ingressozapp.com/convite/id=' . $id;
                echo ('<a href="' . $link . '"><h6>' . $link . '</h6></a>');
                echo ('<input type="hidden" value="' . $link . '" id="link">');
                echo ('<br><button id="compartilhar" class="btn">Copiar Link</button>');

                echo ('<a href="https://ingressozapp.com/promoter/" style="margin-top: 21px;" class="btn">Voltar</a>');
            echo ('</div>');
        echo ('</div>');


} else {
    header('Location: https://ingressozapp.com/promoter/login/');
}

function getId($evento, $promoter){
    include('includes/db_valores.php');
    $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);

    $consulta = "SELECT `id` FROM `Convite` WHERE `evento` = '$evento' AND `promoter` = '$promoter'";

    $gravacoes = mysqli_query($conexao, $consulta);
    $dados = array();
    while($linha = mysqli_fetch_assoc($gravacoes)){
        $dados[] = $linha; 
    }

    
    $id = $dados[0]['id'];
    if ($id != ''){
        return $id;
    }else{
        $consulta = "INSERT INTO `Convite`(`evento`, `promoter`) VALUES ('$evento', '$promoter')";
        
        if(mysqli_query($conexao, $consulta)){
            $sucesso = 1;
            $consulta = "SELECT `id` FROM `Convite` WHERE `evento` = '$evento' AND `promoter` = '$promoter'";
            
            $gravacoes = mysqli_query($conexao, $consulta);
            $dados = array();
            while($linha = mysqli_fetch_assoc($gravacoes)){
                $dados[] = $linha; 
            }

            $id = $dados[0]['id'];
            if ($id != ''){
                return $id;
            }
        }else{echo "erro";}
    }   
}

?>

<script>
  function copiarTexto() {
    var textoCopiado = document.getElementById("link");
    textoCopiado.select();
    document.execCommand("Copy");
    alert("Link Copiado: " + textoCopiado.value);
  }
  const shareData = {
  title: 'MDN',
  text: 'Learn web development on MDN!',
  url: 'https://developer.mozilla.org',
    }

    const btn = document.getElementById('compartilhar');

// Must be triggered some kind of "user activation"
btn.addEventListener('click', async () => {
  try {
    await navigator.share(shareData)
    alert("Ok");
  } catch(err) {
    alert("erro:" + err)
  }
});

</script>

<?php
include_once '../promoter/includes/footer.php';
?>
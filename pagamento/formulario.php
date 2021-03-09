<?php
    include_once 'header.php';
    session_start();
    /*session created*/
    $produtor  =  $_SESSION["usuario"];
    $validade =  $_SESSION["validade"];

    $cemail    = "lucascardosoroscoe@gmail.com";
    $cnome     = "Lucas Cardoso Roscoe";
    $ccpf      = "140.027.396-39";
    $cendereco = "Rua José Antônio, 1123";
    $cbairro   = "Centro";
    $ccidade   = "Campo Grande";
    $cuf       = "MS";
    $ccep      = "79002401";
    $cvalor    = "100.00";
?>

<div class="row">
    <div class="col s12 m6 push-m3 ">
      <form name="formulario" onsubmit="Reservar.disabled=true;" id="formulario" method="POST" action="comprar.php">
          <input style="display:none;" name="cemail"    type="text"      id="cemail"    value="<?php echo $cemail;?>"/>
          <input style="display:none;" name="cnome"     type="text"      id="cnome"  value="<?php echo $cnome;?>"/>
          <input style="display:none;" name="ccpf"      type="text"      id="ccpf"      value="<?php echo $ccpf;?>"/>
          <input style="display:none;" name="cendereco" type="text"      id="cendereco" value="<?php echo $cendereco;?>"/>
          <input style="display:none;" name="cbairro"   type="text"      id="cbairro"   value="<?php echo $cbairro;?>"/>
          <input style="display:none;" name="ccidade"   type="text"      id="ccidade"   value="<?php echo $ccidade;?>"/>
          <input style="display:none;" name="cuf"       type="text"      id="cuf"       value="<?php echo $cuf;?>"/>
          <input style="display:none;" name="ccep"      type="number"    id="ccep"      value="<?php echo $ccep;?>"/>
          <input style="display:none;" name="cvalor"    type="number"    id="cvalor"    value="<?echo $cvalor;?>" step="0.01"/>
          <input style="display:none;" name="cparcelas" type="number" id="cparcelas" value="1"/>

<div>
<span style="font-size: 40px;color:#000;">Dados do Cartão de Crédito</span><br>
</div>
<br>
    <div class="input-field col s12">
      <input name="cnumerocartao" type="number" id="cnumerocartao" required />
      <label for="cnumerocartao">Número do Cartão</label>  
    </div>
    <div class="input-field col s12">
      <input name="cnomecartao" type="text" id="cnomecartao" required />
      <label for="cnomecartao">Nome do Cartão</label>  
    </div>
    <div class="input-field col s12">
      <input name="cvv" type="number" id="cvv" required />
      <label for="cvv">Código de Segurança (CVV)</label>  
    </div>
    <div class="input-field col s12">
      <input name="cmes" type="number" id="cmes" required />
      <label for="cmes">Validade Mês (MM)</label>  
    </div>
    <div class="input-field col s12">
      <input name="cano" type="number" id="cano" required />
      <label for="cano">Validade Ano (AAAA)</label>  
    </div>

<br>
<div id="status"></div>
<br>
<input name="Reservar" type="submit" id="Reservar" value="Comprar" class="btn">
<br>

</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>

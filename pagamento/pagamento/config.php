<?php

$is_sandbox = true;

$sandbox = [
  'client_id' => 'Client_Id_c04d4d8787ded1bc4d8dd3c5433c361718d7ef5e',
  'client_secret' => 'Client_Secret_27f72458b2fd5c61469ea6ddc3d0f4188079d658',
  'sandbox' => true 
];
$producao = [
    'client_id' => 'Client_Id_69c6d3fa0a7559fecc8a1c099c23fdd60762ae8d',
    'client_secret' => 'Client_Secret_6b2e17c056125424a41ef07d18c7d9474ca59dd1',
    'sandbox' => false 
];
if($is_sandbox){
    $options = $sandbox;
}else{
    $options = $producao;
}

?>
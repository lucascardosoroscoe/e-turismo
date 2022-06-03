<?php
include('../app/includes/header.php');
?>
<!-- <div class="header">
    <img src="../app/img/logoEscura.png" id="logo" style="margin: auto;"></div>
</div> -->
<!-- <div class="body"> -->
    <div id="reader" width="600px"></div>
<!-- </div> -->
<!-- <div class="footer">

</div> -->
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
var status = 0;
function onScanSuccess(decodedText, decodedResult) {
    var link = 'https://ingressozapp.com/portaria/index.php?codigo=' + decodedText;
    if (status == 0){
        status = 1;
        setTimeout(abrir(link), 2000);
    }else{
        setTimeout(mudarStatus(), 2000);
    }    
}
function mudarStatus(){
    status = 0;
}
function abrir(link){
        window.open(link, "_blank"); 
}
function onScanFailure(error) {
// handle scan failure, usually better to ignore and keep scanning.
// for example:
console.warn(`Code scan error = ${error}`);
}

let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    { fps: 2, qrbox: {width: 500, height: 500} },
    false);

html5QrcodeScanner.render(onScanSuccess, onScanFailure);


</script>
<style>
    /* button {
        font-size: 30px;
    }
    span {
        font-size: 30px;    
    }
    img {
        width: 400px;
    }
    select {
        font-size: 30px;    
    }
    input {
        font-size: 430px;
    }
    #reader__dashboard_section_swaplink {
        display: none;
    } */
</style>
<?php
include('../app/includes/footer.php');
?>

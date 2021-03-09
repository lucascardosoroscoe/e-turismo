
function selecionarEvento(){
    var evento = document.getElementById('evento').value;
    window.location.replace("mudEvento.php?evento="+evento);
}

function selecionarPromoter(){
    var promoter = document.getElementById('promoter').value;
    window.location.replace("mudPromoter.php?promoter="+promoter);
}
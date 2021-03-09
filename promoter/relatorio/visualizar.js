
function selecionarEvento(){
    var evento = document.getElementById('evento').value;
    window.location.replace("mudEvento.php?evento="+evento);
}
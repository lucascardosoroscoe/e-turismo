/*!
    * Start Bootstrap - SB Admin v6.0.2 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2020 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
(function($) {
    "use strict";

    // Add active state to sidbar nav links
    var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
        $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function() {
            if (this.href === path) {
                $(this).addClass("active");
            }
        });

    // Toggle the side navigation
    $("#sidebarToggle").on("click", function(e) {
        e.preventDefault();
        $("body").toggleClass("sb-sidenav-toggled");
    });
})(jQuery);

$(function(){
	$('.tablesorter').tablesorter();
});
var inputEvento = document.getElementById('selectEvento');
var inputVendedor = document.getElementById('selectVendedor');
var inputLote   = document.getElementById('selectLote');

//Script Selecionar Evento
function selectevento(id){
    var idEvento = inputEvento.value;
    var url = window.location.href;
    var nomeEvento = inputEvento.options[inputEvento.selectedIndex].text;
    window.location = "http://ingressozapp.com/app/assets/selecionarEvento.php?idEvento="+ idEvento + "&nomeEvento=" + nomeEvento + "&u=" + url;
}
function selectVendedor(id){
    var idVendedor = inputVendedor.value;
    var url = window.location.href;
    var nomeVendedor = inputVendedor.options[inputVendedor.selectedIndex].text;
    window.location = "http://ingressozapp.com/app/assets/selecionarVendedor.php?idVendedor="+ idVendedor + "&nomeVendedor=" + nomeVendedor + "&u=" + url;
}

//Script Selecionar Evento
function selectlote(id){
    var idLote = inputLote.value;
    var url = window.location.href;
    window.location = "http://ingressozapp.com/app/assets/selecionarLotes.php?idLote="+ idLote + "&u=" + url;
}

function adicionarlote() {
    var idEvento = inputEvento.value;
    if(idEvento == ""){
        alert("Você deve selecionar um evento antes de Adicionar um lote a ele");
    }else{
        window.location.href = "./adicionar.php?id=" + idEvento;
    }
}

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
var inputMsg = document.getElementById('inputMsg');

var clicado = 0;

//Script Selecionar Evento
function selectevento(id){
    var idEvento = inputEvento.value;
    var url = window.location.pathname;
    var nomeEvento = inputEvento.options[inputEvento.selectedIndex].text;
    window.location = "https://ingressozapp.com/app/assets/selecionarEvento.php?idEvento="+ idEvento + "&nomeEvento=" + nomeEvento + "&u=" + url;
}
function selectVendedor(id){
    var idVendedor = inputVendedor.value;
    var url = window.location.href;
    var nomeVendedor = inputVendedor.options[inputVendedor.selectedIndex].text;
    window.location = "https://ingressozapp.com/app/assets/selecionarVendedor.php?idVendedor="+ idVendedor + "&nomeVendedor=" + nomeVendedor + "&u=" + url;
}

//Script Selecionar Evento
function selectlote(id){
    var idLote = inputLote.value;
    var url = window.location.href;
    window.location = "https://ingressozapp.com/app/assets/selecionarLotes.php?idLote="+ idLote + "&u=" + url;
}

//Mensagem Automação
function modificarMsg(){
    var msg = inputMsg.value;
    var url = window.location.href;
    window.location = "https://ingressozapp.com/app/assets/definirMsg.php?msg="+ msg + "&u=" + url;
}

function adicionarlote() {
    var idEvento = inputEvento.value;
    if(idEvento == ""){
        alert("Você deve selecionar um evento antes de Adicionar um lote a ele");
    }else{
        window.location.href = "./adicionar.php?id=" + idEvento;
    }
}

function enviarForm(){ 
    if(clicado == 0){
        document.getElementsByTagName("form")[0].submit;
        if(document.getElementById('inputName').value!=''||document.getElementById('selectEstilo').value!=''||document.getElementById('inputData').value!=''){
            clicado = 1;
            document.body.style.cursor = 'wait';
            setTimeout(ativarButton, 15000);
            try {
                document.getElementById('addEvento').textContent = 'Criando evento, não recarregue a página,  pode levar algum tempo';
            } catch (error) {
                console.log(error);
            }
        }
    }else{
        alert("Aguarde para clicar novamente");
    }
}

function voltarTexto(){
    try {
        document.getElementById('addEvento').textContent = 'Criar Evento';
    } catch (error) {
        console.log(error);
    }
}
function ativarButton() {
    clicado = 0;
    document.body.style.cursor = 'default';
}


var inputFonte = document.getElementById('selectFonte');
function selectfonte(){
    var fonte = inputFonte.value;
    if (fonte == 'Banner/Flyer/Impressos'){
        exibirMedium();
        mudarTexto('Breve Descrição do artigo Impresso (opcional)', 'Ex: Flyer Principal');
    }else if (fonte == 'Disparo Whatsapp'||fonte == 'Disparo E-mail'){
        exibirMedium();
        mudarTexto('Nome da Lista (opcional)', 'Ex: Clientes Evento Anterior');
    }else if (fonte == 'Facebook/Instagram Orgânico'){
        exibirMedium();
        mudarTexto('Perfil (opcional)', 'Ex: Instagram @ingressozapp');
    }else if (fonte == 'Facebook/Instagram Impulsionamento'){
        ocultarMedium();

    }else if (fonte == 'Google/Youtube Ads'){
        ocultarMedium();

    }else if (fonte == 'Linktree'){
        exibirMedium();
        mudarTexto('Perfil (opcional)', 'Ex: Linktree @ingressozapp');
    }else if (fonte == 'Outdoor'){
        exibirMedium();
        mudarTexto('Localização (opcional)', 'Ex: Afonso Pena');
    }else if (fonte == 'Tik Tok'){
        exibirMedium();
        mudarTexto('Perfil (opcional)', 'Ex: Tik Tok @ingressozapp');
    }
}
function mudarTexto(descricao, placeholder){
    document.getElementById('labelMedium').innerHTML = descricao;
    document.getElementById('inputMedium').placeholder = placeholder;
}

function exibirMedium(){
    document.getElementById('divMedium').style.display = 'block';
}
function ocultarMedium(){
    document.getElementById('divMedium').style.display = 'none';
}
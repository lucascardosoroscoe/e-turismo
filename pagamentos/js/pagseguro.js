function alerta(tipo, titulo, texto) {
  if (tipo == "error") {
      var classe = "bg-danger-400"
  }
  if (tipo == "success") {
      var classe = "bg-teal-400"
  }
  const wrapper = document.createElement('div');
  wrapper.innerHTML = texto;
  swal({
      title: titulo,
      content: wrapper,
      icon: tipo,
      button: {
          text: "Ok",
          closeModal: !0,
          className: classe
      }
  })
}

function blockEl(el, br, txt) {
  if (br) {
      var border_radius = br
  } else {
      var border_radius = "0px"
  }
  if (txt) {
      var txto = txt
  } else {
      var txto = ""
  }
  if (el != "body") {
      $(el).block({
          message: '<i class="icon-spinner2 spinner"></i><br /><span class="txtBlockEl">' + txto + '</span>',
          overlayCSS: {
              backgroundColor: '#fff',
              borderRadius: border_radius,
              opacity: 0.8,
              cursor: ''
          },
          css: {
              border: 0,
              padding: 0,
              backgroundColor: 'none'
          }
      })
  } else {
      $.blockUI({
          message: '<i class="icon-spinner2 spinner"></i><br /><span class="txtBlockEl">' + txto + '</span>',
          overlayCSS: {
              backgroundColor: '#fff',
              opacity: 0.8,
              cursor: ''
          },
          css: {
              border: 0,
              padding: 0,
              backgroundColor: 'none'
          }
      })
  }
}

function unblockEl(el) {
  $(el).unblock()
}

function mostrar_erros(response) {
    var errosCartao = '';
    var promises = [];
    $.each(response, function(key, value) {
        promises.push(errosCartao += "<li>"+value+"</li>");
    });
    $.when.apply($, promises).then(function() {
        alerta("error", "Erro", errosCartao);
    });
}

(function() {
    var language = {
        delimiters: {
            thousands: '.',
            decimal: ','
        },
        abbreviations: {
            thousand: 'mil',
            million: 'milhões',
            billion: 'b',
            trillion: 't'
        },
        ordinal: function(number) {
            return 'º'
        },
        currency: {
            symbol: 'R$'
        }
    };
    if (typeof module !== 'undefined' && module.exports) {
        module.exports = language
    }
    if (typeof window !== 'undefined' && this.numeral && this.numeral.language) {
        this.numeral.language('pt-br', language)
    }
}());

function processar_pagamento_via_cartao(total, parcelas, bandeira, token, hash) {
    blockEl("body", "0px", "Autorizando...");
    PagSeguroDirectPayment.getInstallments({
        amount: total,
        brand: bandeira,
        success: function(response) {

          var valor_parcela      = response.installments[bandeira][parcelas-1]['installmentAmount'];
          var nome               = $('#cartao_nome').val();
          var cpf                = $('#cartao_cpf').val();
              cpf                = cpf.replace(/\D/g, '');
          var data_nascimento    = $('#cartao_data_nascimento').val();
          var numero_celular     = $('#cartao_celular').val();
          var cel                = numero_celular.split(")");
          var ddd                = cel[0];
              ddd                = ddd.replace(/\D/g, '');
          var celular            = cel[1];
              celular            = celular.replace(/\D/g, '');
          var forma_de_pagamento = $('#forma_de_pagamento').val();
          var id_transacao       = $('#id_transacao').val();
          var descricao          = $('#descricao').val();

          var postdata = {id_transacao:id_transacao, token:token, bandeira:bandeira, parcelas:parcelas, descricao:descricao, hash:hash, valor_parcela:valor_parcela, total:total, forma_de_pagamento:forma_de_pagamento, nome_titular:nome, cpf_titular:cpf, data_nascimento_titular:data_nascimento, ddd_titular:ddd, celular_titular:celular};

            $.ajax({
                url: 'script.php',
                type: 'POST',
                data: postdata,
                timeout: 30000,
                error: function(xhr, ajaxOptions, errorThrown) {
                     unblockEl("body");
                    if (errorThrown == "timeout") {
                        alerta("error", "Timeout!", "Tempo limite excedido. Se você está usando o modo Sandbox esse erro é natual, pois em alguns momentos do dia o Sandbox PagSeguro apresenta lentidão ou completa indisponibilidade.")
                    }
                    if (xhr.status == 404) {
                        alerta("error", "404", "Página não encontrada.")
                    }
                },
                success: function(data) {
                    var r = $.parseJSON(data);
                    var status = r.estatus;
                    var mensagem = r.estatusTexto;
                    if (status == "sucesso") {
                        unblockEl("body");
                        alerta("success", "Sucesso", mensagem);
                        $("#div_logos_bandeiras").addClass("hidden");
                        $(".card_pagamento").addClass("hidden");
                        $(".valor_cobrado").addClass("hidden");
                        $(".card_sucesso").removeClass("hidden");
                        $(".card_sucesso_txt").html(mensagem);
                    } else {
                        unblockEl("body");
                        alerta("error", "Erro ao processar o pagamento.", mensagem);
                    }
                }
            })
        },
        error: function(response) {
            unblockEl("body");
            mostrar_erros(response.errors);
        }
    })
}

function gerar_token(numero, bandeira, cvv, validade_mes, validade_ano, hash) {
  blockEl("body", "0px", "Gerando token...");
    PagSeguroDirectPayment.createCardToken({
        cardNumber: numero,
        brand: bandeira,
        cvv: cvv,
        expirationMonth: validade_mes,
        expirationYear: validade_ano,
        success: function(response) {
            var token = response.card.token;
            var total           = $("#total").val();
            var cartao_parcelas = $("#cartao_parcelas").val();
            var parcelas = (cartao_parcelas == 1) ? 1 : cartao_parcelas;
            processar_pagamento_via_cartao(total, parcelas, bandeira, token, hash)
        },
        error: function(response) {
            unblockEl("body");
            mostrar_erros(response.errors);
        }
    })
}

$(document).ready(function() {

  $(".img-banco").on("click", function(e) {
    var id_banco = e.target.id;
    $(".img-banco").removeClass("selecionado");
    $(this).addClass("selecionado");
  $("#banco").val(id_banco);
  });

  $("#tab_cartao").on("click", function(){
    $("#forma_de_pagamento").val("Cartão");
  });

  $("#tab_boleto").on("click", function(){
    $("#forma_de_pagamento").val("Boleto");
  });

  $("#tab_debito").on("click", function(){
    $("#forma_de_pagamento").val("Débito");
  });

    $("#cartao_celular").inputmask2('(99) 9 9999-9999', {
      showMaskOnFocus: false,
      showMaskOnHover: false,
      clearMaskOnLostFocus: true
    });

    $("#cartao_cpf").inputmask2('999.999.999-99', {
      showMaskOnFocus: false,
      showMaskOnHover: false,
      clearMaskOnLostFocus: true
    });

    $("#cartao_data_nascimento").inputmask2('99/99/9999', {
      showMaskOnFocus: false,
      showMaskOnHover: false,
      clearMaskOnLostFocus: true
    });

    $("#cartao_numero").inputmask2('9999 9999 9999 9999', {
      showMaskOnFocus: false,
      showMaskOnHover: false,
      clearMaskOnLostFocus: true
    });

    $("#cartao_validade").inputmask2('99/9999', {
      showMaskOnFocus: false,
      showMaskOnHover: false,
      clearMaskOnLostFocus: true
    });

    var id_transacao    = $('#id_transacao').val();
    var total           = $('#total').val();
    var descricao       = $('#descricao').val();

    $.ajax({
        url: 'sessao.php',
        type: 'POST',
        dataType: 'json',
        timeout: 30000,
        error: function(xhr, ajaxOptions, errorThrown) {
             unblockEl("body");
            if (errorThrown == "timeout") {
                alerta("error", "Timeout!", "Tempo limite excedido. Se você está usando o modo Sandbox esse erro é natual, pois em alguns momentos do dia o Sandbox PagSeguro apresenta lentidão ou completa indisponibilidade.");
            }
            if (xhr.status == 404) {
                alerta("error", "404", "Página não encontrada.");
            }
        },
        success: function(data) {
            var id_sessao = data.id;
            PagSeguroDirectPayment.setSessionId(id_sessao);
            PagSeguroDirectPayment.getPaymentMethods({
                success: function(response) {
                    var logos_bandeiras = '';
                    var options_bandeiras = '';
                    $.each(response.paymentMethods.CREDIT_CARD.options, function(key, value) {
                        var nome_bandeira = value.name;
                            nome_bandeira_lowwer = nome_bandeira.toLowerCase();
                        options_bandeiras += '<option value=' + nome_bandeira + '>' + nome_bandeira + '</option>';
                        logos_bandeiras += '<div data-bandeira="'+nome_bandeira+'" class="img_bandeira ' + nome_bandeira_lowwer + '"><img src="https://stc.pagseguro.uol.com.br/' + value.images.MEDIUM.path + ' " /></div>';
                    });
                    $("#div_logos_bandeiras").html(logos_bandeiras);
                    $(".img_bandeira").on("click", function(){
                      if($("#tab_cartao").hasClass("active")){
                      var bandeira = $(this).data("bandeira");
                      $("#cartao_bandeira").val(bandeira).trigger("change");
                      }
                    });
                    options_bandeiras = '<option value="">Selecione o cartão</option>' + options_bandeiras;
                    $("#cartao_bandeira").html(options_bandeiras);
                }
            })
        }
    });

    //Início - Ação quando a bandeira do cartão é selecionada
    $("#cartao_bandeira").on('change', function() {
        var bandeira        = $(this).val().toLowerCase();
        var total           = $('#total').val();
        blockEl("body","0px", "Calculando parcelas...");
        PagSeguroDirectPayment.getInstallments({
            amount: total,
            brand : bandeira,
            success: function(response) {
                numeral.language('pt-br');
                var juros = '';
                var numero_parcelas = '';
                var installment = response.installments[bandeira];
                $.each(installment, function(key, value) {
                    juros = (value.interestFree == !0) ? 'sem juros' : 'com juros';
                    numero_parcelas += '<option value=' + value.quantity + '>' + value.quantity + 'x de ' + numeral(value.installmentAmount).format('$ 0,0.00') +' '+ juros +'</option>'
                });
                $("#cartao_parcelas").removeClass("hidden").html(numero_parcelas);
                $(".img_bandeira img").removeClass("active");
                $(".img_bandeira."+bandeira+" img").addClass("active");
                unblockEl("body");
            },
            error: function(response) {}
        })
    });
    //Fim - Ação quando a bandeira do cartão é selecionada

    //Iní­cio - Ação quando o botão de pagar é clicado
    $("#botao_pagar").on("click", function(event){
      event.preventDefault();
      var forma_de_pagamento = $("#forma_de_pagamento").val();

      blockEl("body", "0px", "Processando...");

      //Iní­cio - Pagamento via Boleto
      if(forma_de_pagamento == "Boleto"){

        var hash = PagSeguroDirectPayment.getSenderHash();

        $.ajax({
            cache: false,
            url: 'script.php',
            type: 'POST',
            data: {id_transacao:id_transacao, forma_de_pagamento:forma_de_pagamento, hash:hash, total:total, descricao:descricao},
            timeout: 10000,
            error: function(xhr, ajaxOptions, errorThrown) {
                 unblockEl("body");
                if (errorThrown == "timeout") {
                    alerta("error", "Timeout!", "Tempo limite excedido. Se você está usando o modo Sandbox esse erro é natual, pois em alguns momentos do dia o Sandbox PagSeguro apresenta lentidão ou completa indisponibilidade.")
                }
                if (xhr.status == 404) {
                    alerta("error", "404", "Pégina não encontrada.")
                }
            },
            success: function(data) {
                var r = $.parseJSON(data);
                var status = r.estatus;
                var mensagem = r.estatusTexto;
                if (status == "sucesso") {
                    unblockEl("body");
                    alerta("success", "Sucesso", mensagem);
                    $("#div_logos_bandeiras").addClass("hidden");
                    $(".card_pagamento").addClass("hidden");
                    $(".valor_cobrado").addClass("hidden");
                    $(".card_sucesso").removeClass("hidden");
                    $(".card_sucesso_txt").html(mensagem);
                } else {
                    unblockEl("body");
                    alerta("error", "Erro ao processar o pagamento", mensagem);
                }
            }
        })
      }
      //Fim - Pagamento via Boleto

      //Iní­cio - Pagamento via Débito
      if(forma_de_pagamento == "Débito"){

        var hash = PagSeguroDirectPayment.getSenderHash();
        var banco = $('#banco').val();

        $.ajax({
            cache: false,
            url: 'script.php',
            type: 'POST',
            data: {id_transacao:id_transacao, forma_de_pagamento:forma_de_pagamento, banco:banco, hash:hash, total:total, descricao:descricao},
            timeout: 10000,
            error: function(xhr, ajaxOptions, errorThrown) {
                 unblockEl("body");
                if (errorThrown == "timeout") {
                    alerta("error", "Timeout!", "Tempo limite excedido. Se você está usando o modo Sandbox esse erro é natual, pois em alguns momentos do dia o Sandbox PagSeguro apresenta lentidão ou completa indisponibilidade.")
                }
                if (xhr.status == 404) {
                    alerta("error", "404", "Pégina não encontrada.")
                }
            },
            success: function(data) {
                var r = $.parseJSON(data);
                var status = r.estatus;
                var mensagem = r.estatusTexto;
                if (status == "sucesso") {
                    unblockEl("body");
                    alerta("success", "Sucesso", mensagem);
                    $("#div_logos_bandeiras").addClass("hidden");
                    $(".card_pagamento").addClass("hidden");
                    $(".valor_cobrado").addClass("hidden");
                    $(".card_sucesso").removeClass("hidden");
                    $(".card_sucesso_txt").html(mensagem);
                } else {
                    unblockEl("body");
                    alerta("error", "Erro ao processar o pagamento", mensagem);
                }
            }
        })
      }
      //Fim - Pagamento via Débito

      //Início - Pagamento via Cartão
      if(forma_de_pagamento == "Cartão"){

        var err             = "";
        var hash            = PagSeguroDirectPayment.getSenderHash();

        var nome            = $('#cartao_nome').val();
        var cpf             = $('#cartao_cpf').val();
        var data_nascimento = $('#cartao_data_nascimento').val();
        var celular         = $('#cartao_celular').val();

        var numero          = $('#cartao_numero').val();
            numero          = numero.replace(/\s/g,'');
        var bandeira        = $('#cartao_bandeira').val();
        var cvv             = $('#cartao_cvv').val();
        var validade        = $('#cartao_validade').val();
        var val             = validade.split("/");
        var validade_mes    = val[0];
        var validade_ano    = val[1];

        if(!nome){ err = err + "<li>Digite o nome do titular do cartão</li>";}
        if(!celular){ err = err + "<li>Digite o celular do titular do cartão</li>";}
        if(!cpf){ err = err + "<li>Digite o CPF do titular do cartão</li>";}
        if(!data_nascimento){ err = err + "<li>Digite a data de nascimento do titular do cartão</li>";}
        if(!numero){ err = err + "<li>Digite o número do cartão</li>";}
        if(!validade){ err = err + "<li>Digite a data de validade do cartão</li>";}
        if(!cvv){ err = err + "<li>Digite o CVV (código verificador) que fica no verso do seu cartão</li>";}
        if(!bandeira){ err = err + "<li>Selecione a bandeira do cartão</li>";}

        if(err){
          alerta("error", "Erro ao processar o pagamento", err);
          unblockEl("body");
          return false;
        }

        var bin = numero.substring(0, 6);
            bin = parseInt(bin);

        PagSeguroDirectPayment.getBrand({
            cardBin: bin,
            success: function(response) {
                var bandeira = response.brand.name;
                gerar_token(numero, bandeira, cvv, validade_mes, validade_ano, hash);
            },
            error: function(response) {
                unblockEl("body");
                mostrar_erros(response.errors);
            }
        });
      }
      //Fim - Pagamento via Cartão
    });
    //Fim - Ação quando o botão de pagar é clicado
});

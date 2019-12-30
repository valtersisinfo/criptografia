$(document).ready(function() {

  // Funções de HASH
  $.ajax({
    url: "ajax.php",
    method: "POST",
    data: {
      PFuncao: "listarHash",
      PParametros: ""
    },
    dataType: "json",
    success: function(data, textStatus, jqXHR) {
      $("#SHash").html("");
      for (var i = 0; i < data.length; i++) {
        $("#SHash").append("<option>"+data[i]+"</option>");
      }
    }
  });

  // Ao escrever uma mensagem
  $("#IMensagem").on("keyup", function() {
    if ($("#IMensagem").val() != "") {
      $.ajax({
        url: "ajax.php",
        method: "POST",
        data: {
          PFuncao: "obterHash",
          PParametros: {
            hash: $("#SHash option:selected").html(),
            criptografar: $("#IMensagem").val()
          }
        },
        dataType: "json",
        success: function(data, textStatus, jqXHR) {
          $("#PResultadoHash").html("Quantidade de caracteres: " + data.length + "<br>" +
            "Hash: <b>" + data + "</b>");
        }
      });
    } else
      $("#PResultadoHash").html("");
  });

  // Ao escolher outro hash
  $("#SHash").on("change", function() {
    $("#IMensagem").trigger("keyup");
  });

  ////////////////////////////////////////////////////////////

  // Funções de Blowfish
  // Função de criptografia - Ao digitar a senha
  VTempo = "";
  $("#ISenha").on("keyup", function() {
    if ($("#ISenha").val() != "") {
      clearTimeout(VTempo);
      VTempo = setTimeout(function() {
        // Window Object Methods - atob e btoa
        // btoa - Codifica para base64
        // atob - Decodifica de base64
        var VInformacao = "Senha enviada para o servidor - btoa(\"" + $("#ISenha").val() + "\"): " + btoa($("#ISenha").val()) + "<br>";
        $.ajax({
          url: "ajax.php",
          method: "POST",
          data: {
            PFuncao: "criarSenha",
            PParametros: {
              senha: btoa($("#ISenha").val())
            }
          },
          dataType: "json",
          success: function(data, textStatus, jqXHR) {
            $("#PResultadoCriptografiaBlowfish").html(VInformacao + "Informação que deve ser salva no banco de dados: <b>" + data + "</b>");
            $("#IChave").val(data);
            $("#ISenha2").trigger("keyup");
          }
        });
      }, 1000);
    } else
      $("#PResultadoCriptografiaBlowfish").html("");
  });

  // Função de validação - Ao digitar a senha e/ou a chave
  $("#ISenha2").on("keyup", function() {
    if ($("#ISenha2").val() != "" && $("#IChave").val() != "") {
      clearTimeout(VTempo);
      VTempo = setTimeout(function() {
        // Window Object Methods - atob e btoa
        // btoa - Codifica para base64
        // atob - Decodifica de base64
        var VInformacao = "Senha enviada para o servidor - btoa(\"" + $("#ISenha2").val() + "\"): " + btoa($("#ISenha2").val()) + "<br>";
        $.ajax({
          url: "ajax.php",
          method: "POST",
          data: {
            PFuncao: "validarSenha",
            PParametros: {
              senha: btoa($("#ISenha2").val()),
              hash: $("#IChave").val()
            }
          },
          dataType: "json",
          success: function(data, textStatus, jqXHR) {
            if ($("#ISenha2").val() != "" && $("#IChave").val() != "") {
              if (data) $("#PResultadoValidarBlowfish").html("<b>Senha válida!</b>");
              else $("#PResultadoValidarBlowfish").html("<b>Senha inválida!</b>");
            }
          }
        });
      }, 1000);
    } else
      $("#PResultadoValidarBlowfish").html("");
  });

  $("#IChave").on("keyup", function() {
    $("#ISenha2").trigger("keyup");
  });

  ////////////////////////////////////////////////////////////

  // Select com metodos
  $.ajax({
    url: "ajax.php",
    method: "POST",
    data: {
      PFuncao: "listarMetodos",
    },
    dataType: "json",
    success: function(data, textStatus, jqXHR) {
      $("#SMetodo, #SMetodo2").html("");
      for (var i = 0; i < data.length; i++) {
        $("#SMetodo, #SMetodo2").append("<option>"+data[i]+"</option>");
      }
    }
  });

  $("#IEncriptar").on("keyup", function() {
    if ($("#IEncriptar").val() != "" && $("#IChave2").val() != "") {
      $.ajax({
        url: "ajax.php",
        method: "POST",
        data: {
          PFuncao: "encriptacaoSimetrica",
          PParametros: {
            encriptar: $("#IEncriptar").val(),
            chave: $("#IChave2").val(),
            metodo: $("#SMetodo option:selected").html()
          }
        },
        dataType: "json",
        success: function(data, textStatus, jqXHR) {
          $("#PResultadoEncriptacaoSimetrica").html("Encriptado: " + data);
          $("#IEncriptado").val(data);
          $("#IEncriptado").trigger("keyup");
        }
      });
    } else {
      $("#PResultadoEncriptacaoSimetrica").html("Encriptado: " + data);
    }
  });

  $("#IChave2").on("keyup", function() {
     $("#IChave3").val($(this).val());
     $("#IEncriptar").trigger("keyup");
  });

  $("#SMetodo").on("change", function() {
    $("#SMetodo2 option:contains(" + $("#SMetodo option:selected").html() + ")").prop("selected", true);
    $("#IEncriptar").trigger("keyup");
  });

  $("#IEncriptado").on("keyup", function() {
    if ($("#IEncriptado").val() != "" && $("#IChave3").val() != "") {
      $.ajax(
      {
        url: "ajax.php",
        method: "POST",
        data: {
          PFuncao: "descriptacaoSimetrica",
          PParametros: {
            encriptar: $("#IEncriptado").val(),
            chave: $("#IChave3").val(),
            metodo: $("#SMetodo2 option:selected").html()
          }
        },
        dataType: "json",
        success: function(data, textStatus, jqXHR){
          if (data != false) $("#PResultadoDescriptacaoSimetrica").html("Descriptografado: " + data);
          else $("#PResultadoDescriptacaoSimetrica").html("Mensagem e/ou chave está(ão) incorreta(s)!");
        }
      });

    } else {
      $("#PResultadoDescriptacaoSimetrica").html("Encriptado: " + data);
    }
  });

  $("#IChave3").on("keyup", function() {
     $("#IEncriptado").trigger("keyup");
  });

  $("#IEncriptar2").on("keyup", function() {
    $.ajax(
    {
      url: "ajax.php",
      method: "POST",
      data: {
        PFuncao: "encriptacaoAsciiHexadecimal",
        PParametros: {
          encriptar: $("#IEncriptar2").val(),
        }
      },
      dataType: "json",
      success: function(data, textStatus, jqXHR){
        $("#PResultadoEncriptacaoHexadecimal").html("Mensagem encriptada: " + data);
        $("#IEncriptado2").val(data);
        $("#IEncriptado2").trigger("keyup");
      }
    });
  });

  $("#IEncriptado2").on("keyup", function() {
    $.ajax(
    {
      url: "ajax.php",
      method: "POST",
      data: {
        PFuncao: "descriptacaoAsciiHexadecimal",
        PParametros: {
          encriptar: $("#IEncriptado2").val(),
        }
      },
      dataType: "json",
      success: function(data, textStatus, jqXHR){
        $("#PResultadoDescriptacaoHexadecimal").html("Mensagem descriptada: " + data);
      }
    });
  });

});
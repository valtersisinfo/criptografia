$(document).ready(function() {

  /* HASH */
  // Função para listar HASH
  $.ajax({
    url: "ajax.php",
    method: "POST",
    data: {
      PFuncao: "listarHash",
    },
    dataType: "json",
    success: function(data, textStatus, jqXHR) {
      $("#SHash").html("");
      for (var Vi = 0; Vi < data.listaHash.length; Vi++) {
        $("#SHash").append("<option>"+data.listaHash[Vi]+"</option>");
      }
    }
  });

  // Ação para obter HASH da mensagem digitada
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
          $("#PResultadoHash").html("Quantidade de caracteres: " + data.criptografado.length + "<br>" +
            "Hash: <b>" + data.criptografado + "</b>");
        }
      });
    } else
      $("#PResultadoHash").html("");
  });

  // Ação para trocar HASH da mensagem digitada
  $("#SHash").on("change", function() {
    $("#IMensagem").trigger("keyup");
  });

  /* Blowfish */
  // Função para criar uma chave
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
              senha: btoa($("#ISenha").val()),
            }
          },
          dataType: "json",
          success: function(data, textStatus, jqXHR) {
            $("#PChaveBlowfish").html(VInformacao + "Informação que deve ser salva no banco de dados: <b>" + data.chave + "</b>");
            $("#IChave").val(data.chave);
            $("#ISenha2").trigger("keyup");
          }
        });
      }, 1000);
    } else
      $("#PResultadoCriptografiaBlowfish").html("");
  });

  // Função para validar a senha com a chave
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
              chave: $("#IChave").val()
            }
          },
          dataType: "json",
          success: function(data, textStatus, jqXHR) {
            if ($("#ISenha2").val() != "" && $("#IChave").val() != "") {
              if (data.valida) $("#PResultadoValidarBlowfish").html(VInformacao + "<b>Senha válida!</b>");
              else $("#PResultadoValidarBlowfish").html(VInformacao + "<b>Senha inválida!</b>");
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

  /* Encriptação simétrica */
  // Função para listar Métodos
  $.ajax({
    url: "ajax.php",
    method: "POST",
    data: {
      PFuncao: "listarMetodos",
    },
    dataType: "json",
    success: function(data, textStatus, jqXHR) {
      $("#SMetodo, #SMetodo2").html("");
      for (var Vi = 0; Vi < data.listaMetodo.length; Vi++) {
        $("#SMetodo, #SMetodo2").append("<option>"+data.listaMetodo[Vi]+"</option>");
      }
    }
  });

  // Função para encriptar mensagem
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
          if (data.encriptada != false) {
            $("#PResultadoEncriptacaoSimetrica").html("Encriptado: " + data.encriptada);
            $("#IEncriptado").val(data.encriptada);
            $("#IEncriptado").trigger("keyup");
          }
          else
            $("#PResultadoEncriptacaoSimetrica").html("Este método não encrepita em seu servidor!");
        }
      });
    }
  });

  // Chave para encriptação
  $("#IChave2").on("keyup", function() {
     $("#IChave3").val($(this).val());
     $("#IEncriptar").trigger("keyup");
  });

  // Método para a encriptação
  $("#SMetodo").on("change", function() {
    $("#SMetodo2 option:contains(" + $("#SMetodo option:selected").html() + ")").prop("selected", true);
    $("#IEncriptar").trigger("keyup");
  });

  // Para desencriptar
  $("#IEncriptado, #IChave3").on("keyup", function() {
    if ($("#IEncriptado").val() != "" && $("#IChave3").val() != "") {
      $.ajax(
      {
        url: "ajax.php",
        method: "POST",
        data: {
          PFuncao: "descriptacaoSimetrica",
          PParametros: {
            desencriptar: $("#IEncriptado").val(),
            chave: $("#IChave3").val(),
            metodo: $("#SMetodo2 option:selected").html()
          }
        },
        dataType: "json",
        success: function(data, textStatus, jqXHR){
          if (data.desencriptada != false) $("#PResultadoDescriptacaoSimetrica").html("Descriptografado: " + data.desencriptada);
          else $("#PResultadoDescriptacaoSimetrica").html("Mensagem e/ou chave e/ou médoto está(ão) incorreta(s)!");
        }
      });
    }
  });

  // Método para desencriptar
  $("#SMetodo2").on("change", function() {
     $("#IEncriptado").trigger("keyup");
  });

  $("#IEncriptar2, #IChave4").on("keyup", function() {
    $.ajax(
    {
      url: "ajax.php",
      method: "POST",
      data: {
        PFuncao: "encriptacaoAsciiHexadecimal",
        PParametros: {
          encriptar: $("#IEncriptar2").val(),
          chave: $("#IChave4").val(),
        }
      },
      dataType: "json",
      success: function(data, textStatus, jqXHR){
        $("#PResultadoEncriptacaoHexadecimal").html("Mensagem encriptada: " + data.encriptada);
        $("#IEncriptado2").val(data.encriptada);
        $("#IEncriptado2").trigger("keyup");
      }
    });
  });

  $("#IChave4").on("keyup change", function() {
    $("#IChave5").val($(this).val());
  });

  $("#IEncriptado2, #IChave5").on("keyup", function() {
    $.ajax(
    {
      url: "ajax.php",
      method: "POST",
      data: {
        PFuncao: "descriptacaoAsciiHexadecimal",
        PParametros: {
          desencriptar: $("#IEncriptado2").val(),
          chave: $("#IChave5").val(),
        }
      },
      dataType: "json",
      success: function(data, textStatus, jqXHR){
        if (data.desencriptada != false) $("#PResultadoDescriptacaoHexadecimal").html("Descriptografado: " + data.desencriptada);
        else $("#PResultadoDescriptacaoHexadecimal").html("Mensagem e/ou chave está(ão) incorreta(s)!");
      }
    });
  });

  /* SALT */
  $("#IQuantidade").on("keyup", function() {
    if ($("#IQuantidade").val() != "") {
      $.ajax({
        url: "ajax.php",
        method: "POST",
        data: {
          PFuncao: "salt",
          PParametros: {
            quantidade: $("#IQuantidade").val(),
          }
        },
        dataType: "json",
        success: function(data, textStatus, jqXHR) {
          $("#PResultadoSalt").html("Salt: <b>" + data.salt + "</b>");
        }
      });
    } else
      $("#PResultadoHash").html("");
  });

});
$(document).ready(function() {
  $("#senha").on("keyup", function()
  {
    var criptografar = $(this).val();
    if (criptografar == "") {
      $("#validar").css("display", "none");
      $("#sha1").css("display", "none");
      $("#bcript").css("display", "none");
    } else {
      $("#validar").css("display", "block");
      $("#sha1").css("display", "block");
      $("#bcript").css("display", "block");
    }
    // btoa - Passa o que foi escrito para base64
    base64 = btoa(criptografar);
    $("#sha1").html("Enviado para o servidor - btoa(\""+criptografar+"\") = "+base64);
    $.ajax(
    {
      url: "src/criptografia.php",
      method: "POST",
      data: {
        funcao: "criptografar",
        parametros: {
          mensagem: base64
        }
      },
      dataType: "html",
      beforeSend: function(jqXHR, PlainObject){
        //console.log("jqXHR", jqXHR);
        //console.log("PlainObject", PlainObject);
      },
      success: function(data, textStatus, jqXHR){
        //console.log("data", data);
        //console.log("textStatus", textStatus);
        //console.log("jqXHR", jqXHR);
        $("#bcript").html("Informação para ser salva no banco de dados "+data);
      },
      error: function(jqXHR, textStatus, errorThrown){
        //console.log("jqXHR", jqXHR);
        //console.log("textStatus", textStatus);
        //console.log("errorThrown", errorThrown);
        console.log("Mensagem de erro", jqXHR.responseText);
      },
      complete: function(jqXHR, textStatus){
        //console.log("jqXHR", jqXHR);
        //console.log("textStatus", textStatus);
      }
    });
  });

  $("#valida").on("keyup", function()
  {
    var valida = $(this).val();

    $("#validar #sha1").css("display", valida == "" ? "none" : "block");

    // btoa - Passa o que foi escrito para base64
    base64 = btoa(valida);
    $("#validar #sha1").html("Enviado para o servidor - btoa(\""+valida+"\") = "+base64);
    $.ajax(
    {
      url: "src/criptografia.php",
      method: "POST",
      data: {
        funcao: "validar",
        parametros: {
          mensagem: base64
        }
      },
      dataType: "json",
      beforeSend: function(jqXHR, PlainObject){
        //console.log("jqXHR", jqXHR);
        //console.log("PlainObject", PlainObject);
      },
      success: function(data, textStatus, jqXHR){
        //console.log("data", data);
        //console.log("textStatus", textStatus);
        //console.log("jqXHR", jqXHR);
        if (data) $("#resultado").html("Está foi a mensagem criptografada");
        else $("#resultado").html("Está não foi a mensagem criptografada");
      },
      error: function(jqXHR, textStatus, errorThrown){
        //console.log("jqXHR", jqXHR);
        //console.log("textStatus", textStatus);
        //console.log("errorThrown", errorThrown);
        console.log("Mensagem de erro", jqXHR.responseText);
      },
      complete: function(jqXHR, textStatus){
        //console.log("jqXHR", jqXHR);
        //console.log("textStatus", textStatus);
      }
    });
  });

});
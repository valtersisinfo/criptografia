<?php

include	"../biblioteca/criptografia.php";

function ajax()
{
  $VFunc = $_POST["PFuncao"];
  $VArgs = [];
  if (isset($_POST["PParametros"]))
    if (!empty($_POST["PParametros"]))
      $VArgs = $_POST["PParametros"];

  $VResult = call_user_func_array($VFunc, $VArgs);

  echo json_encode($VResult);
  exit;
}

ajax();

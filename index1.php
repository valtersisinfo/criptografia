<?php

  $criptografar = "este texto";
  echo "<h3>Primeiro é necessário saber o que deve ser criptografado. Neste exemplo criptografaremos: '$criptografar'</h3>";

  echo "<h3>Vamos começar pelo <a href='https://pt.wikipedia.org/wiki/Fun%C3%A7%C3%A3o_hash'>HASH</a></h3>";

  $sha1 = sha1($criptografar);
  $md5 = md5($criptografar);

  echo "<p>Na internet é fácil achar exemplos de <a href='https://pt.wikipedia.org/wiki/SHA-1'>SHA-1</a> ( $sha1 ) e <a href='https://pt.wikipedia.org/wiki/MD5'>MD5</a> ( $md5 )";

  echo "<p>Mas poucos falam que existe todos estes hashes para serem ultilizados:</p><table>";

  $hash = hash_algos();
  for ($i=0; $i < count($hash); $i++) {
    echo "<tr><td>".$hash[$i]."</td><td>:</td><td>".hash($hash[$i], $criptografar)."</td></tr>";
  }

  echo "</table>";

  echo "<h3>O HASH sozinho não é seguro. Vamos falar um pouco de <a href='https://pt.wikipedia.org/wiki/Sal_(criptografia)'>SALT</a></h3>";

  $digitos = rand(18, 100);
  echo "<p>1º Definir o tamanho do salt em dígitos: Que tal $digitos digitos?</p>";

  $amostra = array_merge(range('a','z'), range('A','Z'), range(0,9));
  echo "<p>2º Criar um array de amostra com letras de 'a' a 'Z' e números de '0' a '9' ( ";

  for ($i=0; $i < count($amostra); $i++) {
    echo $amostra[$i];
  }

  echo " )</p>";

  echo "<p>3º Embaralhar o array amostra, pegar um item randômico do mesmo e criar o salt";
  $salt = "";
  for ( $i = 0; $i < $digitos; $i++ ){
    shuffle($amostra);
    $salt .= $amostra[array_rand($amostra)];
  }
  echo " ( $salt )</p>";

  echo "<h3>O HASH e o SALT ja ajudam, mas é bom criar uma chave.</h3>";

  $maiorpalavraportuguesa = "pneumoultramicroscopicossilicovulcanoconiótico";

  $amostra = array_merge(range('a','z'), range('A','Z'), range(0,9));
  $salt = "";
  for ( $i = 0; $i < 1024; $i++ ){
    shuffle($amostra);
    $salt .= $amostra[array_rand($amostra)];
  }

  $chave = hash("sha512", $maiorpalavraportuguesa).hash("sha512", $salt);
  $chave = hash("sha512", $chave);

  echo "<p>A chave deveria ser única e conhecida por ti, mas se quiser pode usar: $chave</p>";

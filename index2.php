<?php

  echo "<h3>Encriptar!</h3>";

  // Senha digitada
  $senha = "O rato roeu a roupa do rei de roma";
  echo "<b>Senha digitada: </b>".$senha."<br>";

  // Senha recebida da página
  // SHA1 - Hash de 20 bytes - 40 caracteres
	
  $sha1 = sha1($senha);
  echo "<b>sha1: </b>".$sha1."<br>";

  // SHA2 - SHA512 -Hash de 64 bytes - 128 caracteres
  $sha512 = hash("sha512", $sha1);
  echo "<b>sha512: </b>".$sha512."<br>";

  // Custo
  // Custo pode ser de 04 a 31 - Deve ter 2 dígitos
  // Custo é a potência de 2, ou seja, quanto maior o custo, maior a segurança e a demora
  // 13 - https://www.dicionariodesimbolos.com.br/numero-13/
  // 2¹³ = 8.192 ciclos
  $custo = "13";
  echo "<b>Custo 2<sup>".$custo."</sup>: </b>".pow(2, $custo)." ciclos<br>";

  // Salt dinâmico
  // Salt deve conter 22 caracteres (bcrypt)
  // Defino salt sem informação
  $salt = "";
  // Defino o tamanho do salt
  $tamanhoSalt = 22;
  // Cria um array de amostra com 62 caracteres (a-z, A-Z, 0-9)
  $amostra = array_merge(range("a", "z"),range("A", "Z"),range("0", "9"));
  // Embaralho a amosta
  shuffle($amostra);
  // Obtenho elementos aleatórios da amostra
  $aleatorio = array_rand($amostra, $tamanhoSalt);
  // For para pegar letras e números para o $salt
  for ($i = 0; $i < $tamanhoSalt; $i++){
    // Pego um itens aleatórios da amostra e incluo no salt
    $salt .= $amostra[$aleatorio[$i]];
  }
  echo "<b>salt: </b>".$salt."<br>";
  // $2a$ = Codificação Blowfish para obter 64 caracteres
  $bcrypt = crypt($sha512, "$2a$".$custo."$".$salt."$");
  echo "<b>Blowfish Crypt: </b>".$bcrypt."<br>";

  echo "<h3>Validar!</h3>";

  
  echo "<b>Senha digitada: </b>".$senha."<br>";

  // Senha recebida da página
  // SHA1 - Hash de 20 bytes - 40 caracteres
  $sha1 = sha1($senha);
  echo "<b>sha1: </b>".$sha1."<br>";

  // Hash de 64 bytes - 128 caracteres
  $sha512 = hash("sha512", $sha1);
  echo "<b>sha512: </b>".$sha512."<br>";

  $salvoNoBanco = '$2a$13$sXuohPnD3zUTmvK8B02CJuZzBhbgc.40yAopxsNyXTTG79ltdu336';
  echo "<b>Salvo no banco: </b>".$salvoNoBanco."<br>";

  echo "<b>Resultado: </b>";
  if (crypt($sha512, $salvoNoBanco) === $salvoNoBanco) echo "Está senha foi validada!";
  else echo "Está senha não foi validada!";

  echo '<h3>Todos os hash com a senha "'.$senha.'"</h3>';

  echo "<table><tbody>";
  foreach (hash_algos() as $hash)
  {
    $hash_result = hash($hash, $senha);
    echo "<tr><td><b>".$hash."</b></td><td>".strlen($hash_result)."</td><td>".$hash_result."</td></tr>";
  }
  echo "</tbody></table>";
?>
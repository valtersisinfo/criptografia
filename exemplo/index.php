<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Criptografia - Exemplo</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


  <script src="script.js"></script>
</head>
<body>

  <?php

    $mensagem = "O rato roeu a roupa do rei de roma";

  ?>

  <div class="container-fluid">
    <div class="row">

      <div class="col-12">
        <div class="card mt-2">
          <div class="card-header text-center bg-danger text-white">
            Criptografar com <b>HASH</b>
          </div>
          <div class="card-body">
            <div class="form-group row">
              <label for="IMensagem" class="col-form-label col-form-label-sm col-5">Mensagem: </label>
              <div class="col-7">
                <input id="IMensagem" type="text" class="form-control form-control-sm" aria-describedby="HMensagem" placeholder="Ex. <?php echo $mensagem ?>">
                <small id="HMensagem" class="form-text text-muted text-right">Digite uma mensagem.</small>
              </div>
            </div>
            <div class="form-group row">
              <label for="SHash" class="col-form-label col-form-label-sm col-5">Escolha um hash: </label>
              <div class="col-7">
                <select id="SHash" class="form-control form-control-sm" aria-describedby="HHash" placeholder="Ex. <?php echo $mensagem ?>"></select>
                <small id="HHash" class="form-text text-muted text-right">Escolha um hash.</small>
              </div>
            </div>
            <p id="PResultadoHash" class="text-center"></p>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-6">
        <div class="card mt-2">
          <div class="card-header text-center bg-warning">
            Criptografar senha com <b>BCript</b> (<b>Blowfish</b>)
          </div>
          <div class="card-body">
            <div class="form-group row">
              <label for="ISenha" class="col-form-label col-form-label-sm col-5 col-md-4">Senha: </label>
              <div class="col-7 col-md-8">
                <input id="ISenha" type="password" class="form-control form-control-sm" aria-describedby="HSenha" placeholder="Ex. <?php echo $mensagem ?>">
                <small id="HSenha" class="form-text text-muted text-right">Digite uma senha.</small>
              </div>
            </div>
            <p id="PResultadoCriptografiaBlowfish" class="text-center"></p>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-6">
        <div class="card mt-2">
          <div class="card-header text-center bg-warning">
            Validar senha - <b>BCript</b> (<b>Blowfish</b>)
          </div>
          <div class="card-body">
            <div class="form-group row">
              <label for="ISenha2" class="col-form-label col-form-label-sm col-5 col-md-4">Senha: </label>
              <div class="col-7 col-md-8">
                <input id="ISenha2" type="password" class="form-control form-control-sm" aria-describedby="HSenha2" placeholder="Ex. <?php echo $mensagem ?>">
                <small id="HSenha2" class="form-text text-muted text-right">Digite a senha.</small>
              </div>
            </div>
            <div class="form-group row">
              <label for="IChave" class="col-form-label col-form-label-sm col-5 col-md-4">Chave: </label>
              <div class="col-7 col-md-8">
                <input id="IChave" type="text" class="form-control form-control-sm" aria-describedby="HChave" placeholder="Ex. <?php echo $mensagem ?>">
                <small id="HChave" class="form-text text-muted text-right">Digite a chave sava no BD.</small>
              </div>
            </div>
            <p id="PResultadoValidarBlowfish" class="text-center"></p>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-6">
        <div class="card mt-2">
          <div class="card-header text-center bg-success text-white">
            Encriptação <b>simétrica</b>
          </div>
          <div class="card-body">
            <div class="form-group row">
              <label for="IEncriptar" class="col-form-label col-form-label-sm col-5 col-md-4">Encriptar: </label>
              <div class="col-7 col-md-8">
                <input id="IEncriptar" type="text" class="form-control form-control-sm" aria-describedby="HEncriptar" placeholder="Ex. <?php echo $mensagem ?>">
                <small id="HEncriptar" class="form-text text-muted text-right">Digite um texto.</small>
              </div>
            </div>
            <div class="form-group row">
              <label for="IChave2" class="col-form-label col-form-label-sm col-5 col-md-4">Chave: </label>
              <div class="col-7 col-md-8">
                <input id="IChave2" type="text" class="form-control form-control-sm" aria-describedby="HChave2" placeholder="Ex. <?php echo $mensagem ?>">
                <small id="HChave2" class="form-text text-muted text-right">Digite um texto.</small>
              </div>
            </div>
            <div class="form-group row">
              <label for="SMetodo" class="col-form-label col-form-label-sm col-5 col-md-4">Escolha um método: </label>
              <div class="col-7 col-md-8">
                <select id="SMetodo" class="form-control form-control-sm" aria-describedby="HMetodo" placeholder="Ex. <?php echo $mensagem ?>"></select>
                <small id="HMetodo" class="form-text text-muted text-right">Escolha um método.</small>
              </div>
            </div>
            <p id="PResultadoEncriptacaoSimetrica" class="text-center"></p>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-6">
        <div class="card mt-2">
          <div class="card-header text-center bg-success text-white">
            Descriptação <b>simétrica</b>
          </div>
          <div class="card-body">
            <div class="form-group row">
              <label for="IEncriptado" class="col-form-label col-form-label-sm col-5 col-md-4">Encriptado: </label>
              <div class="col-7 col-md-8">
                <input id="IEncriptado" type="text" class="form-control form-control-sm" aria-describedby="HEncriptado" placeholder="Ex. <?php echo $mensagem ?>">
                <small id="HEncriptado" class="form-text text-muted text-right">Digite um texto.</small>
              </div>
            </div>
            <div class="form-group row">
              <label for="IChave3" class="col-form-label col-form-label-sm col-5 col-md-4">Chave: </label>
              <div class="col-7 col-md-8">
                <input id="IChave3" type="text" class="form-control form-control-sm" aria-describedby="HChave3" placeholder="Ex. <?php echo $mensagem ?>">
                <small id="HChave3" class="form-text text-muted text-right">Digite um texto.</small>
              </div>
            </div>
            <div class="form-group row">
              <label for="SMetodo2" class="col-form-label col-form-label-sm col-5 col-md-4">Escolha um método: </label>
              <div class="col-7 col-md-8">
                <select id="SMetodo2" class="form-control form-control-sm" aria-describedby="HMetodo2" placeholder="Ex. <?php echo $mensagem ?>"></select>
                <small id="HMetodo2" class="form-text text-muted text-right">Escolha um método.</small>
              </div>
            </div>
            <p id="PResultadoDescriptacaoSimetrica" class="text-center"></p>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-6">
        <div class="card mt-2">
          <div class="card-header text-center bg-success text-white">
            Encriptação <b>ascii/hexadeximal</b>
          </div>
          <div class="card-body">
            <div class="form-group row">
              <label for="IEncriptar2" class="col-form-label col-form-label-sm col-5 col-md-4">Encriptar: </label>
              <div class="col-7 col-md-8">
                <input id="IEncriptar2" type="text" class="form-control form-control-sm" aria-describedby="HEncriptar2" placeholder="Ex. <?php echo $mensagem ?>">
                <small id="HEncriptar2" class="form-text text-muted text-right">Digite um texto.</small>
              </div>
            </div>
            <p id="PResultadoEncriptacaoHexadecimal" class="text-center"></p>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-6">
        <div class="card mt-2">
          <div class="card-header text-center bg-success text-white">
            Descriptação <b>ascii/hexadeximal</b>
          </div>
          <div class="card-body">
            <div class="form-group row">
              <label for="IEncriptado2" class="col-form-label col-form-label-sm col-5 col-md-4">Encriptar: </label>
              <div class="col-7 col-md-8">
                <input id="IEncriptado2" type="text" class="form-control form-control-sm" aria-describedby="HEncriptado2" placeholder="Ex. <?php echo $mensagem ?>">
                <small id="HEncriptado2" class="form-text text-muted text-right">Digite um texto.</small>
              </div>
            </div>
            <p id="PResultadoDescriptacaoHexadecimal" class="text-center"></p>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="card mt-2">
          <div class="card-header text-center bg-primary text-white">
            Métodos - Mensagem para ser criptografada: <b><?php echo $mensagem; ?></b>
          </div>
          <div class="card-body p-0" style='height: 400px; overflow-y: scroll; overflow-x: hidden;'>

            <?php

              $string = openssl_random_pseudo_bytes(22);
              // Codificar o pseugo-aleatório para a base 64
              $base64 = base64_encode($string);
              // Obter apenas os primeiros 22 dígitos
              $substr = substr($base64, 0, 22);
              // Substituir + por .
              $key = str_replace("+", ".", $substr);

              $arrayMetodos = openssl_get_cipher_methods();

              //$arrayMetodos = ["AES-128-CBC", "AES-128-CBC-HMAC-SHA1", "AES-128-CBC-HMAC-SHA256", "AES-192-CBC", "AES-256-CBC", "AES-256-CBC-HMAC-SHA1", "AES-256-CBC-HMAC-SHA256", "CAMELLIA-128-CBC", "CAMELLIA-192-CBC", "CAMELLIA-256-CBC", "SEED-CBC", "aes-128-cbc", "aes-128-cbc-hmac-sha1", "aes-128-cbc-hmac-sha256", "aes-192-cbc", "aes-256-cbc", "aes-256-cbc-hmac-sha1", "aes-256-cbc-hmac-sha256", "camellia-128-cbc", "camellia-192-cbc", "camellia-256-cbc", "seed-cbc"];

              echo "<table class='table table-dark table-striped table-hover table-sm'>
              <thead>
              <tr>
              <th>Método</th>
              <th>ivlen</th>
              <th>Tamanho</th>
              <th>Criptografado</th>
              <th>Descriptografado</th>
              </tr>
              </thead>
              <tbody>";


              foreach ($arrayMetodos as $method) {
                if ($method != "aes-128-ccm" && $method != "aes-128-gcm" && $method != "aes-192-ccm" && $method != "aes-192-gcm" &&
                  $method != "aes-256-ccm" && $method != "aes-256-gcm" && $method != "id-aes128-CCM" && $method != "id-aes128-GCM" &&
                  $method != "id-aes192-CCM" && $method != "id-aes192-GCM" && $method != "id-aes256-CCM" && $method != "id-aes256-GCM")
                {
                  // Obter o tamanho iv da cifra
                  $ivlen = openssl_cipher_iv_length($method);
                  // Gerar uma string pseudo-aleatória de bytes
                  $iv = openssl_random_pseudo_bytes($ivlen);

                  $encrypt = openssl_encrypt($mensagem, $method, $key, 0, $iv);
                  $decrypt = openssl_decrypt($encrypt, $method, $key, 0, $iv);

                  echo "<tr><td><b>".$method."</b></td><td><b>".$ivlen."</b></td><td>".strlen($encrypt)."</td><td>".$encrypt."</td><td>".$decrypt."</td></tr>";
                }
              }

              echo "</tbody></table><br>";

            ?>

          </div>
        </div>
      </div>

    </div>
  </div>

  <div class="col-12">
    <div class="card mt-2">
      <div class="card-header text-center bg-primary text-white">
        Métodos - Mensagem para ser criptografada: <b><?php echo $mensagem; ?></b>
      </div>
      <div class="card-body p-0" style='height: 400px; overflow-y: scroll; overflow-x: hidden;'>

        <?php
          echo "<table class='table table-dark table-striped table-hover table-sm'>
          <thead>
          <tr>
          <th>HASH</th>
          <th>Tamanho</th>
          <th>Mensagem</th>
          </tr>
          </thead>
          <tbody>";
          foreach (hash_algos() as $hash)
          {
            $hash_result = hash($hash, $mensagem);
            echo "<tr><td><b>".$hash."</b></td><td>".strlen($hash_result)."</td><td>".$hash_result."</td></tr>";
          }
          echo "</tbody></table>";
        ?>

      </div>
    </div>
  </div>

</body>
</html>
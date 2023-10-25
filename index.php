<?php

    require_once('./Clases/Crypt_AES_Dos.php');
    require_once('./Clases/Encode_Base64.php');

    // Verificamos si el formulario fue enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['textoPlano'])) {
        // Creamos una instancia de Crypt_AES
        $crypt = new Crypt_AES_Dos();

        // Obtenemos el texto ingresado desde el formulario
        $textoPlano = $_POST['textoPlano'];

        // Establecemos los datos a encriptar
        $crypt->setData($textoPlano);

        // Encriptamos los datos
        $crypt->encriptar_aes();
        $texto_encriptado = $crypt->getEncrypted();
        $crypt = null;
    }

    // Verificamos si se proporcionó un texto encriptado para desencriptar
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['texto_encriptado'])) {
        $crypt = new Crypt_AES_Dos();
        $texto_encriptado = $_POST['texto_encriptado'];
        $crypt->setEncrypted($texto_encriptado);
        $crypt->desencriptar_aes();
        $texto_desencriptado = $crypt->getDecrypted();
        $crypt = null;
    }

    //**************  CODIFICACION Y DECODIFICACION BASE 64 */
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['txtPlanoB64'])){
        $code = new Encode_Base64();
        $txtPlanoB64 = $_POST['txtPlanoB64'];
        $code->setCadena($_POST['txtPlanoB64']);
        $code->codificarBase64();
        $textoCodificado = $code->getCodificado();
        
        
        $code = null;
    }
    
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['texto_codificado'])){
        $code = new Encode_Base64();
        $textoCodificado = $_POST['texto_codificado'];
        $code->setCodificado($textoCodificado);
        $code->decodificarBase64();
        $textoDescifrado = $code->getDecodificado();
        $code = null;
    }

    /**************************    Encriptacion AES 256 sobre Base 64 */
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['txt_to_AES_B64'])){
        $codificador = new Encode_Base64();
        $encriptador = new Crypt_AES_Dos();
        $txtPlanoAES_B64 = $_POST['txt_to_AES_B64'];
        //Se codifica a base 64
        $codificador->setCadena($_POST['txt_to_AES_B64']);
        $codificador->codificarBase64(); //Codificacion base 64 de la cadena inicial
        //Se encripta con AES la cadena codificada
        $encriptador->setData($codificador->getCodificado()); //Se inicializa el dato a encriptar pasando la cadena codificada en base 64
        $encriptador->encriptar_aes(); // Se encripta la cadena codificada
        $txt_encriptado = $encriptador->getEncrypted();

        $encriptador = null;
        $codificador = null;

    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['txt_encriptado'])){
        $decodificador = new Encode_Base64();
        $desencriptador = new Crypt_AES_Dos();
        $txt_encriptado = $_POST['txt_encriptado'];
        //Se desencripta el encriptado AES 256
        $desencriptador->setEncrypted($_POST['txt_encriptado']);
        $desencriptador->desencriptar_aes(); //Se desencripta la cadena codificada

        //Se decodifica la cadena ya desencriptada
        $decodificador->setCodificado($desencriptador->getDecrypted());
        $decodificador->decodificarBase64();

        $txt_desencriptado = $decodificador->getDecodificado();

        $desencriptador = null;
        $decodificador = null;

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


    <title>Document</title>
</head>
<body>
    
    <!--  -->

    <div class="container">
        <div class="row">
            <div class="col bg-primary text-white">
                <h1> Codificacion base64 </h1>
                    <!-- Formulario para codificacion en base 64 -->
                    <form method="POST">
                        <div class="form-group">
                            <label for="txtPlanoB64">Ingrese su texto: </label>
                            <input class="form-control" type="text" id="txtPlanoB64" name="txtPlanoB64" value="<?php if(isset($txtPlanoB64)){ echo $txtPlanoB64; } ?>">
                            <input class="btn btn-warning" type="submit" value="Codificar">
                        </div>
                    </form>

                    <!-- Mostrar texto codificado en base 64 -->
                    <?php /*if(isset($textoCodificado)): */?>
                        <h2> Texto codificado en base64 </h2>
                        <p><?php if(isset($textoCodificado)){echo $textoCodificado;} ?></p>

                        <!--  Formulario para decodificar  -->
                        <form method="POST">
                            <div class="form-group">
                                <label for="texto_codificado"> Cadena codificada en base 64 </label>
                                <input class="form-control" type="text" name="texto_codificado" value="<?php if(isset($textoCodificado)){echo $textoCodificado;}  ?>">
                                <input class="btn btn-warning" type="submit" value="Decodificar">
                            </div>
                        </form>
                    <?php /* endif; */?>

                    <?php if(isset($textoDescifrado)): ?>
                        <h2>Texto decodificado en base 64</h2>
                        <p><?php  echo $textoDescifrado; ?></p>
                    <?php endif ?>

            </div>


        </div>


        <div class="row">
            <div class="col bg-dark text-white">
                <h1>Encriptador AES 256 </h1>

                <!-- Formulario para encriptar -->
                <form method="post">
                    <div class="form-group">    
                        <label for="textoPlano">Texto:</label>
                        <input class="form-control" type="text" id="textoPlano" name="textoPlano" value="<?php if(isset($textoPlano)){ echo $textoPlano; } ?>">
                        <input class="btn btn-warning" type="submit" value="Encriptar">
                    </div>
                </form>

                <!-- Mostrar texto encriptado -->
                <?php /*if (isset($texto_encriptado)):*/ ?>
                    <h2>Texto Encriptado:</h2>
                    <p><?php if (isset($texto_encriptado)) { echo $texto_encriptado;} ?></p>

                    <!-- Formulario para desencriptar -->
                    <form method="post">
                        <div class="form-group">
                            <input class="form-control" type="txt" name="texto_encriptado" value="<?php if (isset($texto_encriptado)) { echo $texto_encriptado; } ?>">
                            <input class="btn btn-warning" type="submit" value="Desencriptar">
                        </div>
                    </form>
                <?php /* endif;*/ ?>

                <!-- Mostrar texto desencriptado -->
                <?php if (isset($texto_desencriptado)): ?>
                    <h2>Texto Desencriptado:</h2>
                    <p><?php echo $texto_desencriptado; ?></p>
                <?php endif; ?>
                
            </div>
        </div>
            <!------------------------------------------->
            <!-- Encriptacion de AES 256 sobre base 64 -->
        <div class="row">
            <div class="col bg-success bg-gradient text-white">
                <h1>Encriptador AES 256 sobre base 64 </h1>

                <!-- Formulario para encriptar -->
                <form method="post">
                    <div class="form-group">
                        <label for="txt_to_AES_B64">Texto:</label>
                        <input class="form-control" type="text" id="txt_to_AES_B64" name="txt_to_AES_B64" value="<?php if(isset($txtPlanoAES_B64)){ echo $txtPlanoAES_B64; }?>">
                        <input class="btn btn-warning" type="submit" value="Encriptar">
                    </div>
                </form>

                <!-- Mostrar texto encriptado -->
                <?php /* if (isset($txt_encriptado)): */ ?>
                    <h2>Texto Encriptado:</h2>
                    <p><?php if (isset($txt_encriptado)) { echo $txt_encriptado; } ?></p>

                    <!-- Formulario para desencriptar -->
                    <form method="post">
                        <div class="form-group">
                            <input class="form-control" type="txt" name="txt_encriptado" value="<?php if (isset($txt_encriptado)) { echo $txt_encriptado; } ?>">
                            <input class="btn btn-warning" type="submit" value="Desencriptar">
                        </div>
                    </form>
                <?php /* endif; */ ?>

                <!-- Mostrar texto desencriptado -->
                <?php if (isset($txt_desencriptado)): ?>
                    <h2>Texto Desencriptado:</h2>
                    <p><?php echo $txt_desencriptado; ?></p>
                <?php endif; ?>
                
            </div>
        </div>









        </div>  
    </div>


    
</body>
</html>
<?php
    //Definición de nuestro cipher
    //Metodo de cifrado
    define('AES_256_CBC', 'aes-256-cbc');
        class Crypt_AES_Dos{
            
            //atributos de la clase
            private $encryption_key;
            private $cipher;
            private $iv;
            private $data;
            private $options;
            private $encrypted;
            private $decrypted;

            //Metodo constructor
            public function __construct()
            {
                //Creación de Clave de encriptación o clave de cifrado constante para fines didacticos
                $this->encryption_key = "12345678901234567890123456789012";
                $this->cipher = "AES-256-CBC";
                $this->options = 0;
                $this->iv = str_repeat("0", openssl_cipher_iv_length($this->cipher));
            }
            
            
            public function getData(){
                return $this->data;
            }

            public function setData($data){
                $this->data = $data;
            }

            public function setEncrypted($encrypted){
                $this->encrypted = $encrypted;
            }

            public function getEncrypted(){
                return $this->encrypted;
            }

            

            public function getDecrypted(){
                return $this->decrypted;
            }


            public function encriptar_aes(){
                $this->encrypted = openssl_encrypt($this->data, $this->cipher, $this->encryption_key, $this->options,$this->iv);
                //return $this->encrypted;
            } 

            public function desencriptar_aes(){
                $this->decrypted = openssl_decrypt($this->encrypted, $this->cipher, $this->encryption_key, $this->options, $this->iv);
                //return $this->decrypted;
            }
            
        }
    

?>
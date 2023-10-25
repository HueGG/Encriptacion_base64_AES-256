<?php
    class Encode_Base64{
        //Atributos de la clase
        private $cadena;
        private $codificado;
        private $decodificado;

        public function __construct(){

        }

        public function setCadena($cadena){
            $this->cadena = $cadena;
        }

        public function getCadena(){
            return $this->cadena;
        }

        public function getCodificado(){
            return $this->codificado;
        }

        public function setCodificado($codificado){
            $this->codificado = $codificado;
        }

        public function getDecodificado(){
            return $this->decodificado;
        }
        /******************************************** */
        /************************************************ */

        public function codificarBase64(){
            $this->codificado = base64_encode($this->cadena);
        }

        public function decodificarBase64(){
            $this->decodificado = base64_decode($this->codificado);
        }

    }

?>
<?php
require_once '../config.php';

/////////////////////////////////////////////
// Exemplo de implantação para verificação //
// de reCAPTCHA v3 com PHP                 //
// Testado Windows 10 com PHP 7.3.29       //
// Utiliza cURL com SSL                    //
// Autor: Renan Kvitschal                  //
/////////////////////////////////////////////

class Recaptcha
{
    private $curl;
    private $serverToken;
    private $outJson;
    private $outArray;

    public $erro = true;
    public $validado = false;

    public function __construct($serverToken = _RECAPTCHA_SERVER_TOKEN_)
    {
        $this->serverToken = $serverToken;
    }

    public function validar($response)
    {
        $this->curl = curl_init("https://www.google.com/recaptcha/api/siteverify");

        $post = array(
            "secret" => $this->serverToken,
            "response" => $response
        );

        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, http_build_query($post));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);

        $this->outJson = curl_exec($this->curl);
        $this->outArray = json_decode($this->outJson);

        curl_close($this->curl);
        if ($this->outArray->success == 1) {
            $this->erro = false;
            $this->validado = true;
            return true;
        } else {
            $this->erro = false;
            return false;
        }
        $this->erro = true;
        return false;
    }

    public function getArray()
    {
        return $this->outArray;
    }

    public function getJson()
    {
        return $this->outJson;
    }
}

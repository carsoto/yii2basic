<?php

namespace app\models;
use Yii;
use yii\base\model;


class ValidarFormularioAjax extends model {
    public $nombre;
    public $email;

    public function rules(){
        return array(
            array("nombre", "required", "message" => "Campo nombre requerido"),
            array("nombre", "match", "pattern" => "/^.{3,50}$/", "message" => "Mínimo 3 y máximo 50 caracteres"),
            array("nombre", "match", "pattern" => "/^[0-9a-z]+$/i", "message" => "Sólo se aceptan números y letras"),
            array("email", "required", "message" => "Campo email requerido"),
            array("email", "match", "pattern" => "/^.{5,80}$/", "message" => "Mínimo 5 y máximo 80 caracteres"),
            array("email", "email", "message" => "Formato no válido"),
            array("email", "email_existe"),
        );  
    }

    public function attributeLabels(){
        return array(
            "nombre" => "Nombre: ",
            "email" => "Correo Electrónico: ",
        );
    }

    public function email_existe($attribute, $params){
        $emails = array("carsoto8691@gmail.com", "carsoto1@gmail.com", "marianavera280790@gmail.com", "sg.davidd@gmail.com");
        
        foreach ($emails as $val) {
            if ($this->email == $val) {
                $this->addError($attribute, "El email se encuentra registrado");
                return true;
            }else{
                return false;
            }
        }
    }
}
<?php


namespace src\tienda_virtual\database\models;


class UserModel extends Model
{

    public function __construct()
    {
        $this->setField("id", "");
        $this->setField("username", "");
        $this->setField("password", "");
        $this->setField("mail", "");
        $this->setField("id_persona", "");
        $this->setField("activo", "");
        $this->setField("id_direccion_default", "");
    }

    public function setUsername(string $username) : void {
        $this->setField("username", $username);
    }

    public function setPassword(string $password) : void {
        $this->setField("password", password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]));
    }

    public function setEmail(string $mail) : void {
        $this->setField("mail", $mail);
    }

    public function setIdPersona(string $id_persona) : void {
        $this->setField("id_persona", $id_persona);
    }

    public function setActivo(string $activo) : void {
        $this->setField("activo", $activo);
    }
}
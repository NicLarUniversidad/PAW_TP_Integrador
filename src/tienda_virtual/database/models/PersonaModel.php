<?php


namespace src\tienda_virtual\database\models;


class PersonaModel extends Model
{

    public function __construct()
    {
        $this->setField("id","");
        $this->setField("nombre", "");
        $this->setField("apellido", "");
        $this->setField("mail", "");
        $this->setField("id_direccion", "");
        $this->setField("activo", "");
    }

    public function setEmail(string $mail) : void {
        $this->setField("mail", $mail);
    }

    public function setNombre(string $nombre) : void {
        $this->setField("nombre", $nombre);
    }

    public function setApellido(string $apellido) : void {
        $this->setField("apellido", $apellido);
    }

    public function setIdDireccion(int $idDireccion) : void {
        $this->setField("id_direccion", $idDireccion);
    }

    public function setActivo(string $activo) : void {
        $this->setField("activo", $activo);
    }
}
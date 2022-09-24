<?php


namespace src\tienda_virtual\services;


use Monolog\Logger;
use PDO;
use src\tienda_virtual\database\models\PersonaModel;
use src\tienda_virtual\database\repositories\PersonaRepository;
use src\tienda_virtual\exceptions\IndexNotFoundException;
use src\tienda_virtual\traits\TSession;

class PersonaService
{
    use TSession;
    public static string $USER_SESSION_NAME = "logged_user";
    protected PersonaRepository $personaRepository;

    public function __construct(PDO $pdo, Logger $logger)
    {
        $this->personaRepository = new PersonaRepository($logger, $pdo);
        $this->setSession(new SessionService());
    }

    public function createPersona(string $mail = "", string $nombre = "",
                               string $apellido = "") : PersonaModel {
        $newPersona = new PersonaModel();
        $newPersona->setNombre($nombre);
        $newPersona->setEmail($mail);
        $newPersona->setApellido($apellido);
        $newPersona->setIdDireccion(1);
        $newPersona->setActivo('SI');
        $this->personaRepository->save($newPersona);
        return $newPersona;
    }
   
    public function findByEmail( string $mail="" ) : PersonaModel{
        
        $newPersona = $this->personaRepository->findByMail($mail);
        return $newPersona;
    }
}
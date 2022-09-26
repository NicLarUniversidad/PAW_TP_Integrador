<?php

namespace src\tienda_virtual\controllers;

use src\tienda_virtual\services\TwigPageFinderService;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use src\tienda_virtual\traits\TLogger;
use src\tienda_virtual\services\UserService;
use src\tienda_virtual\services\PersonaService;

class LoginController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->pageFinderService = new TwigPageFinderService();
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    // public function get() {
    //     $cssImports = Array();
    //     $cssImports[] = "main";
    //     $jsImports[]="app";
    //     array_push($jsImports, "paw");
    //     $this->pageFinderService->findFileRute("index","html","html", $cssImports,[],"tienda virtual",$jsImports);
    //     //$this->pageFinderService->findFileRute("index");
    // }

    //-----------------------------------------------------------------
    public function get()
    {
        $cssImports = array();
        $cssImports[] = "login";
        $user = $this->session->get(UserService::$USER_SESSION_NAME);
        if (is_null($user)) {
            $this->pageFinderService->findFileRute("login", "twig", "twig", $cssImports);
        } else {
            $this->pageFinderService->findFileRute("loggeado", "twig", "twig", $cssImports);
        }
    }

    /**
     * @throws IndexNotFoundException
     */
    public function post()
    {
        $username = $this->request->get("username");
        $password = $this->request->get("password");
        $service = new UserService($this->connection, $this->logger);
        if ($service->login($username, $password)) {
            header("Location: /");
        } else {
            //TODO: hacer página...
            echo "usuario o contraseña inválida";
        }
    }

    public function getRegistrarse(): void
    {
        $cssImports = array();
        $cssImports[] = "login";
        $this->pageFinderService->findFileRute("registrarse", "twig", "twig", $cssImports, [], "registrarse");
    }

    public function postRegistrarse(): void
    {
        $username = $this->request->get("username");
        $password = $this->request->get("password");
        $mail = $this->request->get("mail") ?? "";
        $nombre = $this->request->get("nombre") ?? "";
        $apellido = $this->request->get("apellido") ?? "";
        $activo = "SI";
        if (isset($username) and isset($password)) {
            $personaService = new PersonaService($this->connection, $this->logger);
            $newPersona = $personaService->createPersona($mail, $nombre, $apellido);
            //Solicitar datos de direccion
            $persona = $personaService->findByEmail($mail);
            if ($persona) {
                $this->logger->info("NUEVA PERSONA " . $persona->getField("id"));
            }

            $userService = new UserService($this->connection, $this->logger);

            $userService->createUser($username, $password, $mail, $persona->getField("id"), $activo);
            echo "OK";
        } else {
            echo "No se ingresó usuario o contraseña";
        }
    }

    public function getLogout()
    {
        session_destroy();
        session_unset();
        header("Location: /");
        die();
    }
}

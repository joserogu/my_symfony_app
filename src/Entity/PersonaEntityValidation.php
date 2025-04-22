<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class PersonaEntityValidation
{
    #[Assert\NotBlank(message: 'El campo nombre no puede estar vacío')]
    protected $nombre;
    #[Assert\NotBlank(message: 'El campo email no puede estar vacío'), Assert\Email(message: 'El email {{ value }} no es válido')]
    protected $email;
    #[Assert\NotBlank(message: 'El campo telefono no puede estar vacío')]
    protected $telefono;
    protected $pais;

    public function getNombre(): String
    {
        return $this->nombre;
    }

    public function setNombre(String $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getEmail(): String
    {
        return $this->email;
    }

    public function setEmail(String $email): void
    {
        $this->email = $email;
    }

    public function getTelefono(): String
    {
        return $this->telefono;
    }

    public function setTelefono(String $telefono): void
    {
        $this->telefono = $telefono;
    }

    public function getPais(): String
    {
        return $this->pais;
    }

    public function setPais(String $pais): void
    {
        $this->pais = $pais;
    }




}
<?php

namespace App\Entity;

class Persona
{
    protected $nombre;
    protected $email;
    protected $telefono;

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






}
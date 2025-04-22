<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// enviar email
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Transport;

//http client
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UtilidadesController extends AbstractController
{
    public function __construct(
        private HttpClientInterface $client,
    ) {
    }

    #[Route('/utilidades', name: 'utilidades_inicio')]
    public function index(): Response
    {
        return $this->render('utilidades/index.html.twig');
    }

    #[Route('/utilidades/enviar-email', name: 'utilidades_email')]
    public function enviar_email(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from(new Address('noreply@josema.cls', 'Miguelito Perez'))
            ->to('josema@gmail.com')
            ->subject('Mail de prueba')
            // ->text('Hola, este es un mail de prueba')
            ->html('
                <div style="font-family: Arial, sans-serif; line-height: 1.6;">
                    <h2 style="color: #2c3e50;">¡Hola, Usuario!</h2>
                    <p>Este es <strong>un correo de prueba</strong> enviado desde Symfony utilizando MailDev.</p>
                    <p>Si estás viendo esto correctamente, entonces todo está funcionando 🛠️.</p>
                    <hr>
                    <p style="font-size: 0.9em; color: #7f8c8d;">Enviado por <strong>Miguelito Pérez</strong> desde <code>noreply@josema.cls</code>.</p>
                </div>
                ');
        try {
            $mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            die($e);
        }

        return $this->render('utilidades/enviar_email.html.twig');
    }

    /* Usamos el programa de postman para acceder
    https://www.api.tamila.cl/api/login
    {
    "correo": "info@tamila.cl",
    "password": "p2gHNiENUw"
    }
    */
    #[Route('/utilidades/api-rest', name: 'utilidades_api_rest')]
    public function api_rest(): Response
    {
        $response = $this->client->request(
            'GET',
            'https://www.api.tamila.cl/api/categorias',
            [
                'headers' => [
                    'Authorization'=> 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MzYsImlhdCI6MTc0NTMyNzY0MSwiZXhwIjoxNzQ3OTE5NjQxfQ.3zT-gUsUJeoqeEyOi9_Jf0i3Z4jTcBTnJKsjNLWBVYI',
                ]
            ]
        );
        $statusCode = $response->getStatusCode();

        return $this->render('utilidades/api_rest.html.twig', compact('response'));
    }
}

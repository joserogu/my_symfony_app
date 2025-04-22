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
use App\Form\CategoriaApiType;
use Symfony\Component\HttpFoundation\Request;

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

    #[Route('/utilidades/api-rest/crear', name: 'utilidades_api_rest_crear')]
    public function api_rest_crear(Request $request): Response
    {
        $form = $this->createForm(CategoriaApiType::class, null);
        $form->handleRequest($request);
        $submittedToken=$request->request->get('token');
        if ($form->isSubmitted()) {
            if($this->isCsrfTokenValid('generico', $submittedToken)) {
                $campos = $form->getData();
                $response = $this->client->request(
                    'POST',
                    'https://www.api.tamila.cl/api/categorias',
                    [
                        'json' => [
                            'nombre' => ['nombre' => $campos['nombre']],
                        ],
                        'headers' => [
                            'Authorization'=> 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MzYsImlhdCI6MTc0NTMyNzY0MSwiZXhwIjoxNzQ3OTE5NjQxfQ.3zT-gUsUJeoqeEyOi9_Jf0i3Z4jTcBTnJKsjNLWBVYI',
                        ]
                    ]
                );
                $this->addFlash('css', 'success');
                $this->addFlash('mensaje', 'Formulario enviado correctamente');
                return $this->redirectToRoute('utilidades_api_rest_crear');

            } else {
                $this->addFlash('css', 'warning');
                $this->addFlash('mensaje', 'Ocurrió un error al enviar el formulario');
                return $this->redirectToRoute('utilidades_api_rest_crear');    
            }
        } 

        return $this->render('utilidades/api_rest_add.html.twig', compact('form'));
    }



}

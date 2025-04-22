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

class UtilidadesController extends AbstractController
{
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
}

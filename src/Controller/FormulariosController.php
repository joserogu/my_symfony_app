<?php

namespace App\Controller;
use App\Entity\Persona;
use App\Entity\PersonaEntity;
use App\Form\PersonaEntityFormType;
use App\Entity\PersonaEntityValidation;
use App\Entity\PersonaEntityUpload;
use App\Form\PersonaUploadType;
use App\Form\PersonaValidationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FormulariosController extends AbstractController
{
    #[Route('/formularios', name: 'formularios_inicio')]
    public function index(): Response
    {
        return $this->render('formularios/index.html.twig');
    }

    #[Route('/formularios/simple', name: 'formularios_simple')]
    public function simple(Request $request): Response
    {
        $form = $this->createFormBuilder(null)
            ->add('nombre', TextType::class, ['label'=>'Nombre'])
            ->add('email', TextType::class, ['label'=>'E-Mail'])
            ->add('telefono', TextType::class, ['label'=>'Telelfono'])
            ->add('save', SubmitType::class)
            ->getForm();
        
        $submittedToken=$request->request->get('token');
        $form->handleRequest($request);
        // si viene la petición POST del formulario
        // if($form->isSubmitted())
        if($form->isSubmitted())
        {
            if($this->isCsrfTokenValid('generico', $submittedToken)){
                $campos = $form->getData();
                //print_r($campos);
                echo "Nombre: ".$campos['nombre'];
                echo "E-Mail: ".$campos['email'];
                echo "Telefono: ".$campos['telefono'];
                die();    
            } else {
                $this->addFlash('css', 'warning');
                $this->addFlash('mensaje', 'Ocurrió un error al enviar el formulario');
                return $this->redirectToRoute('formularios_simple');
            }
            
        }
        return $this->render('formularios/simple.html.twig', compact('form'));
    }

    #[Route('/formularios/entity', name: 'formularios_entity')]
    public function entity(Request $request): Response
    {
        $persona = new Persona();
        $form = $this->createFormBuilder($persona)
            ->add('nombre', TextType::class, ['label'=>'Nombre'])
            ->add('email', TextType::class, ['label'=>'E-Mail'])
            ->add('telefono', TextType::class, ['label'=>'Telefono'])
            ->add('save', SubmitType::class)
            ->getForm();
        
        $submittedToken=$request->request->get('token');
        $form->handleRequest($request);
        // si viene la petición POST del formulario
        // if($form->isSubmitted())
        if($form->isSubmitted())
        {
            if($this->isCsrfTokenValid('generico', $submittedToken)){
                $campos = $form->getData();
                //print_r($campos);
                echo "Nombre: ".$campos->getNombre(). " | E-Mail: ".$campos->getEmail()." | Telefono: ".$campos->getTelefono();
                die();    
            } else {
                $this->addFlash('css', 'warning');
                $this->addFlash('mensaje', 'Ocurrió un error al enviar el formulario');
                return $this->redirectToRoute('formularios_entity');
            }

        }
        return $this->render('formularios/entity.html.twig', compact('form'));
    }

    #[Route('/formularios/type-form', name: 'formularios_type_form')]
    public function type_form(Request $request): Response
    {
        $persona = new PersonaEntity();
        $form = $this->createForm(PersonaEntityFormType::class, $persona);
        $form->handleRequest($request);
        $submittedToken=$request->request->get('token');
        if($form->isSubmitted())
        {
            if($this->isCsrfTokenValid('generico', $submittedToken)){
                $campos = $form->getData();
                echo "Nombre: ".$campos->getNombre(). " | E-Mail: ".$campos->getEmail()." | Telefono: ".$campos->getTelefono();
                die();    
            } else {
                $this->addFlash('css', 'warning');
                $this->addFlash('mensaje', 'Ocurrió un error al enviar el formulario');
                return $this->redirectToRoute('formularios_type_form');
            }

        }
        return $this->render('formularios/type_form.html.twig', compact('form'));
    }

    #[Route('/formularios/validation', name: 'formularios_validation')]
    public function validation(Request $request, ValidatorInterface $validator): Response
    {
        $persona = new PersonaEntityValidation();
        $form = $this->createForm(PersonaValidationType::class, $persona);
        $form->handleRequest($request);
        $submittedToken=$request->request->get('token');
        if ($form->isSubmitted())
        {
            if($this->isCsrfTokenValid('generico', $submittedToken)){
                $errors = $validator->validate($persona);

                if (count($errors) > 0) {
                    return $this->render('formularios/validation.html.twig', ['form'=>$form, 'errors'=>$errors]);
                }

                $campos = $form->getData();
                echo "Nombre: ".$campos->getNombre(). " | E-Mail: ".$campos->getEmail()." | Telefono: ".$campos->getTelefono();
                die();    

            } else {
                $this->addFlash('css', 'warning');
                $this->addFlash('mensaje', 'Ocurrió un error al enviar el formulario');
                return $this->redirectToRoute('formularios_validation');
            }
        }
        return $this->render('formularios/validation.html.twig', ['form'=>$form, 'errors'=>array()]);
    }

    #[Route('/formularios/upload', name: 'formularios_upload')]
    public function upload(Request $request, ValidatorInterface $validator): Response
    {
        $persona = new PersonaEntityUpload();
        $form = $this->createForm(PersonaUploadType::class, $persona);
        $form->handleRequest($request);
        $submittedToken=$request->request->get('token');
        if ($form->isSubmitted())
        {
            if($this->isCsrfTokenValid('generico', $submittedToken)){
                $errors = $validator->validate($persona);

                if (count($errors) > 0) {
                    return $this->render('formularios/upload.html.twig', ['form'=>$form, 'errors'=>$errors]);
                }
                $foto = $form->get('foto')->getData();
                if ($foto) {
                    $originalName = pathinfo($foto->getClientOriginalName(), PATHINFO_FILENAME);
                    $newfilename = time().'.'.$foto->guessExtension();
                    try {   
                        $foto->move(
                            $this->getParameter('fotos_directory'),
                            $newfilename
                        );
                        $persona->setFoto($newfilename);
                    } catch (FileException $e) {
                        throw new \Exception("mensaje", 'Error al subir el archivo');
                    }
                    $persona->setFoto($newfilename);
                }
                $campos = $form->getData();
                echo "Nombre: ".$campos->getNombre(). " | E-Mail: ".$campos->getEmail()." | Telefono: ".$campos->getTelefono() . " | Pais: ".$campos->getPais()." | Foto: ".$campos->getFoto();
                die();    

            } else {
                $this->addFlash('css', 'warning');
                $this->addFlash('mensaje', 'Ocurrió un error al enviar el formulario');
                return $this->redirectToRoute('formularios_upload');
            }
        }
        return $this->render('formularios/upload.html.twig', ['form'=>$form, 'errors'=>array()]);
    }
}

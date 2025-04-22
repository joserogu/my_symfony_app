<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TemplateController extends AbstractController
{
    #[Route('/template', name: 'template_inicio')]
    public function index(): Response
    {
        return $this->render("template/index.html.twig");
    }

    #[Route('/template/parametros/{id}/{slug}', name: 'template_parametros')]
    // #[Route('/template/parametros/{id}/{slug}', name: 'template_parametros', defaults:
    // ['id'=>1, 'slug'=>"wa"])]
    public function parametros(int $id, string $slug): Response
    {
        if($id >= 0){
            die("id={$id} | slug={$slug}");
        } else {
            throw new NotFoundHttpException('Esta URL no está disponible');
        }
        
    }

    #[Route('/template/excepcion', name: 'template_exception')]
    public function excepcion(): Response
    {
        // throw $this->createNotFoundException('Esta URL no está disponible');
        throw new NotFoundHttpException('Esta URL no está disponible con el otro');
    }

    #[Route('/template/trabajo', name: 'template_trabajo')]
    public function trabajo(): Response
    {
        // interpolación
        $name = 'Josema';
        $lastname = 'Rodríguez';
        $paises = array(
            array(
                'nombre'=>'España', "id"=>1
            ),
            array(
                'nombre'=>'Francia', "id"=>2
            ),
            array(
                'nombre'=>'Andorra', "id"=>3
            ),
            array(
                'nombre'=>'Portugal', "id"=>4
            ),
            array(
                'nombre'=>'Italia', "id"=>5
            ),
        );

        return $this->render("template/trabajo.html.twig", compact('name', 'lastname', 'paises'));
        // return $this->render("template/trabajo.html.twig", [ 'nombre'=>$name, 'apellido'=>$lastname ]);
        // return $this->render("template/trabajo.html.twig", [ 'nombre'=>'Josema', 'apellido'=>'Rodríguez' ]);
    }

    #[Route('/template/layout', name: 'template_layout')]
    public function layout(): Response
    {
        return $this->render("template/layout.html.twig");
    }
}
<?php 
namespace App\Controller\Colegio;

use App\Entity\Colegio\notas;
use App\Repository\Colegio\estudianteRepository;
use App\Repository\Colegio\notasRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class notasController extends AbstractController{
    //un regisro
    public function registrarNotas($id, estudianteRepository $estuRepo, notasRepository $notasRepo){
        //notas pendientes por estuidiante
        $notasRepo->construirPendiente($id);
        $listaNotas=$notasRepo->findBy(array('estudiante'=>$id));
        $estudiante = $estuRepo->find($id);
        return $this->render('Colegio\Notas\Listar\listarNotas.html.twig',['listaNotas'=>$listaNotas,'estudiante'=>$estudiante]);
    }

    public function guardarNotas(Request $request, EntityManagerInterface $em){
        //dd($request);exit;
        $nota   = $request->request->get("nota");
        $idNota = $request->request->get("idNota");
        if ($nota>5 or !is_numeric($nota)) {
            return new Response(json_encode(array("Result"=>2)));
        }

        $notaRepo=$em->getRepository(notas::class)->find($idNota);
        $notaRepo->setNota($nota);
        $em->flush();
        return new Response(json_encode(array("Result"=>1)));
    }
}


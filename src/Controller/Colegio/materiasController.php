<?php 
namespace App\Controller\Colegio;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Colegio\materias;
use App\Form\Colegio\MateriasType;
use App\Repository\Colegio\materiasRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Regex;

class materiasController extends AbstractController{

    //cargarla pagina principak
    public function PresentaMaterias(){
        return $this->render('Colegio\Materias\Listar\presentaMaterias.html.twig');
    }
    // carga la tabla sin cargar pagina 
    public function frameTableMaterias(materiasRepository $materias, PaginatorInterface $paginator, Request $request){
        $listaMaterias= $materias->findAll();
        $pagination=$paginator->paginate($listaMaterias, $request->query->getInt('page',1),10);
        return $this->render('Colegio\Materias\Listar\frameTablaMaterias.html.twig', array('materias'=>$pagination));
    }
    public function crearMaterias($id, EntityManagerInterface $em){

        if ($id==0) {
            $materias=new materias();
        }else {
            $materias=$em->getRepository(materias::class)->find($id);
        }

        $forma=$this->createForm(MateriasType::class, $materias, array('methop'=>'POST','action'=>$this->generateUrl('colegioGuardarMaterias',array('id'=>$id))));

        return $this->render('Colegio\Materias\crear\crearMaterias.html.twig',array('form'=>$forma->createView()));
    }


    public function guardarMaterias($id, Request $request, EntityManagerInterface $em){

        if ($id==0) {
            $materias=new materias();
        }else {
            $materias=$em->getRepository(materias::class)->find($id);
        }

        $forma=$this->createForm(MateriasType::class, $materias, array('methop'=>'POST','action'=>$this->generateUrl('colegioGuardarMaterias')));
        $forma->handleRequest($request);

       if ($id==0) {
            $em->persist($materias);
        }
        $em->flush();
        return $this->redirectToRoute('colegioFrameMaterias');
    }

}


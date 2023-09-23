<?php 
namespace App\Controller\Colegio;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Colegio\materias;
use App\Form\Colegio\MateriasType;
use App\Repository\Colegio\materiasRepository;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;


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

        $forma=$this->createForm(MateriasType::class, $materias, array('method' => 'POST','action'=>$this->generateUrl('colegioGuardarMaterias',array('id'=>$id))));

        return $this->render('Colegio\Materias\Crear\crearMaterias.html.twig',array('form'=>$forma->createView()));
    }


    public function guardarMaterias($id, Request $request, EntityManagerInterface $em){

        if ($id==0) {
            $materias=new materias();
        }else {
            $materias=$em->getRepository(materias::class)->find($id);
        }

        //dd($materias);exit;
        $forma=$this->createForm(MateriasType::class, $materias, array('method' => 'POST','action'=>$this->generateUrl('colegioGuardarMaterias')));
        $forma->handleRequest($request);

       if ($id==0) {
            $em->persist($materias);
        }
        $em->flush();
        return $this->redirectToRoute('colegioTablaMaterias');
    }

    public function eliminarMateria(Request $request, EntityManagerInterface $em){
        //$idsEliminar=explode(",",$request->request->get("idEliminar"));
        $idsEliminar=$request->request->get("idEliminar");
      //  dd($idsEliminar);exit;
       
        $materias = $em->getRepository(materias::class)->find($idsEliminar);
        $em->remove($materias);
        $em->flush();
        return $this->redirectToRoute('colegioTablaMaterias');
    }

}


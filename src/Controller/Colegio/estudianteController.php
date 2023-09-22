<?php 
namespace App\Controller\Colegio;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\Colegio\estudianteRepository;
use App\Entity\Colegio\estudiante;
use App\Form\Colegio\EstudiantesType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class estudianteController extends AbstractController{

   
    public function listarEstudiantes(){
        return $this->render('Colegio\Estudiantes\Listar\listarEstudiantes.html.twig');
    }

    public function frmFiltro(){//createFormBuilder se lo utiliiza  para tener inpues si guardar infpormacion
        $formFiltro= 
                $this->createFormBuilder(null,array('method' => 'POST','action'=>$this->generateUrl('colegioframeTablaEstud')))
                ->add('id',TextType::class, array('label'=>'id','required'=>false))
                ->add('identificacion',TextType::class,array('label'=>'Identificación','required'=>false))
                ->add('nombres',TextType::class,array('label'=>'Nombres','required'=>false))
                ->add('reset',ResetType::class,array('label'=>' '))
                ->add('buscar',SubmitType::class,array('label'=>' '))
                ->getForm();

                return $this->render('Colegio\Estudiantes\Listar\formFltsEstudiantes.html.twig', array('form'=>$formFiltro->createView()));

    }

    public function frameTablaEstud(estudianteRepository $estudiantes,PaginatorInterface $paginator, Request $request){
       // dump($request->request->get('form'));exit();
        $lisEst=$estudiantes->FltsEstudiante($request->request->get('form'));  
        //dd($lisEst);

//        $lisEst=$estudiantes->lisEst();  
        $pagination = $paginator->paginate($lisEst, $request->query->getInt('page', 1), 10);
        return $this->render('Colegio\Estudiantes\Listar\frameTablaEstudiante.html.twig', array('estudiantes'=> $pagination));
    }

    public function crearEstudiantes($id, EntityManagerInterface $em){
       
        if ($id==0) {//cree el estudiante
            $estudiante=new estudiante();
        }else{//lo busque el estudiente  
            $estudiante = $em->getRepository(estudiante::class)->find($id);
        }
        $Forma = $this->createForm(EstudiantesType::class, $estudiante, array(
            //se envia los parametros => se debe adicionar estos para metros en Form/Colegio/EstudiantesType.php
            'letra'  => 'p',
            'idCompania'  => 1,
            'method' => 'POST',
            'action' => $this->generateUrl('colegioEstudGuardar', array('id'=> $id))
        ));
        
        //dd($Forma);
        return $this->render('Colegio\Estudiantes\crear\crearEstudiantes.html.twig', array('form'=>$Forma->createView()));
    }
    public function guardarEstudiantes($id, Request $request,EntityManagerInterface $em){
        
        //dump($request->files->get('estudiantes')['foto']);exit;
        $fotoAnt=null;
        if ($id==0) {//cree el estudiante
            $estudiante=new estudiante();
            $estudiante->setFechaCrea(new \DateTime('now'));
            
        }else{//lo busque el estudiente  
            $estudiante = $em->getRepository(estudiante::class)->find($id);
            $estudiante->setFechaMod(new \DateTime('now'));
            $fotoAnt= $estudiante->getFoto();//trae la foto anaterior
            
        }
        
        $frmFoto=$request->files->get('estudiantes')['foto'];

        $Forma = $this->createForm(EstudiantesType::class, $estudiante, array(
            'method' => 'POST',
            'action' => $this->generateUrl('colegioEstudGuardar', array('id'=> $id))
        ));
        $reqPrefe=implode(",",$request->request->get('estudiantes')['preferencias']);
        //dump($request->request->get('estudiantes')['preferencias']);exit;
        //dump($reqPrefe);exit;
        $Forma->handleRequest($request);
        $estudiante->setPreferencias($reqPrefe);

        $f1=$estudiante->getFechaNac();
        $f2=new \DateTime('now');
        $edad=$f1->diff($f2);
        $estudiante->setEdad($edad->y);

        if (!empty($frmFoto)) {
            $bsFoto =base64_encode(file_get_contents($frmFoto));
        }else{
            $bsFoto =$fotoAnt;
        }
        $estudiante->setFoto($bsFoto);
       
        if ($id==0) {
            $em->persist($estudiante);//crear estudiente 
        }
        $em->flush();//ejecuta en BD
        return $this->redirectToRoute('colegioframeTablaEstud');
    }
  
    public function eliminarEstudiante(Request $request,EntityManagerInterface $em){
        $idsEliminar=explode(",",$request->request->get("idEliminar"));
      //  dd($idsEliminar);exit;
        foreach ($idsEliminar as $id) {
            $estudiante = $em->getRepository(estudiante::class)->find($id);
            $em->remove($estudiante);
        }
        $em->flush();
        return $this->redirectToRoute('colegioframeTablaEstud');
    }

    public function promedioEdades(Request $request){
        //dump($request->request);exit;
        foreach ($request->request as $dato) {
            $datoEdad[]=$dato;
        }
        $promEdad=array_sum($datoEdad)/count($datoEdad);
       return new Response(json_encode( array("Resultado"=>$promEdad) ));
    }

    public function validaIdentificacion($identificacion, estudianteRepository $em){
        $existe = $em->findOneBy(array('identificacion' => $identificacion));
        if (empty($existe)) {
            $validacion=false;
        }else{
            $validacion=true;
        }
        return New Response(json_encode(array("res"=>$validacion)));
    }
}


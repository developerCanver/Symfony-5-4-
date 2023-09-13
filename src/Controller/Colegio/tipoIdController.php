<?php 
namespace App\Controller\Colegio;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\Colegio\tipoIdRepository;
use App\Entity\Colegio\tipoId;
use Doctrine\ORM\EntityManager;

class tipoIdController extends AbstractController{
    //un regisro
     public function accesoAutoWriring($id,tipoIdRepository $tipoIdRepository){
       $tipoId=$tipoIdRepository->find($id);
     //    dd($tipoId); exit;
       return $this->render("Colegio\TipoId\autoWiring.html.twig",array('tipoId'=>$tipoId));
    
    }
    //un regisro
    public function accesoEntity($id, EntityManagerInterface $EM){
        $tipo=$EM->getRepository(tipoId::class)->find($id);
        return $this->render("Colegio\TipoId\autoWiring.html.twig",array('tipoId'=>$tipo));

    }
    //un regisro,no dispone de id
    public function accesoFinOnBy($id, EntityManagerInterface $EM){
        $tipo=$EM->getRepository(tipoId::class)->findOneBy(array('id'=>$id, 'tipo_id'=>'Cedula'));
        return $this->render("Colegio\TipoId\autoWiring.html.twig",array('tipoId'=>$tipo));

    }
    //arreglo, no dispone de id
    public function accesoFO( EntityManagerInterface $EM){
        $registros=$EM->getRepository(tipoId::class)->findBy(array('tipo_id'=>'Pasaporte'));
        return $this->render("Colegio\TipoId\autoWiring.html.twig",array('tipoId'=>$registros));

    }

    public function accesoFAll(EntityManagerInterface $EM){
        $registrosTi=$EM->getRepository(tipoId::class)->findAll();
        return $this->render("Colegio\TipoId\autoWiring.html.twig",array('registrosTi'=>$registrosTi));

    }

    public function accesoQB(EntityManagerInterface $EM){
        $registrosTi=$EM->getRepository(tipoId::class)->buscarLetra('a');
        return $this->render("Colegio\TipoId\autoWiring.html.twig",array('registrosTi'=>$registrosTi));

    }

    public function accesoDQL(EntityManagerInterface $EM){
        $registrosTi=$EM->getRepository(tipoId::class)->buscarxDQL('a');
        return $this->render("Colegio\TipoId\autoWiring.html.twig",array('registrosTi'=>$registrosTi));

    }

}


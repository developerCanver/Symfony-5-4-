<?php

namespace App\Repository\Colegio;

use App\Entity\Colegio\estudiante;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Expr\FuncCall;

/**
 * @extends ServiceEntityRepository<estudiante>
 *
 * @method estudiante|null find($id, $lockMode = null, $lockVersion = null)
 * @method estudiante|null findOneBy(array $criteria, array $orderBy = null)
 * @method estudiante[]    findAll()
 * @method estudiante[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class estudianteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, estudiante::class);
    }

    public function add(estudiante $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(estudiante $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function lisEst(){
        $em=$this->getEntityManager();
        $query=$em->createQuery('select estudiantes from App\Entity\Colegio\estudiante estudiantes
        order by estudiantes.apellidos, estudiantes.nombres desc');
        return $query->getResult();
    }

  public function FltsEstudiante($formulario){

    $parameters = array();

    if (!empty($formulario['id'])) {
      $cont1 = "estudiante.id = :id";
      $parameters[':id'] = $formulario['id'];
    }else {
      $cont1= "1 = 1";
    }

    if (!empty($formulario['identificacion'])) {
        $cont2 = "estudiante.identificacion = :identificacion";
        $parameters[':identificacion'] = $formulario['identificacion'];
    }else {
        $cont2= "1 = 1";
    }

    if (!empty($formulario['nombres'])) {
        $cont3 = " lower(concat(estudiante.apellidos,' ',estudiante.nombres)) like :nombres or lower(concat(estudiante.nombres,' ',estudiante.apellidos)) like :nombres ";
        //$cont3 = " (concat(estudiante.apellidos,' ',estudiante.nombres)) = :nombres or (concat(estudiante.nombres,' ',estudiante.apellidos)) = :nombres";
        $parameters[':nombres'] = '%'. strtolower($formulario['nombres']).'%';
    }else {
        $cont3= "1 = 1";
    }
        
    //->where('tipoId.tipo_id like :letra')
    //->setParameter('letra', '%'.$letra.'%') 

    // dump($parameters);dump($cont1);exit;
    return $this->createQueryBuilder('estudiante')
                //->Where('1=1')
                ->andWhere($cont1)
                ->andWhere($cont2)
                ->andWhere($cont3)
                ->setParameters($parameters)
                ->orderBy('estudiante.id', 'ASC')
                ->getQuery()
                ->getResult();
  }

    //    /**
    //     * @return estudiante[] Returns an array of estudiante objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?estudiante
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

<?php

namespace App\Repository\Colegio;

use App\Entity\Colegio\notas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<notas>
 *
 * @method notas|null find($id, $lockMode = null, $lockVersion = null)
 * @method notas|null findOneBy(array $criteria, array $orderBy = null)
 * @method notas[]    findAll()
 * @method notas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class notasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, notas::class);
    }

    public function add(notas $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(notas $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function construirPendiente($id){

        $em=$this->getEntityManager()->getConnection();
        $sql=" Insert into colegio.notas(id,materia_id, estudiante_id,nota)
            select nextval('colegio.notas_id_seq'),materias.id,estudiantes.id,0
            from colegio.materias,colegio.estudiantes
            where estudiantes.id=:idEstudiante
            and materias.id not in (select materia_id from colegio.notas where estudiante_id=:idEstudiante)
            RETURNING notas.id,materia_id";
            
      $excec=$em->prepare($sql);
      $res=$excec->executeQuery(['idEstudiante'=>$id])->fetchAllAssociative();
      return $res;
    }
//    /**
//     * @return notas[] Returns an array of notas objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?notas
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

<?php

namespace App\Repository\Colegio;

use App\Entity\Colegio\tipoId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<tipoId>
 *
 * @method tipoId|null find($id, $lockMode = null, $lockVersion = null)
 * @method tipoId|null findOneBy(array $criteria, array $orderBy = null)
 * @method tipoId[]    findAll()
 * @method tipoId[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class tipoIdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, tipoId::class);
    }

    public function add(tipoId $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(tipoId $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function buscarLetra($letra){
        $result =$this->createQueryBuilder('tipoId')
                        ->where('tipoId.tipo_id like :letra')
                        ->setParameter('letra', '%'.$letra.'%')
                        ->orderBy('tipoId.id','DESC');
                        
        $query = $result->getQuery();
        return $query->execute();            
    }

    public function buscarLetra_query_builde($letra){
        return $result =$this->createQueryBuilder('tipoId')
                        ->where('tipoId.tipo_id like :letra')
                        ->setParameter('letra', '%'.$letra.'%')
                        ->orderBy('tipoId.id','DESC');
                        
       // $query = $result->getQuery();
        //return $query->execute();            
    }

    public function buscarxDQL($letra){
        $em=$this->getEntityManager();
        $query=$em->createQuery('select tipoId from App\Entity\Colegio\tipoId  tipoId where tipoId.tipo_id like :letra order by tipoId.id asc')
                    ->setParameter('letra', '%'.$letra.'%');

        return $query->execute();    

    }

//    /**
//     * @return tipoId[] Returns an array of tipoId objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?tipoId
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

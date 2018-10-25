<?php

namespace App\Repository;

use App\Entity\Fortune;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class FortuneRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Fortune::class);
    }

    public function findRandom()
    {
        $ids = $this->createQueryBuilder('f')
               ->select('f.id')
               ->getQuery()->getResult();
	if ( count( $ids ) == 0 ) {
            return FALSE;
        }
        $selectedId = array_rand( $ids );
        $dbId       = $ids[$selectedId]['id'];

	       return $this->createQueryBuilder('f')
               ->select('f')
               ->where( 'f.id = :id' )
               ->setParameter('id', $dbId)
               ->getQuery()->getSingleResult();
    }
}

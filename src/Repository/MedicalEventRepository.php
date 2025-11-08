<?php

namespace App\Repository;

use App\Entity\MedicalEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
/**
 * @extends ServiceEntityRepository<MedicalEvent>
 */
class MedicalEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MedicalEvent::class);
    }

       /**
        * @return MedicalEvent[] Returns an array of MedicalEvent objects
        */
    
       // 
       // lister tous les evenements de l'utilsateur connecté
       public function findByUser(User $user): array
{
    return $this->createQueryBuilder('m')
        ->where('m.patient = :user')
        ->orWhere('m.doctor = :user')
        ->setParameter('user', $user)
        ->orderBy('m.date', 'DESC')
        ->getQuery()
        ->getResult();
}
// afficher un medicalEvent relié à un user connecté
public function findOneByUser(User $user, MedicalEvent $medicalEventId): ?MedicalEvent
{
    return $this->createQueryBuilder('m')
        ->where('m.id = :id')
        ->andWhere('m.patient = :user OR m.doctor = :user')
        ->setParameter('id', $medicalEventId)
        ->setParameter('user', $user)
        ->getQuery()
        ->getOneOrNullResult();
}
     
}

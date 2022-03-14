<?php

namespace App\Repository;

use App\Entity\Activity;
use App\Form\model\FilterSearch;
use App\Form\FilterSearchType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Types\DateType;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Activity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Activity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Activity[]    findAll()
 * @method Activity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Activity::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Activity $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Activity $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


   
    public function filterSearch($activity)
    {   
      
       $qb = $this->createQueryBuilder('builder');

       $qb->select('buider');
        // filtre les activités par inscription
       if($registedMeActivity){
             $qb->orWhere(':participant MEMBER OF builder.participant')
                ->setParameter('participant', $participant);
       }
       if($unregistedMeActivity){
           $qb->orWhere(':participant MEMBER OF builder.participant')
           ->setParameter('participant', $participant);
       }

       if($activityOrganizer){
           $qb->orWhere('participant MEMBER OF builder.participant')
           ->setParameter('participant', $participant);
       }

       if($pastActivity){
           $qb->orWhere('participant MEMBER OF builder.participant')
           ->setParameter('participant',$participant);
       }

       if($campus !== null){
           $qb->andWhere('builder.campus=campus')
           ->setParameter('campus',$campus);
       }
       if($startDate !== null){
           $qb->andWhere('builder.startDateTime >= :startDate')
           ->setParameter('startDate', $startDate);
       }

       if($endDate !== null){
           $qb->andWhere('builder.endDateTime >= :endDate ')
           ->setParameter('endDate', $endDate);
       }

       if($search != null){
           $qb->andWhere('builder.name LIKE :search')
           ->setParameter('search', '%'.$search. '%');
       }

       return $qb->getQuery()->getResult();









    }
    
}

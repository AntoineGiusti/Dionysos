<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Activity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\Security;

/**
 * @method Activity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Activity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Activity[]    findAll()
 * @method Activity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivityRepository extends ServiceEntityRepository
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    /**
     * @var PaginatorInterface
     */

    public function __construct(ManagerRegistry $registry, Security $security, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Activity::class);
        $security->getUser();
        $this->paginator = $paginator;
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


    //INSTALLER LE BUNDLE composer require knplabs/knp-paginator-bundle POUR LA MISE EN PAGE

    /**
     * Récupère les produits en lien avec une recherche
     * @return PaginationInterface
     */

    public function findSearch(SearchData $search): PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('a')
            ->select('c', 'a')
            //Pour récupérer la liste des campus
            ->join('a.campus', 'c');


        //LA BARRE DE RECHERCHE FONCTIONNE///////////////////////////////////
        if (!empty($search->q)) {
            $query = $query
                //Le nom de notre activité soit comme le paramètre q
                ->andWhere('a.name LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }
        /////////////////////////////////////////////////////////////////////


        //LA RECHERCHE PAR CAMPUS FONCTIONNE/////////////////////////////////
        if (!empty($search->campuses)) {
            $query = $query
                ->andWhere('c.id IN (:campuses)')
                ->setParameter('campuses', $search->campuses);
        }
        /////////////////////////////////////////////////////////////////////



        //ENTRE DATE 1 et DATE 2 FONCTIONNE /////////////////////////////////////


        if (!empty($search->date1)) {
            $query = $query
                ->andWhere('a.startDate >= (:date1) ')
                ->setParameter('date1', $search->date1);

        }
        if (!empty($search->date2)) {
            $query = $query
                ->andWhere('a.startDate <= (:date2) ')
                ->setParameter('date2', $search->date2);

        }
        ///////////////////////////////////////////////////////////////////////////

        if (!empty($search->isOrganizer)) {
            $query = $query
                ->andWhere('a.organizer = (:organizer)')
                ->setParameter('organizer', $search->isOrganizer);
        }


            $query = $query->getQuery();
            return $this->paginator->paginate(
                $query,
                $search->page,
                //Nombre max d'activités affichés lors de la recherche
                10,
            );

        }


//    public function filterSearch($activity)
//    {
//       $participant = $this->getUser();
//
//       $qb = $this->createQueryBuilder('builder');
//
//       $qb->select('builder');
//
//        // filtre les activités par inscription
//        if($registedMeActivity){
//             $qb->orWhere(':participant MEMBER OF builder.participant')
//                ->setParameter('participant', $participant);
//       }
//
//       if($unregistedMeActivity){
//           $qb->orWhere(':participant MEMBER OF builder.participant')
//           ->setParameter('participant', $participant);
//       }
//
//       //Filtre "Donc je suis l'organisateur"
//       if($activityOrganizer){
//           $qb->orWhere('participant MEMBER OF builder.participant')
//           ->setParameter('participant', $participant);
//       }
//
//       if($pastActivity){
//           $qb->orWhere('participant MEMBER OF builder.participant')
//           ->setParameter('participant',$participant);
//       }
//
//       if($campus !== null){
//           $qb->andWhere('builder.campus=campus')
//           ->setParameter('campus',$campus);
//       }
//       if($startDate !== null){
//           $qb->andWhere('builder.startDateTime >= :startDate')
//           ->setParameter('startDate', $startDate);
//       }
//
//       if($endDate !== null){
//           $qb->andWhere('builder.endDateTime >= :endDate ')
//           ->setParameter('endDate', $endDate);
//       }
//
//       if($search != null){
//           $qb->andWhere('builder.name LIKE :search')
//           ->setParameter('search', '%'.$search . '%');
//       }
//
//       return $qb->getQuery()->getResult();
//    }

    }

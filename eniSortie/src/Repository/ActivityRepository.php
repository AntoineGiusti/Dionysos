<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Activity;
use App\Entity\Participant;
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
     * @var Security
     */
    private $security;

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
        $this->security = $security;
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


        //SI ORGANISATEUR ////////////////////////////////////////////////////////
        if (!empty($search->isOrganizer)) {
            $user = $this->security->getUser();
            $query = $query
                ->andWhere('a.organizer = :organizer')
                ->setParameter(':organizer', $user);
        }
        /////////////////////////////////////////////////////////////////////////

        //INSCRIT A L'ACTIVITE////////////////////////////////////////////////////////////

        if(!empty($search->isRegistered)){
            $user=$this->security->getUser();
            $query = $query
                ->orWhere(':user MEMBER OF a.participant')
                ->setParameter('user', $user);
        }
        /////////////////////////////////////////////////////////////////////////////////
        ///

        //PAS INSCRIT A L'ACTIVITE//////////////////////////////////////////////////////
        if(!empty($search->isNotRegistered)){
            $user=$this->security->getUser();
            $query=$query
                ->orWhere(':user NOT MEMBER OF a.participant')
                ->setParameter('user',$user);
        }
        ///////////////////////////////////////////////////////////////////////////////

        //ACTIVITES PASSEES///////////////////////////////////////////////////////////

        if(!empty($search->passedActivity)){
            $query=$query
                ->andWhere('a.startDate <= :date ')
                ->setParameter(':date',  new \DateTime);
        }
        /////////////////////////////////////////////////////////////////////////////

            $query = $query->getQuery();
            return $this->paginator->paginate(
                $query,
                $search->page,
                //Nombre max d'activités affichés lors de la recherche
                20,
            );
        }
    }

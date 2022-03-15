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

    /**
     * Récupère les produits en lien avec une recherche
     * @return PaginationInterface
     */

    public function findSearch(SearchData $search): PaginationInterface
    {
        $user = $this->security->getUser();
        $query = $this
            ->createQueryBuilder('a')
            ->select('c', 'a')
            //Pour récupérer la liste des campus
            ->innerJoin('a.campus', 'c')
            ->leftJoin('a.organizer', 'o');

        if (!empty($search->getQ())) {
            $query
                //Le nom de notre activité soit comme le paramètre q
                ->andWhere('a.name LIKE :q')
                ->setParameter('q', "%{$search->getQ()}%");
        }

        if (!empty($search->getCampus())) {
            $query
                ->andWhere('c.id = :campuses')
                ->setParameter('campuses', $search->getCampus());
        }

        if (!empty($search->getDate1())) {
            $query
                ->andWhere('a.startDate >= :date1 ')
                ->setParameter('date1', $search->getDate1());
        }
        if (!empty($search->getDate2())) {
            $query
                ->andWhere('a.startDate <= :date2 ')
                ->setParameter('date2', $search->getDate2());
        }

        if ($search->getIsOrganizer()) {
            $query
                ->andWhere('a.organizer = :organizer')
                ->setParameter(':organizer', $user);
        }

            if($search->getIsRegistered()){
                $query
                    ->andWhere(':user MEMBER OF a.participant')
                    ->setParameter('user', $user);
            }

            if($search->getIsNotRegistered()){
                $query
                    ->andWhere(':user NOT MEMBER OF a.participant')
                    ->setParameter('user',$user);
            }


        if(!empty($search->passedActivity)){
            $query
                ->andWhere('a.startDate <= :date ')
                ->setParameter(':date',  new \DateTime);
        }
            $query = $query->getQuery();
            return $this->paginator->paginate(
                $query,
                $search->page,
                //Nombre max d'activités affichés lors de la recherche
                20,
            );
        }
    }

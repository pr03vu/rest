<?php

namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Users::class);
    }


    /**
     * @param array $data
     * @throws ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function hydrate(array $data) : void
    {
        $users = new Users();

        foreach($data as $property => $value) {
            $setterName = 'set' . $property;

            if (method_exists($users, $setterName)) {
                $users->{$setterName}($value);
            }
        }

        $this->getEntityManager()->persist($users);
        $this->getEntityManager()->flush();

    }

    /**
     * @param string $sort
     * @return Query
     */
    public function getUsers(string $sort = 'ASC')
    {
        $query =  $this->createQueryBuilder('users')
            ->orderBy('users.id', $sort);

        return $query->getQuery();
    }

    /**
     * @param string $firstName
     * @return mixed
     */
    public function findByFirstName(string $firstName)
    {
        return $this->createQueryBuilder('users')
            ->where('users.firstName LIKE :firstName')
            ->setParameter('firstName', '%' . $firstName . '%')
            ->setMaxResults(Users::LIMIT)
            ->getQuery()
            ->getResult();
    }
}

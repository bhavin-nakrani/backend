<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function getDataTableListings($order, $search)
    {
        $column = null;
        $orderDir = 'asc';
        if (!empty($order)) {
            $columnId = $order['column'];
            $orderDir = $order['dir'];
            $column = $this->columns($columnId);
        }

        $sql = $this->createQueryBuilder('u')
            ->select('u.id, u.name, u.photo, u.email, u.phone, r.name as roles')
            ->leftJoin('u.userRole', 'r')
        ;

        if (!empty($column)) {
            $sql->orderBy('u.'.$column, $orderDir);
        }

        if (!empty($search)) {
            foreach ($this->columns() as $key => $field) {
                $sql->orWhere('u.'.$field.' LIKE :searchTxt');
            }
            $sql->setParameter('searchTxt', '%'.$search.'%');
        }

        $query = $sql;

        return $query->getQuery();
    }

    private function columns($id = '')
    {
        $cols = ['id', 'photo', 'name', 'email', 'phone', 'roles'];
        if (array_key_exists($id, $cols)) {
            return $cols[$id];
        }

        return $cols;
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

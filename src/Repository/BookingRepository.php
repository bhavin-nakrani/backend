<?php

namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
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

        $sql = $this->createQueryBuilder('b')
            ->select('b.id, b.title, DATE_FORMAT(b.beginAt, \'%Y-%m-%d %H:%i:%s\') as beginAt
            , DATE_FORMAT(b.endAt, \'%Y-%m-%d %H:%i:%s\') as endAt')
        ;

        if (!empty($column)) {
            $sql->orderBy('b.'.$column, $orderDir);
        }

        if (!empty($search)) {
            foreach ($this->columns() as $key => $field) {
                $sql->orWhere('b.'.$field.' LIKE :searchTxt');
            }
            $sql->setParameter('searchTxt', '%'.$search.'%');
        }

        $query = $sql;

        return $query->getQuery();
    }

    private function columns($id = '')
    {
        $cols = ['id', 'title', 'beginAt', 'endAt'];
        if (array_key_exists($id, $cols)) {
            return $cols[$id];
        }

        return $cols;
    }
}

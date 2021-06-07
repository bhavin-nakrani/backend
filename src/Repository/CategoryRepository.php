<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
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

        $sql = $this->createQueryBuilder('c')
            ->select('c.id, c.title, c.slug')
        ;

        if (!empty($column)) {
            $sql->orderBy('c.'.$column, $orderDir);
        }

        if (!empty($search)) {
            foreach ($this->columns() as $key => $field) {
                $sql->orWhere('c.'.$field.' LIKE :searchTxt');
            }
            $sql->setParameter('searchTxt', '%'.$search.'%');
        }

        $query = $sql;

        return $query->getQuery();
    }

    private function columns($id = '')
    {
        $cols = ['id', 'title', 'slug'];
        if (array_key_exists($id, $cols)) {
            return $cols[$id];
        }

        return $cols;
    }
}

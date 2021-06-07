<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
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

        $sql = $this->createQueryBuilder('a')
            ->select('a.id, a.title, a.slug, a.isPublish, 
            DATE_FORMAT(a.updatedAt, \'%Y-%m-%d %H:%i:%s\') as updatedAt, c.title AS category')
            ->leftJoin('a.category', 'c')
        ;

        if (!empty($column)) {
            $sql->orderBy('a.'.$column, $orderDir);
        }

        if (!empty($search)) {
            foreach ($this->columns() as $key => $field) {
                if ('category' == $field) {
                    $sql->orWhere('c.title LIKE :searchTxt');
                } else {
                    $sql->orWhere('a.'.$field.' LIKE :searchTxt');
                }
            }
            $sql->setParameter('searchTxt', '%'.$search.'%');
        }

        $query = $sql;

        return $query->getQuery();
    }

    private function columns($id = '')
    {
        $cols = ['id', 'title', 'slug', 'isPublish', 'category', 'updatedAt'];
        if (array_key_exists($id, $cols)) {
            return $cols[$id];
        }

        return $cols;
    }
}

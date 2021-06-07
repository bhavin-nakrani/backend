<?php

namespace App\Repository;

use App\Entity\Role;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Role|null find($id, $lockMode = null, $lockVersion = null)
 * @method Role|null findOneBy(array $criteria, array $orderBy = null)
 * @method Role[]    findAll()
 * @method Role[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Role::class);
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

        $sql = $this->createQueryBuilder('r')
            ->select('r.id, r.name, r.isAdd, r.isEdit, r.isDelete, r.isView')
        ;

        if (!empty($column)) {
            $sql->orderBy('r.'.$column, $orderDir);
        }

        if (!empty($search)) {
            foreach ($this->columns() as $key => $field) {
                $sql->orWhere('r.'.$field.' LIKE :searchTxt');
            }
            $sql->setParameter('searchTxt', '%'.$search.'%');
        }

        $query = $sql;

        return $query->getQuery();
    }

    private function columns($id = '')
    {
        $cols = ['id', 'name', 'isAdd', 'isEdit', 'isDelete', 'isView'];
        if (array_key_exists($id, $cols)) {
            return $cols[$id];
        }

        return $cols;
    }
}

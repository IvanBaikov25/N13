<?php
namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Customer;

class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    // 1️⃣ Сколько заказов у каждого клиента
    public function findCustomerOrderCounts(): array
    {
        return $this->createQueryBuilder('c')
            ->select('c.id, c.name, c.email, COUNT(o.id) as orderCount')
            ->leftJoin('c.orders', 'o')
            ->groupBy('c.id')
            ->orderBy('orderCount', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findTop3CustomersByTotalSpent(): array
    {
        return $this->createQueryBuilder('c')
            ->select('c.id, c.name, c.email, SUM(o.total) as totalSpent')
            ->leftJoin('c.orders', 'o')
            ->groupBy('c.id')
            ->having('totalSpent > 0')
            ->orderBy('totalSpent', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }
}
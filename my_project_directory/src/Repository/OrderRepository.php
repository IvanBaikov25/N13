<?php
namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, \App\Entity\Order::class);
    }

    public function findAverageOrderTotal(): ?string
    {
        $result = $this->createQueryBuilder('o')
            ->select('AVG(o.total)')
            ->getQuery()
            ->getSingleScalarResult();

        return $result ? number_format((float) $result, 2, '.', '') : '0.00';
    }
    public function findRecentOrdersWithCustomer(int $limit = 10): array
{
    return $this->createQueryBuilder('o')
        ->select('o.id, o.total, c.name as customerName, o.createdAt')
        ->join('o.customer', 'c')
        ->orderBy('o.createdAt', 'DESC')
        ->setMaxResults($limit)
        ->getQuery()
        ->getResult();
}
}
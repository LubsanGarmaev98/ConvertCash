<?php

namespace App\Repository;

use App\Entity\Currency;

use DateTime;
use Doctrine\ORM\EntityRepository;

class CurrencyRepository extends EntityRepository
{
    public function add(Currency $entity, bool $flush = false): void
    {
        #persist сохранение в памяти, flush сохранение в бд
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findOneByCharCode(string $charCode): ?Currency
    {
        return $this->findOneBy(['charCode' => $charCode]);
    }
    public function findOneByData(): array
    {
        return $this->createQueryBuilder('c')
            ->select('c.dateTime')
            ->getQuery()
            ->getArrayResult();
    }

    public function deleteOldValute(): void
    {
        $entities = $this->findAll();

        foreach ($entities as $entity)
        {
            $this->getEntityManager()->remove($entity);
        }
        $this->getEntityManager()->flush();
    }

    public function delete(Currency $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
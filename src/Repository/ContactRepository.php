<?php

/*
 * This file is part of the "Gen RabbitMQ test" project.
 * (c) Sergey Rybak <srybak007@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use App\DTO\ContactQueryDTO;
use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository implements ContactRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    public function save(Contact $contact): Contact
    {
        $em = $this->getEntityManager();
        $em->persist($contact);
        $em->flush();

        return $contact;
    }

    public function forceCloseConnection()
    {
        $em = $this->getEntityManager();

        $em->clear();
        $em->getConnection()->close();
    }

    public function query(ContactQueryDTO $queryDTO): ?iterable
    {
        return $this->prepareQuery($queryDTO)
            ->setMaxResults($queryDTO->getLength())
            ->setFirstResult($queryDTO->getStart())
            ->getQuery()
            ->getResult();

    }

    public function length(ContactQueryDTO $queryDTO): int
    {

        return intval($this->prepareQuery($queryDTO)
            ->select('COUNT(c)')
            ->getQuery()
            ->getSingleScalarResult());
    }

    private function prepareQuery(ContactQueryDTO $queryDTO): QueryBuilder
    {
        $qb = $this->createQueryBuilder('c');

        if ($queryDTO->getSearch()) {
            $qb
                ->where('c.firstName LIKE :search')
                ->orWhere('c.lastName LIKE :search')
                ->orWhere('c.phoneNumbers LIKE :search')
                ->setParameter('search', "%{$queryDTO->getSearch()}%");
        }

        if ($queryDTO->getOrderBy()) {
            $ascDesc = $queryDTO->getOrderDir() ?? 'ASC';
            $qb->orderBy("c.{$queryDTO->getOrderBy()}", strtoupper($ascDesc));
        }

        return $qb;
    }
}

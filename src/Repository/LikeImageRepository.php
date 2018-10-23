<?php

namespace App\Repository;

use App\Entity\LikeImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LikeImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method LikeImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method LikeImage[]    findAll()
 * @method LikeImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LikeImageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LikeImage::class);
    }

//    /**
//     * @return LikeImage[] Returns an array of LikeImage objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LikeImage
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /* Search if  image is liked by user */
    public function findItem(int $user, int $image): array
    {
        $qb = $this->createQueryBuilder('l');

        $qb
            ->where('l.user_id = ?1 AND l.imageId = ?2')
            ->setParameters(array(
                1 => $user,
                2 => $image
            ));

        return $qb
            ->getQuery()
            ->getResult();

    }

}

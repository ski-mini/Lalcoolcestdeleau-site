<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Deck
 *
 */
class Deck extends EntityRepository
{
    /**
     * Retourne la liste des decks en fonction du type
     * @param /FOSbundle/Entity/User $user
     *
     * @return array
     */
    public function listByUser($user)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('d')
            ->from($this->_entityName, 'd')
            ->where('d.name IS NOT NULL')
            ->andWhere('d.user = :user')
            ->setParameter('user', $user)
            ->andWhere('d.archived = :archived')
            ->setParameter('archived', '0');

        return $qb->getQuery()->getResult();
    }

    /**
     * JSON
     * Retourne la liste des decks en fonction du type
     * @param int $decktype
     *
     * @return array
     */
    public function listByDecktype($decktype)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('d')
            ->from($this->_entityName, 'd')
            ->join('d.user', 'u')
            ->addSelect('u.username')
            ->where('d.visibility = :visibility')
            ->setParameter('visibility', '1')
            ->andWhere('d.name IS NOT NULL')
            ->andWhere('d.decktype = :decktype')
            ->setParameter('decktype', $decktype)
            ->andWhere('d.archived = :archived')
            ->setParameter('archived', '0');

        return $qb->getQuery()->getResult();
    }

    /**
     * JSON
     * Retourne un deck par rapport à son id
     * @param int $id
     *
     * @return array
     */
    public function oneDeck($id)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('d')
            ->from($this->_entityName, 'd')
            // ->join('d.rules', 'r')
            // ->addSelect('r')
            ->join('d.user', 'u')
            ->addSelect('u.username')
            ->where('d.visibility <> :visibility')
            ->setParameter('visibility', '3')
            ->andWhere('d.name IS NOT NULL')
            ->andWhere('d.id = :id')
            ->setParameter('id', $id)
            ->andWhere('d.archived = :archived')
            ->setParameter('archived', '0');

        return $qb->getQuery()->getResult();
    }

    /**
     * Retourne le rate le plus elevé
     * @return float
     */
    public function maxRate()
    {
        $queryBuilder = $this->createQueryBuilder('d');
        $queryBuilder->select('MAX(d.rate) AS max_rate');
        $queryBuilder->where('d.archived = 0');

        $result = $queryBuilder->getQuery()->getResult();

        if(!empty($result[0]['max_rate']))
            return $result[0]['max_rate'];
        else
            return 5;
    }

    /**
     * Retourne le dl le plus elevé
     * @return int
     */
    public function maxDownload()
    {
        $queryBuilder = $this->createQueryBuilder('d');
        $queryBuilder->select('MAX(d.download) AS max_download');
        $queryBuilder->where('d.archived = 0');

        $result = $queryBuilder->getQuery()->getResult();

        if(!empty($result[0]['max_download']))
            return $result[0]['max_download'];
        else
            return 1;
    }

}

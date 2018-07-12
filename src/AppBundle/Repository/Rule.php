<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Rule
 *
 */
class Rule extends EntityRepository
{

    /**
     * JSON
     * Retourne la liste des decks en fonction du type
     * @param int $id
     *
     * @return array
     */
    public function smallListByDeck($id)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('r')
            ->from($this->_entityName, 'r')
            ->addSelect('RAND() as HIDDEN rand')
            ->join('r.decks', 'd')
            ->where('d.id = :id')
            ->setParameter('id', $id)
            ->orderBy('rand')
            ->setMaxResults(3);

        return $qb->getQuery()->getResult();
    }

    /**
     * JSON
     * Retourne la liste des decks en fonction du type
     * @param int $id
     *
     * @return array
     */
    public function listByDeck($id)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('r')
            ->from($this->_entityName, 'r')
            ->join('r.decks', 'd')
            ->where('d.id = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getResult();
    }
}

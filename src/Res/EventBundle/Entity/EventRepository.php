<?php

namespace Res\EventBundle\Entity;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query;
use Doctrine\DBAL\Query\QueryBuilder;
use DoctrineExtensions\Types\Date;
use Doctrine\ORM\EntityRepository;
use Res\EventBundle\Entity\Event;
use Res\ImageBundle\Entity\Image;

class EventRepository extends EntityRepository
{
    public function findEventsFromDate($month = null, $year = null)
    {
        $fullDate = $year . '-0' . $month . '-01';
        $dateFrom = new \DateTime($fullDate);
        $dateTo = new \DateTime($fullDate);
        $dateTo->modify('+1 month');
        $dateTo->modify('-1 day');

        $qb = $this->createQueryBuilder('e');

        $qb->select('e');
        //$qb->join('e.images', 'i');
        $and = $qb->expr()->andx();
        if ($month && $year) {
            $and->add($qb->expr()->gte('e.date', '\''.$dateFrom->format('Y-m-d H:i:s').'\''));
            $and->add($qb->expr()->lte('e.date', '\''.$dateTo->format('Y-m-d H:i:s').'\''));
        }

        $qb->where($and);

        return $qb->getQuery()->getResult();
    }
}
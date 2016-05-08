<?php

namespace Notimeo\CoreBundle\Search;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder as DoctrineQueryBuilder;
use Symfony\Component\HttpFoundation;

/**
 * @author Krzysztof Trzos <k.trzos@notimeo.pl>
 */
class QueryBuilder
{
    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * @var HttpFoundation\Request
     */
    private $request;

    public function __construct(Registry $doctrine, HttpFoundation\RequestStack $request)
    {
        $this->doctrine = $doctrine;
        $this->request  = $request->getCurrentRequest();
    }

    /**
     * Creates the query builder used to get all the records displayed by the
     * "list" view.
     *
     * @param array  $entityConfig
     * @param string $sortDirection
     * @param string $sortField
     *
     * @return DoctrineQueryBuilder
     */
    public function createListQueryBuilder(array $entityConfig, $sortField, $sortDirection)
    {
        /** @var $em EntityManager */
        $em = $this->doctrine->getManagerForClass($entityConfig['class']);
        /** @var $queryBuilder DoctrineQueryBuilder */
        $queryBuilder = $em->createQueryBuilder()
            ->select('entity')
            ->from($entityConfig['class'], 'entity');

        if($this->request->query->has('by_property')) {
            $property = $this->request->query->get('by_property');

            if(property_exists($entityConfig['class'], $property)) {
                $queryBuilder->andWhere(
                    'entity.'.$property.
                    ' = '.
                    (int)$this->request->query->get('by_property_val')
                );
            }
        }

        if(null !== $sortField) {
            $queryBuilder->orderBy('entity.'.$sortField, $sortDirection);
        }

        return $queryBuilder;
    }
}

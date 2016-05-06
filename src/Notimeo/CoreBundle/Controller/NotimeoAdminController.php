<?php

namespace Notimeo\CoreBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController;
use JavierEguiluz\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Notimeo\LocaleBundle\Locale\EntityExt\Locales;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\QueryBuilder;

/**
 * Class NotimeoAdminController
 *
 * @package Notimeo\CoreBundle\Controller
 */
class NotimeoAdminController extends AdminController
{
    /**
     * The method that is executed when the user performs a 'list' action on an
     * entity.
     *
     * @return Response
     */
    protected function listAction()
    {
        $this->dispatch(EasyAdminEvents::PRE_LIST);

        $fields    = $this->entity['list']['fields'];
        $paginator = $this->findAll(
            $this->entity['class'],
            $this->request->query->get('page', 1),
            $this->config['list']['max_results'],
            $this->request->query->get('sortField'),
            $this->request->query->get('sortDirection')
        );

        if(is_subclass_of($this->entity['class'], Locales::class)) {
            $locale = $this->request->attributes->get('_locale');

            foreach($paginator->getCurrentPageResults() as $item) {
                /* @var $item Locales */
                $item->setCurrentLang($locale);
            }
        }

        $this->dispatch(
            EasyAdminEvents::POST_LIST,
            array('paginator' => $paginator)
        );

        $deleteForm = $this->createDeleteForm($this->entity['name'], '__id__');

        dump($this->entity['templates']['list']);

        return $this->render($this->entity['templates']['list'], array(
            'paginator'            => $paginator,
            'fields'               => $fields,
            'delete_form_template' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates Query Builder instance for all the records.
     *
     * @param string      $entityClass
     * @param string      $sortDirection
     * @param string|null $sortField
     *
     * @return QueryBuilder The Query Builder instance
     */
    protected function createListQueryBuilder(
        $entityClass, $sortDirection, $sortField = null
    )
    {
        return $this
            ->get('notimeo.query_builder')
            ->createListQueryBuilder($this->entity, $sortField, $sortDirection);
    }
}
<?php
namespace Notimeo\BannersBundle\EventListener;

use Notimeo\BannersBundle\Entity;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class PageAuthorUpdater
 *
 * @package    Notimeo\BannersBundle
 * @subpackage EventListener
 */
class BannersAuthorSubscriber implements EventSubscriber
{
    private $tokenStorage;

    /**
     * PageAuthorUpdater constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            'prePersist',
            'preUpdate',
        );
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->update($args, 'add');
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->update($args, 'edit');
    }

    /**
     * @param  LifecycleEventArgs $args
     * @param  string             $type
     */
    public function update(LifecycleEventArgs $args, $type)
    {
        $currentUser = null;
        $entity      = $args->getEntity();

        if(null !== $this->tokenStorage->getToken()) {
            $currentUser = $this->tokenStorage->getToken()->getUser();
        }

        if(
            !$entity instanceof Entity\Banner
            && !$entity instanceof Entity\BannerCategory
        ) {
            return;
        }

        if('add' === $type) {
            $entity->setAuthor($currentUser);
        } else {
            $entity->setUpdatedBy($currentUser);
        }
    }
}
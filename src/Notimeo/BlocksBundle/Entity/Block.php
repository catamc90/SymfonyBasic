<?php

namespace Notimeo\BlocksBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Notimeo\UserBundle\Entity\User;

/**
 * Block entity class.
 *
 * @ORM\Table(name="blocks")
 * @ORM\Entity(repositoryClass="Notimeo\BlocksBundle\Repository\BlockRepository")
 * @HasLifecycleCallbacks
 */
class Block
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * Content of this block.
     *
     * @var string
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $updateDate;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="Notimeo\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    private $author;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="Notimeo\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="updatedby_id", referencedColumnName="id")
     */
    private $updatedBy;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="BlockRegion", inversedBy="regions")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    private $region;

    /**
     * @var int
     * @ORM\Column(name="region_weight", type="integer")
     */
    private $regionWeight = 0;

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateModifiedDatetime()
    {
        $this->setUpdateDate(new \DateTime());
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Block
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set updateDate
     *
     * @param \DateTime $updateDate
     *
     * @return Block
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * Get updateDate
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * Set author
     *
     * @param User $author
     *
     * @return Block
     */
    public function setAuthor(User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set updatedBy
     *
     * @param User $updatedBy
     *
     * @return Block
     */
    public function setUpdatedBy(User $updatedBy = null)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return User
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Block
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set regionWeight
     *
     * @param integer $regionWeight
     *
     * @return Block
     */
    public function setRegionWeight($regionWeight)
    {
        $this->regionWeight = $regionWeight;

        return $this;
    }

    /**
     * Get regionWeight
     *
     * @return integer
     */
    public function getRegionWeight()
    {
        return $this->regionWeight;
    }

    /**
     * Set region
     *
     * @param BlockRegion $region
     *
     * @return Block
     */
    public function setRegion(BlockRegion $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return BlockRegion
     */
    public function getRegion()
    {
        return $this->region;
    }
}

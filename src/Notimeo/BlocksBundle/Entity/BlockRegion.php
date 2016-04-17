<?php

namespace Notimeo\BlocksBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Notimeo\UserBundle\Entity\User;

/**
 * Category
 *
 * @ORM\Table(name="blocks_regions")
 * @ORM\Entity(repositoryClass="Notimeo\BlocksBundle\Repository\BlockRegionRepository")
 * @HasLifecycleCallbacks
 */
class BlockRegion
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     * @ORM\Column(name="update_date", type="datetime")
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
     * @ORM\OneToMany(targetEntity="Block", mappedBy="region")
     */
    private $regions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->regions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return string
     */
    function __toString()
    {
        return $this->name;
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
     * Set name
     *
     * @param string $name
     *
     * @return BlockRegion
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set updateDate
     *
     * @param \DateTime $updateDate
     *
     * @return BlockRegion
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
     * @return BlockRegion
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
     * @return BlockRegion
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
     * Add banner
     *
     * @param Block $banner
     *
     * @return BlockRegion
     */
    public function addBlock(Block $banner)
    {
        $this->regions[] = $banner;

        return $this;
    }

    /**
     * Remove banner
     *
     * @param Block $banner
     */
    public function removeBlock(Block $banner)
    {
        $this->regions->removeElement($banner);
    }

    /**
     * Get banners
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRegions()
    {
        return $this->regions;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateModifiedDatetime()
    {
        $this->setUpdateDate(new \DateTime());
    }

    /**
     * Add region
     *
     * @param \Notimeo\BlocksBundle\Entity\Block $region
     *
     * @return BlockRegion
     */
    public function addRegion(\Notimeo\BlocksBundle\Entity\Block $region)
    {
        $this->regions[] = $region;

        return $this;
    }

    /**
     * Remove region
     *
     * @param \Notimeo\BlocksBundle\Entity\Block $region
     */
    public function removeRegion(\Notimeo\BlocksBundle\Entity\Block $region)
    {
        $this->regions->removeElement($region);
    }
}

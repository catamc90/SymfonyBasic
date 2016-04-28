<?php

namespace Notimeo\PageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Notimeo\LocaleBundle\Locale\EntityExt\Locales;
use Notimeo\PageBundle\Entity\Page\PageFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Notimeo\UserBundle\Entity\User;
use Notimeo\LocaleBundle\Validator\Constraints as NotimeoLocaleAssert;

/**
 * Page
 *
 * @ORM\Table(name="pages")
 * @ORM\Entity(repositoryClass="Notimeo\PageBundle\Repository\PageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Page extends Locales
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
     * @ORM\Column(name="is_published", type="boolean")
     */
    private $isPublished;

    /**
     * @Assert\Valid
     * @Assert\Count(min="1")
     * @NotimeoLocaleAssert\ContainsMainLocale()
     * @NotimeoLocaleAssert\OneLocalePerLang()
     * @ORM\OneToMany(
     *     targetEntity="Notimeo\PageBundle\Entity\Page\PageLocale",
     *     mappedBy="page",
     *     cascade={"persist","remove"},
     *     orphanRemoval=true
     * )
     * @var Page\PageLocale[]
     */
    protected $locales;

    /**
     * @Assert\Valid
     * @ORM\OneToMany(
     *     targetEntity="Notimeo\PageBundle\Entity\Page\PageFile",
     *     mappedBy="page",
     *     cascade={"persist","remove"},
     *     orphanRemoval=true
     * )
     * @var PageFile[]
     */
    private $pageFiles;

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
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param User $author
     */
    public function setAuthor(User $author)
    {
        $this->author = $author;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pageFiles = new ArrayCollection();
        $this->locales   = new ArrayCollection();

        if($this->locales->isEmpty()) {
//            $this->locales->add(new Page\PageLocale());
        }
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
     * Set whether this page is published or not.
     *
     * @param boolean $isPublished
     *
     * @return $this
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    /**
     * Check if page is published.
     *
     * @return boolean
     */
    public function getIsPublished()
    {
        return $this->isPublished;
    }

    /**
     * Set updateDate
     *
     * @param \DateTime $updateDate
     *
     * @return $this
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
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateModifiedDatetime()
    {
        $this->setUpdateDate(new \DateTime());
    }

    /**
     * Add pageFile
     *
     * @param PageFile $pageFile
     *
     * @return $this
     */
    public function addPageFile(PageFile $pageFile)
    {
        $this->pageFiles[] = $pageFile;
        $pageFile->setPage($this);

        return $this;
    }

    /**
     * Remove pageFile
     *
     * @param PageFile $pageFile
     */
    public function removePageFile(PageFile $pageFile)
    {
        $this->pageFiles->removeElement($pageFile);
    }

    /**
     * Get pageFiles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPageFiles()
    {
        return $this->pageFiles;
    }

    /**
     * Set updatedBy
     *
     * @param User $updatedBy
     *
     * @return $this
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
     * Add locale
     *
     * @param Page\PageLocale $locale
     *
     * @return $this
     */
    public function addLocale(Page\PageLocale $locale)
    {
        $this->locales[] = $locale;
        $locale->setPage($this);

        return $this;
    }

    /**
     * Remove locale
     *
     * @param Page\PageLocale $locale
     */
    public function removeLocale(Page\PageLocale $locale)
    {
        $this->locales->removeElement($locale);
    }

    /**
     * Get locales
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLocales()
    {
        return $this->locales;
    }
}

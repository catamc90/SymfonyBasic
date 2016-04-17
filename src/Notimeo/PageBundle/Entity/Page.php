<?php

namespace Notimeo\PageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Notimeo\UserBundle\Entity\User;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Page
 *
 * @ORM\Table(name="pages")
 * @ORM\Entity(repositoryClass="Notimeo\PageBundle\Repository\PageRepository")
 * @Gedmo\TranslationEntity(class="Notimeo\PageBundle\Entity\Page\PageTranslation")
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 */
class Page
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
     * @Gedmo\Translatable
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\Length(min="10")
     */
    private $title;

    /**
     * @var string
     * @Gedmo\Translatable
     * @ORM\Column(name="content", type="text")
     * @Assert\Length(min="10")
     */
    private $content;

    /**
     * @ORM\Column(name="is_published", type="boolean")
     */
    private $isPublished;

    /**
     * @ORM\OneToMany(
     *   targetEntity="Notimeo\PageBundle\Entity\Page\PageTranslation",
     *   mappedBy="object",
     *   cascade={"persist", "remove"}
     * )
     */
    private $translations;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @Assert\Valid
     * @ORM\OneToMany(
     *     targetEntity="PageFile",
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
        $this->translations = new ArrayCollection();
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
     * Set content
     *
     * @param string $content
     *
     * @return Page
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
     * Set whether this page is published or not.
     *
     * @param boolean $isPublished
     *
     * @return Page
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

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if($image) {
            $this->updateDate = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set updateDate
     *
     * @param \DateTime $updateDate
     *
     * @return Page
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
     * @return Page
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
     * @return Page
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

    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

    public function getTranslations()
    {
        return $this->translations;
    }

    public function addTranslation(Page\PageTranslation $t)
    {
        if (!$this->translations->contains($t)) {
            $this->translations[] = $t;
            $t->setObject($this);
        }
    }

    public function setTranslations($at)        // method used when values is set throught a type collection (add new throught the data-prototype)
    {
        foreach ($at as $t) {
            $this->addTranslation($t);
        }
        return $this;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Page
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
}

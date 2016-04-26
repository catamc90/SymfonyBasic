<?php

namespace Notimeo\PageBundle\Entity\Page;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;
use Notimeo\PageBundle\Entity\Page;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Page
 *
 * @ORM\Table(name="pages_locales")
 * @ORM\Entity(repositoryClass="Notimeo\PageBundle\Repository\PageLocaleRepository")
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 */
class PageLocale extends AbstractPersonalTranslation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="lang", type="string", length=5)
     */
    protected $lang;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @var string
     * @ORM\Column(name="content", type="text")
     */
    protected $content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    protected $image;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="image")
     * @Assert\Valid
     * @var File
     */
    protected $imageFile;

    /**
     * @ORM\ManyToOne(targetEntity="Notimeo\PageBundle\Entity\Page", inversedBy="locales")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id")
     */
    protected $page;

    /**
     * Set title
     *
     * @param string $title
     * @return $this
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
     * Set content
     *
     * @param string $content
     *
     * @return $this
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
     * Set page
     *
     * @param Page $page
     *
     * @return $this
     */
    public function setPage(Page $page = null)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set lang
     *
     * @param string $lang
     *
     * @return $this
     */
    public function setLang($lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * Get lang
     *
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }
}

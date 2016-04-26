<?php

namespace Notimeo\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="pages_files")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 */
class PageFile
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
     * @Assert\NotBlank()
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\Length(min="10", groups={"xxxx"})
     */
    private $title;

    /**
     * @ORM\Column(name="contract", type="string", length=255, nullable=true)
     * @var string
     */
    private $contract;

    /**
     * @Vich\UploadableField(mapping="user_contracts", fileNameProperty="contract")
     * @var File
     * @Assert\File(maxSize="2000k")
     */
    private $contractFile;

    /**
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="pageFiles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $page;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $updateDate;

    /**
     * PageFile constructor.
     */
    public function __construct() {
        $this->updateDate = new \DateTime();
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
     * Set contract
     *
     * @param string $contract
     *
     * @return PageFile
     */
    public function setContract($contract)
    {
        $this->contract = $contract;

        return $this;
    }

    /**
     * Get contract
     *
     * @return string
     */
    public function getContract()
    {
        return $this->contract;
    }

    public function setContractFile(File $image = null)
    {
        $this->contractFile = $image;

        if($image) {
            $this->updateDate = new \DateTime('now');
        }
    }

    public function getContractFile()
    {
        return $this->contractFile;
    }

    /**
     * Set page
     *
     * @param \Notimeo\PageBundle\Entity\Page $page
     *
     * @return PageFile
     */
    public function setPage(\Notimeo\PageBundle\Entity\Page $page = null)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return \Notimeo\PageBundle\Entity\Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return PageFile
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
     * @return PageFile
     */
    public function setUpdateDate(\DateTime $updateDate)
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
        // update the modified time
        $this->setUpdateDate(new \DateTime());
    }
}

<?php

namespace Msite\MsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AppExamMapping
 *
 * @ORM\Table(name="app_exam_mapping")
 * @ORM\Entity(repositoryClass="AppExamMappingRepository")
 */
class AppExamMapping
{
    /**
     * @var string
     *
     * @ORM\Column(name="examName", type="string", length=20, nullable=true)
     */
    private $examname;

    /**
     * @var integer
     *
     * @ORM\Column(name="categoryId", type="integer", nullable=true)
     */
    private $categoryid;

    /**
     * @var integer
     *
     * @ORM\Column(name="examId", type="integer", nullable=true)
     */
    private $examid;

    /**
     * @var string
     *
     * @ORM\Column(name="descrption", type="string", length=20, nullable=true)
     */
    private $descrption;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set examname
     *
     * @param string $examname
     * @return AppExamMapping
     */
    public function setExamname($examname)
    {
        $this->examname = $examname;

        return $this;
    }

    /**
     * Get examname
     *
     * @return string 
     */
    public function getExamname()
    {
        return $this->examname;
    }

    /**
     * Set categoryid
     *
     * @param integer $categoryid
     * @return AppExamMapping
     */
    public function setCategoryid($categoryid)
    {
        $this->categoryid = $categoryid;

        return $this;
    }

    /**
     * Get categoryid
     *
     * @return integer 
     */
    public function getCategoryid()
    {
        return $this->categoryid;
    }

    /**
     * Set examid
     *
     * @param integer $examid
     * @return AppExamMapping
     */
    public function setExamid($examid)
    {
        $this->examid = $examid;

        return $this;
    }

    /**
     * Get examid
     *
     * @return integer 
     */
    public function getExamid()
    {
        return $this->examid;
    }

    /**
     * Set descrption
     *
     * @param string $descrption
     * @return AppExamMapping
     */
    public function setDescrption($descrption)
    {
        $this->descrption = $descrption;

        return $this;
    }

    /**
     * Get descrption
     *
     * @return string 
     */
    public function getDescrption()
    {
        return $this->descrption;
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
}

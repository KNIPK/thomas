<?php

namespace Kni\ThomasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Test
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Test
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="imie", type="string", length=255)
     */
    private $imie;

    /**
     * @var string
     *
     * @ORM\Column(name="nazwisko", type="string", length=255)
     */
    private $nazwisko;

    /**
     * @var integer
     *
     * @ORM\Column(name="wiek", type="integer")
     */
    private $wiek;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="date")
     */
    private $endDate;


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
     * Set imie
     *
     * @param string $imie
     * @return Test
     */
    public function setImie($imie)
    {
        $this->imie = $imie;
    
        return $this;
    }

    /**
     * Get imie
     *
     * @Assert\Length(
     *      min = "3",
     *      max = "20",
     *      minMessage = "Login musi mieć minimum 3 znaki",
     *      maxMessage = "Login może mieć maksymalnie 20 znaków"
     * )
     * @return string 
     */
    public function getImie()
    {
        return $this->imie;
    }

    /**
     * Set nazwisko
     *
     * @param string $nazwisko
     * @return Test
     */
    public function setNazwisko($nazwisko)
    {
        $this->nazwisko = $nazwisko;
    
        return $this;
    }

    /**
     * Get nazwisko
     *
     * @return string 
     */
    public function getNazwisko()
    {
        return $this->nazwisko;
    }

    /**
     * Set wiek
     *
     * @param integer $wiek
     * @return Test
     */
    public function setWiek($wiek)
    {
        $this->wiek = $wiek;
    
        return $this;
    }

    /**
     * Get wiek
     *
     * @return integer 
     */
    public function getWiek()
    {
        return $this->wiek;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return Test
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    
        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
}
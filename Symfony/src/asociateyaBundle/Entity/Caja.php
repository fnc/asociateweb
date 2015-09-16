<?php

namespace asociateyaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Caja
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Caja
{
    /**
    *  @ORM\Id
    *  @ORM\Column(type="integer", name="caja_id")
    *  @ORM\GeneratedValue(strategy="AUTO")
    */
   private $id;

    public function __construct($name=null)
    {
        $this->emprendimientos = new \ArrayCollection();
  
    }
	
	/**
	* @ORM\OneToMany(targetEntity="Emprendimiento", mappedBy="caja")
	*/
	
	private $emprendimientos;
	

    /**
     * @var string
     *
     * @ORM\Column(name="montoCobrado", type="decimal")
     */
    private $montoCobrado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaCobro", type="datetime")
     */
    private $fechaCobro;


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
     * Set idEmprendimiento
     *
     * @param integer $idEmprendimiento
     *
     * @return Caja
     */
    public function setIdEmprendimiento($idEmprendimiento)
    {
        $this->idEmprendimiento = $idEmprendimiento;

        return $this;
    }

    /**
     * Get idEmprendimiento
     *
     * @return integer
     */
    public function getIdEmprendimiento()
    {
        return $this->idEmprendimiento;
    }

    /**
     * Set montoCobrado
     *
     * @param string $montoCobrado
     *
     * @return Caja
     */
    public function setMontoCobrado($montoCobrado)
    {
        $this->montoCobrado = $montoCobrado;

        return $this;
    }

    /**
     * Get montoCobrado
     *
     * @return string
     */
    public function getMontoCobrado()
    {
        return $this->montoCobrado;
    }

    /**
     * Set fechaCobro
     *
     * @param \DateTime $fechaCobro
     *
     * @return Caja
     */
    public function setFechaCobro($fechaCobro)
    {
        $this->fechaCobro = $fechaCobro;

        return $this;
    }

    /**
     * Get fechaCobro
     *
     * @return \DateTime
     */
    public function getFechaCobro()
    {
        return $this->fechaCobro;
    }

    /**
     * Add emprendimiento
     *
     * @param \asociateyaBundle\Entity\Emprendimiento $emprendimiento
     *
     * @return Caja
     */
    public function addEmprendimiento(\asociateyaBundle\Entity\Emprendimiento $emprendimiento)
    {
        $this->emprendimientos[] = $emprendimiento;

        return $this;
    }

    /**
     * Remove emprendimiento
     *
     * @param \asociateyaBundle\Entity\Emprendimiento $emprendimiento
     */
    public function removeEmprendimiento(\asociateyaBundle\Entity\Emprendimiento $emprendimiento)
    {
        $this->emprendimientos->removeElement($emprendimiento);
    }

    /**
     * Get emprendimientos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmprendimientos()
    {
        return $this->emprendimientos;
    }
}

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
        $this->idEmprendimientos = new ArrayCollection();

  
    }
	
	/**
	* @ORM\OneToMany(targetEntity="Emprendimiento", mappedBy="id")
	*/
	
	private $idEmprendimientos;
	

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
     * Add idEmprendimiento
     *
     * @param \asociateyaBundle\Entity\Emprendimiento $idEmprendimiento
     *
     * @return Caja
     */
    public function addIdEmprendimiento(\asociateyaBundle\Entity\Emprendimiento $idEmprendimiento)
    {
        $this->idEmprendimientos[] = $idEmprendimiento;

        return $this;
    }

    /**
     * Remove idEmprendimiento
     *
     * @param \asociateyaBundle\Entity\Emprendimiento $idEmprendimiento
     */
    public function removeIdEmprendimiento(\asociateyaBundle\Entity\Emprendimiento $idEmprendimiento)
    {
        $this->idEmprendimientos->removeElement($idEmprendimiento);
    }

    /**
     * Get idEmprendimientos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdEmprendimientos()
    {
        return $this->idEmprendimientos;
    }
}

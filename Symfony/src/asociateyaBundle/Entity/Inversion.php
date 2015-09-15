<?php

namespace asociateyaBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;//para usar arrays
use Symfony\Component\Security\Core\User\UserInterface;

/**
* @ORM\Entity(repositoryClass="asociateyaBundle\Entity\UserRepository")
* @ORM\Table(name="Inversion")
*/
class Inversion {

/**
*  @ORM\Id
*  @ORM\Column(type="integer", name="inversion_id")
*  @ORM\GeneratedValue(strategy="AUTO")
*/
    private $id;
 

	/**
	* @ORM\ManyToOne(targetEntity="Usuario", inversedBy="id")
	* @ORM\JoinColumn(name="usuario_id", referencedColumnName="usuario_id",         onDelete="CASCADE")
	*/
	     private $idUsuario;

	/**
	* @ORM\ManyToOne(targetEntity="Emprendimiento", inversedBy="id")
	* @ORM\JoinColumn(name="emprendimiento_id", referencedColumnName="emprendimiento_id",         onDelete="CASCADE")
	*/
	     private $idEmprendimiento;


    

    /**
     * @var string
     *
     * @ORM\Column(name="monto", type="decimal")
     */
    private $monto;

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
     * @return Inversion
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
     * Set monto
     *
     * @param string $monto
     *
     * @return Inversion
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto
     *
     * @return string
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * Set idUsuario
     *
     * @param \asociateyaBundle\Entity\Usuario $idUsuario
     *
     * @return Inversion
     */
    public function setIdUsuario(\asociateyaBundle\Entity\Usuario $idUsuario = null)
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get idUsuario
     *
     * @return \asociateyaBundle\Entity\Usuario
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }
}

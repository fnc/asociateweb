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
	* @ORM\ManyToOne(targetEntity="Usuario", inversedBy="inversiones")
	* @ORM\JoinColumn(name="usuario_id", referencedColumnName="usuario_id",         onDelete="CASCADE")
	*/
	private $usuario;

	/**
	* @ORM\ManyToOne(targetEntity="Emprendimiento", inversedBy="inversiones")
	* @ORM\JoinColumn(name="emprendimiento_id", referencedColumnName="emprendimiento_id",         onDelete="CASCADE")
	*/
	private $emprendimiento;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaEmision", type="datetime")
     */
    private $fechaEmision;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaCobro", type="datetime")
     */
    private $fechaCobro;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="decimal")
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="detalleEstado", type="string", length=80)
     */
    private $detalleEstado; 

    /**
     * @var string
     *
     * @ORM\Column(name="idPago", type="decimal")
     */
    private $idPago;

    /**
     * @var string
     *
     * @ORM\Column(name="idUsuarioMP", type="decimal")
     */
    private $idUsuarioMP;

    /**
     * @var string
     *
     * @ORM\Column(name="cantidadAcciones", type="integer")
     */
    private $cantidadAcciones;
 


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

    /**
     * Set emprendimiento
     *
     * @param \asociateyaBundle\Entity\Emprendimiento $emprendimiento
     *
     * @return Inversion
     */
    public function setEmprendimiento(\asociateyaBundle\Entity\Emprendimiento $emprendimiento = null)
    {
        $this->emprendimiento = $emprendimiento;

        return $this;
    }

    /**
     * Get emprendimiento
     *
     * @return \asociateyaBundle\Entity\Emprendimiento
     */
    public function getEmprendimiento()
    {
        return $this->emprendimiento;
    }

    /**
     * Set usuario
     *
     * @param \asociateyaBundle\Entity\Usuario $usuario
     *
     * @return Inversion
     */
    public function setUsuario(\asociateyaBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \asociateyaBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set fechaEmision
     *
     * @param \DateTime $fechaEmision
     *
     * @return Inversion
     */
    public function setFechaEmision($fechaEmision)
    {
        $this->fechaEmision = $fechaEmision;

        return $this;
    }

    /**
     * Get fechaEmision
     *
     * @return \DateTime
     */
    public function getFechaEmision()
    {
        return $this->fechaEmision;
    }

    /**
     * Set fechaCobro
     *
     * @param \DateTime $fechaCobro
     *
     * @return Inversion
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
     * Set estado
     *
     * @param string $estado
     *
     * @return Inversion
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set detalleEstado
     *
     * @param string $detalleEstado
     *
     * @return Inversion
     */
    public function setDetalleEstado($detalleEstado)
    {
        $this->detalleEstado = $detalleEstado;

        return $this;
    }

    /**
     * Get detalleEstado
     *
     * @return string
     */
    public function getDetalleEstado()
    {
        return $this->detalleEstado;
    }

    /**
     * Set idPago
     *
     * @param string $idPago
     *
     * @return Inversion
     */
    public function setIdPago($idPago)
    {
        $this->idPago = $idPago;

        return $this;
    }

    /**
     * Get idPago
     *
     * @return string
     */
    public function getIdPago()
    {
        return $this->idPago;
    }

    /**
     * Set idUsuarioMP
     *
     * @param string $idUsuarioMP
     *
     * @return Inversion
     */
    public function setIdUsuarioMP($idUsuarioMP)
    {
        $this->idUsuarioMP = $idUsuarioMP;

        return $this;
    }

    /**
     * Get idUsuarioMP
     *
     * @return string
     */
    public function getIdUsuarioMP()
    {
        return $this->idUsuarioMP;
    }

    /**
     * Set cantidadAcciones
     *
     * @param integer $cantidadAcciones
     *
     * @return Inversion
     */
    public function setCantidadAcciones($cantidadAcciones)
    {
        $this->cantidadAcciones = $cantidadAcciones;

        return $this;
    }

    /**
     * Get cantidadAcciones
     *
     * @return integer
     */
    public function getCantidadAcciones()
    {
        return $this->cantidadAcciones;
    }
}

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
   * @ORM\OneToMany(targetEntity="PagoInversion", mappedBy="inversion")
   */
   private $pagos;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaEmision", type="datetime")
     */
    private $fechaEmision;

    /**
     * @var string
     *
     * @ORM\Column(name="cantidadAcciones", type="integer")
     */
    private $cantidadAcciones;


    public function __construct() {
        $this->pagos = new ArrayCollection();
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
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
      $pagos = $this->getPagos();
      foreach ($pagos as $pago) {
         if($pago->getEstado() != "2")
         {
            return "Pendiente";
         }
      }
      return "Acreditado";
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

    /**
     * Add pago
     *
     * @param \asociateyaBundle\Entity\PagoInversion $pago
     *
     * @return Inversion
     */
    public function addPago(\asociateyaBundle\Entity\PagoInversion $pago)
    {
        $this->pagos[] = $pago;

        return $this;
    }

    /**
     * Remove pago
     *
     * @param \asociateyaBundle\Entity\PagoInversion $pago
     */
    public function removePago(\asociateyaBundle\Entity\PagoInversion $pago)
    {
        $this->pagos->removeElement($pago);
    }

    /**
     * Get pagos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPagos()
    {
        return $this->pagos;
    }
}

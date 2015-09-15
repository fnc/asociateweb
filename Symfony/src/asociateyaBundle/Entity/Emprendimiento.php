<?php

namespace asociateyaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;//para usar arrays
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * Emprendimiento
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Emprendimiento
{
    /**
     * @var integer
     *
     * @ORM\Column(name="emprendimiento_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\OneToMany(targetEntity="Inversion", mappedBy="idEmprendimiento")
     * @ORM\OneToMany(targetEntity="Comentario", mappedBy="idEmprendimiento")
     * @ORM\ManyToMany(targetEntity="Categoria", inversedBy="id")
     * @ORM\JoinTable(name="emprendimientoXcategoria")
     **/

   protected $id;

    public function __construct($name=null)
    {
        $this->id = new ArrayCollection();

  
    }
	/**
	* @ORM\ManyToOne(targetEntity="Emprendedor", inversedBy="id")
	* @ORM\JoinColumn(name="emprendedor_id", referencedColumnName="emprendedor_id",         onDelete="CASCADE")
	*/
	     protected $idEmprendedor;
	/**
	* @ORM\ManyToOne(targetEntity="Caja", inversedBy="id")
	* @ORM\JoinColumn(name="caja_id", referencedColumnName="caja_id",         onDelete="CASCADE")
	*/
	     protected $idCaja;



    /**
     * @var integer
     *
     * @ORM\Column(name="idCategoria", type="integer")
     */
    private $idCategoria;

    /**
     * @var string
     *
     * @ORM\Column(name="monto", type="decimal")
     */
    private $monto;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoDeMeta", type="string", length=255)
     */
    private $tipoDeMeta;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=80)
     */
    private $nombre;
    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=255)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="precioAccion", type="decimal")
     */
    private $precioAccion;

    /**
     * @var integer
     *
     * @ORM\Column(name="totalAcciones", type="integer")
     */
    private $totalAcciones;

    /**
     * @var integer
     *
     * @ORM\Column(name="accionesRestantes", type="integer")
     */
    private $accionesRestantes;


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
     * Set idCategoria
     *
     * @param integer $idCategoria
     *
     * @return Emprendimiento
     */
    public function setIdCategoria($idCategoria)
    {
        $this->idCategoria = $idCategoria;

        return $this;
    }

    /**
     * Get idCategoria
     *
     * @return integer
     */
    public function getIdCategoria()
    {
        return $this->idCategoria;
    }

    /**
     * Set monto
     *
     * @param string $monto
     *
     * @return Emprendimiento
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
     * Set tipoDeMeta
     *
     * @param string $tipoDeMeta
     *
     * @return Emprendimiento
     */
    public function setTipoDeMeta($tipoDeMeta)
    {
        $this->tipoDeMeta = $tipoDeMeta;

        return $this;
    }

    /**
     * Get tipoDeMeta
     *
     * @return string
     */
    public function getTipoDeMeta()
    {
        return $this->tipoDeMeta;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Emprendimiento
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return Emprendimiento
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
     * Set precioAccion
     *
     * @param string $precioAccion
     *
     * @return Emprendimiento
     */
    public function setPrecioAccion($precioAccion)
    {
        $this->precioAccion = $precioAccion;

        return $this;
    }

    /**
     * Get precioAccion
     *
     * @return string
     */
    public function getPrecioAccion()
    {
        return $this->precioAccion;
    }

    /**
     * Set totalAcciones
     *
     * @param integer $totalAcciones
     *
     * @return Emprendimiento
     */
    public function setTotalAcciones($totalAcciones)
    {
        $this->totalAcciones = $totalAcciones;

        return $this;
    }

    /**
     * Get totalAcciones
     *
     * @return integer
     */
    public function getTotalAcciones()
    {
        return $this->totalAcciones;
    }

    /**
     * Set accionesRestantes
     *
     * @param integer $accionesRestantes
     *
     * @return Emprendimiento
     */
    public function setAccionesRestantes($accionesRestantes)
    {
        $this->accionesRestantes = $accionesRestantes;

        return $this;
    }

    /**
     * Get accionesRestantes
     *
     * @return integer
     */
    public function getAccionesRestantes()
    {
        return $this->accionesRestantes;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Emprendimiento
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set idEmprendedor
     *
     * @param \asociateyaBundle\Entity\Emprenddor $idEmprendedor
     *
     * @return Emprendimiento
     */
    public function setIdEmprendedor(\asociateyaBundle\Entity\Emprenddor $idEmprendedor = null)
    {
        $this->idEmprendedor = $idEmprendedor;

        return $this;
    }

    /**
     * Get idEmprendedor
     *
     * @return \asociateyaBundle\Entity\Emprenddor
     */
    public function getIdEmprendedor()
    {
        return $this->idEmprendedor;
    }

    /**
     * Set idCaja
     *
     * @param \asociateyaBundle\Entity\Caja $idCaja
     *
     * @return Emprendimiento
     */
    public function setIdCaja(\asociateyaBundle\Entity\Caja $idCaja = null)
    {
        $this->idCaja = $idCaja;

        return $this;
    }

    /**
     * Get idCaja
     *
     * @return \asociateyaBundle\Entity\Caja
     */
    public function getIdCaja()
    {
        return $this->idCaja;
    }
}

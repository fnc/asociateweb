<?php

namespace asociateyaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
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
 **/

private $id;

public function __construct($name=null)
{
	$this->idInversiones = new ArrayCollection();
    $this->idComentarios = new ArrayCollection();
    $this->idCategorias = new ArrayCollection();
}

/**
* @ORM\OneToMany(targetEntity="Inversion", mappedBy="idEmprendimiento")
*/
private $idInversiones;

/**
 * @ORM\OneToMany(targetEntity="Comentario", mappedBy="idEmprendimiento")
*/

private $idComentarios;
 /**
 * ORM\ManyToMany(targetEntity="Categoria", inversedBy="idEmprendimientos")
 * ORM\JoinTable(name="idEmprendimientos_idCategorias")
* @ORM\ManyToOne(targetEntity="Categoria", inversedBy="idEmprendimientos")
* @ORM\JoinColumn(name="categoria_id", referencedColumnName="categoria_id",         onDelete="CASCADE")

 */
 private $idCategorias;


/**
* @ORM\ManyToOne(targetEntity="Emprendedor", inversedBy="id")
* @ORM\JoinColumn(name="emprendedor_id", referencedColumnName="emprendedor_id",         onDelete="CASCADE")
*/
     private $idEmprendedor;
/**
* @ORM\ManyToOne(targetEntity="Caja", inversedBy="id")
* @ORM\JoinColumn(name="caja_id", referencedColumnName="caja_id",         onDelete="CASCADE")
*/
     private $idCaja;



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
 * @ORM\Column(name="rutaImagen", type="string", length=255)
 */
private $rutaImagen;
/**
 * @var string
 *
 * @ORM\Column(name="descripcionCorta", type="string", length=80)
 */
private $descripcionCorta;
/**
 * @var string
 *
 * @ORM\Column(name="descripcionLarga", type="string", length=255)
 */
private $descripcionLarga;

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
 * @var string
 *
 * @ORM\Column(name="ranking", type="decimal")
 */
private $ranking;
/**
 * @ORM\Column(type="datetime")
 */
private $fechaCreacion;
/**
 * @ORM\Column(type="datetime")
 */
private $fechaAprobacion;

/**
 * @ORM\Column(type="datetime")
 */
private $fechaCancelacion;

/**
 * @ORM\Column(type="datetime")
 */
private $fechaFinalizacion;

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

    /**
     * Set rutaImagen
     *
     * @param string $rutaImagen
     *
     * @return Emprendimiento
     */
    public function setRutaImagen($rutaImagen)
    {
        $this->rutaImagen = $rutaImagen;

        return $this;
    }

    /**
     * Get rutaImagen
     *
     * @return string
     */
    public function getRutaImagen()
    {
        return $this->rutaImagen;
    }

    /**
     * Set descripcionCorta
     *
     * @param string $descripcionCorta
     *
     * @return Emprendimiento
     */
    public function setDescripcionCorta($descripcionCorta)
    {
        $this->descripcionCorta = $descripcionCorta;

        return $this;
    }

    /**
     * Get descripcionCorta
     *
     * @return string
     */
    public function getDescripcionCorta()
    {
        return $this->descripcionCorta;
    }

    /**
     * Set descripcionLarga
     *
     * @param string $descripcionLarga
     *
     * @return Emprendimiento
     */
    public function setDescripcionLarga($descripcionLarga)
    {
        $this->descripcionLarga = $descripcionLarga;

        return $this;
    }

    /**
     * Get descripcionLarga
     *
     * @return string
     */
    public function getDescripcionLarga()
    {
        return $this->descripcionLarga;
    }

    /**
     * Set ranking
     *
     * @param string $ranking
     *
     * @return Emprendimiento
     */
    public function setRanking($ranking)
    {
        $this->ranking = $ranking;

        return $this;
    }

    /**
     * Get ranking
     *
     * @return string
     */
    public function getRanking()
    {
        return $this->ranking;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Emprendimiento
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set fechaAprobacion
     *
     * @param \DateTime $fechaAprobacion
     *
     * @return Emprendimiento
     */
    public function setFechaAprobacion($fechaAprobacion)
    {
        $this->fechaAprobacion = $fechaAprobacion;

        return $this;
    }

    /**
     * Get fechaAprobacion
     *
     * @return \DateTime
     */
    public function getFechaAprobacion()
    {
        return $this->fechaAprobacion;
    }

    /**
     * Set fechaCancelacion
     *
     * @param \DateTime $fechaCancelacion
     *
     * @return Emprendimiento
     */
    public function setFechaCancelacion($fechaCancelacion)
    {
        $this->fechaCancelacion = $fechaCancelacion;

        return $this;
    }

    /**
     * Get fechaCancelacion
     *
     * @return \DateTime
     */
    public function getFechaCancelacion()
    {
        return $this->fechaCancelacion;
    }

    /**
     * Set fechaFinalizacion
     *
     * @param \DateTime $fechaFinalizacion
     *
     * @return Emprendimiento
     */
    public function setFechaFinalizacion($fechaFinalizacion)
    {
        $this->fechaFinalizacion = $fechaFinalizacion;

        return $this;
    }

    /**
     * Get fechaFinalizacion
     *
     * @return \DateTime
     */
    public function getFechaFinalizacion()
    {
        return $this->fechaFinalizacion;
    }

    /**
     * Add idInversione
     *
     * @param \asociateyaBundle\Entity\Inversion $idInversione
     *
     * @return Emprendimiento
     */
    public function addIdInversione(\asociateyaBundle\Entity\Inversion $idInversione)
    {
        $this->idInversiones[] = $idInversione;

        return $this;
    }

    /**
     * Remove idInversione
     *
     * @param \asociateyaBundle\Entity\Inversion $idInversione
     */
    public function removeIdInversione(\asociateyaBundle\Entity\Inversion $idInversione)
    {
        $this->idInversiones->removeElement($idInversione);
    }

    /**
     * Get idInversiones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdInversiones()
    {
        return $this->idInversiones;
    }

    /**
     * Add idComentario
     *
     * @param \asociateyaBundle\Entity\Comentario $idComentario
     *
     * @return Emprendimiento
     */
    public function addIdComentario(\asociateyaBundle\Entity\Comentario $idComentario)
    {
        $this->idComentarios[] = $idComentario;

        return $this;
    }

    /**
     * Remove idComentario
     *
     * @param \asociateyaBundle\Entity\Comentario $idComentario
     */
    public function removeIdComentario(\asociateyaBundle\Entity\Comentario $idComentario)
    {
        $this->idComentarios->removeElement($idComentario);
    }

    /**
     * Get idComentarios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdComentarios()
    {
        return $this->idComentarios;
    }

    /**
     * Add idCategoria
     *
     * @param \asociateyaBundle\Entity\Categoria $idCategoria
     *
     * @return Emprendimiento
     */
    public function addIdCategoria(\asociateyaBundle\Entity\Categoria $idCategoria)
    {
        $this->idCategorias[] = $idCategoria;

        return $this;
    }

    /**
     * Remove idCategoria
     *
     * @param \asociateyaBundle\Entity\Categoria $idCategoria
     */
    public function removeIdCategoria(\asociateyaBundle\Entity\Categoria $idCategoria)
    {
        $this->idCategorias->removeElement($idCategoria);
    }

    /**
     * Get idCategorias
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdCategorias()
    {
        return $this->idCategorias;
    }

    /**
     * Set idCategorias
     *
     * @param \asociateyaBundle\Entity\Categoria $idCategorias
     *
     * @return Emprendimiento
     */
    public function setIdCategorias(\asociateyaBundle\Entity\Categoria $idCategorias = null)
    {
        $this->idCategorias = $idCategorias;

        return $this;
    }
}

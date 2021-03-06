<?php

namespace asociateyaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


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
    	$this->inversiones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comentarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categorias = new  \Doctrine\Common\Collections\ArrayCollection();
        $this->resultados = new  \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
    * @ORM\OneToMany(targetEntity="Inversion", mappedBy="emprendimiento")
    */
    private $inversiones;

    /**
    * @ORM\OneToMany(targetEntity="Resultado", mappedBy="emprendimiento")
    */
    private $resultados;

    /**
     * @ORM\OneToMany(targetEntity="Comentario", mappedBy="emprendimiento")
    */
    private $comentarios;


     /**
     * @ORM\ManyToMany(targetEntity="Categoria", inversedBy="emprendimientos")
     * @ORM\OrderBy({"nombre" = "ASC"})
     * @ORM\JoinTable(name="emprendimientosXcategorias",
     *         joinColumns={@ORM\JoinColumn(name="emprendimiento_id",referencedColumnName="emprendimiento_id")},
     *         inverseJoinColumns={@ORM\JoinColumn(name="categoria_id",referencedColumnName="categoria_id")})
     *
     *
     * ORM\ManyToOne(targetEntity="Categoria", inversedBy="idEmprendimientos")
     * ORM\JoinColumn(name="categoria_id", referencedColumnName="categoria_id",         onDelete="CASCADE")
     */
    private $categorias;

    /**
    * @ORM\ManyToOne(targetEntity="Emprendedor", inversedBy="emprendimientos")
    * @ORM\JoinColumn(name="emprendedor_id", referencedColumnName="emprendedor_id", onDelete="CASCADE")
    */
    private $emprendedor;



    /**
     * @var string
     *
     * @ORM\Column(name="monto", type="decimal")
     */
    private $monto;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoDeMeta", type="string", length=255, nullable=true)
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
     * @Assert\NotBlank(message="Por favor, suba una imagen para el proyecto.")
     * @Assert\File(mimeTypes={ "image/jpeg" })
     */
    private $rutaImagen;

    /**
     * @var string
     *
     * @ORM\Column(name="rutaVideo", type="string", length=80, nullable=true)
     */
    private $rutaVideo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcionCorta", type="string", length=80)
     */
    private $descripcionCorta;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcionLarga", type="string", length=600)
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
     * @ORM\Column(name="precioAccion", type="decimal",nullable=true)
     */
    private $precioAccion;

    /**
     * @var integer
     *
     * @ORM\Column(name="totalAcciones", type="integer",nullable=true)
     */
    private $totalAcciones;

    /**
     * @var integer
     *
     * @ORM\Column(name="accionesRestantes", type="integer",nullable=true)
     */
    private $accionesRestantes;

    /**
     * @var string
     *
     * @ORM\Column(name="ranking", type="decimal",nullable=true)
     */
    private $ranking;

    /**
     * @var string
     *
     * @ORM\Column(name="idRefund", type="decimal",nullable=true)
     */
    private $idRefund;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fechaCreacion;
    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $fechaAprobacion;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $fechaCancelacion;

    /**
     * @ORM\Column(type="datetime",nullable=true)
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
     * Set rutaVideo
     *
     * @param string $rutaVideo
     *
     * @return Emprendimiento
     */
    public function setRutaVideo($rutaVideo)
    {
        $this->rutaVideo = $rutaVideo;

        return $this;
    }

    /**
     * Get rutaImagen
     *
     * @return string
     */
    public function getRutaVideo()
    {
        return $this->rutaVideo;
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
     * Set idRefund
     *
     * @param string $idRefund
     *
     * @return Emprendimiento
     */
    public function setIdRefund($idRefund)
    {
        $this->idRefund = $idRefund;

        return $this;
    }

    /**
     * Get idRefund
     *
     * @return string
     */
    public function getIdRefund()
    {
        return $this->idRefund;
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
     * Add inversione
     *
     * @param \asociateyaBundle\Entity\Inversion $inversione
     *
     * @return Emprendimiento
     */
    public function addInversione(\asociateyaBundle\Entity\Inversion $inversione)
    {
        $this->inversiones[] = $inversione;

        return $this;
    }

    /**
     * Remove inversione
     *
     * @param \asociateyaBundle\Entity\Inversion $inversione
     */
    public function removeInversione(\asociateyaBundle\Entity\Inversion $inversione)
    {
        $this->inversiones->removeElement($inversione);
    }

    /**
     * Get inversiones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInversiones()
    {
        return $this->inversiones;
    }

    /**
     * Add comentario
     *
     * @param \asociateyaBundle\Entity\Comentario $comentario
     *
     * @return Emprendimiento
     */
    public function addComentario(\asociateyaBundle\Entity\Comentario $comentario)
    {
        $this->comentarios[] = $comentario;

        return $this;
    }

    /**
     * Remove comentario
     *
     * @param \asociateyaBundle\Entity\Comentario $comentario
     */
    public function removeComentario(\asociateyaBundle\Entity\Comentario $comentario)
    {
        $this->comentarios->removeElement($comentario);
    }

    /**
     * Get comentarios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComentarios()
    {
        return $this->comentarios;
    }

    /**
     * Add categoria
     *
     * @param \asociateyaBundle\Entity\Categoria $categoria
     *
     * @return Emprendimiento
     */
    public function addCategoria(\asociateyaBundle\Entity\Categoria $categoria)
    {
        $this->categorias[] = $categoria;

        return $this;
    }

    /**
     * Remove categoria
     *
     * @param \asociateyaBundle\Entity\Categoria $categoria
     */
    public function removeCategoria(\asociateyaBundle\Entity\Categoria $categoria)
    {
        $this->categorias->removeElement($categoria);
    }

    /**
     * Get categorias
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategorias()
    {
        return $this->categorias;
    }

    /**
     * Set emprendedor
     *
     * @param \asociateyaBundle\Entity\Emprendedor $emprendedor
     *
     * @return Emprendimiento
     */
    public function setEmprendedor(\asociateyaBundle\Entity\Emprendedor $emprendedor = null)
    {
        $this->emprendedor = $emprendedor;

        return $this;
    }

    /**
     * Get emprendedor
     *
     * @return \asociateyaBundle\Entity\Emprendedor
     */
    public function getEmprendedor()
    {
        return $this->emprendedor;
    }


    /**
     * Add resultado
     *
     * @param \asociateyaBundle\Entity\Resultado $resultado
     *
     * @return Emprendimiento
     */
    public function addResultado(\asociateyaBundle\Entity\Resultado $resultado)
    {
        $this->resultados[] = $resultado;

        return $this;
    }

    /**
     * Remove resultado
     *
     * @param \asociateyaBundle\Entity\Resultado $resultado
     */
    public function removeResultado(\asociateyaBundle\Entity\Resultado $resultado)
    {
        $this->resultados->removeElement($resultado);
    }

    /**
     * Get resultados
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResultados()
    {
        return $this->resultados;
    }
}

<?php

namespace asociateyaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
}


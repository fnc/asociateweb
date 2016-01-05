<?php

namespace asociateyaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pago
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"pagoInversion" = "PagoInversion"})
 */
abstract class Pago
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
     * @ORM\Column(name="idMp", type="string", length=255)
     */
    private $idMp;

    /**
     * @var string
     *
     * @ORM\Column(name="idMPUser", type="string", length=255)
     */
    private $idMPUser;

    /**
     * @var string
     *
     * @ORM\Column(name="monto", type="decimal")
     */
    private $monto;

    /**
     * @var integer
     *
     * @ORM\Column(name="estado", type="integer")
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="detalleEstado", type="string", length=80, nullable=true)
     */
    private $detalleEstado;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idMp
     *
     * @param string $idMp
     *
     * @return Pago
     */
    public function setIdMp($idMp)
    {
        $this->idMp = $idMp;

        return $this;
    }

    /**
     * Get idMp
     *
     * @return string
     */
    public function getIdMp()
    {
        return $this->idMp;
    }

    /**
     * Set idMPUser
     *
     * @param string $idMPUser
     *
     * @return Pago
     */
    public function setIdMPUser($idMPUser)
    {
        $this->idMPUser = $idMPUser;

        return $this;
    }

    /**
     * Get idMPUser
     *
     * @return string
     */
    public function getIdMPUser()
    {
        return $this->idMPUser;
    }

    /**
     * Set monto
     *
     * @param string $monto
     *
     * @return Pago
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
     * Set estado
     *
     * @param integer $estado
     *
     * @return Pago
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return integer
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set fechaEmision
     *
     * @param \DateTime $fechaEmision
     *
     * @return Pago
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
     * @return Pago
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
     * Set detalleEstado
     *
     * @param string $detalleEstado
     *
     * @return Pago
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
}

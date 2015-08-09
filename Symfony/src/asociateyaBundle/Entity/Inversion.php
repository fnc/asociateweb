<?php

namespace asociateyaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inversion
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Inversion
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
     * @ORM\Column(name="idUsuario", type="integer")
     */
    private $idUsuario;

    /**
     * @var integer
     *
     * @ORM\Column(name="idEmprendimiento", type="integer")
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
     * Set idUsuario
     *
     * @param integer $idUsuario
     *
     * @return Inversion
     */
    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get idUsuario
     *
     * @return integer
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
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
}

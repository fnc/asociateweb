<?php

namespace asociateyaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DatosDeEmprendedor
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class DatosDeEmprendedor
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
     * @ORM\Column(name="idEmprendedor", type="integer")
     */
    private $idEmprendedor;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaConjuntoDatos", type="datetime")
     */
    private $fechaConjuntoDatos;


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
     * Set idEmprendedor
     *
     * @param integer $idEmprendedor
     *
     * @return DatosDeEmprendedor
     */
    public function setIdEmprendedor($idEmprendedor)
    {
        $this->idEmprendedor = $idEmprendedor;

        return $this;
    }

    /**
     * Get idEmprendedor
     *
     * @return integer
     */
    public function getIdEmprendedor()
    {
        return $this->idEmprendedor;
    }

    /**
     * Set fechaConjuntoDatos
     *
     * @param \DateTime $fechaConjuntoDatos
     *
     * @return DatosDeEmprendedor
     */
    public function setFechaConjuntoDatos($fechaConjuntoDatos)
    {
        $this->fechaConjuntoDatos = $fechaConjuntoDatos;

        return $this;
    }

    /**
     * Get fechaConjuntoDatos
     *
     * @return \DateTime
     */
    public function getFechaConjuntoDatos()
    {
        return $this->fechaConjuntoDatos;
    }
}

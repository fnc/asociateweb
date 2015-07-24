<?php

namespace asociateyaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DescripcionesDeEmprendimiento
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class DescripcionesDeEmprendimiento
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
     * @ORM\Column(name="idEmprendimiento", type="integer")
     */
    private $idEmprendimiento;

    /**
     * @var integer
     *
     * @ORM\Column(name="tipoRecurso", type="integer")
     */
    private $tipoRecurso;

    /**
     * @var string
     *
     * @ORM\Column(name="rutaRecurso", type="string", length=255)
     */
    private $rutaRecurso;


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
     * @return DescripcionesDeEmprendimiento
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
     * Set tipoRecurso
     *
     * @param integer $tipoRecurso
     *
     * @return DescripcionesDeEmprendimiento
     */
    public function setTipoRecurso($tipoRecurso)
    {
        $this->tipoRecurso = $tipoRecurso;

        return $this;
    }

    /**
     * Get tipoRecurso
     *
     * @return integer
     */
    public function getTipoRecurso()
    {
        return $this->tipoRecurso;
    }

    /**
     * Set rutaRecurso
     *
     * @param string $rutaRecurso
     *
     * @return DescripcionesDeEmprendimiento
     */
    public function setRutaRecurso($rutaRecurso)
    {
        $this->rutaRecurso = $rutaRecurso;

        return $this;
    }

    /**
     * Get rutaRecurso
     *
     * @return string
     */
    public function getRutaRecurso()
    {
        return $this->rutaRecurso;
    }
}


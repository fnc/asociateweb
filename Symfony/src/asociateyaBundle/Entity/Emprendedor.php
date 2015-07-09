<?php
// src/asociateyaBundle/Entity/Emprendedor.php

namespace asociateyaBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="emprendedores")
 */

class Emprendedor
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="date")
     */
    protected $fechaAprobacion;

    /**
     * @ORM\Column(type="integer")
     */
    protected $estado;

    /**
     * @ORM\Column(type="integer")
     */
    protected $reputacion;


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
     * Set fechaAprobacion
     *
     * @param \DateTime $fechaAprobacion
     *
     * @return Emprendedor
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
     * Set estado
     *
     * @param integer $estado
     *
     * @return Emprendedor
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
     * Set reputacion
     *
     * @param integer $reputacion
     *
     * @return Emprendedor
     */
    public function setReputacion($reputacion)
    {
        $this->reputacion = $reputacion;

        return $this;
    }

    /**
     * Get reputacion
     *
     * @return integer
     */
    public function getReputacion()
    {
        return $this->reputacion;
    }
}

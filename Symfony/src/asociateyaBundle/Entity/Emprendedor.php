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
*  @ORM\Id
*  @ORM\Column(type="integer", name="emprendedor_id")
*  @ORM\GeneratedValue(strategy="AUTO")
* @ORM\OneToMany(targetEntity="Emprendimiento", mappedBy="idEmprendedor")
*/
   protected $id;

    public function __construct($name=null)
    {
        $this->id = new ArrayCollection();

  
    }

/**
	* @ORM\OneToOne(targetEntity="Usuario", inversedBy="id")
	* @ORM\JoinColumn(name="usuario_id", referencedColumnName="usuario_id",         onDelete="CASCADE")
	*/
	     protected $idUsuario;

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

    /**
     * Set idUsuario
     *
     * @param \asociateyaBundle\Entity\Usuario $idUsuario
     *
     * @return Emprendedor
     */
    public function setIdUsuario(\asociateyaBundle\Entity\Usuario $idUsuario = null)
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get idUsuario
     *
     * @return \asociateyaBundle\Entity\Usuario
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }
}

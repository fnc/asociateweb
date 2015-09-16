<?php
// src/asociateyaBundle/Entity/Emprendedor.php

namespace asociateyaBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Emprendedor")
 */

class Emprendedor
{
    
/**
*  @ORM\Id
*  @ORM\Column(type="integer", name="emprendedor_id")
*  @ORM\GeneratedValue(strategy="AUTO")
*/
   private $id;

    public function __construct($name=null)
    {
        $this->emprendimientos = new \ArrayCollection();  
    }

    /**
	* @ORM\OneToOne(targetEntity="Usuario", inversedBy="emprendedor")
	* @ORM\JoinColumn(name="usuario_id", referencedColumnName="usuario_id", onDelete="CASCADE")
	*/
	private $usuario;

	/**
	* @ORM\OneToMany(targetEntity="Emprendimiento", mappedBy="emprendedor")
	*/
	private $emprendimientos;
    
    /**
     * @ORM\Column(type="date")
     */
    private $fechaAprobacion;

    /**
     * @ORM\Column(type="integer")
     */
    private $estado;

    /**
     * @ORM\Column(type="integer")
     */
    private $reputacion;


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

    /**
     * Add idEmprendimiento
     *
     * @param \asociateyaBundle\Entity\Emprendimiento $idEmprendimiento
     *
     * @return Emprendedor
     */
    public function addIdEmprendimiento(\asociateyaBundle\Entity\Emprendimiento $idEmprendimiento)
    {
        $this->idEmprendimientos[] = $idEmprendimiento;

        return $this;
    }

    /**
     * Remove idEmprendimiento
     *
     * @param \asociateyaBundle\Entity\Emprendimiento $idEmprendimiento
     */
    public function removeIdEmprendimiento(\asociateyaBundle\Entity\Emprendimiento $idEmprendimiento)
    {
        $this->idEmprendimientos->removeElement($idEmprendimiento);
    }

    /**
     * Get idEmprendimientos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdEmprendimientos()
    {
        return $this->idEmprendimientos;
    }

    /**
     * Add emprendimiento
     *
     * @param \asociateyaBundle\Entity\Emprendimiento $emprendimiento
     *
     * @return Emprendedor
     */
    public function addEmprendimiento(\asociateyaBundle\Entity\Emprendimiento $emprendimiento)
    {
        $this->emprendimientos[] = $emprendimiento;

        return $this;
    }

    /**
     * Remove emprendimiento
     *
     * @param \asociateyaBundle\Entity\Emprendimiento $emprendimiento
     */
    public function removeEmprendimiento(\asociateyaBundle\Entity\Emprendimiento $emprendimiento)
    {
        $this->emprendimientos->removeElement($emprendimiento);
    }

    /**
     * Get emprendimientos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmprendimientos()
    {
        return $this->emprendimientos;
    }

    /**
     * Set usuario
     *
     * @param \asociateyaBundle\Entity\Usuario $usuario
     *
     * @return Emprendedor
     */
    public function setUsuario(\asociateyaBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \asociateyaBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}

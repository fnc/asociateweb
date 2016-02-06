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
        $this->emprendimientos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @ORM\Column(type="date",nullable=true)
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
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     *
     * @ORM\Column(name="apellido", type="string", length=255)
     */
    private $apellido;

    /**
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     *
     * @ORM\Column(name="dni", type="string", length=255)
     */
    private $dni;

    /**
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;

    /**
     *
     * @ORM\Column(name="ciudad", type="string", length=255)
     */
    private $ciudad;

    /**
     *
     * @ORM\Column(name="provincia", type="string", length=255)
     */
    private $provincia;

    /**
     *
     * @ORM\Column(name="cuit", type="string", length=255)
     */
    private $cuit;

    /**
     *
     * @ORM\Column(name="telefono", type="string", length=255)
     */
    private $telefono;


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

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Emprendedor
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
     * Set apellido
     *
     * @param string $apellido
     *
     * @return Emprendedor
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Emprendedor
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set dni
     *
     * @param string $dni
     *
     * @return Emprendedor
     */
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get dni
     *
     * @return string
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Emprendedor
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set ciudad
     *
     * @param string $ciudad
     *
     * @return Emprendedor
     */
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return string
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Set provincia
     *
     * @param string $provincia
     *
     * @return Emprendedor
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return string
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set cuit
     *
     * @param string $cuit
     *
     * @return Emprendedor
     */
    public function setCuit($cuit)
    {
        $this->cuit = $cuit;

        return $this;
    }

    /**
     * Get cuit
     *
     * @return string
     */
    public function getCuit()
    {
        return $this->cuit;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Emprendedor
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }
}

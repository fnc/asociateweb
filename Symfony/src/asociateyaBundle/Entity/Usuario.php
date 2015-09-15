<?php
// src/asociateyaBundle/Entity/Usuario.php

namespace asociateyaBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
@ORM\Entity
@ORM\Table(name="Usuario")
*/
class Usuario implements UserInterface, \Serializable {

/**
* @ORM\Id
* @ORM\Column(type="integer", name="usuario_id")
* @ORM\GeneratedValue(strategy="AUTO")
* @ORM\OneToMany(targetEntity="Inversion", mappedBy="idUsuario")
* @ORM\OneToMany(targetEntity="Comentario", mappedBy="idUsuario")
* @ORM\OneToOne(targetEntity="Emprendedor", mappedBy="idUsuario")
*/
protected $id;

public function __construct($name=null)
{
	$this->id = new ArrayCollection();
    $this->fechaCreacion = new DateTime();
    $this->isActive = true;
}
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
 * @ORM\Column(name="cuit", type="string", length=255)
 */
private $cuit;

/**
 *
 * @ORM\Column(name="saldo", type="string", length=255)
 */
private $saldo;

/**
 * 
 * @ORM\Column(type="integer",name="comentario_id")  
   */
protected $idComentario;

/**
 * @ORM\Column(type="datetime")
 */
protected $fechaCreacion;

/**
 *
 * @ORM\Column(name="contrasena", type="string", length=255)
 */
protected $contrasena;

/**
 *
 * @ORM\Column(name="rol", type="string", length=255)
 */
protected $rol;


 /**
 * @ORM\Column(name="isActive", type="boolean")
 */
 private $isActive;


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
 * Set nombre
 *
 * @param string $nombre
 *
 * @return Usuario
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
 * @return Usuario
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
 * @return Usuario
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
 * @return Usuario
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
 * @return Usuario
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
 * Set cuit
 *
 * @param string $cuit
 *
 * @return Usuario
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
 * Set idComentario
 *
 * @param integer $idComentario
 *
 * @return Usuario
 */
public function setIdComentario($idComentario)
{
	$this->idComentario = $idComentario;

	return $this;
}

/**
 * Get idComentario
 *
 * @return integer
 */
public function getIdComentario()
{
	return $this->idComentario;
}

/**
 * Set fechaCreacion
 *
 * @param \DateTime $fechaCreacion
 *
 * @return Usuario
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
 * Set contrasena
 *
 * @param string $contrasena
 *
 * @return Usuario
 */
public function setContrasena($contrasena)
{
	$this->contrasena = $contrasena;

	return $this;
}

/**
 * Get contrasena
 *
 * @return string
 */
public function getContrasena()
{
	return $this->contrasena;
}

/**
 * Set rol
 *
 * @param string $rol
 *
 * @return Usuario
 */
public function setRol($rol)
{
	$this->rol = $rol;

	return $this;
}

/**
 * Get rol
 *
 * @return string
 */
public function getRol()
{
	return $this->rol;
}

/**
 * Set isActive
 *
 * @param boolean $isActive
 *
 * @return Usuario
 */
public function setIsActive($isActive)
{
	$this->isActive = $isActive;

	return $this;
}

/**
 * Get isActive
 *
 * @return boolean
 */
public function getIsActive()
{
	return $this->isActive;
}
#interfaz UserInterface
public function getSalt()
{
    // you *may* need a real salt depending on your encoder
    // see section on salt below
    return null;
}

#interfaz UserInterface
public function getRoles()
{
    return array('ROLE_USER');
}

#interfaz UserInterface
public function eraseCredentials()
{
}

/** @see \Serializable::serialize() */
public function serialize()
{
    return serialize(array(
        $this->id,
        $this->nombreUsuario,
        $this->contrasena,
        // see section on salt below
        // $this->salt,
        ));
}

/** @see \Serializable::unserialize() */
public function unserialize($serialized)
{
    list (
        $this->id,
        $this->nombreUsuario,
        $this->contrasena,
        // see section on salt below
        // $this->salt
        ) = unserialize($serialized);
}
     * Add idInversion
     *
     * @param \asociateyaBundle\Entity\Inversion $idInversion
     *
     * @return Usuario
     */
    public function addIdInversion(\asociateyaBundle\Entity\Inversion $idInversion)
    {
        $this->idInversion[] = $idInversion;

        return $this;
    }

    /**
     * Remove idInversion
     *
     * @param \asociateyaBundle\Entity\Inversion $idInversion
     */
    public function removeIdInversion(\asociateyaBundle\Entity\Inversion $idInversion)
    {
        $this->idInversion->removeElement($idInversion);
    }



}

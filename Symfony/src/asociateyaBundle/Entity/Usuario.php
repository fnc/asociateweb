<?php
// src/asociateyaBundle/Entity/Usuario.php

namespace asociateyaBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;


/**
*@ORM\Entity
*@ORM\Table(name="Usuario")
*/
class Usuario implements UserInterface, \Serializable 
{

    /**
    * @ORM\Id
    * @ORM\Column(type="integer", name="usuario_id")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;

    /**
    * @ORM\OneToMany(targetEntity="Inversion", mappedBy="usuario", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
    */
    private $inversiones;

    /**
    * @ORM\OneToMany(targetEntity="Comentario", mappedBy="usuario", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
    */
    private $comentarios;

    /**
    * @ORM\OneToOne(targetEntity="Emprendedor", mappedBy="usuario", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
    */
    private $emprendedor;

    /**
     *
     * @ORM\Column(name="nombre", type="string", length=255,nullable=true)
     */
    private $nombre;

    /**
     *
     * @ORM\Column(name="apellido", type="string", length=255,nullable=true)
     */
    private $apellido;

    /**
     *
     * @ORM\Column(name="email", type="string", length=255,nullable=true)
     */
    private $email;

    /**
     *
     * @ORM\Column(name="dni", type="string", length=255,nullable=true)
     */
    private $dni;

    /**
     *
     * @ORM\Column(name="direccion", type="string", length=255,nullable=true)
     */
    private $direccion;

    /**
     *
     * @ORM\Column(name="cuit", type="string", length=255,nullable=true)
     */
    private $cuit;

    /**
     *
     * @ORM\Column(name="saldo", type="string", length=255,nullable=true)
     */
    private $saldo;


    /**
     * @ORM\Column(type="datetime")
     */
    private $fechaCreacion;


    /**
    * @var string
    *
    * @ORM\Column(name="nombreUsuario", type="string", length=255)
    */
    private $nombreUsuario;

    /**
     *
     * @ORM\Column(name="contrasena", type="string", length=255)
     */
    private $contrasena;

    /**
     *
     * @ORM\Column(name="rol", type="string", length=255,nullable=true)
     */
    private $rol;


     /**
     * @ORM\Column(name="isActive", type="boolean")
     */
     private $isActive;


    public function __construct($name=null)
    {
        $this->inversiones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comentarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fechaCreacion = new \DateTime();
        $this->isActive = true;
    }


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
    * @ORM\PrePersist
    */
    public function onPrePersistSetfechaCracion()
    {
        $this->fechaCreacion = new \DateTime();
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
    public function getUsername()
    {
        return $this->nombreUsuario;
    }

    #interfaz UserInterface
    public function getPassword()
    {
        return $this->contrasena;
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
        return array($this->getRol());
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

    /**
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




    /**
     * Set saldo
     *
     * @param string $saldo
     *
     * @return Usuario
     */
    public function setSaldo($saldo)
    {
        $this->saldo = $saldo;

        return $this;
    }

    /**
     * Get saldo
     *
     * @return string
     */
    public function getSaldo()
    {
        return $this->saldo;
    }

    /**
     * Set nombreUsuario
     *
     * @param string $nombreUsuario
     *
     * @return Usuario
     */
    public function setNombreUsuario($nombreUsuario)
    {
        $this->nombreUsuario = $nombreUsuario;

        return $this;
    }

    /**
     * Get nombreUsuario
     *
     * @return string
     */
    public function getNombreUsuario()
    {
        return $this->nombreUsuario;
    }

    /**
     * Add idInversione
     *
     * @param \asociateyaBundle\Entity\Inversion $idInversione
     *
     * @return Usuario
     */
    public function addIdInversione(\asociateyaBundle\Entity\Inversion $idInversione)
    {
        $this->idInversiones[] = $idInversione;

        return $this;
    }

    /**
     * Remove idInversione
     *
     * @param \asociateyaBundle\Entity\Inversion $idInversione
     */
    public function removeIdInversione(\asociateyaBundle\Entity\Inversion $idInversione)
    {
        $this->idInversiones->removeElement($idInversione);
    }

    /**
     * Get idInversiones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdInversiones()
    {
        return $this->idInversiones;
    }

    /**
     * Add idComentario
     *
     * @param \asociateyaBundle\Entity\Comentario $idComentario
     *
     * @return Usuario
     */
    public function addIdComentario(\asociateyaBundle\Entity\Comentario $idComentario)
    {
        $this->idComentarios[] = $idComentario;

        return $this;
    }

    /**
     * Remove idComentario
     *
     * @param \asociateyaBundle\Entity\Comentario $idComentario
     */
    public function removeIdComentario(\asociateyaBundle\Entity\Comentario $idComentario)
    {
        $this->idComentarios->removeElement($idComentario);
    }

    /**
     * Get idComentarios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdComentarios()
    {
        return $this->idComentarios;
    }

    /**
     * Set idEmprendedor
     *
     * @param \asociateyaBundle\Entity\Emprendedor $idEmprendedor
     *
     * @return Usuario
     */
    public function setIdEmprendedor(\asociateyaBundle\Entity\Emprendedor $idEmprendedor = null)
    {
        $this->idEmprendedor = $idEmprendedor;

        return $this;
    }

    /**
     * Get idEmprendedor
     *
     * @return \asociateyaBundle\Entity\Emprendedor
     */
    public function getIdEmprendedor()
    {
        return $this->idEmprendedor;
    }

    /**
     * Add inversione
     *
     * @param \asociateyaBundle\Entity\Inversion $inversione
     *
     * @return Usuario
     */
    public function addInversione(\asociateyaBundle\Entity\Inversion $inversione)
    {
        $this->inversiones[] = $inversione;

        return $this;
    }

    /**
     * Remove inversione
     *
     * @param \asociateyaBundle\Entity\Inversion $inversione
     */
    public function removeInversione(\asociateyaBundle\Entity\Inversion $inversione)
    {
        $this->inversiones->removeElement($inversione);
    }

    /**
     * Get inversiones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInversiones()
    {
        return $this->inversiones;
    }

    /**
     * Add comentario
     *
     * @param \asociateyaBundle\Entity\Comentario $comentario
     *
     * @return Usuario
     */
    public function addComentario(\asociateyaBundle\Entity\Comentario $comentario)
    {
        $this->comentarios[] = $comentario;

        return $this;
    }

    /**
     * Remove comentario
     *
     * @param \asociateyaBundle\Entity\Comentario $comentario
     */
    public function removeComentario(\asociateyaBundle\Entity\Comentario $comentario)
    {
        $this->comentarios->removeElement($comentario);
    }

    /**
     * Get comentarios
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComentarios()
    {
        return $this->comentarios;
    }

    /**
     * Set emprendedor
     *
     * @param \asociateyaBundle\Entity\Emprendedor $emprendedor
     *
     * @return Usuario
     */
    public function setEmprendedor(\asociateyaBundle\Entity\Emprendedor $emprendedor = null)
    {
        $this->emprendedor = $emprendedor;

        return $this;
    }

    /**
     * Get emprendedor
     *
     * @return \asociateyaBundle\Entity\Emprendedor
     */
    public function getEmprendedor()
    {
        return $this->emprendedor;
    }
}

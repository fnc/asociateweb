<?php
// src/asociateyaBundle/Entity/Usuario.php

namespace asociateyaBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;//para usar arrays
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="asociateyaBundle\Entity\UserRepository")
 * @ORM\Table(name="usuarios")
 */

class Usuario implements UserInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="DatosDeUsuario", mappedBy="idUsuario", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    protected $datosDeUsuario;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $fechaCreacion;
    
    /**
     * @var string
     *
     * @ORM\Column(name="nombreUsuario", type="string", length=255)
     */
        private $nombreUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="contrasena", type="string", length=255)
     */
            private $contrasena;

     /**
     * @ORM\Column(name="is_active", type="boolean")
     */
     private $isActive;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->datosDeUsuario = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fechaCreacion = new \DateTime();
        $this->isActive = true;
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
     * Add datosDeUsuario
     *
     * @param \asociateyaBundle\Entity\DatosDeUsuario $datosDeUsuario
     *
     * @return Usuario
     */
    public function addDatosDeUsuario(\asociateyaBundle\Entity\DatosDeUsuario $datosDeUsuario)
    {
        $this->datosDeUsuario[] = $datosDeUsuario;

        return $this;
    }

    /**
     * Remove datosDeUsuario
     *
     * @param \asociateyaBundle\Entity\DatosDeUsuario $datosDeUsuario
     */
    public function removeDatosDeUsuario(\asociateyaBundle\Entity\DatosDeUsuario $datosDeUsuario)
    {
        $this->datosDeUsuario->removeElement($datosDeUsuario);
    }

    /**
     * Get datosDeUsuario
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDatosDeUsuario()
    {
        return $this->datosDeUsuario;
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
}

<?php

namespace asociateyaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;//para usar arrays
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * Categoria
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Categoria
{
    /**
     * @var integer
     *
     * @ORM\Column(name="categoria_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;


    /**
     * ORM\ManyToMany(targetEntity="Emprendimiento", mappedBy="idCategorias")
     * @ORM\OneToMany(targetEntity="Emprendimiento", mappedBy="id")
	
     **/
    private $idEmprendimientos;
public function __construct($name=null)
    {
        $this->idEmprendimientos = new ArrayCollection();

  
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
     * @return Categoria
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Categoria
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Add idEmprendimiento
     *
     * @param \asociateyaBundle\Entity\Emprendimiento $idEmprendimiento
     *
     * @return Categoria
     */
    public function addIdEmprendimiento(\asociateyaBundle\Entity\Emprendimiento $idEmprendimiento)
    {
        $this->idEmprendimiento[] = $idEmprendimiento;

        return $this;
    }

    /**
     * Remove idEmprendimiento
     *
     * @param \asociateyaBundle\Entity\Emprendimiento $idEmprendimiento
     */
    public function removeIdEmprendimiento(\asociateyaBundle\Entity\Emprendimiento $idEmprendimiento)
    {
        $this->idEmprendimiento->removeElement($idEmprendimiento);
    }

    /**
     * Get idEmprendimiento
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdEmprendimiento()
    {
        return $this->idEmprendimiento;
    }

    /**
     * Add emprendimiento
     *
     * @param \asociateyaBundle\Entity\Emprendimiento $emprendimiento
     *
     * @return Categoria
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
     * Get idEmprendimientos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdEmprendimientos()
    {
        return $this->idEmprendimientos;
    }
}

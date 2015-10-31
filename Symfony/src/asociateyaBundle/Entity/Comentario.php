<?php

namespace asociateyaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;//para usar arrays
use Symfony\Component\Security\Core\User\UserInterface;

/**
*
* @ORM\Entity
* @ORM\Table()
*/
class Comentario
{
    /**
    *  @ORM\Id
    *  @ORM\Column(type="integer", name="comentario_id")
    *  @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;

    /**
     *
     * @ORM\Column(name="idComentarioAnterior", type="integer",nullable=true)
     */
    private $idComentarioAnterior;

    /**
    * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="comentarios")
    * @ORM\JoinColumn(name="usuario_id", referencedColumnName="usuario_id",onDelete="CASCADE")
    */
    private $usuario;

    /**
    * @ORM\ManyToOne(targetEntity="Emprendimiento", inversedBy="comentarios")
    * @ORM\JoinColumn(name="emprendimiento_id", referencedColumnName="emprendimiento_id", onDelete="CASCADE")
    */
    private $emprendimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="leido", type="string", length=1)
     */
    private $leido;


    /**
     * @var string
     *
     * @ORM\Column(name="texto", type="string", length=255)
     */
    private $texto;


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
     * Set idComentarioAnterior
     *
     * @param integer $idComentarioAnterior
     *
     * @return Comentario
     */
    public function setIdComentarioAnterior($idComentarioAnterior)
    {
        $this->idComentarioAnterior = $idComentarioAnterior;

        return $this;
    }

    /**
     * Get idComentarioAnterior
     *
     * @return integer
     */
    public function getIdComentarioAnterior()
    {
        return $this->idComentarioAnterior;
    }

    /**
     * Set texto
     *
     * @param string $texto
     *
     * @return Comentario
     */
    public function setTexto($texto)
    {
        $this->texto = $texto;

        return $this;
    }

    /**
     * Get texto
     *
     * @return string
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * Set leido
     *
     * @param string $leido
     *
     * @return Comentario
     */
    public function setLeido($leido)
    {
        $this->leido = $leido;

        return $this;
    }

    /**
     * Get leido
     *
     * @return string
     */
    public function getLeido()
    {
        return $this->leido;
    }

    /**
     * Set idUsuario
     *
     * @param \asociateyaBundle\Entity\Usuario $idUsuario
     *
     * @return Comentario
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
     * Set idEmprendimiento
     *
     * @param \asociateyaBundle\Entity\Emprendimiento $idEmprendimiento
     *
     * @return Comentario
     */
    public function setIdEmprendimiento(\asociateyaBundle\Entity\Emprendimiento $idEmprendimiento = null)
    {
        $this->idEmprendimiento = $idEmprendimiento;

        return $this;
    }

    /**
     * Get idEmprendimiento
     *
     * @return \asociateyaBundle\Entity\Emprendimiento
     */
    public function getIdEmprendimiento()
    {
        return $this->idEmprendimiento;
    }

    /**
     * Set usuario
     *
     * @param \asociateyaBundle\Entity\Usuario $usuario
     *
     * @return Comentario
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
     * Set emprendimiento
     *
     * @param \asociateyaBundle\Entity\Emprendimiento $emprendimiento
     *
     * @return Comentario
     */
    public function setEmprendimiento(\asociateyaBundle\Entity\Emprendimiento $emprendimiento = null)
    {
        $this->emprendimiento = $emprendimiento;

        return $this;
    }

    /**
     * Get emprendimiento
     *
     * @return \asociateyaBundle\Entity\Emprendimiento
     */
    public function getEmprendimiento()
    {
        return $this->emprendimiento;
    }
}

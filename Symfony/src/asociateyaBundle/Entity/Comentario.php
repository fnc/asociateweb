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
     * @ORM\Column(name="idComentarioAnterior", type="integer")
     */
    private $idComentarioAnterior;

    /**
    * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="comentarios")
    * @ORM\JoinColumn(name="usuario_id", referencedColumnName="usuario_id",onDelete="CASCADE")
    */
    private $usuario;

    /**
    * @ORM\ManyToOne(targetEntity="Emprendimiento", inversedBy="id")
    * @ORM\JoinColumn(name="emprendimiento_id", referencedColumnName="emprendimiento_id",         onDelete="CASCADE")
    */
    private $idEmprendimiento;


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
}

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
     * @ORM\OneToOne(targetEntity="Comentario")
     * @ORM\JoinColumn(name="comentarioPadre_id" , referencedColumnName="comentario_id")
     */
    private $comentarioPadre;

    /**
     * @ORM\OneToOne(targetEntity="Comentario")
     * @ORM\JoinColumn(name="comentarioHijo_id" , referencedColumnName="comentario_id")
     */
    private $comentarioHijo;

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
     * @ORM\Column(type="datetime")
     */
    private $fechaCreacion;


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

        /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Emprendimiento
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
     * Set comentarioPadre
     *
     * @param \asociateyaBundle\Entity\Comentario $comentarioPadre
     *
     * @return Comentario
     */
    public function setComentarioPadre(\asociateyaBundle\Entity\Comentario $comentarioPadre = null)
    {
        $this->comentarioPadre = $comentarioPadre;

        return $this;
    }

    /**
     * Get comentarioPadre
     *
     * @return \asociateyaBundle\Entity\Comentario
     */
    public function getComentarioPadre()
    {
        return $this->comentarioPadre;
    }

    /**
     * Set comentarioHijo
     *
     * @param \asociateyaBundle\Entity\Comentario $comentarioHijo
     *
     * @return Comentario
     */
    public function setComentarioHijo(\asociateyaBundle\Entity\Comentario $comentarioHijo = null)
    {
        $this->comentarioHijo = $comentarioHijo;

        return $this;
    }

    /**
     * Get comentarioHijo
     *
     * @return \asociateyaBundle\Entity\Comentario
     */
    public function getComentarioHijo()
    {
        return $this->comentarioHijo;
    }
}

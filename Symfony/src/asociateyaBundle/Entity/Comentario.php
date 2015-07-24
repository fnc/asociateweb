<?php

namespace asociateyaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comentario
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Comentario
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="idComentarioAnterior", type="integer")
     */
    private $idComentarioAnterior;

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
}


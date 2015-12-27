<?php

namespace asociateyaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Resultado
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Resultado
{
    /**
     * @var integer
     *
     * @ORM\Column(name="resultado_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="monto", type="decimal")
     */
    private $monto;

    /**
     * @var string
     *
     * @ORM\Column(name="rutaInforme", type="string", length=255)
     */
    private $rutaInforme;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
    * @ORM\ManyToOne(targetEntity="Emprendimiento", inversedBy="resultados")
    * @ORM\JoinColumn(name="emprendimiento_id", referencedColumnName="emprendimiento_id", onDelete="CASCADE")
    */
    private $emprendimiento;


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
     * Set monto
     *
     * @param string $monto
     *
     * @return Resultado
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto
     *
     * @return string
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * Set rutaInforme
     *
     * @param string $rutaInforme
     *
     * @return Resultado
     */
    public function setRutaInforme($rutaInforme)
    {
        $this->rutaInforme = $rutaInforme;

        return $this;
    }

    /**
     * Get rutaInforme
     *
     * @return string
     */
    public function getRutaInforme()
    {
        return $this->rutaInforme;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Resultado
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set emprendimiento
     *
     * @param \asociateyaBundle\Entity\Emprendimiento $emprendimiento
     *
     * @return Inversion
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

<?php

namespace asociateyaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
*/
class NuevoEstadoResultado extends Notificacion
{
   /**
   * @ORM\OneToOne(targetEntity="Resultado")
   * @ORM\JoinColumn(name="resultado_id", referencedColumnName="resultado_id")
   */
   private $resultado;

    /**
     * Set resultado
     *
     * @param \asociateyaBundle\Entity\Resultado $resultado
     *
     * @return Notificacion
     */
    public function setResultado(\asociateyaBundle\Entity\Resultado $resultado = null)
    {
        $this->resultado = $resultado;

        return $this;
    }

    /**
     * Get resultado
     *
     * @return \asociateyaBundle\Entity\Resultado
     */
    public function getResultado()
    {
        return $this->resultado;
    }
}

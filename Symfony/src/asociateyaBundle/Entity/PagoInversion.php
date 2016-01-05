<?php

namespace asociateyaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PagoInversion
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class PagoInversion extends Pago
{
   /**
   * @ORM\ManyToOne(targetEntity="Inversion", inversedBy="pagos")
   * @ORM\JoinColumn(name="inversion_id", referencedColumnName="inversion_id")
   */
   private $inversion;


    /**
     * Set inversion
     *
     * @param \asociateyaBundle\Entity\Inversion $inversion
     *
     * @return PagoInversion
     */
    public function setInversion(\asociateyaBundle\Entity\Inversion $inversion = null)
    {
        $this->inversion = $inversion;

        return $this;
    }

    /**
     * Get inversion
     *
     * @return \asociateyaBundle\Entity\Inversion
     */
    public function getInversion()
    {
        return $this->inversion;
    }
}

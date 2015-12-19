<?php

namespace asociateyaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
*/
class NuevaInversion extends Notificacion
{
   /**
   * @ORM\OneToOne(targetEntity="Inversion")
   * @ORM\JoinColumn(name="inversion_id", referencedColumnName="inversion_id")
   */
   private $inversion;

   /**
   * Set inversion
   *
   * @param \asociateyaBundle\Entity\Inversion $inversion
   *
   * @return Notificacion
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

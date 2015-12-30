<?php

namespace asociateyaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
*/
class EmprendimientoCancelado extends Notificacion
{
   /**
   * @ORM\OneToOne(targetEntity="Emprendimiento")
   * @ORM\JoinColumn(name="emprendimiento_id", referencedColumnName="emprendimiento_id")
   */
   private $emprendimiento;

    /**
     * Set emprendimiento
     *
     * @param \asociateyaBundle\Entity\Emprendimiento $emprendimiento
     *
     * @return EmprendimientoCancelado
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

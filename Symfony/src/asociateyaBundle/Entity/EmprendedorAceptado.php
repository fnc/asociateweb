<?php

namespace asociateyaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
*/
class EmprendedorAceptado extends Notificacion
{
   /**
   * @ORM\OneToOne(targetEntity="Emprendedor")
   * @ORM\JoinColumn(name="emprendedor_id", referencedColumnName="emprendedor_id")
   */
   private $emprendedor;

    /**
     * Set emprendedor
     *
     * @param \asociateyaBundle\Entity\Emprendedor $emprndedor
     *
     * @return EmprendedorAceptado
     */
    public function setEmprendedor(\asociateyaBundle\Entity\Emprendedor $emprendedor = null)
    {
        $this->emprendedor = $emprendedor;

        return $this;
    }

    /**
     * Get emprendedor
     *
     * @return \asociateyaBundle\Entity\Emprendedor
     */
    public function getEmprendedor()
    {
        return $this->emprendedor;
    }
}

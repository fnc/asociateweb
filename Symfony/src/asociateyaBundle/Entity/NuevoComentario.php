<?php

namespace asociateyaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
*/
class NuevoComentario extends Notificacion
{
   /**
   * @ORM\OneToOne(targetEntity="Comentario")
   * @ORM\JoinColumn(name="comentario_id", referencedColumnName="comentario_id")
   */
   private $comentario;

   /**
   * Set comentario
   *
   * @param \asociateyaBundle\Entity\Comentario $comentario
   *
   * @return Notificacion
   */
   public function setComentario(\asociateyaBundle\Entity\Comentario $comentario = null)
   {
      $this->comentario = $comentario;

      return $this;
   }

   /**
   * Get comentario
   *
   * @return \asociateyaBundle\Entity\Comentario
   */
   public function getComentario()
   {
      return $this->comentario;
   }

}

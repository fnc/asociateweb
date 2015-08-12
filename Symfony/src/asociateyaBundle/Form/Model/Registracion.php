<?php 
// src/asociateyaBundle/Form/Model/Registracion.php
namespace asociateyaBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

use asociateyaBundle\Entity\Usuario;

class Registracion
{
    /**
     * @Assert\Type(type="asociateyaBundle\Entity\Usuario")
     * @Assert\Valid()
     */
    protected $usuario;

    /**
     * @Assert\NotBlank()
     * @Assert\True()
     */
    protected $termsAccepted;

    public function setUsuario(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getTermsAccepted()
    {
        return $this->termsAccepted;
    }

    public function setTermsAccepted($termsAccepted)
    {
        $this->termsAccepted = (bool) $termsAccepted;
    }
}
?>
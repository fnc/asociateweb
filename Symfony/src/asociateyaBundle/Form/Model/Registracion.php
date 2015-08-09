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
    protected $user;

    /**
     * @Assert\NotBlank()
     * @Assert\True()
     */
    protected $termsAccepted;

    public function setUser(Usuario $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
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
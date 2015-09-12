<?php 
// src/asociateyaBundle/Form/Model/ModificacionUsuario.php
namespace asociateyaBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

use asociateyaBundle\Entity\Usuario;

use asociateyaBundle\Entity\DatosDeUsuario;

class ModificacionUsuario
{
    /**
     * @Assert\Type(type="asociateyaBundle\Entity\Usuario")
     * @Assert\Valid()
     */
    protected $usuario;

    /**
     * @Assert\Type(type="asociateyaBundle\Entity\DatosDeUsuario")
     * @Assert\Valid()
     */
    protected $datosDeUsuario;

    public function setUsuario(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setDatosDeUsuario(DatosDeUsuario $datosDeUsuario)
    {
        $this->datosDeUsuario = $datosDeUsuario;
    }

    public function getDatosDeUsuario()
    {
        return $this->datosDeUsuario;
    }

}
?>
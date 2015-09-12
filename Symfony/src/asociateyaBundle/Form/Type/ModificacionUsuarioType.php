<?php 
// src/asociateyaBundle/Form/Type/ModificacionUsuarioType.php
namespace asociateyaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ModificacionUsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('usuario', new UsuarioType());

        $builder->add('datosdeusuario', new DatosDeUsuarioType());

        $builder->add('Modificar', 'submit');
    }

    public function getName()
    {
        return 'modificacionusuario';
    }
}
?>
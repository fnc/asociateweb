<?php 
// src/asociateyaBundle/Form/Type/RegistracionType.php
namespace asociateyaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistracionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('usuario', new UsuarioType());
        $builder->add(
            'Acepto_los_terminos_de_uso_de_AsociateYa',
            'checkbox',
            array('property_path' => 'termsAccepted')
        );
        $builder->add('Registrar', 'submit');
    }

    public function getName()
    {
        return 'registration';
    }
}
?>
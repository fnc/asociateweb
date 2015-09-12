<?php 
// src/asociateyaBundle/Form/Type/DatosDeUsuarioType.php
namespace asociateyaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DatosDeUsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre', 'text');
        $builder->add('apellido', 'text');
        $builder->add('email', 'email');
        $builder->add('dni', 'text');
        $builder->add('direccion', 'text');
        $builder->add('cuit', 'text');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'asociateyaBundle\Entity\Usuario'
        ));
    }

    public function getName()
    {
        return 'datosdeusuario';
    }
}
?>
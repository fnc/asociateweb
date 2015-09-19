<?php

namespace asociateyaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;



class EmprendimientoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('monto', 'text', array('attr' => array('class' => 'element text currency')))
            ->add('tipoDeMeta')
            ->add('nombre', 'text', array('attr' => array('class' => 'element text large')))
            ->add('rutaImagen')
            ->add('descripcionCorta', 'textarea', array('attr' => array('class' => 'element textarea small')))
            ->add('descripcionLarga', 'textarea', array('attr' => array('class' => 'element textarea large')))
            //->add('estado')
            ->add('precioAccion', 'text', array('attr' => array('class' => 'element text currency')))
            ->add('totalAcciones', 'text', array('attr' => array('class' => 'element text')))
            //->add('accionesRestantes')
            //->add('ranking')
            //->add('fechaCreacion')
            //->add('fechaAprobacion')
            //->add('fechaCancelacion')
            //->add('fechaFinalizacion')
            ->add('categorias', 'entity', array('class' => 'asociateyaBundle:Categoria','choice_label' => 'nombre','multiple'=>true,'expanded'=>true))
            //->add('emprendedor')
            //->add('caja')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'asociateyaBundle\Entity\Emprendimiento'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'asociateyabundle_emprendimiento';
    }
}

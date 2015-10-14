<?php

namespace asociateyaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;



class EmprendimientoEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('descripcionCorta', 'textarea', array('attr' => array('class' => 'element textarea small')))
            ->add('descripcionLarga', 'textarea', array('attr' => array('class' => 'element textarea large')))
            //->add('rutaImagen', 'file', array('label' => 'Imagen emprendimiento(JPG)','data_class' => null))
            ->add('categorias', 'entity', array('class' => 'asociateyaBundle:Categoria',
                                                'choice_label' => 'nombre',
                                                'multiple'=>true,
                                                'expanded'=>true,
                                                'placeholder'=>'Elija una categoria.'))
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

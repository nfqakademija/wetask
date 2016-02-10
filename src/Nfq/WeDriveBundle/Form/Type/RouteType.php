<?php
/**
 * Created by PhpStorm.
 * User: Edvinas
 * Date: 14.4.17
 * Time: 18.51
 */

namespace Nfq\WeDriveBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RouteType extends AbstractType
{

    protected $entity;

    public function __construct($entity = 'route')
    {
        $this->entity = $entity;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                'text',
                array(
                    'attr' => array(
                        'class' => 'form-control'
                    )
                )
            )
            ->add(
                'destination',
                'text',
                array(
                    'attr' => array(
                        'class' => 'form-control'
                    )
                )
            )
            ->add(
                'routePoints',
                'hidden',
                array(
                    'mapped' => false,
                    'required' => false,
                    'property_path' => null,
                )
            )
        ;


        if ($this->entity == 'route') {
            $builder->add(
                'save',
                'submit',
                array(
                    'attr' => array(
                        'class' => 'btn btn-sm btn-success',
                    )
                )
            );

        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Nfq\WeDriveBundle\Entity\Route',
            )
        );
    }

    public function getName()
    {
        return 'route';
    }
}

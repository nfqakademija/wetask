<?php
/**
 * Created by PhpStorm.
 * User: Edvinas
 * Date: 14.4.12
 * Time: 22.34
 */

namespace Nfq\WeDriveBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpKernel\Tests\Controller;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class TripType extends AbstractType
{

    protected $routes;

    public function __construct($routes)
    {
        $this->routes = $routes;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                'text',
                array(
                    'label' => 'Title',
                    'label_attr' => array(
                        'class' => 'control-label'
                    ),
                    'attr' => array(
                        'class' => 'form-control'
                    )
                )
            )
            ->add(
                'description',
                'text',
                array(
                    'label' => 'Description',
                    'label_attr' => array(
                        'class' => 'control-label'
                    ),
                    'attr' => array(
                        'class' => 'form-control'
                    )
                )
            )
            ->add(
                'maxPassengers',
                'integer',
                array(
                    'label' => 'Max seats',
                    'label_attr' => array(
                        'class' => 'control-label'
                    ),
                    'attr' => array(
                        'class' => 'form-control'
                    )
                )
            )
            ->add(
                'availableSeats',
                'integer',
                array(
                    'label' => 'Available seats',
                    'label_attr' => array(
                        'class' => 'control-label'
                    ),
                    'attr' => array(
                        'class' => 'form-control'
                    )
                )
            )
            ->add(
                'departureTime',
                'datetime',
                array(
                    'label' => 'Departure time',
                    'label_attr' => array(
                        'class' => 'control-label'
                    ),
                    'data'  =>  new \DateTime("+3 hours"),
                    'input' =>  'datetime'
                )
            )
            ->add(
                'route',
                'entity',
                array(
                    'label' => 'Choose route',
                    'label_attr' => array(
                        'class' => 'control-label'
                    ),
                    'attr' => array(
                        'class' => 'form-control col-lg-10'
                    ),
                    'class'     => 'NfqWeDriveBundle:Route',
                    'choices'   => $this->routes,
                    'property'  => 'name'
                )
            )
            ->add(
                'save',
                'submit',
                array(
                    'attr' => array(
                        'class' => 'btn btn-lg btn-success col-lg-2'
                    )
                )
            );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'Nfq\WeDriveBundle\Entity\Trip',
            ));
    }

    public function getName()
    {
        return 'trip';
    }
}

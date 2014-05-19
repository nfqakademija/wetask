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


class TripRouteType extends AbstractType
{

//    protected $route;
//
//    public function __construct($route)
//    {
//        $this->route = $route;
//    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choices = array();
        for($i=0;$i<20;$i++){
            $choices["$i"] = "$i";
        }
        $builder
//            ->add(
//                'title',
//                'text',
//                array(
//                    'label' => 'Title',
//                    'label_attr' => array(
//                        'class' => 'control-label'
//                    ),
//                    'attr' => array(
//                        'class' => 'form-control'
//                    )
//                )
//            )
            ->add(
                'route',
                new RouteType('trip')
            )
            ->add(
                'description',
                'text',
                array(
                    'label' => 'Description',
                    'required' => false,
                    'label_attr' => array(
                        'class' => 'control-label'
                    ),
                    'attr' => array(
                        'class' => 'form-control',
                    )
                )
            )
//            ->add(
//                'maxPassengers',
//                'integer',
//                array(
//                    'label' => 'Available seats',
//                    'label_attr' => array(
//                        'class' => 'control-label'
//                    ),
//                    'attr' => array(
//                        'class' => 'form-control'
//                    )
//                )
//            )
                        ->add(
                'maxPassengers',
                'choice',
                array(
                    'label' => 'Available seats',
                    'label_attr' => array(
                        'class' => 'control-label'
                    ),
                    'attr' => array(
                        'class' => 'form-control'
                    ),
                    'choices' => $choices
                )
            )
            ->add(
                'departureTime',
                'datetime',
                array(
                    'label' => 'Departure time',
                    'date_widget' => 'single_text',
                    'time_widget' => 'single_text',
                    'label_attr' => array(
                        'class' => 'control-label'
                    ),
                    'data' => new \DateTime("+3 hours"),
                    'input' => 'datetime'
                )
            )
//            ->add(
//                'route',
//                'entity',
//                array(
//                    'label' => 'Choose route',
//                    'label_attr' => array(
//                        'class' => 'control-label'
//                    ),
//                    'attr' => array(
//                        'class' => 'form-control col-lg-10'
//                    ),
//                    'class'     => 'NfqWeDriveBundle:Route',
//                    'choices'   => $this->routes,
//                    'property'  => 'name'
//                )
//            )
            ->add(
                'save',
                'submit',
                array(
                    'attr' => array(
                        'class' => 'btn btn-sm btn-success col-lg-2'
                    )
                )
            );

//        unset($this['route.save']);
//        $builder->remove(
//
//            );

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Nfq\WeDriveBundle\Entity\Trip',
            )
        );
    }

    public function getName()
    {
        return 'trip';
    }
}

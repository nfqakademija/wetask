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

class TripType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('trip_name','text')
            ->add('destination', 'text')
            ->add('departure_time', 'time');
    }

    public function getName()
    {
        return 'trip';
    }
}

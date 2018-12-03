<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 02/12/2018
 * Time: 13:47
 */

namespace App\Form;
use App\Entity\Gift;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GiftType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if(array_key_exists('editing', $options['data']) ) {

            $builder
                ->add('name', TextType::class, array('data' => $options['data']['name']))
                ->add('description', TextType::class, array('data' => $options['data']['description']))
                ->add('source', TextType::class, array('data' => $options['data']['source']))
                ->add('save', SubmitType::class, array('label' => 'Editer le cadeau'));
        } else {
            $builder
                ->add('name', TextType::class)
                ->add('description', TextType::class)
                ->add('source', TextType::class)
                ->add('save', SubmitType::class, array('label' => 'Editer le cadeau'));
        }

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data' => null,
        ));
    }
}
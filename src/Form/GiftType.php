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
                ->add('name', TextType::class, array('data' => $options['data']['name'], 'attr' => array('placeholder' => 'Nom du cadeau'), 'label' => false))
                ->add('description', TextType::class, array('data' => $options['data']['description'], 'attr' => array('placeholder' => 'Description du cadeau (optionnel)'), 'label' => false))
                ->add('source', TextType::class, array('data' => $options['data']['source'], 'attr' => array('placeholder' => 'Lien vers le cadeau (optionnel)'), 'label' => false))
                ->add('save', SubmitType::class, array('label' => 'Envoyer'));
        } else {
            $builder
                ->add('name', TextType::class, array('attr' => array('placeholder' => 'Nom du cadeau'), 'label' => false))
                ->add('description', TextType::class, array('attr' => array('placeholder' => 'Description du cadeau (optionnel)'), 'label' => false))
                ->add('source', TextType::class, array('attr' => array('placeholder' => 'Lien vers le cadeau (optionnel)'), 'label' => false))
                ->add('save', SubmitType::class, array('label' => 'Envoyer'));
        }

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data' => null,
        ));
    }
}
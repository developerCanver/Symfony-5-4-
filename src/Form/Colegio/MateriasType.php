<?php

namespace App\Form\Colegio;

use App\Entity\Colegio\materias;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MateriasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       
         $builder
           
            ->add('materia', TextType::class, array(
                        'label'         =>'Materia',
                        'attr'          => ['Placeholder'=>'Igrese materia']
            ))
           
            ->add('submit', SubmitType::class, array(
                'label' => ' '
            )) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        //adicion de los parametros a utilizar
        $resolver->setDefaults([
            'data_class' => materias::class,
        ]);
    }
}

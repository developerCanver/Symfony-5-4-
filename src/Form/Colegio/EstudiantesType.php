<?php

namespace App\Form\Colegio;

use App\Entity\Colegio\estudiante;
use App\Entity\Colegio\tipoId;
use App\Repository\Colegio\tipoIdRepository;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EstudiantesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // se asignan los árametros a  las variables 
        $idCompania=$options['idCompania'];
        $letra=$options['letra'];
        //dump($options['data']->getPreferencias());exit;
        $options['data']->setPreferencias(explode(",",$options['data']->getPreferencias()));
        $builder
           
            ->add('apellidos', TextType::class, array(
                        'label'         =>'Apellidos',
                        'attr'          => ['Placeholder'=>'Apellido del estudiante']
            ))
                    ->add('nombres',    TextType::class, array(
                        'label'         => 'Nombres',
                        'attr'          =>  ['Placeholder'=>'Nombre del estudiante']
            ))
            ->add('direccion',    TextType::class, array(
                        'label'         => 'Dirección',
                        'attr'          =>  ['Placeholder'=>'Dirección del estudiante']
            ))
            ->add('fecha_nac', DateType::class, array(
                        'widget'        => 'single_text',
                        'data'          => new \DateTime('2022-12-13'),
                        'attr'          => ['max'=>'2023-01-01', 'min'  => '1990-01-01']
            ))
            ->add('identificacion',    TextType::class, array(
                        'label'         => 'Identificación',
                        //'html5'          =>  true,
                        'attr'          =>  ['Placeholder'=>'Identificación del estudiante','minlength'=>8,'maxlength'=>15]
            ))
            ->add('foto', FileType::class, array(
                        'label'         => 'Foto',
                        'data_class'    => null,
                        'attr'          =>  ['accept' => 'image/*'],
                        'required'      => false,
            ))
          
            ->add('tipoid',EntityType::class, array(
                    'label'           => 'Tipo ID',
                    'class'           => tipoId::class,
                    'choice_label'    => 'tipo_id',
                    'query_builder'   => function(tipoIdRepository $tipoId) use ($letra){
                   
                    
                   /*  return $tipoId->createQueryBuilder('tipoId')
                    ->where('tipoId.tipo_id like :letra')
                    ->setParameter('letra', '%'.$letra.'%')
                    - >orderBy('tipoId.id','DESC');*/
                    
                    //----------------2----------------
                     //se utiliza la funcion de buscar letra en Repository/Colegio/tipoIdRepository.php
                    return $tipoId->buscarLetra_query_builde($letra);
                    

                }
            ))
            ->add('preferencias', ChoiceType::class,array(
                        'multiple'      => true,
                        'placeholder'   => 'seleccione Preferencia',
                        'choices'       => array(
                                            'Deportes'      =>1,
                                            'Television'    =>2,
                                            'Lectura'       =>3,
                    )

            ))
           
            ->add('idCompania', HiddenType::class, array(
                'label' => 'idCompania',
                'mapped' => false,
                'data'  => $idCompania,
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Guardar estudiante'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        //adicion de los parametros a utilizar
        $resolver->setDefaults([
            'data_class' => estudiante::class,
            'idCompania' => null,
            'letra' => null,
        ]);
    }
}

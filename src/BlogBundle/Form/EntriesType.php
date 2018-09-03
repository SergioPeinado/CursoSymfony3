<?php

namespace BlogBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntriesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',
                TextType::class,
                array(
                    "label" => "Título:",
                    "required" => "required",
                    "attr" =>
                        array(
                            "class" => "form-name form-control",
                        ))
            )
            ->add('content',
                TextareaType::class,
                array(
                    "label" => "Descripcion:",
                    "required" => "required",
                    "attr" =>
                        array(
                            "class" => "form-name form-control",
                        ))
            )
            ->add('status',
                ChoiceType::class,
                array(
                    "label" => "Estado:",
                    "choice" =>
                        array(
                            "public"=>"Publicado",
                            "private"=>"Privado"
                        ),
                    "attr" =>
                        array(
                            "class" => "form-name form-control",
                        ))
            )
            ->add('image',
                FileType::class,
                array(
                    "label" => "Imagen:",
                    "attr" =>
                        array(
                            "class" => "form-name form-control",
                        ))
            )
            ->add('category',
                EntityType::class,
                array(
                    "label" => "Categorias:",
                    "attr" =>
                        array(
                            "class" => "form-name form-control",
                        ))
            )
            ->add('tags')
            ->add("Guardar",
                SubmitType::class,
                array("attr" =>
                    array(
                        "class" => "btn btn-success",
                    ))
            )
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BlogBundle\Entity\Entries'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'blogbundle_entries';
    }


}

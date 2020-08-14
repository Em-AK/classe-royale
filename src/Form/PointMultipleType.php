<?php

namespace App\Form;

use App\Entity\Point;
use App\Entity\Student;
use App\Repository\StudentRepository;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PointMultipleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $number = $options['number'];
        $builder
            ->add('student', EntityType::class, [
                'class' => Student::class,
                'choice_label' => 'firstname',
                'expanded' => true,
                'multiple' => true,
                'query_builder' => function (StudentRepository $studentRepository) use ($number) {
                return $studentRepository->createQueryBuilder('s')
                    ->andWhere('s.classgroup = :val')
                    ->setParameter('val', $number)
                    ->orderBy('s.lastname', 'ASC')
                    ;
                }
            ])
            ->add('quantity', IntegerType::class)
            ->add('reason', ReasonType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ])
            ->setRequired('number');
    }
}

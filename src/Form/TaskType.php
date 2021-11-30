<?php
namespace App\Form\Type;

use App\Entity\Task;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('task', TextType::class,[
                'label' => 'Task:',
            ])
            ->add('dueDate', DateType::class, [
                'label' => 'To be Completed Before:',
            ])
            ->add('Description', TextType::class, [
                'required' => false,
                'label' => 'Description of the Task',
                ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=>Task::class,
        ]);
    }
}
?>
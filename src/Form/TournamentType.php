<?php


namespace App\Form;

use Doctrine\DBAL\Types\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class TournamentType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('traveldistance', TextType::class)
            ->add('model', TextType::class)
            ->add('flight_duration', TextType::class)
            ->add('participant_name', TextType::class)
            ->add('date', DateType::class)
            ->add('round', NumberType::class);
    }
}
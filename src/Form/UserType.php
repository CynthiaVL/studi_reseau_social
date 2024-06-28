<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Context\ExecutionContext;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nom d\'utilisateur : ', 
                'required' => true, 
                'constraints' => [
                    new Length(["min"=>5 ,"max"=>50, "minMessage" => "Le nom d'utilisateur doit faire au moins 5 caractères", "maxMessage" => "Le nom d'utilisateur ne doit pas dépasser les 50 caractères"])
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe ', 
                'required' => true, 
                'constraints' => [
                    new Length(["min"=>7 ,"max"=>300, "minMessage" => "Le mot de passe doit faire au moins 7 caractères", "maxMessage" => "Le mot de passe ne doit pas dépasser les 300 caractères"])
                ]
            ])
            ->add('confirmPassword', PasswordType::class, [
                'label' => 'Confirmer le mot de passe ', 
                'required' => true, 
                'constraints' => [
                    new Callback(['callback' => function($value, ExecutionContext $ec){
                        if($ec->getRoot()['password']->getViewData() !== $value) {
                            $ec->addViolation("Les mots de pass doivent-être identiques");
                        }
                    }])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => User::class,
            "csrf_protection" => true,
            "csrf_field_name" => '_token',
            "csrf_token_id" => 'user_item'
        ]);
    }
}

?>
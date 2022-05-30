<?php
/**
 * Sales type.
 */

namespace App\Form\Type;

use App\Entity\Add;
use App\Entity\Categories;
use App\Entity\Sales;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SalesType.
 */
class SalesType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @param array<string, mixed> $options
     *
     * @see FormTypeExtensionInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'category',
            EntityType::class,
            [
                'class' => Categories::class,
                'choice_label' => function ($categories) {
                    return $categories->getName();
                },
                'label' => 'label.category',
                'placeholder' => 'brak',
                'required' => true,
            ]);
        $builder->add(
            'title',
            TextType::class,
            [
                'label' => 'label.title',
                'required' => true,
                'attr' => ['max_length' => 255],
            ]);
        $builder->add(
            'smartphone',
            CheckboxType::class,
            [
                'label' => 'label.smartphone',
                'required' => false,
            ]);
        $builder->add(
            'acc',
            IntegerType::class,
            [
                'label' => 'label.acc',
                'required' => true,
                'attr' => ['max_length' => 11],
            ]);
        $builder->add(
            'adds',
            EntityType::class,
            [
                'class' => Add::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => function ($adds) {
                    return $adds->getComment();
                },
                'label' => 'label.add',
                'placeholder' => 'brak',
                'required' => true,
            ]);
    }

    /**
     * Configures the options for this type.
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Sales::class]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'sales';
    }
}

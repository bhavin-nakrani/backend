<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'query_builder' => function (EntityRepository $en) {
                    return $en->createQueryBuilder('c')
                        ->orderBy('c.title', 'ASC');
                },
                'choice_label' => 'title',
                'label' => 'Category',
            ])
            ->add('title', TextType::class, ['required' => true, 'label' => 'Title'])
            ->add('shortDescription', TextareaType::class, ['required' => false, 'label' => 'Short Description'])
            ->add('description', TextareaType::class, ['required' => false, 'label' => 'Description'])
            ->add('slug', TextType::class, ['label' => 'Slug'])
            ->add('isPublish', CheckboxType::class, ['label' => 'Is Publish?'])
            ->add('author', TextType::class, ['label' => 'Author'])
            ->add('metaTitle', TextType::class, ['label' => 'Meta Title'])
            ->add('metaKeyword', TextType::class, ['label' => 'Meta Keyword'])
            ->add('metaDescription', TextType::class, ['label' => 'Meta Description'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}

<?php

namespace Victoire\Bundle\SeoBundle\Form;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Victoire\Bundle\SeoBundle\DataTransformer\PageToIdTransformer;

/**
 *
 * @author Paul Andrieux
 *
 */
class PageSeoType extends AbstractType
{
    /**
     * @param ObjectManager $em
     */
    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entityManager = $this->em;
        $pageToIdTransformer = new PageToIdTransformer($entityManager);

        $builder
            ->add('metaTitle', null, array(
                'label' => 'form.pageSeo.metaTitle.label',
            ))
            ->add('metaDescription', null, array(
                'label' => 'form.pageSeo.metaDescription.label',
            ))
            ->add('relAuthor', null, array(
                'label' => 'form.pageSeo.relAuthor.label',
            ))
            ->add('relPublisher', null, array(
                'label' => 'form.pageSeo.relPublisher.label',
            ))
            ->add('ogTitle', null, array(
                'label'      => 'form.pageSeo.ogTitle.label',
                'vic_help_block' => 'form.pageSeo.ogTitle.vic_help_block',
            ))
            ->add('ogType', null, array(
                'label' => 'form.pageSeo.ogType.label',
            ))
            ->add('ogImage', 'media', array(
                'label' => 'form.pageSeo.ogImage.label',
            ))
            ->add('ogUrl', null, array(
                'label' => 'form.pageSeo.ogUrl.label',
            ))
            ->add('ogDescription', null, array(
                'label' => 'form.pageSeo.ogDescription.label',
            ))
            ->add('fbAdmins', null, array(
                'label' => 'form.pageSeo.fbAdmins.label',
            ))
            ->add('twitterCard', null, array(
                'label'      => 'form.pageSeo.twitterCard.label',
                'vic_help_block' => 'form.pageSeo.twitterCard.vic_help_block',
            ))
            ->add('twitterUrl', null, array(
                'label' => 'form.pageSeo.twitterUrl.label',
            ))
            ->add('twitterTitle', null, array(
                'label' => 'form.pageSeo.twitterTitle.label',
            ))
            ->add('twitterDescription', null, array(
                'label' => 'form.pageSeo.twitterDescription.label',
            ))
            ->add('twitterImage', 'media', array(
                'label' => 'form.pageSeo.twitterImage.label',
            ))
            ->add('schemaPageType', null, array(
                'label' => 'form.pageSeo.schemaPageType.label',
            ))
            ->add('schemaName', null, array(
                'label' => 'form.pageSeo.schemaName.label',
            ))
            ->add('schemaDescription', null, array(
                'label' => 'form.pageSeo.schemaDescription.label',
            ))
            ->add('schemaImage', 'media', array(
                'label' => 'form.pageSeo.schemaImage.label',
            ))
            ->add('metaRobotsIndex', 'choice', array(
                'label' => 'form.pageSeo.metaRobotsIndex.label',
                'choices' => [
                    'index' => 'form.pageSeo.metaRobotsIndex.values.index',
                    'noindex' => 'form.pageSeo.metaRobotsIndex.values.noindex',
                ],
            ))
            ->add('metaRobotsFollow', 'choice', array(
                'label' => 'form.pageSeo.metaRobotsFollow.label',
                'choices' => [
                    'follow' => 'form.pageSeo.metaRobotsFollow.values.follow',
                    'nofollow' => 'form.pageSeo.metaRobotsFollow.values.nofollow',
                ],
            ))
            ->add('metaRobotsAdvanced', null, array(
                'label' => 'form.pageSeo.metaRobotsAdvanced.label',
            ))
            ->add('sitemapIndexed', null, array(
                'label' => 'form.pageSeo.sitemapIndexed.label',
            ))
            ->add('sitemapPriority', null, array(
                'label' => 'form.pageSeo.sitemapPriority.label',
            ))
            ->add('sitemapPriority', 'choice',
                array(
                    'label'   => 'form.pageSeo.sitemapPriority.label',
                    'choices' => array_combine(range(0, 1, 0.1), range(0, 1, 0.1)),
            ))
            ->add('relCanonical', null, array(
                'label' => 'form.pageSeo.relCanonical.label',
            ))
            ->add('keyword', null, array(
                'label' => 'form.pageSeo.keyword.label',
            ))
            ->add('redirectTo', null, array(
                'label'      => 'form.pageSeo.redirectTo.label',
                'vic_help_block' => 'form.pageSeo.redirectTo.vic_help_block',
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'         => 'Victoire\Bundle\SeoBundle\Entity\PageSeo',
            'translation_domain' => 'victoire',
        ));
    }

    /**
     * The name of the form
     *
     * @return string
     */
    public function getName()
    {
        return 'seo_page';
    }
}

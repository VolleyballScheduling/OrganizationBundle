<?php
namespace Volleyball\Bundle\OrganizationBundle\Form\Type;

class OrganizationFormType extends \Symfony\Component\Form\AbstractType
{
    /**
     * Build form
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('description');
        $builder->add('save', 'submit');
    }

    /**
     * Set default options
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(\Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Volleyball\Bundle\OrganizationBundle\Entity\Organization',
            )
        );
    }
    
    /**
     * Get name
     * @return string
     */
    public function getName()
    {
        return 'organization';
    }
}

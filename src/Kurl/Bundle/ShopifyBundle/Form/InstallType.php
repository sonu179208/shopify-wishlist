<?php
/**
  * The app install form.
  *
  * @created 06/09/2013 13:05
  * @author chris
  */

namespace Kurl\Bundle\ShopifyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class Install
 *
 * @package Kurl\Bundle\ShopifyBundle\Form
 */
class InstallType extends AbstractType
{
    /**
     * Builds the form.
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('hostname', 'text');
    }

    /**
     * This form does not tie into an entity, doing nothing here seems to be fine :P.
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Kurl\Bundle\ShopifyBundle\Entity\Shop'
            )
        );
    }

    /**
     * The form identifier.
     * @return string the form name
     */
    public function getName()
    {
        return 'kurl_shopify_registry_form_install';
    }
}
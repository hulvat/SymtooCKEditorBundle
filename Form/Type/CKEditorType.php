<?php

namespace Symtoo\CKEditorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * CKEditor type
 *
 * @author GeLo <geloen.eric@gmail.com>
 * @author Miloslav Kmet <miloslav.kmet@gmail.com>
 */
class CKEditorType extends AbstractType
{
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->setAttribute('toolbar', $options['toolbar'])
            ->setAttribute('ui_color', $options['ui_color'])
            ->setAttribute('ui_skin', $options['ui_skin'])
            ->setAttribute('browser', $options['browser'])
            ->setAttribute('browser_image', $options['browser_image'])
            ->setAttribute('browser_flash', $options['browser_flash'])
        ;

    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form)
    {
        $connector = $this->router->generate('symtoo_ckeditor_connector');
        // TODO: trigger an event, so other bundles will be able to add button to Toolbar
        $view
            ->set('toolbar', $form->getAttribute('toolbar'))
            ->set('ui_color', $form->getAttribute('ui_color'))
            ->set('ui_skin', $form->getAttribute('ui_skin'))
            ->set('browser', strtr($form->getAttribute('browser'), array('%connector%' => $connector)))
            ->set('browser_flash', strtr($form->getAttribute('browser_flash'), array('%connector%' => $connector)))
            ->set('browser_image', strtr($form->getAttribute('browser_image'), array('%connector%' => $connector)))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultOptions(array $options)
    {
        return array(
            'required' => false,
            'toolbar' => array(
                array(
                    'name' => 'document',
                    'items' => array('Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates')
                ),
                array(
                    'name' => 'clipboard',
                    'items' => array('Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo')
                ),
                array(
                    'name' => 'editing',
                    'items' => array('Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt')
                ),
                array(
                    'name' => 'forms',
                    'items' => array('Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField')
                ),
                '/',
                array(
                    'name' => 'basicstyles',
                    'items' => array('Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat')
                ),
                array(
                    'name' => 'paragraph',
                    'items' => array('NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl')
                ),
                array(
                    'name' => 'links',
                    'items' => array('Link','Unlink','Anchor')
                ),
                array(
                    'name' => 'insert',
                    'items' => array('Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak')
                ),
                '/',
                array(
                    'name' => 'styles',
                    'items' => array('Styles','Format','Font','FontSize')
                ),
                array(
                    'name' => 'colors',
                    'items' => array('TextColor','BGColor')
                ),
                array(
                    'name' => 'tools',
                    'items' => array('Maximize', 'ShowBlocks','-','About')
                )
            ),
            'ui_color'      => null,
            'browser'       => 'bundles/symtoockeditor/filebrowser/browser.html?Type=File&Connector=%connector%',
            'browser_image' => 'bundles/symtoockeditor/filebrowser/browser.html?Type=Image&Connector=%connector%',
            'browser_flash' => 'bundles/symtoockeditor/filebrowser/browser.html?Type=Flash&Connector=%connector%',
            'ui_skin'       => 'v2',
        );
    }

    /**
     * Returns the allowed option values for each option (if any).
     *
     * @param array $options
     *
     * @return array The allowed option values
     */
    public function getAllowedOptionValues(array $options)
    {
        return array('required' => array(false));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(array $options)
    {
        return 'textarea';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ckeditor';
    }
}

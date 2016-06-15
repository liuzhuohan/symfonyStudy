<?php
/**
 * Created by PhpStorm.
 * User: xinxiguanli
 * Date: 16/6/6
 * Time: 下午4:18
 */

namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class BlogPostAdmin extends admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        // ... configure $formMapper
//        $formMapper
//            ->add('title', 'text')
//            ->add('body', 'textarea')
//        ;
//        $formMapper
//            // ...
//            ->add('title', 'text')
//            ->add('body', 'textarea')
////            ->add('category', 'entity', array(
////                'class' => 'AppBundle\Entity\Category',
////                'property' => 'name',
////            ))
//            ->add('category', 'sonata_type_model', array(
//                'class' => 'AppBundle\Entity\Category',
//                'property' => 'name',
//            ));
        $formMapper
            ->tab('Post')
            ->with('Content',array('class' => 'col-md-9'))
            ->add('title', 'text')
            ->add('body', 'textarea')
            ->end()
            ->end()
            ->tab('Publish Options')
            ->with('Meta data', array('class' => 'col-md-3'))
            ->add('category', 'sonata_type_model', array(
                'class' => 'AppBundle\Entity\Category',
                'property' => 'name',
            ))
            ->end()
        ;

    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->add('category.name')
            ->add('draft')
        ;
    }

    public function toString($object)
    {
        return $object instanceof BlogPost
            ? $object->getTitle()
            : 'Blog Post'; // shown in the breadcrumb on the create view
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('category', null, array(), 'entity', array(
                'class'    => 'AppBundle\Entity\Category',
                'property' => 'name',
            ));
    }
}
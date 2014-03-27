<?php

namespace Nfq\NfqVenickBundle\Controller;

use Nfq\NfqVenickBundle\Entity\Product;
use Nfq\NfqVenickBundle\Entity\weTask;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
//        $product = new Product();
//        $product->setName('Book');
//        $product->setPrice(1.2);
//        $product->setVat(1.8);
        $product = new weTask();
        $product->setName('Work');
        $product->setDescription('Create a database');
        $product->setCompleted(0);
        $em = $this->getDoctrine()->getManager();

        $em->persist($product);
        $em->flush();

//        $productRepository = $em->getRepository("NfqVenickBundle:weTask");
//        $product = $productRepository->findOneBy(array('id' => 1));

        return $this->render('NfqVenickBundle:Default:index.html.twig',array('name' => $name ,
           'product' => $product));
    }
}

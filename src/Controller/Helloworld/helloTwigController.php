<?php 
namespace App\Controller\Helloworld;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 use Symfony\Component\HttpFoundation\Response;
class helloTwigController extends AbstractController{
 
    public function helloTwig($usuario){
       return $this->render('HelloWorld\TwigExamples\helloTwig.html.twig',array('usuario'=>$usuario));
    }

    public function helloRedirect(){
        $x = rand(1,999);
        return $this->redirectToRoute('helloTwig_index', array('usuario' => $x));
    }

    public function helloApi(){
        $x = rand(1,999);
        return new Response(json_encode(array('user'=>$x)));
   
    }

}
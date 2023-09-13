<?php 
namespace App\Controller\Helloworld;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class helloWorldController extends AbstractController{
 
    public function helloworld(){
       dd("hola mundo"); exit;
    }
}
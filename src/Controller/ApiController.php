<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Post; 
use App\Entity\Programa;
use App\Entity\Slide; 

class ApiController extends Controller
{

    public function index()
    {
		  return $this->render('home/index.html.twig');
    }

    public function getPosts(Request $request, $page = null, $limit = null)
    {
        $response = new Response();

        $host = $request->server->get('HTTP_HOST');
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Post::class);
        $resultados = $repository->findAllOrderByIdDesc(9);
        $retorno = array();

        foreach($resultados as $key => &$post){
            $data = array();
            $post->setImage($host . Post::IMAGE_URL . $post->getImage());
            $post->setAudio($host . Post::AUDIO_URL . $post->getAudio());
            if(strlen($post->getTitle()) > 70){
                $post->setTitle(substr($post->getTitle(), 0, 70) . '...');
            }
            if(strlen($post->getDescription()) > 150){
            	$post->setDescription(substr($post->getDescription(), 0, 150) . '...');
            }
            $data['title'] = $post->getTitle();
            $data['description'] = $post->getDescription();
            $data['image'] = $post->getImage();
            $data['audio'] = $post->getAudio();
            $data['updatedAt'] = $post->getUpdatedAt()->format('d-m-Y H:i:s');
            $data['slug'] = $post->getSlug();
            
            $retorno[] = $data;
        }
        $response->setContent(json_encode($retorno));
        $response->headers->set('Content-Type', 'application/json');
        // Allow all websites
        $response->headers->set('Access-Control-Allow-Origin', '*');
        // Or a predefined website   
        return $response;
        //return $this->json($resultados);
    }

    public function getPostData(Request $request, $slug)
    {
        $response = new Response();

        $host = $request->server->get('HTTP_HOST');
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Post::class);
        $post = $repository->findOneBySlug($slug);
        $retorno = array();

        if($post){
            $post->setImage($host . Post::IMAGE_URL . $post->getImage());
            $post->setAudio($host . Post::AUDIO_URL . $post->getAudio());
            $data = array();
            $data['title'] = $post->getTitle();
            $data['description'] = $post->getDescription();
            $data['image'] = $post->getImage();
            $data['audio'] = $post->getAudio();
            $data['updatedAt'] = $post->getUpdatedAt()->format('d-m-Y H:i:s');
            $data['slug'] = $post->getSlug();
            
            $response->setContent(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');
            // Allow all websites
            $response->headers->set('Access-Control-Allow-Origin', '*');
            // Or a predefined website
            return $response;
        }
        throw NewException('Post not found');
    }
    

    public function getSlides(Request $request, $page = null, $limit = null)
    {
        $response = new Response();
        $retorno = array();
        $host = $request->server->get('HTTP_HOST');
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Slide::class);
        $resultados = $repository->findAllOrderByIdDescAndLimit(3);
        foreach($resultados as $key => &$slide)
        {
            $slide->setImage($host . Slide::IMAGE_URL . $slide->getImage());
            $data['title'] = $slide->getTitle();
            $data['description'] = $slide->getDescription();
            $data['image'] = $slide->getImage();
            
            $retorno[] = $data;
        }
        $response->setContent(json_encode($retorno));
        $response->headers->set('Content-Type', 'application/json');
        // Allow all websites
        $response->headers->set('Access-Control-Allow-Origin', '*');
        // Or a predefined website   
        return $response;
    }

    public function contacto(Request $request)
    {
        // $nombre = $request->request->get('nombre');
        // $email = $request->request->get('email');
        // $tel = $request->request->get('tel');
        // $mensaje = $request->request->get('mensaje');
        $response = new Response();
        $response->setContent(json_encode('trolo'));
        $response->headers->set('Content-Type', 'application/json');
        // Allow all websites
        $response->headers->set('Access-Control-Allow-Headers', '*');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        // Or a predefined website   
        return $response;
        
        
        try {

              $subject = 'RADIO formulario';

              $transporter = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
                  ->setUsername('ctcwebgenerica@gmail.com')
                  ->setPassword('hpzvctc5000');

              $mailer = \Swift_Mailer::newInstance($transporter);
              $message = \Swift_Message::newInstance($subject)
                ->setFrom(array('ctcwebgenerica@gmail.com' => 'Web CTC'))
                ->setTo('simonberton@gmail.com')
                ->setBody('Nombre: '.$nombre ."\nEmail: ".$email."\nMensaje: ".$mensaje);

              $result = $mailer->send($message);

              //$browser = $this->getBrowser();

              /*$content = $app['storage']->getContentObject('contact');
              $content->setValues(array(
                  'ip' => $request->getClientIp(),
                  'user_agent' => $browser["userAgent"],
                  'nombre_apellido' => $nombre,
                  'city' => $city,
                  'email' => $email,
                  'cellphone' => $cellphone,
                  'mensaje' => $mensaje
              ));
              $app['storage']->saveContent($content, "DATOS");*/

              $res->resultado = $resultado;
              $res->mensaje = 'Todo OK';


          }
          catch (Exception $e) {
              print_r($e);
              $res->resultado = 'ERROR Exception';
              $res->mensaje = $e->getMessage();

              return new JsonResponse(array("resultado" => $res->resultado, "mensaje" => $res->mensaje));
          }
    }

    public function getProgramas(Request $request, $page = null, $limit = null)
    {
        $response = new Response();

        $host = $request->server->get('HTTP_HOST');
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Programa::class);
        $resultados = $repository->findAllOrderByIdDesc(10);
        $retorno = array();

        foreach($resultados as $key => &$programa){
            $data = array();
            $programa->setImage($host . Programa::IMAGE_URL . $programa->getImage());
            $data['title'] = $programa->getTitle();
            $data['description'] = $programa->getDescription();
            $data['image'] = $programa->getImage();
            $data['slug'] = $programa->getSlug();
            
            $retorno[] = $data;
        }
        $response->setContent(json_encode($retorno));
        $response->headers->set('Content-Type', 'application/json');
        // Allow all websites
        $response->headers->set('Access-Control-Allow-Origin', '*');
        // Or a predefined website   
        return $response;
        //return $this->json($resultados);
    }

    public function getProgramaData(Request $request, $slug)
    {
        $response = new Response();

        $host = $request->server->get('HTTP_HOST');
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Programa::class);
        $programa = $repository->findOneBySlug($slug);
        $retorno = array();

        if($programa){
            $data['title'] = $programa->getTitle();
            foreach($programa->getPosts() as &$post){
                $post_data = array();
                $post->setImage($host . Post::IMAGE_URL . $post->getImage());
                $post->setAudio($host . Post::AUDIO_URL . $post->getAudio());
                $post_data['title'] = $post->getTitle();
                $post_data['descripcion'] = $post->getDescription();
                $post_data['image'] = $post->getImage();
                $dapost_datata['audio'] = $post->getAudio();
                $post_data['updatedAt'] = $post->getUpdatedAt()->format('d-m-Y H:i:s');
                $post_data['slug'] = $post->getSlug();
                $data['posts'][] = $post_data;
            }

            $response->setContent(json_encode($data));
            $response->headers->set('Content-Type', 'application/json');
            // Allow all websites
            $response->headers->set('Access-Control-Allow-Origin', '*');
            // Or a predefined website
            return $response;
        }
        throw NewException('Post not found');
    }
}

<?php
// src/asociateyaBundle/Controller/UsuarioAnonimoController.php
namespace asociateyaBundle\Controller;
// ...
use asociateyaBundle\Entity\Usuario;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use asociateyaBundle\Form\Type\RegistracionType;
use asociateyaBundle\Form\Model\Registracion;
use asociateyaBundle\Form\Type\ModificacionUsuarioType;
use asociateyaBundle\Form\Model\ModificacionUsuario;

// ...


class UsuarioAnonimoController extends Controller
{

    public function formularioModificacionUsuarioAction()
    {
        $modificacionUsuario = new ModificacionUsuario();
        $form = $this->createForm(new ModificacionUsuarioType(), $modificacionUsuario, array(
            'action' => $this->generateUrl('asociateya_registrar'),
            ));
        
        return $this->render('asociateyaBundle:asociateYa:registro.html.twig',array('form' => $form->createView()));
        
    }

    public function modificacionUsuarioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = new Usuario();
        $form = $this->createForm(new RegistracionType(), new Registracion());

        $form->handleRequest($request);

        if ($form->isValid()) {
        // perform some action...
            $registracion = $form->getData();
            $nuevoUsuario = $registracion->getUsuario();
            
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($nuevoUsuario, $nuevoUsuario->getContrasena());
            $nuevoUsuario->setContrasena($encoded);
            $em->persist($nuevoUsuario);
            $em->flush();

            return $this->redirectToRoute('asociateya_registrar_exito');
        }

        return $this->render('asociateyaBundle:asociateYa:registro.html.twig',array('form' => $form->createView()));
        
    }
	
    public function formularioRegistroAction()
    {
        $registracion = new Registracion();
        $form = $this->createForm(new RegistracionType(), $registracion, array(
            'action' => $this->generateUrl('asociateya_registrar'),
            ));
        
        return $this->render('asociateyaBundle:asociateYa:registro.html.twig',array('form' => $form->createView()));
        
    }

    public function registrarUsuarioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = new Usuario();
        $form = $this->createForm(new RegistracionType(), new Registracion());

        $form->handleRequest($request);

        if ($form->isValid()) {
        // perform some action...
            $registracion = $form->getData();
            $nuevoUsuario = $registracion->getUsuario();
            
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($nuevoUsuario, $nuevoUsuario->getContrasena());
            $nuevoUsuario->setContrasena($encoded);
            $em->persist($nuevoUsuario);
            $em->flush();

            return $this->redirectToRoute('asociateya_registrar_exito');
        }

        return $this->render('asociateyaBundle:asociateYa:registro.html.twig',array('form' => $form->createView()));
        
    }
    
    public function exitoRegistroAction()
    {
        $registracion = new Registracion();
        $form = $this->createForm(new RegistracionType(), $registracion, array(
            'action' => $this->generateUrl('asociateya_registrar'),
            ));
        
        return $this->render('asociateyaBundle:asociateYa:exito.html.twig',array('form' => $form->createView()));
        
    }

    public function ingresarAction(Request $request)
    {
       $authenticationUtils = $this->get('security.authentication_utils');

    // get the login error if there is one
       $error = $authenticationUtils->getLastAuthenticationError();

    // last username entered by the user
       $lastUsername = $authenticationUtils->getLastUsername();

       return $this->render(
        'asociateyaBundle:asociateYa:log_in.html.twig',
        array(
            // last username entered by the user
            'last_username' => $lastUsername,
            'error'         => $error,
            )
        );
   }


   public function crearAction()
   {
    $nuevoUsuario = new Usuario();
    $nuevoUsuario->setNombre('Franco');
    $nuevoUsuario->setApellido('croci');
    $nuevoUsuario->setMail('fede@rico.com');
    $nuevoUsuario->setPassword('qwerty');
    $nuevoUsuario->setDni('3516465');
    $nuevoUsuario->setCuit('123123123');
    $em = $this->getDoctrine()->getManager();
    $em->persist($nuevoUsuario);
    $em->flush();

    return new Response('Se creo un nuevo usuario id '.$nuevoUsuario->getId());
}
}
?>

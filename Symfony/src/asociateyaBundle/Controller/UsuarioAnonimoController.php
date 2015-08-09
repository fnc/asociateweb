<?php
// src/asociateyaBundle/Controller/UsuarioAnonimoController.php
namespace asociateyaBundle\Controller;
// ...
use asociateyaBundle\Entity\Usuario;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use asociateyaBundle\Form\Type\RegistracionType;
use asociateyaBundle\Form\Model\Registracion;

// ...


class UsuarioAnonimoController extends Controller
{
	
public function formularioRegistroAction()
{
        $registracion = new Registracion();
        $form = $this->createForm(new RegistracionType(), $registracion, array(
            'action' => $this->generateUrl('asociateya_registrar'),
        ));
    
     return $this->render('asociateyaBundle:asociateYa:registro.html.twig',array('form' => $form->createView()));
    
}

public function registroUsuarioAction(Request $request)
{
    $usuario = new Usuario();
    $form = $this->createFormBuilder($usuario)
        // ...
        ->getForm();

    $form->handleRequest($request);

    if ($form->isValid()) {
        // perform some action...

        return $this->redirectToRoute('task_success');
    }

     return $this->render('asociateyaBundle:asociateYa:registro.html.twig');// array('name' => $name));
    
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

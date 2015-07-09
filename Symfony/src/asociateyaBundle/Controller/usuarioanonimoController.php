// src/asociateyaBundle/Controller/usuarioanonimoController.php

// ...
use asociateyaBundle\Entity\Usuario;
use Symfony\Component\HttpFoundation\Response;

// ...
public function createAction()
{
    $nuevoUsuario = new Usuario();
    $nuevoUsuario->setNombre('A Foo Bar');
    //$nuevoUsuario->setPrice('19.99');
    //$nuevoUsuario->setDescription('Lorem ipsum dolor');

    $em = $this->getDoctrine()->getManager();

    $em->persist($nuevoUsuario);
    $em->flush();

    return new Response('Se creo un nuevo usuario id '.$nuevoUsuario->getId());
}

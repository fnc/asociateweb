<?php
namespace asociateyaBundle\Command;
 
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
 
class PublicarEstadoResultadoCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('asociateya:publicarEstadoResultado')
            ->setDescription('Notifica y paga ganancias a inversores')
            ->addArgument('emprendimiento', InputArgument::OPTIONAL, 'Publicar ganancias de un emprendimiento especifico.')
            ->addArgument('ganancias', InputArgument::OPTIONAL, 'Monto de las ganancias.');
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $nombreEmprendimiento = $input->getArgument('emprendimiento');

        $em = $this->getContainer()->get('doctrine')->getManager();

        $emprendimiento = $em->getRepository('asociateyaBundle:Emprendimiento')->findByNombre($nombreEmprendimiento);

        if (!$emprendimiento) {
            $output->writeln("<error>No se encontró el emprendimiento ".$nombreEmprendimiento." </error>");
            return;
        }

 
        // Do whatever

        //recorrer inversiones

        //emitir pago

        //mandar mail
        $message = \Swift_Message::newInstance()
        ->setSubject("Se han acreditado ganancias del emprendimiento")//.$emprendimiento->getNombre())
        ->setFrom('noreply@asociateya.com')
        ->setTo('fedecroci@hotmail.com')
        ->setBody($this->getContainer()->get('templating')->render(
                 // app/Resources/views/Emails/registration.html.twig
                 'Emails/resultado.html.twig',
                 //array('name' => $emprendimiento->getNombre())
             ),
            'text/html'
        )

    ;
    $this->getContainer()->get('mailer')->send($message);


        $em->flush();
    }
}
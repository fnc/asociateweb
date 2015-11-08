<?php
namespace asociateyaBundle\Command;
 
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use asociateyaBundle\Controller;
 
class PublicarEstadoResultadoCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('asociateya:publicarEstadoResultado')
            ->setDescription('Notifica y paga ganancias a inversores')
            ->addArgument('emprendimiento', InputArgument::OPTIONAL, 'Publicar ganancias de un emprendimiento especifico.')
            ->addArgument('ganancias', InputArgument::OPTIONAL, 'Porcentaje de ganancias a pagar.');
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

         $output->writeln("<info>Se pagaran ganacias del emprendimiento ".$emprendimiento[0]->getNombre()." </info>");
  

        //recorrer inversiones

        $inversiones = $emprendimiento[0]->getInversiones();

        require_once __DIR__.'/../Controller/mercadopago.php';

        $output->writeln(__DIR__.'/../Controller/mercadopago.php');

        $mp = new \MP ("ff8080814c11e237014c1ff593b57b4d");




        foreach ($inversiones as $inversion) {
                
            $montoAPagar = (float)$inversion->getCantidadAcciones()*(float)$emprendimiento[0]->getPrecioAccion()*(0.0495);

            //TODO completar bien la info del pago
            $output->writeln("<info>Se pagaran ganacias a ".$inversion->getUsuario()->getNombreUsuario()." </info>");
            $payment_data = array(
                    "transaction_amount" => 1,//$montoAPagar,
                    "token" => "ff8080814c11e237014c1ff593b57b4d",
                    "description" => "Ganancias de emprendimiento ".$emprendimiento[0]->getNombre() ,
                    "installments" => 1,
                    "payer" => array ("id" => "1683437747"),
                    "application_fee" => 0,
                    );

            $payment = $mp->post("/v1/payments", $payment_data);

        }


        //emitir pago

        //mandar mail
        $message = \Swift_Message::newInstance()
        ->setSubject("Se han acreditado ganancias del emprendimiento")//.$emprendimiento->getNombre())
        ->setFrom('noreply@asociateya.com')
        ->setTo('fedecroci@hotmail.com')
        ->setBody(//$this->getContainer()->get('templating')->render(
                 // app/Resources/views/Emails/registration.html.twig
                 'Emails/resultado.html.twig',
                 //array('name' => $emprendimiento[0]->getNombre())
             //),
            
            'text/html'
        )

    ;
    $this->getContainer()->get('mailer')->send($message);


        $em->flush();
    }
}
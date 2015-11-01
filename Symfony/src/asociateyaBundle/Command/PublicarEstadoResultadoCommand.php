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
            ->addArgument('my_argument', InputArgument::OPTIONAL, 'Argument description');
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        // Do whatever

        //recorrer inversiones

        //emitir pago

        //mandar mail
        $output->writeln('Hello World');
        $em->flush();
    }
}
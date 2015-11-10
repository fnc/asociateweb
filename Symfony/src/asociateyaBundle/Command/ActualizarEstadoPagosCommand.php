<?php
namespace asociateyaBundle\Command;
 
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
 
class ActualizarEstadoPagosCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('asociateya:actualizarestadopagos')
            ->setDescription('Cancela los emprendiientos que se les acabo el plazo')
            ->addArgument('my_argument', InputArgument::OPTIONAL, 'Argument description');
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        // Do whatever

        $fromDate = new \DateTime('now'); // Have for example 2013-06-10 09:53:21
        $fromDate->setTime(0, 0, 0); // Modify to 2013-06-10 00:00:00, beginning of the day

        $toDate = clone $fromDate;
        $toDate->modify('+1 day'); // Have 2013-06-11 00:00:00
        $output->writeln($fromDate);


        $q = $em->getRepository("asociateyaBundle:Emprendimiento")
            ->createQueryBuilder('e')
            ->where('e.fechaFinalizacion >= :fromDate')
            ->andWhere('e.fechaFinalizacion < :toDate')
            ->setParameter('fromDate', $fromDate)
            ->setParameter('toDate', $toDate)
            ->getQuery();

            $emprendimientos = $q->getResult();

        foreach ($emprendimientos as $emprendimiento) {
            $output->writeln($emprendimiento->getNombre());
        } 


        
        $em->flush();
    }
}
<?php
namespace asociateyaBundle\Command;
 
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
 
class CancelacionPlazoCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('asociateya:cancelacionPlazo')
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
        //$output->writeln($fromDate);

        $output->writeln("");
        $output->writeln("<info>A continuación se listarán los emprendimientos con el plazo vencido:</info>");
        $output->writeln("");

        $q = $em->getRepository("asociateyaBundle:Emprendimiento")
            ->createQueryBuilder('e')
            ->where('e.fechaFinalizacion >= :fromDate')
            ->andWhere('e.fechaFinalizacion < :toDate')
            ->andWhere('e.estado = :estado')
            ->setParameter('fromDate', $fromDate)
            ->setParameter('toDate', $toDate)
            ->setParameter('estado', 1)
            ->getQuery();

            $emprendimientos = $q->getResult();

        foreach ($emprendimientos as $emprendimiento) {
            $output->writeln("Emprendimiento: ".$emprendimiento->getNombre());
            $emprendimiento->setEstado(4);//Cancelado pago acreditado (en realidad se refiere a una cancelacion definitiva)
            $inversiones = $emprendimiento->getInversiones();
            if(count($inversiones)>0){
                $output->writeln("<comment>Se emitiran las devoluciones de las ".count($inversiones)." inversiones del emprendimiento ".$emprendimiento->getNombre()."</comment>");
                
                foreach ($inversiones as $inversion) {
                    //Devolver la inversion
                    $resultado = $mp->refund_payment($inversion->getIdPago());

                	$inversion->setEstado(3);//refunded

                	$comisionRefund = (float)$inversion->getCantidadAcciones()*(float)$emprendimiento->getPrecioAccion()*(0.0495);
                }

            }
            else{
                $output->writeln("<comment>No hay inveriones para devolver en el emprendimiento ".$emprendimiento->getNombre()."</comment>");
            }

        } 


        
        $em->flush();

        $output->writeln("");
    }
}
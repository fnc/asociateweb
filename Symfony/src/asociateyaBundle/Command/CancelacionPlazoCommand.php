<?php
namespace asociateyaBundle\Command;
 
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use asociateyaBundle\Entity\Emprendimiento;
use asociateyaBundle\Entity\Usuario;
use asociateyaBundle\Entity\Inversion;
use asociateyaBundle\Entity\Pago;
use asociateyaBundle\Entity\PagoInversion;
use asociateyaBundle\Entity\EmprendimientoCancelado;
 
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
        $toDate->modify('+2 day'); // Have 2013-06-11 00:00:00
        $output->writeln($fromDate);
        $output->writeln($toDate);
        $output->writeln("");
        $output->writeln("<info>A continuación se listarán los emprendimientos con el plazo vencido:</info>");
        $output->writeln("");

        $q = $em->getRepository("asociateyaBundle:Emprendimiento")
            ->createQueryBuilder('e')
            ->where('e.fechaFinalizacion >= :fromDate')
            ->andWhere('e.fechaFinalizacion <= :toDate')
            ->andWhere('e.estado = :estado')
            ->setParameter('fromDate', $fromDate)
            ->setParameter('toDate', $toDate)
            ->setParameter('estado', 1)
            ->getQuery();

        $emprendimientos = $q->getResult();
        if(!$emprendimientos){
        
            $output->writeln("Ningun emprendimiento aplica.");

        }

        foreach ($emprendimientos as $emprendimiento) {
            $output->writeln("Emprendimiento: ".$emprendimiento->getNombre());
            $emprendimiento->setEstado(4);//Cancelado pago acreditado (en realidad se refiere a una cancelacion definitiva)
            $inversiones = $emprendimiento->getInversiones();
            if(count($inversiones)>0){
                $output->writeln("<comment>Se emitiran las devoluciones de las ".count($inversiones)." inversiones del emprendimiento ".$emprendimiento->getNombre()."</comment>");
                
                foreach ($inversiones as $inversion) {

               foreach ($inversion->getPagos() as $pago ) {

                   $resultado = $mp->refund_payment($pago->getIdMp());

                   $pago->setEstado(3);//refunded

                   //TODO esto no se usa porque el refund aparentemente devuelve la comision
                   $comisionRefund = (float)$pago->getMonto()*(0.0495);

                   $notificacionEmprendimiento = new EmprendimientoCancelado();
                   $notificacionEmprendimiento->setUsuario($inversion->getUsuario());
                   $notificacionEmprendimiento->setFechaCreacion(new \DateTime());
                   $notificacionEmprendimiento->setEmprendimiento($inversion->getEmprendimiento());
                   $em->persist($notificacionEmprendimiento);
               
            }
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
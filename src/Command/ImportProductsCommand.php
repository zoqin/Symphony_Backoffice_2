<?php

namespace App\Command;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(
    name: 'app:import-products',
    description: 'Importation de produits ficsit depuis un fichier CSV situé dans le dossier public',
)]
class ImportProductsCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ParameterBagInterface $parameterBag,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument(
                'filename',
                InputArgument::OPTIONAL,
                'Le nom du fichier CSV à importer (default import_produits.csv)',
                'import_produits.csv'
            )
            // ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $publicPath = $this->parameterBag->get('kernel.project_dir') . '/public';
        $fileName = $input->getArgument('filename');
        $filePath = $publicPath . '/' . $fileName;

//        $arg1 = $input->getArgument('arg1');
//
//        if ($arg1) {
//            $io->note(sprintf('You passed an argument: %s', $arg1));
//        }
//
//        if ($input->getOption('option1')) {
//            // ...
//        }

        if(!file_exists($filePath)) {
            $io->error(sprintf('Le fichier "%s" n\'existe pas dans le dossier public', $filePath));
            return Command::FAILURE;
        }

        if(($handle = fopen($filePath, 'r')) !== FALSE) {
            $io->title('Début de l\'importation...');

            fgetcsv($handle,1000, ",");

            $count = 0;
            while(($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $product = new Product();
                $product->setName($data[0])
                    ->setDescription($data[1])
                    ->setPrice($data[2]);

                $this->entityManager->persist($product);
                $count++;
            }

            $this->entityManager->flush();
            fclose($handle);
        }

        $io->success(sprintf('%d produits on été importés avec succès !', $count));

        return Command::SUCCESS;
    }
}

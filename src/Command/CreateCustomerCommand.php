<?php

namespace App\Command;

use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsCommand(
    name: 'app:create-customer',
    description: 'Créer un nouveau client',
)]
class CreateCustomerCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator,
    )
    {
        parent::__construct();
    }

//    protected function configure(): void
//    {
//        $this
//            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
//            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
//        ;
//    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
//        $arg1 = $input->getArgument('arg1');



//        if ($arg1) {
//            $io->note(sprintf('You passed an argument: %s', $arg1));
//        }
//
//        if ($input->getOption('option1')) {
//            // ...
//        }
        $io->title('Création d\'un nouveau client');

        $customer = new Customer();

        $fields = [
            'firstname' => 'Prénom',
            'lastname' => 'Nom',
            'email' => 'Email',
            'phoneNumber' => 'Téléphone',
            'address' => 'Adresse',
        ];

        foreach($fields as $property => $label) {
            $isValid = false;
            while (!$isValid) {
                $value = $io->ask($label);

                try {
                    $setter = 'set'.ucfirst($property);
                    $customer->$setter($value);

                    $errors = $this->validator->validateProperty($customer, $property);

                    if (count($errors) > 0) {
                        foreach ($errors as $error) {
                            $io->error($error->getMessage());
                        }
                    } else {
                        $isValid = true;
                    }
                } catch (\TypeError $error) {
                    $io->error($error->getMessage());
                }
            }
        }

        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        $io->success('Client créé avec succès !');

        return Command::SUCCESS;
    }
}

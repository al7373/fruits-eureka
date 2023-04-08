<?php
// src/Command/FetchFruitsCommand.php
namespace App\Command;

use App\Entity\Fruit;
use App\Repository\FruitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\HttpClientInterface;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class FetchFruitsCommand extends Command
{
    protected static $defaultName = 'fruits:fetch';
    private $httpClient;
    private $entityManager;
    private $fruitRepository;
    private $mailer; // Declare the $mailer property

    public function __construct(HttpClientInterface $httpClient, EntityManagerInterface $entityManager, FruitRepository $fruitRepository, MailerInterface $mailer)
    {
        $this->httpClient = $httpClient;
        $this->entityManager = $entityManager;
        $this->fruitRepository = $fruitRepository;
        $this->mailer = $mailer; // Initialize the $mailer property

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Fetch fruits from FruityVice API and store them in the local database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Fetch data from FruityVice API
        $response = $this->httpClient->request('GET', 'https://fruityvice.com/api/fruit/all');
        $data = $response->toArray();

        // Save fruits data to the local database
        foreach ($data as $fruitData) {
            // Check if the fruit exists in the database
            $fruit = $this->fruitRepository->findOneBy(['fruit_id' => $fruitData['id']]);

            // If the fruit doesn't exist, create a new Fruit entity
            if (!$fruit) {
                $fruit = new Fruit();
                $fruit->setFruitId($fruitData['id']);
            }

            $fruit->setName($fruitData['name']);
            $fruit->setFamily($fruitData['family']);
            $fruit->setGenus($fruitData['genus']);
            $fruit->setFruitOrder($fruitData['order']);
            $fruit->setCarbohydrates($fruitData['nutritions']['carbohydrates']);
            $fruit->setProtein($fruitData['nutritions']['protein']);
            $fruit->setFat($fruitData['nutritions']['fat']);
            $fruit->setCalories($fruitData['nutritions']['calories']);
            $fruit->setSugar($fruitData['nutritions']['sugar']);

            $this->entityManager->persist($fruit);
        }

        $this->entityManager->flush();

        $io->success('Fruits data has been fetched and saved to the database.');
        // Send an email notification
        $email = (new Email())
            ->from('noreply@example.com')
            ->to('ramrijalain@gmail.com')
            ->subject('Fruits data has been fetched and saved')
            ->text('Fruits data from FruityVice API has been successfully fetched and saved to the local database.');

        $this->mailer->send($email);

        $io->success('An email notification has been sent.');

        return Command::SUCCESS;
    }
}


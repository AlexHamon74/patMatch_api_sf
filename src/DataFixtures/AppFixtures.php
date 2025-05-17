<?php

namespace App\DataFixtures;

use App\Entity\Animal;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Client;
use App\Entity\Correspondance;
use App\Entity\DocumentAdministratif;
use App\Entity\Eleveur;
use App\Entity\Espece;
use App\Entity\Race;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Enum\SexeAnimal;

class AppFixtures extends Fixture
{
    const ELEVEUR_USER = [
        ['michel@eleveur.com', 'Michel'],
        ['maurice@eleveur.com', 'Maurice'],
        ['raymond@eleveur.com', 'Raymond'],
        ['josiane@eleveur.com', 'Josiane'],
        ['simone@eleveur.com', 'Simone'],
    ];
    const CLIENT_USER = [
        ['leo@client.com', 'Leo'],
        ['noah@client.com', 'Noah'],
        ['lina@client.com', 'Lina'],
        ['enzo@client.com', 'Enzo'],
        ['jade@client.com', 'Jade'],
    ];
    const CATEGORIE_NOM = ['Nourriture', 'Dressage', 'Nouvelle adption', 'Administratifs'];
    const ARTICLE_TITRE = ['Comment nourrir son labrador ?', 'Nos conseils pour le dressage de chien.', 'Comment adopter un chat ?', 'Le guide pour les documents administratifs'];
    const ESPECE_NOM = ['Chien', 'Chat'];
    const RACE_CHIEN_NOM = ['Labrador', 'Golden retriever', 'Berger australien', 'Husky'];
    const RACE_CHAT_NOM = ['Maine Coon', 'Persan', 'Sphynx', 'Siamois'];
    const ANIMAL_CHIEN_NOM = ['Rex', 'Luna', 'Max', 'Bella', 'Rocky', 'Nala', 'Simba', 'Milo', 'Oslo', 'Channel'];
    const ANIMAL_CHAT_NOM = ['Misty', 'Oliver', 'Neko', 'Félix', 'Mochi', 'Tigrou', 'Sushi', 'Salem', 'Moustache', 'Dina'];
    const COULEUR_ANIMAL = ['Gris', 'Blanc', 'Noir', 'Beige', 'Blanc et noir', 'Orange'];

    public function __construct() {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // ---------------
        // Ajout des Users
        // ---------------
        $admin_user = new User();
        $admin_user->setEmail('admin@test.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword('admin123')
            ->setNom('Test')
            ->setPrenom('Admin')
            ->setDateDeNaissance(new DateTimeImmutable());

        $manager->persist($admin_user);

        $eleveurs = [];
        foreach(self::ELEVEUR_USER as $eleveur_user_data) {
            $eleveur_user = new Eleveur();
            $eleveur_user->setEmail($eleveur_user_data[0])
                ->setRoles(['ROLE_ELEVEUR'])
                ->setPassword('test123')
                ->setNom('Eleveur')
                ->setPrenom($eleveur_user_data[1])
                ->setDateDeNaissance(new DateTimeImmutable());
            
            $manager->persist($eleveur_user);
            $eleveurs[$eleveur_user_data[0]] = $eleveur_user;
        }

        $clients = [];
        foreach(self::CLIENT_USER as $client_user_data) {
            $client_user = new Client();
            $client_user->setEmail($client_user_data[0])
            ->setRoles(['ROLE_USER'])
            ->setPassword('test123')
            ->setNom('Client')
            ->setPrenom($client_user_data[1])
            ->setDateDeNaissance(new DateTimeImmutable());
            
            $manager->persist($client_user);
            $clients[$client_user_data[0]] = $client_user;
        }

        // --------------------------------
        // Ajout des Articles et catégories
        // --------------------------------
        $categories = [];
        foreach(self::CATEGORIE_NOM as $categorie_nom) {
        $categorie = new Categorie();
            $categorie->setNom($categorie_nom)
            ->setDescription($faker->realTextBetween());

            $manager->persist($categorie);
            $categories[$categorie_nom] = $categorie;
        }

        foreach(self::ARTICLE_TITRE as $article_titre) {
            $article = new Article();
            $article->setUtilisateur($faker->randomElement($eleveurs))
            ->setCategorie($faker->randomElement($categories))
            ->setTitre($article_titre)
            ->setContenu($faker->realTextBetween())
            ->setDateDeCreation(new DateTimeImmutable());

            $manager->persist($article);
        }

        // --------------------------
        // Ajout des Espèces et races
        // --------------------------
        $especes = [];
        foreach (self::ESPECE_NOM as $espece_nom) {
            $espece = new Espece();
            $espece->setNom($espece_nom);

            $manager->persist($espece);
            $especes[$espece_nom] = $espece;
        }

        $races_chien = [];
        foreach(self::RACE_CHIEN_NOM as $race_chien_nom) {
            $race_chien = new Race();
            $race_chien->setNom($race_chien_nom)
                ->setEspece($especes['Chien'])
                ->setDescription($faker->realTextBetween());
            
            $manager->persist($race_chien);
            $races_chien[$race_chien_nom] = $race_chien;
        }

        $races_chat = [];
        foreach(self::RACE_CHAT_NOM as $race_chat_nom) {
            $race_chat = new Race();
            $race_chat->setNom($race_chat_nom)
                ->setEspece($especes['Chat'])
                ->setDescription($faker->realTextBetween());
            
            $manager->persist($race_chat);
            $races_chat[$race_chat_nom] = $race_chat;
        }

        // ----------------------------------
        // Ajout des documents administratifs
        // ----------------------------------
        for($i=0; $i<5; $i++) {
            $document_administratif = new DocumentAdministratif();
            $document_administratif->setUtilisateur($faker->randomElement($eleveurs))
                ->setCheminDocument('chemin_doc');

            $manager->persist($document_administratif);
        }

        // -----------------
        // Ajout des animaux
        // -----------------
        $animaux = [];
        foreach(self::ANIMAL_CHIEN_NOM as $animal_chien_nom) {
            $animal = new Animal();
            $animal->setEleveur($faker->randomElement($eleveurs))
                ->setNom($animal_chien_nom)
                ->setDateDeNaissance(new DateTimeImmutable())
                ->setSexe($faker->randomElement(SexeAnimal::cases()))
                ->setNumeroIdentification($faker->numberBetween(1000000, 10000000))
                ->setRace($faker->randomElement($races_chien))
                ->setPoids($faker->numberBetween(2, 50))
                ->setTaille($faker->numberBetween(10, 100))
                ->setStatutVaccination($faker->realTextBetween(10, 80))
                ->setStatutSterilisation($faker->realTextBetween(10, 80))
                ->setInfosSante($faker->realTextBetween())
                ->setTypeAlimentation($faker->realTextBetween(10, 80))
                ->setTypeAlimentationDetails($faker->realTextBetween())
                ->setNiveauEnergie($faker->realTextBetween())
                ->setSociabilite($faker->realTextBetween(10, 80))
                ->setEducation($faker->realTextBetween(10, 80))
                ->setTypeLogement($faker->realTextBetween(10, 80))
                ->setFamilleIdeale($faker->realTextBetween(10, 80))
                ->setBesoinsExercice($faker->realTextBetween())
                ->setPrix($faker->numberBetween(50, 1000));

            $manager->persist($animal);
            $animaux[$animal_chien_nom] = $animal;
        }
        foreach(self::ANIMAL_CHAT_NOM as $animal_chat_nom) {
            $animal = new Animal();
            $animal->setEleveur($faker->randomElement($eleveurs))
                ->setNom($animal_chat_nom)
                ->setDateDeNaissance(new DateTimeImmutable())
                ->setSexe($faker->randomElement(SexeAnimal::cases()))
                ->setNumeroIdentification($faker->numberBetween(1000000, 10000000))
                ->setRace($faker->randomElement($races_chat))
                ->setPoids($faker->numberBetween(2, 50))
                ->setTaille($faker->numberBetween(10, 100))
                ->setStatutVaccination($faker->realTextBetween(10, 80))
                ->setStatutSterilisation($faker->realTextBetween(10, 80))
                ->setInfosSante($faker->realTextBetween())
                ->setTypeAlimentation($faker->realTextBetween(10, 80))
                ->setTypeAlimentationDetails($faker->realTextBetween())
                ->setNiveauEnergie($faker->realTextBetween())
                ->setSociabilite($faker->realTextBetween(10, 80))
                ->setEducation($faker->realTextBetween(10, 80))
                ->setTypeLogement($faker->realTextBetween(10, 80))
                ->setFamilleIdeale($faker->realTextBetween(10, 80))
                ->setBesoinsExercice($faker->realTextBetween())
                ->setPrix($faker->numberBetween(50, 1000));

            $manager->persist($animal);
            $animaux[$animal_chat_nom] = $animal;
        }

        // -----------------
        // Ajout des matchs
        // -----------------
        foreach($animaux as $animal) {
            $correspondance = new Correspondance();
            $correspondance->setUser($faker->randomElement($clients))
                ->setAnimal($animal);
            
            $manager->persist($correspondance);
        }

        $manager->flush();
    }
}
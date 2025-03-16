<?php

namespace App\DataFixtures;

use App\Entity\Animal;
use App\Entity\AnimalPersonnalite;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Correspondance;
use App\Entity\DocumentAdministratif;
use App\Entity\Espece;
use App\Entity\Personnalite;
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
    const PARTICULIER_USER = [
        ['leo@particulier.com', 'Leo'],
        ['noah@particulier.com', 'Noah'],
        ['lina@particulier.com', 'Lina'],
        ['enzo@particulier.com', 'Enzo'],
        ['jade@particulier.com', 'Jade'],
    ];
    const CATEGORIE_NOM = ['Nourriture', 'Dressage', 'Nouvelle adption', 'Administratifs'];
    const ARTICLE_TITRE = ['Comment nourrir son labrador ?', 'Nos conseils pour le dressage de chien.', 'Comment adopter un chat ?', 'Le guide pour les documents administratifs'];
    const ESPECE_NOM = ['Chien', 'Chat'];
    const RACE_CHIEN_NOM = ['Labrador', 'Golden retriever', 'Berger australien', 'Husky'];
    const RACE_CHAT_NOM = ['Maine Coon', 'Persan', 'Sphynx', 'Siamois'];
    const PERSONNALITE_NOM = ['Paresseux', 'Sportif', 'Timide', 'Avenant'];
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
            ->setDateDeNaissance(new DateTimeImmutable())
            ->setMisAJourLe(new DateTimeImmutable());

        $manager->persist($admin_user);

        $eleveurs = [];
        foreach(self::ELEVEUR_USER as $eleveur_user_data) {
            $eleveur_user = new User();
            $eleveur_user->setEmail($eleveur_user_data[0])
                ->setRoles(['ROLE_ELEVEUR'])
                ->setPassword('test123')
                ->setNom('Eleveur')
                ->setPrenom($eleveur_user_data[1])
                ->setDateDeNaissance(new DateTimeImmutable())
                ->setMisAJourLe(new DateTimeImmutable());
            
            $manager->persist($eleveur_user);
            $eleveurs[$eleveur_user_data[0]] = $eleveur_user;
        }

        $particuliers = [];
        foreach(self::PARTICULIER_USER as $particulier_user_data) {
            $particulier_user = new User();
            $particulier_user->setEmail($particulier_user_data[0])
            ->setRoles(['ROLE_PARTICULIER'])
            ->setPassword('test123')
            ->setNom('Particulier')
            ->setPrenom($particulier_user_data[1])
            ->setDateDeNaissance(new DateTimeImmutable())
            ->setMisAJourLe(new DateTimeImmutable());
            
            $manager->persist($particulier_user);
            $particuliers[$particulier_user_data[0]] = $particulier_user;
        }

        // --------------------------------
        // Ajout des Articles et catégories
        // --------------------------------
        $categories = [];
        foreach(self::CATEGORIE_NOM as $categorie_nom) {
        $categorie = new Categorie();
            $categorie->setNom($categorie_nom)
            ->setDescription($faker->realTextBetween())
            ->setMisAJourLe(new DateTimeImmutable());

            $manager->persist($categorie);
            $categories[$categorie_nom] = $categorie;
        }

        foreach(self::ARTICLE_TITRE as $article_titre) {
            $article = new Article();
            $article->setUtilisateur($faker->randomElement($eleveurs))
            ->setCategorie($faker->randomElement($categories))
            ->setTitre($article_titre)
            ->setContenu($faker->realTextBetween())
            ->setDateDeCreation(new DateTimeImmutable())
            ->setMisAJourLe(new DateTimeImmutable());

            $manager->persist($article);
        }

        // --------------------------
        // Ajout des Espèces et races
        // --------------------------
        $especes = [];
        foreach (self::ESPECE_NOM as $espece_nom) {
            $espece = new Espece();
            $espece->setNom($espece_nom)
                ->setMisAJourLe(new DateTimeImmutable());

            $manager->persist($espece);
            $especes[$espece_nom] = $espece;
        }

        $races_chien = [];
        foreach(self::RACE_CHIEN_NOM as $race_chien_nom) {
            $race_chien = new Race();
            $race_chien->setNom($race_chien_nom)
                ->setEspece($especes['Chien'])
                ->setDescription($faker->realTextBetween())
                ->setMisAJourLe(new DateTimeImmutable());
            
            $manager->persist($race_chien);
            $races_chien[$race_chien_nom] = $race_chien;
        }

        $races_chat = [];
        foreach(self::RACE_CHAT_NOM as $race_chat_nom) {
            $race_chat = new Race();
            $race_chat->setNom($race_chat_nom)
                ->setEspece($especes['Chat'])
                ->setDescription($faker->realTextBetween())
                ->setMisAJourLe(new DateTimeImmutable());
            
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

        // -----------------------
        // Ajout des personnalités
        // -----------------------
        $personnalites = [];
        foreach(self::PERSONNALITE_NOM as $personnalite_nom) {
            $personnalite = new Personnalite();
            $personnalite->setNom($personnalite_nom)
                ->setDescription($faker->realTextBetween())
                ->setMisAJourLe(new DateTimeImmutable());
            
            $manager->persist($personnalite);
            $personnalites[$personnalite_nom] = $personnalite;
        }

        // -----------------
        // Ajout des animaux
        // -----------------
        $animaux = [];
        foreach(self::ANIMAL_CHIEN_NOM as $animal_chien_nom) {
            $animal = new Animal();
            $animal->setUtilisateur($faker->randomElement($eleveurs))
                ->setRace($faker->randomElement($races_chien))
                ->setNom($animal_chien_nom)
                ->setDateDeNaissance(new DateTimeImmutable())
                ->setCouleur($faker->randomElement(self::COULEUR_ANIMAL))
                ->setNumeroIdentification($faker->numberBetween(1000000, 10000000))
                ->setPoids($faker->numberBetween(2, 50))
                ->setTaille($faker->numberBetween(10, 100))
                ->setSexe($faker->randomElement(SexeAnimal::cases()))
                ->setInfosSante($faker->realTextBetween())
                ->setDescription($faker->realTextBetween())
                ->setMisAJourLe(new DateTimeImmutable());

            $manager->persist($animal);
            $animaux[$animal_chien_nom] = $animal;
        }
        foreach(self::ANIMAL_CHAT_NOM as $animal_chat_nom) {
            $animal = new Animal();
            $animal->setUtilisateur($faker->randomElement($eleveurs))
                ->setRace($faker->randomElement($races_chat))
                ->setNom($animal_chat_nom)
                ->setDateDeNaissance(new DateTimeImmutable())
                ->setCouleur($faker->randomElement(self::COULEUR_ANIMAL))
                ->setNumeroIdentification($faker->numberBetween(1000000, 10000000))
                ->setPoids($faker->numberBetween(2, 50))
                ->setTaille($faker->numberBetween(10, 100))
                ->setSexe($faker->randomElement(SexeAnimal::cases()))
                ->setInfosSante($faker->realTextBetween())
                ->setDescription($faker->realTextBetween())
                ->setMisAJourLe(new DateTimeImmutable());

            $manager->persist($animal);
            $animaux[$animal_chat_nom] = $animal;
        }

        // -----------------------------------------
        // Attribution des personnalités aux animaux
        // -----------------------------------------
        foreach($animaux as $animal) {
            $animal_personnalite = new AnimalPersonnalite();
            $animal_personnalite->setAnimal($animal)
                ->setPersonnalite($faker->randomElement($personnalites));

            $manager->persist($animal_personnalite);
        }

        // -----------------
        // Ajout des matchs
        // -----------------
        foreach($animaux as $animal) {
            $correspondance = new Correspondance();
            $correspondance->setUser($faker->randomElement($particuliers))
                ->setAnimal($animal);
            
            $manager->persist($correspondance);
        }

        $manager->flush();
    }
}
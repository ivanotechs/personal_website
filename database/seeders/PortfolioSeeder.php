<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use App\Models\Education;
use App\Models\Experience;
use App\Models\PageSeo;
use App\Models\Project;
use App\Models\Setting;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $this->admin();
        $this->media();
        $this->settings();
        $this->experience();
        $this->education();
        $this->skills();
        $this->projects();
        $this->pages();
        Setting::forgetCache();
    }

    private function t(string $en, string $de, string $fr): array
    {
        return ['en' => $en, 'de' => $de, 'fr' => $fr];
    }

    private function admin(): void
    {
        $email = 'djforbian@gmail.com';
        $user = User::query()->firstOrNew(['email' => $email]);
        $user->name = 'Yannick Ivan Djoukeng Nougning';
        $user->phone = '+237 670011942';
        $user->address = 'Caprice';
        $user->city = 'Accra';
        $user->country = 'Ghana';
        $user->email_verified_at = $user->email_verified_at ?? now();

        if (! $user->exists) {
            $user->password = (string) env('ADMIN_PASSWORD', 'ChangeThisPassword');
        }

        $user->save();
    }

    private function media(): void
    {
        foreach (['logo.jpg', 'portrait.jpg'] as $file) {
            $source = database_path('seeders/assets/'.$file);
            if (is_file($source)) {
                Storage::disk('public')->put('brand/'.$file, file_get_contents($source));
            }
        }
    }

    private function settings(): void
    {
        Setting::query()->updateOrCreate(['id' => 1], [
            'site_name' => 'Ivanotechs',
            'handle' => 'ivanotechs',
            'full_name' => 'Yannick Ivan Djoukeng Nougning',
            'logo_path' => 'brand/logo.jpg',
            'portrait_path' => 'brand/portrait.jpg',
            'public_email' => 'djforbian@gmail.com',
            'phone' => '+237 670011942',
            'address' => 'Caprice',
            'city' => 'Accra',
            'country' => 'Ghana',
            'birth_date' => '2003-01-15',
            'github_url' => 'https://github.com/ivanotechs',
            'linkedin_url' => 'https://www.linkedin.com/in/djoukeng-nougning-yannick-ivan-2ab40719a/',
            'xing_url' => 'https://www.xing.com/profile/YANNICKIVAN_DJOUKENGNOUGNING/web_profiles',
            'website_url' => 'https://mk.funvas.com',
            'x_url' => 'https://x.com/ivanotechs',
            'accent' => '#2f7cff',
            'nationality' => $this->t('Cameroonian', 'Kamerunisch', 'Camerounaise'),
            'role_label' => $this->t('Software engineer', 'Softwareentwickler', 'Ingénieur logiciel'),
            'tagline' => $this->t(
                'I build software for products that move.',
                'Ich baue Software für Produkte, die sich bewegen.',
                'Je construis des logiciels pour des produits qui bougent.',
            ),
            'about_short' => $this->t(
                'Software engineer and freelance developer. I trained as a computer engineer at the University of Buea and I am starting a master’s in automotive software engineering this semester.',
                'Softwareentwickler und Freiberufler. Ich habe Computer Engineering an der Universität Buea studiert und beginne in diesem Semester den Master in Automotive Software Engineering.',
                'Ingénieur logiciel et développeur indépendant. J’ai étudié l’ingénierie informatique à l’université de Buea et je commence ce semestre un master en ingénierie logicielle automobile.',
            ),
            'about_long' => $this->t(
                'I am a passionate software developer and I learn quickly. I adapt to the situation in front of me so I can do my best work, and I want to build useful solutions for everyday problems with strong teams. I studied computer engineering at the University of Buea from 2020 to 2024: PHP, C/C++, the web, Java, Python, Matlab, software architecture, data and artificial intelligence, networks, electronics, and microcontrollers. From 2023 to 2025 I developed and tested software at Afrovision Group, including Laravel applications, Livewire and Alpine.js interfaces, Flutter apps, and Docker deployments. Since October 2025 I have been freelancing under Ivanotechs and building Market Pilot at mk.funvas.com. This semester I am starting a master’s in automotive software engineering. I am looking for partial work in web development or software development, 30 hours a week or more, from home or hybrid.',
                'Ich bin ein leidenschaftlicher Softwareentwickler und lerne schnell. Ich passe mich an die Situation an, um mein Bestes zu geben, und ich möchte mit starken Teams Lösungen für Probleme des Alltags bauen. Von 2020 bis 2024 habe ich Computer Engineering an der Universität Buea studiert: PHP, C/C++, Web, Java, Python, Matlab, Softwarearchitektur, Daten und künstliche Intelligenz, Netzwerke, Elektronik und Mikrocontroller. Von 2023 bis 2025 habe ich bei der Afrovision Group Software entwickelt und getestet, darunter Laravel-Anwendungen, Oberflächen mit Livewire und Alpine.js, Flutter-Apps und Deployments mit Docker. Seit Oktober 2025 arbeite ich freiberuflich als Ivanotechs und baue Market Pilot auf mk.funvas.com. In diesem Semester beginne ich den Master in Automotive Software Engineering. Ich suche eine Teilzeitstelle in der Web- oder Softwareentwicklung, 30 Stunden pro Woche oder mehr, im Homeoffice oder hybrid.',
                'Je suis un développeur passionné et j’apprends vite. Je m’adapte à la situation pour donner le meilleur de moi-même, et je veux construire des solutions utiles aux problèmes du quotidien avec de bonnes équipes. De 2020 à 2024, j’ai étudié l’ingénierie informatique à l’université de Buea : PHP, C/C++, web, Java, Python, Matlab, architecture logicielle, données et intelligence artificielle, réseaux, électronique et microcontrôleurs. De 2023 à 2025, j’ai développé et testé des logiciels chez Afrovision Group, dont des applications Laravel, des interfaces Livewire et Alpine.js, des applications Flutter et des déploiements Docker. Depuis octobre 2025, je suis indépendant sous le nom Ivanotechs et je construis Market Pilot sur mk.funvas.com. Ce semestre, je commence un master en ingénierie logicielle automobile. Je cherche un temps partiel en développement web ou logiciel, 30 heures par semaine ou plus, en télétravail ou en hybride.',
            ),
            'availability' => $this->t(
                'Open to partial work in web or software development, 30 hours a week or more, home office or hybrid.',
                'Offen für Teilzeit in Web- oder Softwareentwicklung, 30 Stunden pro Woche oder mehr, Homeoffice oder hybrid.',
                'Disponible pour un temps partiel en développement web ou logiciel, 30 heures par semaine ou plus, télétravail ou hybride.',
            ),
            'seo_title' => $this->t(
                'Ivanotechs — Yannick Ivan Djoukeng Nougning, software engineer',
                'Ivanotechs — Yannick Ivan Djoukeng Nougning, Softwareentwickler',
                'Ivanotechs — Yannick Ivan Djoukeng Nougning, ingénieur logiciel',
            ),
            'seo_description' => $this->t(
                'Portfolio of Yannick Ivan Djoukeng Nougning, ivanotechs. Freelance software engineer, Laravel and web developer, starting a master’s in automotive software engineering. Open to partial remote or hybrid work.',
                'Portfolio von Yannick Ivan Djoukeng Nougning, ivanotechs. Freiberuflicher Softwareentwickler, Laravel und Web, Beginn des Masters in Automotive Software Engineering. Offen für Teilzeit remote oder hybrid.',
                'Portfolio de Yannick Ivan Djoukeng Nougning, ivanotechs. Ingénieur logiciel indépendant, Laravel et web, début d’un master en ingénierie logicielle automobile. Ouvert à un temps partiel à distance ou hybride.',
            ),
            'seo_keywords' => $this->t(
                'Ivanotechs, ivanotechs, Yannick Ivan Djoukeng Nougning, Ivan Djoukeng, Laravel, Livewire, Alpine.js, web developer, automotive software, freelance',
                'Ivanotechs, ivanotechs, Yannick Ivan Djoukeng Nougning, Softwareentwickler, Laravel, Livewire, Alpine.js, Webentwicklung, Automotive Software, Freiberufler',
                'Ivanotechs, ivanotechs, Yannick Ivan Djoukeng Nougning, développeur web, Laravel, Livewire, Alpine.js, logiciel automobile, freelance',
            ),
            'highlights' => [
                ['icon' => 'window', 'title' => $this->t('Web applications', 'Webanwendungen', 'Applications web'), 'body' => $this->t('Laravel, Livewire, Alpine.js, and Tailwind for product sites and admin tools.', 'Laravel, Livewire, Alpine.js und Tailwind für Produktseiten und Admin-Werkzeuge.', 'Laravel, Livewire, Alpine.js et Tailwind pour des sites produit et des outils d’admin.')],
                ['icon' => 'car', 'title' => $this->t('Automotive software', 'Automotive Software', 'Logiciel automobile'), 'body' => $this->t('A master’s starting this semester, next to software that already sits near vehicles and logistics.', 'Ein Master, der in diesem Semester beginnt, neben Software, die schon nah an Fahrzeugen und Logistik sitzt.', 'Un master qui commence ce semestre, à côté de logiciels déjà proches des véhicules et de la logistique.')],
                ['icon' => 'chip', 'title' => $this->t('Systems', 'Systeme', 'Systèmes'), 'body' => $this->t('C and C++ for a shell, local chat, and stock tools, plus Docker for deployment.', 'C und C++ für eine Shell, lokalen Chat und Lagerwerkzeuge, plus Docker für das Deployment.', 'C et C++ pour un shell, un chat local et des outils de stock, plus Docker pour le déploiement.')],
                ['icon' => 'spark', 'title' => $this->t('Freelance', 'Freiberuflich', 'Indépendant'), 'body' => $this->t('Available for 30 hours or more each week, at home or hybrid.', 'Verfügbar für 30 Stunden oder mehr pro Woche, zu Hause oder hybrid.', 'Disponible 30 heures ou plus par semaine, à la maison ou en hybride.')],
            ],
            'spoken_languages' => [
                ['name' => $this->t('English', 'Englisch', 'Anglais'), 'level' => $this->t('Native', 'Muttersprache', 'Langue maternelle')],
                ['name' => $this->t('French', 'Französisch', 'Français'), 'level' => $this->t('Native', 'Muttersprache', 'Langue maternelle')],
                ['name' => $this->t('German', 'Deutsch', 'Allemand'), 'level' => $this->t('B2 independent', 'B2 selbstständig', 'B2 indépendant')],
            ],
        ]);
    }

    private function experience(): void
    {
        Experience::query()->delete();

        $rows = [
            ['Freelance', 'Remote', '2025-10-01', null, true, 1,
                $this->t('Software engineer', 'Softwareentwickler', 'Ingénieur logiciel'),
                $this->t('Independent work as Ivanotechs. Current build: Market Pilot, the marketing platform at mk.funvas.com. Open to partial contracts of 30 hours or more, home office or hybrid.', 'Selbstständige Arbeit als Ivanotechs. Aktueller Bau: Market Pilot, die Marketingplattform auf mk.funvas.com. Offen für Teilzeitverträge ab 30 Stunden, Homeoffice oder hybrid.', 'Travail indépendant sous le nom Ivanotechs. Chantier en cours : Market Pilot, la plateforme marketing sur mk.funvas.com. Ouvert à des contrats partiels de 30 heures ou plus, télétravail ou hybride.')],
            ['Afrovision Group', 'Buea, Cameroon', '2024-01-09', '2025-11-21', false, 2,
                $this->t('Software developer', 'Softwareentwickler', 'Développeur logiciel'),
                $this->t('Fullstack websites and web applications with PHP, Laravel, HTML, CSS, Livewire, and Alpine.js, plus Flutter. Docker for deployment, Git and GitHub for the team.', 'Fullstack-Websites und Webanwendungen mit PHP, Laravel, HTML, CSS, Livewire und Alpine.js, dazu Flutter. Docker für das Deployment, Git und GitHub im Team.', 'Sites et applications web fullstack en PHP, Laravel, HTML, CSS, Livewire et Alpine.js, plus Flutter. Docker pour le déploiement, Git et GitHub en équipe.')],
            ['Bruno Kaiser Gruppe GmbH', null, '2024-01-01', '2025-11-30', false, 3,
                $this->t('Software developer', 'Softwareentwickler', 'Développeur logiciel'),
                $this->t('Listed on the Xing profile as software developer for this period.', 'Im Xing-Profil als Softwareentwickler für diesen Zeitraum genannt.', 'Indiqué sur le profil Xing comme développeur logiciel pour cette période.')],
            ['Afrovision Group', 'Buea', '2023-08-08', '2024-01-08', false, 4,
                $this->t('Software development internship', 'Praktikum Softwareentwicklung', 'Stage en développement logiciel'),
                $this->t('Software development and testing.', 'Softwareentwicklung und Testing.', 'Développement logiciel et tests.')],
        ];

        foreach ($rows as [$company, $location, $start, $end, $current, $sort, $role, $summary]) {
            Experience::query()->create([
                'company' => $company,
                'location' => $location,
                'start_date' => $start,
                'end_date' => $end,
                'is_current' => $current,
                'sort' => $sort,
                'role' => $role,
                'summary' => $summary,
            ]);
        }
    }

    private function education(): void
    {
        Education::query()->delete();

        $rows = [
            ['', null, '2026-10-01', null, true, 1,
                $this->t('M.Sc. Automotive Software Engineering', 'M.Sc. Automotive Software Engineering', 'Master en ingénierie logicielle automobile'),
                $this->t('The programme starts this semester. The university name can be added here from the admin.', 'Das Studium beginnt in diesem Semester. Der Name der Hochschule kann hier im Admin ergänzt werden.', 'Le cursus commence ce semestre. Le nom de l’établissement peut être ajouté ici depuis l’admin.')],
            ['University of Buea', 'Buea, Cameroon', '2020-11-02', '2024-07-19', false, 2,
                $this->t('Computer engineering', 'Computer Engineering', 'Ingénierie informatique'),
                $this->t('EQF level 6. Software with PHP, C/C++, HTML, CSS, JavaScript, Matlab, Java, and Python. Architecture and algorithms, data and artificial intelligence, networks and service-oriented architecture, electronics and microcontrollers.', 'EQR-Niveau 6. Software mit PHP, C/C++, HTML, CSS, JavaScript, Matlab, Java und Python. Architektur und Algorithmen, Daten und künstliche Intelligenz, Netzwerke und serviceorientierte Architektur, Elektronik und Mikrocontroller.', 'Niveau CEC 6. Logiciel en PHP, C/C++, HTML, CSS, JavaScript, Matlab, Java et Python. Architecture et algorithmes, données et intelligence artificielle, réseaux et architecture orientée services, électronique et microcontrôleurs.')],
            ['GBHS Dschang', 'Dschang, Cameroon', '2017-09-04', '2019-06-21', false, 3,
                $this->t('Abitur', 'Abitur', 'Baccalauréat'),
                $this->t('EQF level 4. Mathematics, physics, chemistry, information technology, and further mathematics.', 'EQR-Niveau 4. Mathematik, Physik, Chemie, Informationstechnik und weitere Mathematik.', 'Niveau CEC 4. Mathématiques, physique, chimie, informatique et mathématiques approfondies.')],
        ];

        foreach ($rows as [$school, $location, $start, $end, $current, $sort, $title, $summary]) {
            Education::query()->create([
                'school' => $school,
                'location' => $location,
                'start_date' => $start,
                'end_date' => $end,
                'is_current' => $current,
                'sort' => $sort,
                'title' => $title,
                'summary' => $summary,
            ]);
        }
    }

    private function skills(): void
    {
        Skill::query()->delete();
        $groups = [
            'Building' => $this->t('Building', 'Bauen', 'Construction'),
            'Engineering' => $this->t('Engineering', 'Engineering', 'Ingénierie'),
            'Automotive' => $this->t('Automotive and systems', 'Automotive und Systeme', 'Automobile et systèmes'),
        ];
        $items = [
            ['Laravel', 'Building'], ['Livewire', 'Building'], ['Alpine.js', 'Building'], ['Tailwind CSS', 'Building'], ['PHP', 'Building'], ['JavaScript', 'Building'], ['Flutter', 'Building'],
            ['MySQL', 'Engineering'], ['Git', 'Engineering'], ['Docker', 'Engineering'], ['REST', 'Engineering'], ['Python', 'Engineering'], ['Java', 'Engineering'],
            ['C', 'Automotive'], ['C++', 'Automotive'], ['Microcontrollers', 'Automotive'], ['Linux', 'Automotive'],
        ];
        foreach ($items as $index => [$name, $group]) {
            Skill::query()->create([
                'name' => $name,
                'group_label' => $groups[$group],
                'sort' => $index + 1,
            ]);
        }
    }

    private function projects(): void
    {
        Project::query()->delete();
        $sort = 1;
        foreach ($this->projectRows() as $row) {
            Project::query()->create($row + ['sort' => $sort, 'published' => true]);
            $sort++;
        }
    }

    private function projectRows(): array
    {
        $web = 'web';
        $mobile = 'mobile';
        $systems = 'systems';
        $data = 'data';
        $platform = 'platform';

        return [
            $this->project('market-pilot', $platform, '2026', 'https://mk.funvas.com', null, true, ['Laravel', 'SaaS', 'SMS'], 'Market Pilot',
                $this->t('The product I am building now at mk.funvas.com.', 'Das Produkt, das ich gerade auf mk.funvas.com baue.', 'Le produit que je construis en ce moment sur mk.funvas.com.'),
                $this->t('A multi-tenant marketing platform. The backend covers content plans, SMS campaigns, wallets, agents, and AI generation jobs.', 'Eine Multi-Tenant-Marketingplattform. Das Backend umfasst Content-Pläne, SMS-Kampagnen, Wallets, Agenten und KI-Generierung.', 'Une plateforme marketing multi-tenant. Le backend couvre les plans de contenu, les campagnes SMS, les portefeuilles, les agents et les tâches de génération IA.')),
            $this->project('signbridge', $web, '2026', null, null, true, ['Laravel', 'Livewire', 'OTP'], 'SignBridge',
                $this->t('A learning API and admin for lessons, practice, and passwordless sign-in.', 'Eine Lern-API und ein Admin für Lektionen, Übung und Anmeldung ohne Passwort.', 'Une API d’apprentissage et un admin pour les leçons, la pratique et la connexion sans mot de passe.'),
                $this->t('Laravel 13 API and Livewire admin: email OTP, Google and Apple login, lessons, questions, and practice sessions.', 'Laravel-13-API und Livewire-Admin: E-Mail-OTP, Anmeldung mit Google und Apple, Lektionen, Fragen und Übungssitzungen.', 'API Laravel 13 et admin Livewire : OTP par e-mail, connexion Google et Apple, leçons, questions et sessions de pratique.')),
            $this->project('swift-relocate', $web, '2025', null, null, true, ['Laravel', 'Quotes', 'Tracking'], 'Swift Relocate',
                $this->t('A moving-company site with quotes, jobs, and shipment tracking.', 'Eine Umzugswebsite mit Angeboten, Aufträgen und Sendungsverfolgung.', 'Un site de déménagement avec devis, missions et suivi des envois.'),
                $this->t('Public pages for services and locations, plus move jobs, vehicles, negotiations, and a tracking result.', 'Öffentliche Seiten für Leistungen und Orte, dazu Umzugsaufträge, Fahrzeuge, Verhandlungen und ein Tracking-Ergebnis.', 'Pages publiques pour les services et les lieux, plus les missions, les véhicules, les négociations et un résultat de suivi.')),
            $this->project('vamvam', $platform, '2026', null, null, true, ['Laravel', 'Education'], 'Vamvam',
                $this->t('University software for classes, attendance, results, and staff pay.', 'Hochschulsoftware für Klassen, Anwesenheit, Ergebnisse und Gehälter.', 'Logiciel universitaire pour les classes, les présences, les résultats et les salaires.'),
                $this->t('The university application models students, courses, attendance, results, and wages. A separate admin dashboard was designed in Figma and built as an interface.', 'Die Hochschulanwendung modelliert Studierende, Kurse, Anwesenheit, Ergebnisse und Löhne. Ein separates Admin-Dashboard wurde in Figma entworfen und als Oberfläche gebaut.', 'L’application universitaire modélise étudiants, cours, présences, résultats et salaires. Un tableau de bord admin séparé a été dessiné dans Figma puis construit.')),
            $this->project('buyam', $platform, '2025', null, null, true, ['Laravel', 'Marketplace'], 'Buyam',
                $this->t('A marketplace backend for vendors, products, and subscriptions.', 'Ein Marktplatz-Backend für Händler, Produkte und Abos.', 'Un backend de marketplace pour vendeurs, produits et abonnements.'),
                $this->t('Vendors, wishlists, ratings, subscriptions, and a public site for selling, resellers, and customers. A global marketing site sits beside the backend.', 'Händler, Wunschlisten, Bewertungen, Abos und eine öffentliche Seite für Verkauf, Wiederverkäufer und Kunden. Eine globale Marketingseite steht neben dem Backend.', 'Vendeurs, listes d’envies, notes, abonnements et un site public pour la vente, les revendeurs et les clients. Un site marketing global accompagne le backend.')),
            $this->project('flexy-pay', $platform, '2025', null, null, true, ['Laravel', 'Accounts', 'Loans'], 'Flexy Pay',
                $this->t('Banking software for accounts, savings, and loans.', 'Bankensoftware für Konten, Sparen und Kredite.', 'Logiciel bancaire pour comptes, épargne et prêts.'),
                $this->t('The Flexy Pay codebase opens accounts, links them, and records loans, guarantors, charges, and transactions.', 'Der Flexy-Pay-Code eröffnet Konten, verknüpft sie und erfasst Kredite, Bürgen, Gebühren und Transaktionen.', 'Le code Flexy Pay ouvre des comptes, les relie et enregistre prêts, garants, frais et transactions.')),
            $this->project('manuba', $web, '2025', null, null, true, ['Laravel', 'Hospitality'], 'Manuba',
                $this->t('A back office for dishes, drinks, rentals, stock, and pay.', 'Ein Backoffice für Gerichte, Getränke, Vermietung, Lager und Lohn.', 'Un back-office pour plats, boissons, locations, stock et paie.'),
                $this->t('Menus, gallery, products, purchases, rentals, defects, teams, and salary scales, with a sync path for pending changes.', 'Speisen, Galerie, Produkte, Einkäufe, Vermietungen, Mängel, Teams und Gehaltsstufen, mit einem Sync für offene Änderungen.', 'Menus, galerie, produits, achats, locations, défauts, équipes et grilles de salaire, avec une synchro des changements en attente.')),
            $this->project('pro4home', $mobile, '2025', null, null, false, ['Laravel', 'Flutter'], 'Pro4Home',
                $this->t('Home services: a Laravel API and a Flutter app.', 'Dienstleistungen fürs Zuhause: eine Laravel-API und eine Flutter-App.', 'Services à domicile : une API Laravel et une application Flutter.'),
                $this->t('Companies, skills, requests, portfolios, and blog content on the backend, with a Flutter client in the same Afrovision work.', 'Firmen, Fähigkeiten, Anfragen, Portfolios und Blog im Backend, mit einem Flutter-Client in derselben Afrovision-Arbeit.', 'Entreprises, compétences, demandes, portfolios et blog côté backend, avec un client Flutter dans le même travail Afrovision.')),
            $this->project('true-life', $web, '2025', null, null, false, ['Laravel', 'Invoices'], 'True Life',
                $this->t('Institutions, clients, products, and invoices.', 'Einrichtungen, Kunden, Produkte und Rechnungen.', 'Institutions, clients, produits et factures.'),
                $this->t('A Laravel application for client institutions, users, products, invoices, and payments, with a Flutter client beside it.', 'Eine Laravel-Anwendung für Einrichtungen, Nutzer, Produkte, Rechnungen und Zahlungen, mit einem Flutter-Client daneben.', 'Une application Laravel pour institutions, utilisateurs, produits, factures et paiements, avec un client Flutter à côté.')),
            $this->project('tim-logistics', $web, '2025', null, null, false, ['Laravel', 'Logistics'], 'Tim Logistics',
                $this->t('Orders and agents, with a map for a delivery job.', 'Aufträge und Agenten, mit einer Karte für einen Lieferauftrag.', 'Commandes et agents, avec une carte pour une course de livraison.'),
                $this->t('Separate flows for customers and agents, orders, services, and a map view of an order.', 'Getrennte Abläufe für Kunden und Agenten, Aufträge, Leistungen und eine Kartenansicht eines Auftrags.', 'Parcours séparés pour clients et agents, commandes, services et une carte d’une commande.')),
            $this->project('borderless-rx', $web, '2025', null, null, false, ['Laravel', 'Catalog'], 'Borderless RX',
                $this->t('A catalog with products, orders, and appointments.', 'Ein Katalog mit Produkten, Bestellungen und Terminen.', 'Un catalogue avec produits, commandes et rendez-vous.'),
                $this->t('Categories, products, services, orders, appointment requests, and a blog.', 'Kategorien, Produkte, Leistungen, Bestellungen, Terminanfragen und ein Blog.', 'Catégories, produits, services, commandes, demandes de rendez-vous et un blog.')),
            $this->project('confiance', $web, '2025', null, null, false, ['Laravel', 'Directories'], 'Confiance',
                $this->t('A directory of businesses, with subscriptions and reviews.', 'Ein Verzeichnis von Betrieben, mit Abos und Bewertungen.', 'Un annuaire d’entreprises, avec abonnements et avis.'),
                $this->t('Business pages, verification, subscriptions, and reviews.', 'Betriebsseiten, Prüfung, Abos und Bewertungen.', 'Fiches d’entreprises, vérification, abonnements et avis.')),
            $this->project('bella', $web, '2025', null, null, false, ['Laravel', 'Housing'], 'Bella Co-Living',
                $this->t('Rooms, tour requests, applications, and payments for co-living.', 'Zimmer, Besichtigungswünsche, Bewerbungen und Zahlungen für Co-Living.', 'Chambres, demandes de visite, candidatures et paiements pour le co-living.'),
                $this->t('Public pages for available rooms and contact, plus applications and documents.', 'Öffentliche Seiten für freie Zimmer und Kontakt, dazu Bewerbungen und Dokumente.', 'Pages publiques pour les chambres libres et le contact, plus les candidatures et les documents.')),
            $this->project('mapme', $web, '2025', null, null, false, ['Laravel', 'Alerts'], 'Mapme',
                $this->t('Regions, alerts, and user codes.', 'Regionen, Alarme und Nutzercodes.', 'Régions, alertes et codes utilisateur.'),
                $this->t('A French-language admin for regions, cities, alerts, and account activation.', 'Ein französischsprachiger Admin für Regionen, Städte, Alarme und Kontoaktivierung.', 'Un admin en français pour régions, villes, alertes et activation de comptes.')),
            $this->project('jupiter', $web, '2025', null, null, false, ['Laravel', 'Content'], 'Jupiter',
                $this->t('A company site with services, a blog, podcasts, and a logistics glossary.', 'Eine Firmenwebsite mit Leistungen, Blog, Podcasts und einem Logistikglossar.', 'Un site d’entreprise avec services, blog, podcasts et un glossaire logistique.'),
                $this->t('Services, case studies, documents, and editorial pages.', 'Leistungen, Fallstudien, Dokumente und redaktionelle Seiten.', 'Services, études de cas, documents et pages éditoriales.')),
            $this->project('eoro-sport', $web, '2025', null, null, false, ['Laravel', 'Sport'], 'Eoro Sport',
                $this->t('Sports news, fixtures, standings, and players.', 'Sportnachrichten, Spiele, Tabellen und Spieler.', 'Actualité sportive, matchs, classements et joueurs.'),
                $this->t('Fixtures, odds, standings, videos, and editorial picks.', 'Spiele, Quoten, Tabellen, Videos und redaktionelle Auswahlen.', 'Matchs, cotes, classements, vidéos et sélections éditoriales.')),
            $this->project('camerconner', $web, '2025', null, 'https://github.com/ivanotechs/camercorner', false, ['Laravel', 'Marketplace'], 'Camerconner',
                $this->t('A product catalog with sellers and identity checks.', 'Ein Produktkatalog mit Händlern und Identitätsprüfung.', 'Un catalogue de produits avec vendeurs et contrôle d’identité.'),
                $this->t('Products, seller products, orders, KYC, and a blog. The repository is also on GitHub as camercorner.', 'Produkte, Händlerprodukte, Bestellungen, KYC und ein Blog. Das Repository liegt auch auf GitHub als camercorner.', 'Produits, produits vendeurs, commandes, KYC et un blog. Le dépôt est aussi sur GitHub sous camercorner.')),
            $this->project('mohada', $web, '2025', null, null, false, ['Laravel', 'OHADA'], 'Mohada',
                $this->t('Search across an OHADA register, with payment notifications.', 'Suche in einem OHADA-Register, mit Zahlungsbenachrichtigungen.', 'Recherche dans un registre OHADA, avec des notifications de paiement.'),
                $this->t('A public search and a CinetPay notification endpoint sit in the routes.', 'Eine öffentliche Suche und ein CinetPay-Benachrichtigungspunkt stehen in den Routen.', 'Une recherche publique et un point de notification CinetPay sont dans les routes.')),
            $this->project('cts24', $web, '2025', null, null, false, ['Laravel', 'Courses'], 'CTS24',
                $this->t('A shop, courses, an accelerator, and shipment tracking.', 'Ein Shop, Kurse, ein Accelerator und Sendungsverfolgung.', 'Une boutique, des cours, un accélérateur et un suivi d’envoi.'),
                $this->t('Products, course participants, orders, and a tracking result.', 'Produkte, Kursteilnehmer, Bestellungen und ein Tracking-Ergebnis.', 'Produits, participants aux cours, commandes et un résultat de suivi.')),
            $this->project('exssa-usa', $web, '2025', null, null, false, ['Laravel'], 'ExSSA USA',
                $this->t('The website for ExSakerettes in the USA.', 'Die Website für ExSakerettes in den USA.', 'Le site des ExSakerettes aux États-Unis.'),
                $this->t('A Laravel site whose repository describes itself as the ExSSA USA website.', 'Eine Laravel-Seite, deren Repository sich als ExSSA-USA-Website beschreibt.', 'Un site Laravel dont le dépôt se décrit comme le site ExSSA USA.')),
            $this->project('elcrypto', $web, '2025', null, null, false, ['Laravel'], 'Elcrypto',
                $this->t('Accounts, transactions, and content pages.', 'Konten, Transaktionen und Inhaltsseiten.', 'Comptes, transactions et pages de contenu.'),
                $this->t('A Laravel application with users, roles, regions, transactions, and editable pages.', 'Eine Laravel-Anwendung mit Nutzern, Rollen, Regionen, Transaktionen und bearbeitbaren Seiten.', 'Une application Laravel avec utilisateurs, rôles, régions, transactions et pages éditables.')),
            $this->project('valeo-trips', $web, '2025', null, null, false, ['Laravel', 'Field service'], 'Valeo field trips',
                $this->t('A small tool for recording field-service trips.', 'Ein kleines Werkzeug, um Außendienstfahrten zu erfassen.', 'Un petit outil pour enregistrer les déplacements du service terrain.'),
                $this->t('Users, trips, and trip records. It lived with the Afrovision Laravel work.', 'Nutzer, Fahrten und Fahrtprotokolle. Es lag bei der Laravel-Arbeit von Afrovision.', 'Utilisateurs, trajets et relevés. Il faisait partie du travail Laravel d’Afrovision.')),
            $this->project('foliade', $web, '2025', null, null, false, ['Laravel'], 'Foliade',
                $this->t('A public site for an organisation, its projects, articles, and statutes.', 'Eine öffentliche Seite für eine Organisation, ihre Projekte, Artikel und Statuten.', 'Un site public pour une organisation, ses projets, ses articles et ses statuts.'),
                $this->t('Pages for about, projects, a blog, contact, and statutes.', 'Seiten für Über uns, Projekte, einen Blog, Kontakt und Statuten.', 'Pages à propos, projets, blog, contact et statuts.')),
            $this->project('task-app', $web, '2025', null, null, false, ['Laravel', 'Payroll'], 'Task App',
                $this->t('Projects, tasks, payroll, and team profiles.', 'Projekte, Aufgaben, Lohnabrechnung und Teamprofile.', 'Projets, tâches, paie et profils d’équipe.'),
                $this->t('A Laravel app for tasks assigned to people, payments, training, and public project pages.', 'Eine Laravel-App für Aufgaben an Personen, Zahlungen, Weiterbildung und öffentliche Projektseiten.', 'Une application Laravel pour les tâches assignées, les paiements, la formation et des pages de projets publiques.')),
            $this->project('smecredit', $web, '2025', null, null, false, ['CakePHP'], 'SME Credit',
                $this->t('A CakePHP application named SME Credit.', 'Eine CakePHP-Anwendung mit dem Namen SME Credit.', 'Une application CakePHP nommée SME Credit.'),
                $this->t('It sits in the Afrovision CakePHP work. The public description stays limited to what the project itself shows.', 'Es liegt in der CakePHP-Arbeit von Afrovision. Die öffentliche Beschreibung bleibt bei dem, was das Projekt selbst zeigt.', 'Il est dans le travail CakePHP d’Afrovision. La description publique reste limitée à ce que le projet montre.')),
            $this->project('stock-management', $systems, '2024', null, 'https://github.com/ivanotechs/stock_management', false, ['C'], 'Stock management',
                $this->t('A C program for a supermarket: stock, clients, and tills, stored in files.', 'Ein C-Programm für einen Supermarkt: Lager, Kunden und Kassen, gespeichert in Dateien.', 'Un programme C pour un supermarché : stock, clients et caisses, stockés dans des fichiers.'),
                $this->t('Published on GitHub as stock_management.', 'Auf GitHub als stock_management veröffentlicht.', 'Publié sur GitHub sous stock_management.')),
            $this->project('linux-shell', $systems, '2024', null, 'https://github.com/ivanotechs/linux_shell', false, ['C', 'Linux'], 'Linux shell',
                $this->t('A shell with processes, pipes, and input and output redirection.', 'Eine Shell mit Prozessen, Pipes und Ein- und Ausgabeumleitung.', 'Un shell avec processus, tubes et redirections d’entrée et de sortie.'),
                $this->t('Built on Linux and published on GitHub as linux_shell.', 'Unter Linux gebaut und auf GitHub als linux_shell veröffentlicht.', 'Construit sous Linux et publié sur GitHub sous linux_shell.')),
            $this->project('wlan-chat', $systems, '2024', null, 'https://github.com/ivanotechs/wlan_chat', false, ['C', 'Sockets'], 'WLAN chat',
                $this->t('A terminal chat for computers on the same Wi-Fi.', 'Ein Terminal-Chat für Rechner im selben WLAN.', 'Un chat en terminal pour des ordinateurs sur le même Wi-Fi.'),
                $this->t('A console application in C, published as wlan_chat.', 'Eine Konsolenanwendung in C, veröffentlicht als wlan_chat.', 'Une application console en C, publiée sous wlan_chat.')),
            $this->project('programming-friend', $mobile, '2024', null, 'https://github.com/ivanotechs/programming_friend', false, ['Mobile'], 'Programming Friend',
                $this->t('A mobile app for learning programming with tests and questions.', 'Eine mobile App, um Programmieren mit Tests und Fragen zu lernen.', 'Une application mobile pour apprendre à programmer avec des tests et des questions.'),
                $this->t('The GitHub description: tests, and a way to ask when you are stuck.', 'Die GitHub-Beschreibung: Tests und eine Möglichkeit zu fragen, wenn man feststeckt.', 'La description GitHub : des tests, et un moyen de poser une question quand on bloque.')),
            $this->project('car-price', $data, '2024', null, 'https://github.com/ivanotechs/car_price_Prediction', false, ['Python', 'scikit-learn'], 'Car price prediction',
                $this->t('Linear regression on a Kaggle car-price dataset.', 'Lineare Regression auf einem Kaggle-Datensatz zu Autopreisen.', 'Régression linéaire sur un jeu Kaggle de prix de voitures.'),
                $this->t('A Jupyter notebook using scikit-learn, published as car_price_Prediction.', 'Ein Jupyter-Notebook mit scikit-learn, veröffentlicht als car_price_Prediction.', 'Un notebook Jupyter avec scikit-learn, publié sous car_price_Prediction.')),
            $this->project('scraper', $data, '2024', null, 'https://github.com/ivanotechs/scraper', false, ['Python'], 'Amazon scraper',
                $this->t('A Python scraper that writes selected Amazon products to CSV.', 'Ein Python-Scraper, der ausgewählte Amazon-Produkte als CSV schreibt.', 'Un scraper Python qui écrit des produits Amazon choisis en CSV.'),
                $this->t('Published on GitHub as scraper.', 'Auf GitHub als scraper veröffentlicht.', 'Publié sur GitHub sous scraper.')),
            $this->project('send-sms', $systems, '2024', null, 'https://github.com/ivanotechs/sendSMS', false, ['PHP'], 'Send SMS',
                $this->t('PHP for sending a message to an application user.', 'PHP, um eine Nachricht an einen Anwendungsnutzer zu senden.', 'Du PHP pour envoyer un message à un utilisateur d’application.'),
                $this->t('A small repository, sendSMS, described on GitHub in those terms.', 'Ein kleines Repository, sendSMS, auf GitHub so beschrieben.', 'Un petit dépôt, sendSMS, décrit ainsi sur GitHub.')),
        ];
    }

    private function project(string $slug, string $category, string $year, ?string $url, ?string $github, bool $featured, array $stack, string $title, array $summary, array $body): array
    {
        return [
            'slug' => $slug,
            'category' => $category,
            'year' => $year,
            'url' => $url,
            'github_url' => $github,
            'featured' => $featured,
            'stack' => $stack,
            'title' => ['en' => $title, 'de' => $title, 'fr' => $title],
            'summary' => $summary,
            'body' => $body,
        ];
    }

    private function pages(): void
    {
        $pages = [
            'home' => $this->t('Ivanotechs — Yannick Ivan Djoukeng Nougning', 'Ivanotechs — Yannick Ivan Djoukeng Nougning', 'Ivanotechs — Yannick Ivan Djoukeng Nougning'),
            'about' => $this->t('About Ivanotechs — Yannick Ivan Djoukeng Nougning', 'Über Ivanotechs — Yannick Ivan Djoukeng Nougning', 'À propos d’Ivanotechs — Yannick Ivan Djoukeng Nougning'),
            'cv' => $this->t('CV — Ivanotechs, Yannick Ivan Djoukeng Nougning', 'Lebenslauf — Ivanotechs, Yannick Ivan Djoukeng Nougning', 'CV — Ivanotechs, Yannick Ivan Djoukeng Nougning'),
            'projects' => $this->t('Projects — Ivanotechs, ivanotechs', 'Projekte — Ivanotechs, ivanotechs', 'Projets — Ivanotechs, ivanotechs'),
            'contact' => $this->t('Contact Ivanotechs — djforbian@gmail.com', 'Kontakt Ivanotechs — djforbian@gmail.com', 'Contact Ivanotechs — djforbian@gmail.com'),
        ];
        $descriptions = [
            'home' => $this->t('Ivanotechs, the site of Yannick Ivan Djoukeng Nougning. Software, projects, and a master’s in automotive software.', 'Ivanotechs, die Seite von Yannick Ivan Djoukeng Nougning. Software, Projekte und ein Master in Automotive Software.', 'Ivanotechs, le site de Yannick Ivan Djoukeng Nougning. Logiciel, projets et un master en logiciel automobile.'),
            'about' => $this->t('Who Ivan Djoukeng is: computer engineering, Afrovision, freelance work, and automotive software.', 'Wer Ivan Djoukeng ist: Computer Engineering, Afrovision, Freiberuflichkeit und Automotive Software.', 'Qui est Ivan Djoukeng : ingénierie informatique, Afrovision, indépendant et logiciel automobile.'),
            'cv' => $this->t('CV of Yannick Ivan Djoukeng Nougning: education, Afrovision Group, Bruno Kaiser, and freelance work.', 'Lebenslauf von Yannick Ivan Djoukeng Nougning: Ausbildung, Afrovision Group, Bruno Kaiser und Freiberuflichkeit.', 'CV de Yannick Ivan Djoukeng Nougning : études, Afrovision Group, Bruno Kaiser et travail indépendant.'),
            'projects' => $this->t('Projects by ivanotechs: Laravel, Flutter, C, and the marketing platform mk.funvas.com.', 'Projekte von ivanotechs: Laravel, Flutter, C und die Marketingplattform mk.funvas.com.', 'Projets d’ivanotechs : Laravel, Flutter, C et la plateforme marketing mk.funvas.com.'),
            'contact' => $this->t('Contact Ivanotechs. Messages are sent to djforbian@gmail.com.', 'Kontakt zu Ivanotechs. Nachrichten gehen an djforbian@gmail.com.', 'Contacter Ivanotechs. Les messages partent vers djforbian@gmail.com.'),
        ];

        foreach ($pages as $key => $title) {
            PageSeo::query()->updateOrCreate(['key' => $key], [
                'title' => $title,
                'description' => $descriptions[$key],
            ]);
        }

        ContactMessage::query()->where('email', 'seed@example.com')->delete();
    }
}

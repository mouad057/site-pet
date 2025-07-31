<?php
// Simuler une liste de services. 
// Vous pouvez facilement ajouter ou modifier des services ici.
$services = [
    [
        'icon' => '🐾', // Emoji en guise d'icône simple
        'title' => 'Promenade de Chiens',
        'description' => 'Des promenades stimulantes et sécurisées pour que votre chien reste heureux, en bonne santé et socialisé.'
    ],
    [
        'icon' => '🏠',
        'title' => 'Garde à Domicile',
        'description' => 'Nous gardons vos animaux dans le confort de leur propre maison, en maintenant leur routine habituelle.'
    ],
    [
        'icon' => '🐈',
        'title' => 'Visites pour Chats',
        'description' => 'Des visites quotidiennes pour nourrir votre chat, nettoyer sa litière et lui offrir des câlins pendant votre absence.'
    ],
    [
        'icon' => '✂️',
        'title' => 'Toilettage Professionnel',
        'description' => 'Un service de toilettage complet pour que votre compagnon soit propre, soigné et se sente au mieux.'
    ],
    [
        'icon' => '🎓',
        'title' => 'Éducation & Dressage',
        'description' => 'Des sessions de dressage positives pour enseigner les bonnes manières et renforcer votre lien avec votre animal.'
    ],
    [
        'icon' => '🚑',
        'title' => 'Transport Animalier',
        'description' => 'Un transport sûr et fiable pour les rendez-vous chez le vétérinaire ou toute autre destination nécessaire.'
    ]
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Services - Favpet</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #ff7878;
            --secondary-color: #fff0f0;
            --dark-color: #2c3e50;
            --light-gray-color: #f8f9fa;
            --text-color: #555;
            --font-family: 'Poppins', sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-family);
            background-color: #fff;
            color: var(--text-color);
            line-height: 1.7;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* --- En-tête --- */
        .main-header {
            background-color: #fff;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .main-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo svg {
            width: 40px;
            height: 40px;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 35px;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--dark-color);
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: var(--primary-color);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .btn {
            padding: 10px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: #fff;
            box-shadow: 0 4px 10px rgba(255, 120, 120, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
        }

        .btn-login {
            text-decoration: none;
            color: var(--dark-color);
            font-weight: 600;
            padding: 10px 15px;
        }
        .btn-login:hover {
            color: var(--primary-color);
        }

        /* --- Section Hero --- */
        .hero {
            background-color: var(--light-gray-color);
            text-align: center;
            padding: 80px 20px;
        }

        .hero h1 {
            font-size: 3rem;
            color: var(--dark-color);
            margin-bottom: 15px;
        }

        .hero p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto;
            color: var(--text-color);
        }
        
        /* --- Section Services --- */
        .services-section {
            padding: 80px 0;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .service-card {
            background: #fff;
            border: 1px solid #f0f0f0;
            border-radius: 16px;
            padding: 30px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }
        
        .service-card .icon {
            font-size: 3rem;
            line-height: 1;
            margin-bottom: 20px;
            display: inline-block;
            background-color: var(--secondary-color);
            color: var(--primary-color);
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: auto;
            margin-right: auto;
        }
        
        .service-card h3 {
            font-size: 1.5rem;
            color: var(--dark-color);
            margin-bottom: 10px;
        }
        
        .service-card p {
            font-size: 1rem;
            color: var(--text-color);
        }

        /* --- Section CTA (Call to Action) --- */
        .cta-section {
            background-color: var(--dark-color);
            color: #fff;
            padding: 60px 20px;
            text-align: center;
            border-radius: 20px;
            margin: 40px auto;
        }
        .cta-section h2 {
            font-size: 2.2rem;
            margin-bottom: 15px;
        }
        .cta-section p {
            margin-bottom: 30px;
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
    </style>
</head>
<body>

    <header class="main-header">
        <div class="container">
            <nav class="main-nav">
                <a href="#" class="logo">
                    <svg viewBox="0 0 24 24" fill="#ff7878" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm3.67 10.33-1.42 1.42L13 12.5V16h-2v-3.5l-1.25 1.25-1.42-1.42L12 8.67l3.67 3.66z" fill-rule="evenodd" clip-rule="evenodd"/></svg>
                </a>
                <ul class="nav-links">
                    <li><a href="#">Find Favpet</a></li>
                    <li><a href="#" class="active">Service</a></li>
                    <li><a href="favpet.php">Favpet</a></li>
                    <li><a href="#">Review</a></li>
                </ul>
                <div class="nav-actions">
                    <a href="#" class="btn-login">Login</a>
                    <a href="#" class="btn btn-primary">Request Service</a>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="container">
                <h1>Des Soins d'Excellence pour Vos Compagnons</h1>
                <p>Découvrez notre gamme complète de services conçus pour le bien-être et le bonheur de votre meilleur ami. Chaque service est fourni par des passionnés qualifiés.</p>
            </div>
        </section>

        <section class="services-section">
            <div class="container">
                <div class="services-grid">
                    <?php foreach ($services as $service): ?>
                        <div class="service-card">
                            <div class="icon"><?php echo htmlspecialchars($service['icon']); ?></div>
                            <h3><?php echo htmlspecialchars($service['title']); ?></h3>
                            <p><?php echo htmlspecialchars($service['description']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="cta-section-wrapper">
             <div class="container">
                <div class="cta-section">
                    <h2>Prêt à offrir le meilleur à votre animal ?</h2>
                    <p>Trouvez un pet sitter de confiance près de chez vous en quelques clics.</p>
                    <a href="#" class="btn btn-primary">Trouver mon Favpet</a>
                </div>
            </div>
        </section>
    </main>

</body>
</html>
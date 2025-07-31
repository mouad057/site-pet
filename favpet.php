<?php
// On simule une base de données de vos "Favpets" (pet sitters)
// Vous pouvez facilement ajouter ou modifier des profils ici
$favpets = [
    [
        'name' => 'Léa Dubois',
        'specialty' => 'Spécialiste des Chiens Actifs',
        'bio' => 'Avec plus de 5 ans d\'expérience, Léa adore les longues randonnées et les jeux en plein air. Elle saura comment dépenser l\'énergie de votre chien en toute sécurité.',
        'image' => 'https://i.pravatar.cc/300?img=7'
    ],
    [
        'name' => 'Marc Petit',
        'specialty' => 'Expert en Câlins pour Chats',
        'bio' => 'Patient et doux, Marc comprend le langage des chats et sait comment mettre à l\'aise même les plus timides. Votre chat sera choyé et détendu.',
        'image' => 'https://i.pravatar.cc/300?img=8'
    ],
    [
        'name' => 'Chloé Lambert',
        'specialty' => 'Soins pour Nouveaux Animaux de Compagnie',
        'bio' => 'Chloé a une expertise particulière avec les chiots et les chatons, offrant des soins attentifs et aidant à la propreté et à la socialisation de base.',
        'image' => 'https://i.pravatar.cc/300?img=9'
    ],
    [
        'name' => 'Julien Moreau',
        'specialty' => 'Garde d\'Animaux Exotiques',
        'bio' => 'Vétérinaire de formation, Julien est qualifié pour s\'occuper de lapins, furets, et autres petits mammifères ayant des besoins spécifiques.',
        'image' => 'https://i.pravatar.cc/300?img=10'
    ]
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Favpets - Pet Care Services</title>

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

        /* --- Header --- */
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

        /* --- Page Content --- */
        .page-header {
            background-color: var(--light-gray-color);
            text-align: center;
            padding: 80px 20px;
        }

        .page-header h1 {
            font-size: 3rem;
            color: var(--dark-color);
            margin-bottom: 15px;
        }

        .page-header p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto;
            color: var(--text-color);
        }

        .favpet-section {
            padding: 80px 0;
        }

        .favpet-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 40px;
        }
        
        .favpet-card {
            background: #fff;
            text-align: center;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
        }
        
        .favpet-card:hover {
            transform: translateY(-10px);
        }
        
        .favpet-card img {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid var(--secondary-color);
            margin-bottom: 20px;
        }
        
        .favpet-card h3 {
            font-size: 1.5rem;
            color: var(--dark-color);
            margin-bottom: 8px;
        }
        
        .favpet-card .specialty {
            font-size: 1rem;
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .favpet-card .bio {
            font-size: 0.95rem;
            color: var(--text-color);
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
                    <li><a href="#">Service</a></li>
                    <li><a href="#" class="active">Favpet</a></li>
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
        <div class="page-header">
            <div class="container">
                <h1>Rencontrez nos Favpets</h1>
                <p>Nos gardiens d'animaux ne sont pas seulement des professionnels, ce sont des passionnés. Découvrez les visages de confiance qui prendront soin de votre compagnon.</p>
            </div>
        </div>

        <section class="favpet-section">
            <div class="container">
                <div class="favpet-grid">
                    <?php foreach ($favpets as $favpet): ?>
                        <div class="favpet-card">
                            <img src="<?php echo htmlspecialchars($favpet['image']); ?>" alt="Photo de <?php echo htmlspecialchars($favpet['name']); ?>">
                            <h3><?php echo htmlspecialchars($favpet['name']); ?></h3>
                            <p class="specialty"><?php echo htmlspecialchars($favpet['specialty']); ?></p>
                            <p class="bio"><?php echo htmlspecialchars($favpet['bio']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>

</body>
</html>
<?php
// Simuler une base de données de gardiens d'animaux (Favpets)
$all_favpets = [
    ['name' => 'Marie Dupont', 'service' => 'Garde à domicile', 'city' => 'Paris', 'image' => 'man.jpg'],
    ['name' => 'Julien Martin', 'service' => 'Promenade de chiens', 'city' => 'Lyon', 'image' => 'sarah.jpg'],
    ['name' => 'Claire Petit', 'service' => 'Garde de chats', 'city' => 'Marseille', 'image' => 'omar.jpg'],
    ['name' => 'Luc Durand', 'service' => 'Garde à domicile', 'city' => 'Lyon', 'image' => 'man2.jpg'],
    ['name' => 'Anne Leroy', 'service' => 'Promenade de chiens', 'city' => 'Paris', 'image' => 'woman2.jpg'],
    ['name' => 'Paul Lefebvre', 'service' => 'Garde de chats', 'city' => 'Paris', 'image' => 'woman3.jpg'],
];

// --- Logique de Filtrage ---
// On commence avec la liste complète
$favpets_to_display = $all_favpets;

// Filtrer par service si le champ est rempli
if (isset($_GET['service']) && !empty($_GET['service'])) {
    $service_filter = $_GET['service'];
    $favpets_to_display = array_filter($favpets_to_display, function($pet) use ($service_filter) {
        return $pet['service'] == $service_filter;
    });
}

// Filtrer par ville si le champ est rempli
if (isset($_GET['city']) && !empty($_GET['city'])) {
    $city_filter = strtolower(trim($_GET['city']));
    $favpets_to_display = array_filter($favpets_to_display, function($pet) use ($city_filter) {
        return strtolower($pet['city']) == $city_filter;
    });
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trouver un Favpet - Pet Care Services</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* --- Variables et Styles de Base --- */
        :root {
            --primary-color: #ff7878;
            --secondary-color: #fff0f0;
            --dark-color: #333;
            --light-gray-color: #f8f9fa;
            --text-color: #555;
            --border-color: #ddd;
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
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* --- En-tête et Navigation --- */
        .main-header {
            background-color: #fff;
            padding: 15px 0;
            border-bottom: 1px solid var(--light-gray-color);
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
            border-radius: 50px; /* Bords très arrondis */
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
            box-shadow: 0 6px burdensome 12px rgba(255, 120, 120, 0.6);
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

        /* --- Section de Recherche --- */
        .search-section {
            background-color: var(--light-gray-color);
            padding: 80px 0;
            text-align: center;
        }

        .search-section h1 {
            color: var(--dark-color);
            font-size: 2.8rem;
            margin-bottom: 15px;
        }

        .search-form {
            margin-top: 30px;
            background-color: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            align-items: flex-end;
        }

        .form-group {
            text-align: left;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--dark-color);
            font-size: 14px;
        }

        .form-group input,
        .form-group select {
            width: 280px;
            padding: 12px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-family: var(--font-family);
            font-size: 1rem;
        }
        
        .search-form .btn {
            height: 50px; /* Aligner la hauteur avec les inputs */
            border-radius: 8px; /* Aligner le radius avec les inputs */
        }

        /* --- Section des Résultats --- */
        .results-section {
            padding: 60px 0;
        }

        .results-section h2 {
            text-align: center;
            font-size: 2.2rem;
            color: var(--dark-color);
            margin-bottom: 40px;
        }

        .results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
        }

        .favpet-card {
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.07);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .favpet-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .favpet-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .favpet-card .card-body {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .card-body h3 {
            margin: 0;
            color: var(--dark-color);
            font-size: 1.25rem;
        }

        .card-body .service-type {
            color: var(--primary-color);
            font-weight: 600;
            margin-top: 5px;
            font-size: 0.9rem;
        }

        .card-body .location {
            margin: 10px 0;
            color: var(--text-color);
        }

        .btn-secondary {
            display: inline-block;
            margin-top: auto; /* Pousse le bouton vers le bas */
            background-color: var(--secondary-color);
            color: var(--primary-color);
            width: 100%;
            text-align: center;
            padding: 12px;
            border-radius: 8px;
        }

        .btn-secondary:hover {
            background-color: var(--primary-color);
            color: #fff;
        }
        
        .no-results {
            grid-column: 1 / -1; /* Occupe toute la largeur de la grille */
            text-align: center;
            font-size: 1.2rem;
            padding: 50px;
            background: var(--light-gray-color);
            border-radius: 12px;
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
                    <li><a href="#" class="active">Find Favpet</a></li>
                    <li><a href="service.php">Service</a></li>
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
        <section class="search-section">
            <div class="container">
                <h1>Trouvez le meilleur service pour votre ami</h1>
                <p>Recherchez parmi des centaines de pet sitters qualifiés près de chez vous.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET" class="search-form">
                    <div class="form-group">
                        <label for="service">Je cherche un service de...</label>
                        <select id="service" name="service">
                            <option value="">Tous les services</option>
                            <option value="Garde à domicile" <?php echo (isset($_GET['service']) && $_GET['service'] == 'Garde à domicile') ? 'selected' : ''; ?>>Garde à domicile</option>
                            <option value="Promenade de chiens" <?php echo (isset($_GET['service']) && $_GET['service'] == 'Promenade de chiens') ? 'selected' : ''; ?>>Promenade de chiens</option>
                            <option value="Garde de chats" <?php echo (isset($_GET['service']) && $_GET['service'] == 'Garde de chats') ? 'selected' : ''; ?>>Garde de chats</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="city">Dans la ville de...</label>
                        <input type="text" id="city" name="city" placeholder="Ex: Paris, Lyon..." value="<?php echo isset($_GET['city']) ? htmlspecialchars($_GET['city']) : ''; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Rechercher</button>
                </form>
            </div>
        </section>

        <section class="results-section">
            <div class="container">
                <h2>Résultats de la recherche</h2>
                <div class="results-grid">
                    <?php if (empty($favpets_to_display)): ?>
                        <p class="no-results">😢 Aucun résultat trouvé. Essayez d'élargir vos critères de recherche.</p>
                    <?php else: ?>
                        <?php foreach ($favpets_to_display as $pet): ?>
                        <div class="favpet-card">
                            <img src="<?php echo htmlspecialchars($pet['image']); ?>" alt="Photo de <?php echo htmlspecialchars($pet['name']); ?>">
                            <div class="card-body">
                                <h3><?php echo htmlspecialchars($pet['name']); ?></h3>
                                <p class="service-type"><?php echo htmlspecialchars($pet['service']); ?></p>
                                <p class="location"><?php echo htmlspecialchars($pet['city']); ?></p>
                                <a href="#" class="btn btn-secondary">Voir le profil</a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

</body>
</html>
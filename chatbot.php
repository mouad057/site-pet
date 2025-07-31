<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $knowledgeBase = [
        "horaires"    => "Notre boutique est ouverte 7j/7, de 10h00 à 22h00. La zone de jeu reste ouverte jusqu'à minuit !",
        "ouverture"   => "Notre boutique est ouverte 7j/7, de 10h00 à 22h00. La zone de jeu reste ouverte jusqu'à minuit !",
        "adresse"     => "Retrouvez-nous au cœur du gaming, au 404 Boulevard des Pixels, Casablanca.",
        "magasin"     => "Retrouvez-nous au cœur du gaming, au 404 Boulevard des Pixels, Casablanca.",
        "ps5"         => "La PS5 est très demandée ! Nous avons des arrivages réguliers. Le mieux est d'appeler pour connaître le stock en temps réel.",
        "xbox"        => "Nous avons les Xbox Series X et S en stock. Venez tester la puissance du Game Pass dans notre zone de jeu !",
        "switch"      => "La Nintendo Switch et la Switch OLED sont disponibles avec un large choix de jeux. Parfait pour jouer partout !",
        "pc"          => "Nous montons des PC sur mesure ! Cartes graphiques, processeurs, RAM... Dites-nous ce dont vous avez besoin pour votre build de rêve.",
        "carte graphique" => "Nous avons les dernières RTX de Nvidia et les cartes AMD. Contactez-nous pour un modèle précis.",
        "réparation"  => "Oui, notre atelier technique répare consoles, manettes et PC. Apportez votre matériel pour un diagnostic gratuit.",
        "sav"         => "Oui, notre atelier technique répare consoles, manettes et PC. Apportez votre matériel pour un diagnostic gratuit.",
        "précommande" => "Vous pouvez précommander les prochains hits sur notre site web ou en magasin pour obtenir des bonus exclusifs.",
        "tournoi"     => "Nous organisons des tournois de Valorant et Street Fighter chaque week-end ! Suivez nos réseaux sociaux pour le calendrier.",
        "événement"   => "Nous organisons des tournois de Valorant et Street Fighter chaque week-end ! Suivez nos réseaux sociaux pour le calendrier.",
        "contact"     => "Contactez-nous au 05 22 99 88 77 ou par email à contact@gaming-boutique.ma.",
        "téléphone"   => "Contactez-nous au 05 22 99 88 77 ou par email à contact@gaming-boutique.ma.",
        "bonjour"     => "Bonjour, joueur ! Prêt à trouver votre prochain équipement ou jeu ? Comment puis-je vous aider ?",
        "salut"       => "Salut ! Bienvenue dans le hub. Que cherchez-vous aujourd'hui ?",
        "merci"       => "De rien ! Bon jeu et n'hésitez pas si vous avez d'autres questions !"
    ];
    $defaultResponse = "GG? Je n'ai pas la réponse à cette quête !\n\n(\\__/)\n(o.O)\n(> <)\n\nEssayez de reformuler ou contactez un de nos maîtres du jeu au 05 22 99 88 77.";
    
    $input = json_decode(file_get_contents('php://input'), true);
    $userMessage = isset($input['message']) ? strtolower(trim($input['message'])) : '';
    $reply = $defaultResponse;

    if (!empty($userMessage)) {
        foreach ($knowledgeBase as $keyword => $response) {
            if (strpos($userMessage, $keyword) !== false) {
                $reply = $response;
                break;
            }
        }
    }
    echo json_encode(['reply' => $reply]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assistant Gaming</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        
        :root {
            --dark-bg: #121212;          /* Fond très sombre (gamer) */
            --dark-surface: #1E1E1E;     /* Fond du chat (gamer) */
            --pika-yellow: #FBCB0A;      /* Accent principal (Pikachu) */
            --pika-red: #D82A2A;         /* Accent secondaire (Pikachu) */
            --dark-user-msg: #373737;   /* Bulle utilisateur (gamer) */
            --text-light: #FFFFFF;       /* Texte clair (gamer) */
            --text-dark: #121212;        /* Texte sombre pour bulles claires */
        }

        body {
            background-color: var(--dark-bg);
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        #chat-container {
            width: 100%;
            max-width: 420px;
            height: 90vh;
            max-height: 700px;
            background: var(--dark-surface);
            border-radius: 16px;
            box-shadow: 0 0 30px var(--pika-yellow);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border: 1px solid var(--pika-yellow);
        }
        
        #chat-header {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            background: var(--dark-surface);
            color: var(--text-light);
            border-bottom: 2px solid var(--pika-yellow);
            flex-shrink: 0;
        }

        #header-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid var(--pika-red);
        }

        #header-title {
            font-size: 1.3em;
            font-weight: 600;
        }
        
        #chat-messages {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .message {
            padding: 12px 18px;
            border-radius: 18px;
            max-width: 80%;
            line-height: 1.5;
            font-weight: 500;
            white-space: pre-wrap;
        }

        .user-message {
            background: var(--dark-user-msg);
            color: var(--text-light);
            align-self: flex-end;
            border-bottom-right-radius: 5px;
        }

        .bot-message {
            background-color: var(--pika-yellow);
            color: var(--text-dark);
            align-self: flex-start;
            border-bottom-left-radius: 5px;
        }

        #chat-input-container {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            background-color: var(--dark-surface);
            border-top: 1px solid #2a2a2a;
        }

        #user-input {
            flex-grow: 1;
            border: 2px solid #444;
            background-color: var(--dark-bg);
            color: var(--text-light);
            border-radius: 12px;
            padding: 12px 18px;
            font-size: 1em;
            outline: none;
            transition: border-color 0.2s;
        }
        #user-input:focus {
            border-color: var(--pika-red);
        }

        #send-btn {
            background: var(--pika-red);
            border: none;
            width: 48px;
            height: 48px;
            margin-left: 10px;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: opacity 0.2s ease;
        }
        #send-btn:hover {
            opacity: 0.85;
        }
        #send-btn svg {
            width: 22px;
            height: 22px;
            fill: var(--text-light);
        }
    </style>
</head>
<body>

    <div id="chat-container">
        <div id="chat-header">
            <img id="header-avatar" src="188987.png" alt="Avatar">
            <div id="header-title">PIKACHU Gaming</div>
        </div>
        <div id="chat-messages">
        </div>
        <div id="chat-input-container">
            <input type="text" id="user-input" placeholder="Posez votre question...">
            <button id="send-btn" aria-label="Envoyer">
                <svg viewBox="0 0 24 24">
                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                </svg>
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const userInput = document.getElementById('user-input');
            const sendBtn = document.getElementById('send-btn');
            const chatMessages = document.getElementById('chat-messages');

            function addMessage(message, sender) {
                const messageDiv = document.createElement('div');
                messageDiv.classList.add('message', `${sender}-message`);
                messageDiv.textContent = message;
                chatMessages.appendChild(messageDiv);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            async function sendMessage() {
                const messageText = userInput.value.trim();
                if (messageText === '') return;
                addMessage(messageText, 'user');
                userInput.value = '';
                try {
                    const response = await fetch('', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ message: messageText })
                    });
                    if (!response.ok) throw new Error('Erreur réseau.');
                    const botReply = await response.json();
                    addMessage(botReply.reply, 'bot');
                } catch (error) {
                    console.error('Erreur:', error);
                    addMessage('Désolé, le serveur ne répond pas. Réessayez plus tard.', 'bot');
                }
            }

            sendBtn.addEventListener('click', sendMessage);
            userInput.addEventListener('keypress', (event) => {
                if (event.key === 'Enter') sendMessage();
            });
            
            setTimeout(() => {
                addMessage("Bienvenue, joueur ! Posez-moi une question sur nos produits, horaires ou événements.", 'bot');
            }, 500);
        });
    </script>

</body>
</html>
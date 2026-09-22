<?php $utilisateurConnecte = $_SESSION['utilisateur'] ?? null; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titre ?? 'Vibely') ?> | Vibely</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= strpos($_SERVER['SCRIPT_NAME'], '/public/') !== false ? 'css/style.css' : 'public/css/style.css' ?>">
</head>
<body>
    <div class="app-shell">
        <aside class="sidebar">
            <a class="brand" href="index.php?route=accueil/index"><span class="brand-mark">V</span><span>vibely</span></a>
            <nav class="main-nav" aria-label="Navigation principale">
                <a href="index.php?route=accueil/index">Accueil</a>
                <a href="index.php?route=accueil/explorer">Explorer</a>
                <?php if ($utilisateurConnecte): ?>
                    <a href="index.php?route=playlist/liste">Mes playlists</a>
                    <?php if (($utilisateurConnecte['email'] ?? '') === 'admin@gmail.com'): ?>
                        <a href="index.php?route=morceau/admin">Catalogue</a>
                    <?php endif; ?>
                <?php endif; ?>
            </nav>
            <div class="sidebar-note"><span class="pulse-dot"></span><span>Find your frequency</span></div>
        </aside>
        <main class="page-content">
            <header class="topbar">
                <div class="mobile-brand"><span class="brand-mark">V</span> vibely</div>
                <form class="top-search" action="index.php" method="get">
                    <input type="hidden" name="route" value="accueil/explorer">
                    <span aria-hidden="true">⌕</span>
                    <input type="search" name="q" placeholder="Artiste, titre, ambiance..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                </form>
                <?php if ($utilisateurConnecte): ?>
                    <div class="account-menu"><span class="avatar"><?= strtoupper(substr($utilisateurConnecte['nom'], 0, 1)) ?></span><span><?= htmlspecialchars($utilisateurConnecte['nom']) ?></span><a href="index.php?route=utilisateur/deconnexion">Sortir</a></div>
                <?php else: ?>
                    <a class="button button-ghost" href="index.php?route=utilisateur/connexion">Connexion</a>
                <?php endif; ?>
            </header>
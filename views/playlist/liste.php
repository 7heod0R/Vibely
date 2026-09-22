<?php $playlists = $playlists ?? []; ?>
<section class="section-head"><div><p class="eyebrow">YOUR LIBRARY</p><h1>Mes playlists</h1><p class="muted">Tes sélections, tes règles, ton rythme.</p></div><a href="index.php?route=playlist/creer" class="button button-primary">+ Nouvelle playlist</a></section>
<section class="playlist-grid">
    <?php if (empty($playlists)): ?><div class="empty-state"><span class="empty-icon">♪</span><h2>Ton espace est encore silencieux.</h2><p>Crée ta première playlist et commence à construire ta bande-son.</p><a class="button button-primary" href="index.php?route=playlist/creer">Créer une playlist</a></div>
    <?php else: foreach ($playlists as $playlist): ?>
        <a class="playlist-card" href="index.php?route=playlist/detail&id=<?= (int) $playlist['id'] ?>"><div class="playlist-art art-<?= ((int) $playlist['id'] % 5) + 1 ?>"><span>♫</span></div><div><h2><?= htmlspecialchars($playlist['nom']) ?></h2><p><?= (int) $playlist['nombre_morceaux'] ?> morceau(s)</p></div><span class="card-arrow">↗</span></a>
    <?php endforeach; endif; ?>
</section>
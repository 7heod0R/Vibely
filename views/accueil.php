<?php $moods = $moods ?? []; ?>
<?php $titre = 'Accueil'; ?>
<section class="hero-panel">
    <div class="hero-copy"><p class="eyebrow">WELCOME TO VIBELY</p><h1>La musique qui<br><em>ressemble à ton mood.</em></h1><p class="hero-text">Explore des sons qui suivent ton énergie, puis crée la playlist qui te ressemble.</p><a class="button button-primary" href="index.php?route=accueil/explorer">Explorer les vibes <span>↗</span></a></div>
    <div class="hero-orbit"><div class="orbit-disc"><span>V</span></div><div class="orbit-label label-one">MOOD<br><strong>01</strong></div><div class="orbit-label label-two">PLAY<br><strong>∞</strong></div></div>
</section>
<section class="section-head compact"><div><p class="eyebrow">CHOOSE YOUR ENERGY</p><h2>Quelle est ta vibe aujourd'hui ?</h2></div><a class="text-link" href="index.php?route=accueil/explorer">Tout explorer →</a></section>
<section class="mood-row">
    <?php foreach ($moods as $index => $mood): ?><a class="mood-chip mood-<?= ($index % 5) + 1 ?>" href="index.php?route=accueil/explorer&mood=<?= (int) $mood['id'] ?>"><span class="mood-symbol"><?= ['◒', '✦', '◌', '◉', '◇'][$index % 5] ?></span><span><?= htmlspecialchars($mood['nom']) ?></span></a><?php endforeach; ?>
</section>
<section class="section-head compact"><div><p class="eyebrow">FRESHLY ADDED</p><h2>Dans tes oreilles bientôt</h2></div><a class="text-link" href="index.php?route=accueil/explorer">Voir le catalogue →</a></section>
<section class="track-grid">
    <?php foreach ($morceaux as $index => $morceau): ?><article class="track-card"><div class="cover cover-<?= ($index % 6) + 1 ?>"><span><?= sprintf('%02d', $index + 1) ?></span><button class="play-button" type="button" data-audio="<?= htmlspecialchars($morceau['fichier_audio'] ?? '') ?>" data-title="<?= htmlspecialchars($morceau['titre']) ?>" data-artist="<?= htmlspecialchars($morceau['artiste_nom']) ?>">▶</button></div><div class="track-meta"><div><h3><?= htmlspecialchars($morceau['titre']) ?></h3><p><?= htmlspecialchars($morceau['artiste_nom']) ?></p></div><span class="duration"><?= sprintf('%02d:%02d', intdiv((int)($morceau['duree'] ?? 0), 60), (int)($morceau['duree'] ?? 0) % 60) ?></span></div></article><?php endforeach; ?>
</section>

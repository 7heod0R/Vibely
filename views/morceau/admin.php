<?php $moods = $moods ?? []; ?>
<section class="section-head"><div><p class="eyebrow">ADMIN · CATALOGUE</p><h1>Gérer les morceaux</h1><p class="muted">Modifie plusieurs morceaux puis enregistre tout en une seule fois.</p></div><a href="index.php?route=morceau/creer" class="button button-primary">+ Nouveau morceau</a></section>

<?php if (isset($_GET['ok'])): ?><div class="alert alert-success">Catalogue enregistré.</div><?php endif; ?>

<section class="track-list">
    <?php if (empty($morceaux)): ?>
        <div class="empty-state"><h2>Aucun morceau dans le catalogue.</h2></div>
    <?php else: ?>
        <form class="admin-catalog-form" method="post" action="index.php?route=morceau/admin">
            <?php foreach ($morceaux as $morceau): ?>
                <article class="track-row admin-row">
                    <input type="hidden" name="morceaux[<?= (int) $morceau['id'] ?>][id]" value="<?= (int) $morceau['id'] ?>">
                    <div class="track-row-info">
                        <input type="text" name="morceaux[<?= (int) $morceau['id'] ?>][titre]" value="<?= htmlspecialchars($morceau['titre']) ?>" required maxlength="255" aria-label="Titre">
                        <p><?= htmlspecialchars($morceau['artiste_nom']) ?><?php if ($morceau['moods']): ?> · <?php foreach ($morceau['moods'] as $mood): ?><span class="mood-tag"><?= htmlspecialchars($mood['nom']) ?></span><?php endforeach; ?><?php else: ?> · <span class="mood-tag mood-tag-empty">Aucune catégorie</span><?php endif; ?></p>
                    </div>
                    <input class="duration-input" type="text" name="morceaux[<?= (int) $morceau['id'] ?>][duree]" value="<?= sprintf('%02d:%02d', intdiv((int)($morceau['duree'] ?? 0), 60), (int)($morceau['duree'] ?? 0) % 60) ?>" maxlength="10" aria-label="Durée">
                    <div class="mood-checks">
                        <?php foreach ($moods as $mood): $checked = in_array((int) $mood['id'], array_column($morceau['moods'], 'id'), true); ?>
                            <label class="mood-check"><input type="checkbox" name="morceaux[<?= (int) $morceau['id'] ?>][mood_id][]" value="<?= (int) $mood['id'] ?>" <?= $checked ? 'checked' : '' ?>><span><?= htmlspecialchars($mood['nom']) ?></span></label>
                        <?php endforeach; ?>
                    </div>
                </article>
            <?php endforeach; ?>
            <button class="button button-primary admin-save" type="submit">Enregistrer</button>
        </form>
    <?php endif; ?>
</section>
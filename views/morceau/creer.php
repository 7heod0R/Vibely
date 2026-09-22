<?php $moods = $moods ?? []; ?>
<section class="form-shell"><a class="back-link" href="index.php?route=morceau/admin">← Retour au catalogue</a><p class="eyebrow">NEW TRACK</p><h1>Ajouter un morceau</h1><p class="muted">Renseigne le morceau puis choisis sa ou ses catégories de base.</p>
    <form class="vibely-form" method="post" action="index.php?route=morceau/creer">
        <label>Titre<input type="text" name="titre" placeholder="Ex. Midnight drives" required maxlength="255"></label>
        <label>Artiste<select name="artiste_id" required><option value="">Choisir un artiste</option><?php foreach ($artistes as $artiste): ?><option value="<?= (int) $artiste['id'] ?>"><?= htmlspecialchars($artiste['nom']) ?></option><?php endforeach; ?></select></label>
        <label>Durée<input type="text" name="duree" value="03:24" maxlength="10" placeholder="mm:ss"></label>
        <label>Fichier audio<input type="text" name="fichier_audio" placeholder="audio/demo.mp3"></label>
        <label>Catégories <span class="optional">Plusieurs possibles</span></label>
        <div class="mood-checks">
            <?php foreach ($moods as $mood): ?>
                <label class="mood-check"><input type="checkbox" name="mood_id[]" value="<?= (int) $mood['id'] ?>"><span style="--tag:<?= '' ?>"><?= htmlspecialchars($mood['nom']) ?></span></label>
            <?php endforeach; ?>
        </div>
        <button class="button button-primary" type="submit">Ajouter le morceau <span>↗</span></button>
    </form>
</section>
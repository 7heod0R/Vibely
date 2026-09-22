document.addEventListener('DOMContentLoaded', () => {
    const player = document.createElement('div');
    player.className = 'audio-player';
    player.innerHTML = '<div class="audio-info"><strong>Choisis un morceau</strong><span>Vibely player</span></div><audio controls></audio>' ;
    document.body.appendChild(player);

    document.querySelectorAll('.play-button').forEach((button) => {
        button.addEventListener('click', () => {
            const audio = player.querySelector('audio');
            const title = player.querySelector('strong');
            const artist = player.querySelector('span');
            const source = button.dataset.audio;

            title.textContent = button.dataset.title || 'Morceau Vibely';
            artist.textContent = button.dataset.artist || 'Vibely';
            player.classList.add('active');

            if (source) {
                audio.src = source;
                audio.play().catch(() => {});
            }
        });
    });
});

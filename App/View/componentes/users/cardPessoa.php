<?php
// Normaliza a variável esperada pelo card: aceita $pessoa ou $aluno
if (!isset($pessoa) && isset($aluno)) {
    $pessoa = $aluno;
}

// Evita caso nada tenha sido passado
if (!isset($pessoa) || !is_array($pessoa)) {
    $pessoa = [
        'nome' => 'Sem nome',
        'foto' => '',
        'linkedin' => '#',
        'github' => '#',
        'perfil' => ''
    ];
}

$caminhoFoto = urlImagem($pessoa['foto'] ?? null, 'App/View/assets/img/utilitarios/avatar.png');
?>

<div class="card-container">
    <div class="image-dev">
        <img src="<?= htmlspecialchars($caminhoFoto); ?>" onerror="<?= fallbackImagemOnError('App/View/assets/img/utilitarios/avatar.png') ?>" alt="Foto de <?= htmlspecialchars($pessoa['nome']); ?>">
    </div>
    <div class="text-card">
        <h2><?= htmlspecialchars($pessoa['nome']); ?></h2>
        <?php if($pessoa['perfil'] == 'aluno'): ?>
            <p>Aluno</p>
        <?php elseif($pessoa['perfil'] == 'professor'): ?>
            <p>Professor</p>
        <?php endif; ?>
        <div class="social-icons">
            <a href="<?= htmlspecialchars($pessoa['linkedin'] ?? '#'); ?>" target="_blank">
                <img src="<?= Config::getDirImg() ?>utilitarios/icons8-linkedin-50.png" alt="LinkedIn">
            </a>
            <a href="<?= htmlspecialchars($pessoa['github'] ?? '#'); ?>" target="_blank">
                <img src="<?= Config::getDirImg() ?>utilitarios/icons8-github-50.png" alt="GitHub">
            </a>
        </div>
    </div>
</div>

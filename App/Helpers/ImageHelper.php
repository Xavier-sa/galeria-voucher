<?php

/**
 * Gera a URL completa de uma imagem, aplicando regras de fallback e subpasta.
 * * @param string|null $nomeImagem Nome do arquivo da imagem ou URL completa.
 * @param string $fallback Caminho da imagem padrão caso $nomeImagem não seja informado.
 * @return string URL completa da imagem para exibição.
 */
function urlImagem(?string $nomeImagem, ?string $fallback = 'App/View/assets/img/utilitarios/sem-foto.svg'): string
{
    $fallback = ltrim((string) $fallback, './');
    $nomeImagem = trim((string) $nomeImagem);

    if ($nomeImagem !== '' && filter_var($nomeImagem, FILTER_VALIDATE_URL)) {
        return $nomeImagem;
    }

    $caminho = ltrim($nomeImagem, './');
    $raizProjeto = dirname(__DIR__, 2);
    if ($caminho === '' || !is_file($raizProjeto . '/' . $caminho)) {
        $caminho = $fallback;
    }

    return Config::getAppUrl() . $caminho;
}

/**
 * Retorna um atributo onerror seguro para falhas que só o navegador consegue
 * detectar, como uma imagem externa removida depois da renderização.
 */
function fallbackImagemOnError(?string $fallback = 'App/View/assets/img/utilitarios/sem-foto.svg'): string
{
    $urlFallback = urlImagem(null, $fallback);
    return "this.onerror=null;this.src=" . htmlspecialchars(json_encode($urlFallback), ENT_QUOTES, 'UTF-8') . ';';
}

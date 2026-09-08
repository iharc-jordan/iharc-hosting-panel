<?php
/**
 * Local-only QA fixture for the native Ceasar white-label templates.
 *
 * Run from the repository root:
 *   php -S 127.0.0.1:8099 -t . tools/branding-preview.php
 *
 * The fixture serves the checked-in panel logo at /images/* and renders the
 * actual login and footer templates with two server-owned APP_NAME values.
 */
declare(strict_types=1);

$repositoryRoot = dirname(__DIR__);
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
if (str_starts_with($requestPath, '/images/')) {
    $asset = realpath($repositoryRoot . '/web' . $requestPath);
    $imageRoot = realpath($repositoryRoot . '/web/images');
    if ($asset !== false && $imageRoot !== false && str_starts_with($asset, $imageRoot . DIRECTORY_SEPARATOR) && is_file($asset)) {
        $mime = mime_content_type($asset) ?: 'application/octet-stream';
        header('Content-Type: ' . $mime);
        readfile($asset);
        return true;
    }
    http_response_code(404);
    exit;
}

if (!function_exists('tohtml')) {
    function tohtml(mixed $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
if (!function_exists('_')) {
    function _(string $value): string
    {
        return $value;
    }
}

function renderNativeLogin(string $appName, string $label, string $repositoryRoot): string
{
    $_SESSION = [
        'APP_NAME' => $appName,
        'VERSION' => '1.10.4',
    ];
    $error = '';

    ob_start();
    require $repositoryRoot . '/web/templates/pages/login/login.php';
    $login = (string) ob_get_clean();

    ob_start();
    require $repositoryRoot . '/web/templates/includes/app-footer.php';
    $footer = (string) ob_get_clean();

    return '<article class="preview-card"><p class="preview-label">' . tohtml($label) . '</p>' . $login . $footer . '</article>';
}

$requestedBrand = strtolower((string) ($_GET['brand'] ?? ''));
$variants = $requestedBrand === 'iharc'
    ? [['IHARC Labs Hosting', 'IHARC override']]
    : [['Ceasar Control Panel', 'Default'] , ['IHARC Labs Hosting', 'IHARC override']];

$cards = '';
foreach ($variants as [$appName, $label]) {
    $cards .= renderNativeLogin($appName, $label, $repositoryRoot);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ceasar branding preview</title>
    <style>
        :root { color-scheme: light; font-family: system-ui, sans-serif; }
        body { margin: 0; min-height: 100vh; background: #eef2f7; color: #172033; }
        main { max-width: 1120px; margin: 0 auto; padding: 32px 20px 56px; }
        h1 { margin: 0 0 8px; font-size: 1.7rem; }
        .intro { margin: 0 0 24px; color: #4b5563; }
        .preview-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px; }
        .preview-card { min-height: 540px; border-radius: 12px; overflow: hidden; background: #2b56b1; box-shadow: 0 8px 24px rgb(23 32 51 / 18%); }
        .preview-label { margin: 0; padding: 12px 20px; background: #172033; color: #fff; font-size: .8rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; }
        .preview-card .login { margin: 0; padding: 38px 28px 30px; }
        .preview-card .login > a { display: block; text-align: center; }
        .preview-card .login form { max-width: 300px; margin: 0 auto; }
        .preview-card .login-title { text-align: center; }
        .preview-card .form-label { display: block; margin: 0 0 6px; color: #fff; }
        .preview-card .form-control { box-sizing: border-box; width: 100%; padding: 10px; border: 0; border-radius: 5px; }
        .preview-card .button { padding: 10px 16px; border: 0; border-radius: 5px; background: #fff; color: #172033; font-weight: 700; }
        .preview-card .app-footer { margin-top: 30px; padding: 14px 20px; border-top: 1px solid rgb(255 255 255 / 30%); color: #fff; text-align: center; }
        .preview-card .app-footer p { margin: 0; }
        .preview-card .app-footer-link { color: #fff; font-weight: 700; }
    </style>
</head>
<body>
<main>
    <h1>Native branding preview</h1>
    <p class="intro">Actual panel login and footer templates rendered with the default and server-owned override configurations.</p>
    <section class="preview-grid"><?= $cards ?></section>
</main>
</body>
</html>

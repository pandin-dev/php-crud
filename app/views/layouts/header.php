<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sistema CRUD' ?></title>
    <meta name="description" content="Sistema completo de gerenciamento de usuários com operações CRUD desenvolvido em PHP puro com arquitetura MVC.">
    <meta name="keywords" content="PHP, CRUD, MySQL, Bootstrap, MVC, Sistema de Usuários, Pandin">
    <meta name="author" content="Pandin">
    
    <!-- Open Graph Meta Tags (Facebook) -->
    <meta property="og:title" content="<?= $title ?? 'Sistema CRUD' ?>">
    <meta property="og:description" content="Sistema completo de gerenciamento de usuários com operações CRUD desenvolvido em PHP puro com arquitetura MVC.">
    <meta property="og:image" content="https://pandin.dev/static/media/logo.f9d2a21d43934c936788.webp">
    <meta property="og:url" content="<?= $_SERVER['REQUEST_URI'] ?? '/' ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Sistema CRUD - Pandin">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $title ?? 'Sistema CRUD' ?>">
    <meta name="twitter:description" content="Sistema completo de gerenciamento de usuários com operações CRUD desenvolvido em PHP puro com arquitetura MVC.">
    <meta name="twitter:image" content="https://pandin.dev/static/media/logo.f9d2a21d43934c936788.webp">
    <meta name="twitter:creator" content="@pandin">
    
    <link rel="icon" type="image/x-icon" href="https://pandin.dev/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/"><i class="fas fa-users"></i> Sistema CRUD</a>
            <div class="navbar-nav">
                <a class="nav-link" href="/">Home</a>
                <a class="nav-link" href="/users">Usuários</a>
                <a class="nav-link" href="/xml"><i class="fas fa-file-code"></i> XML</a>
                <a class="nav-link" href="/logs"><i class="fas fa-clipboard-list"></i> Logs</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['success'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['error'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

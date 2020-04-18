<?php require KAT_GLOWNY . '/widoki/szablony/naglowek.php'; ?>
<div class="container mt-3 mb-3">
    <h1><?php echo $dane['post']->tytul; ?></h1>
    <div class="p-2 mb-3">
        Napisane przez <?php echo $dane['uzytkownik']->imie; ?> <?php echo $dane['uzytkownik']->nazwisko; ?> w dniu <?php echo $dane['post']->data_utworzenia; ?>
    </div>
    <pre>
        <?php echo $dane['post']->tekst; ?>
    </pre>

    <h4>Komentarze (0)</h4>
</div>
<?php require KAT_GLOWNY . '/widoki/szablony/stopka.php'; ?>
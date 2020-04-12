<?php require KAT_GLOWNY . '/widoki/szablony/naglowek.php'; ?>
    <div class="container mt-4 mb-4">
    <?php echo wyswietlPowiadomienie('uzytkownik_powiadomienie'); ?>
        <div class="row text-center">
            <?php if ($dane['id'] === $_SESSION['id_uzytkownika']) : ?>
            <div class="col-md-4">
                <h2>Twój profil</h2>
                <img class="images" src="<?php echo $dane['gravatar']; ?>" alt="Awatar" width="150" height="150">
                <h4 class="text-center"><?php echo $dane['uzytkownik']->imie; ?> <?php echo $dane['uzytkownik']->nazwisko; ?></h4>
                <span id="nazwa_uzytkownika" class="text-center">@<?php echo $dane['uzytkownik']->nazwa_uzytkownika; ?></span>
            </div>
            <div class="col-md-8">
                <h2>Posty</h2>
                <p>Nie masz jeszcze żadnych postów. :( 
                    Stwórz swój pierwszy post i niech świat się dowie, co Ci w głowie siedzi!</p>
            </div>
            <?php else : ?>
            <div class="col-md-4">
                <h2>Profil użytkownika</h2>
                <img class="images" src="<?php echo $dane['gravatar']; ?>" alt="Awatar" width="150" height="150">
                <h4 class="text-center"><?php echo $dane['uzytkownik']->imie; ?> <?php echo $dane['uzytkownik']->nazwisko; ?></h4>
                <span id="nazwa_uzytkownika" class="text-center">@<?php echo $dane['uzytkownik']->nazwa_uzytkownika; ?></span>
            </div>
            <div class="col-md-8">
                <h2>Posty</h2>
                <p>Ten użytkownik jeszcze nic nie opublikował.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
<?php require KAT_GLOWNY . '/widoki/szablony/stopka.php'; ?>
<?php require KAT_GLOWNY . '/widoki/szablony/naglowek.php'; ?>
    <div class="container mt-4 mb-4">
    <?php echo wyswietlPowiadomienie('uzytkownik_powiadomienie'); ?>
        <div class="row">
            <div class="col-md-4">
                <h2>Twój profil</h2>
                <img class="images" src="<?php echo KAT_GLOWNY; ?>/public/img/log.png" alt="Awatar" width="250" height="250">
                <h4 class="text-center"><?php echo $dane['uzytkownik']->imie; ?> <?php echo $dane['uzytkownik']->nazwisko; ?></h4>
                <span id="nazwa_uzytkownika" class="text-center">@<?php echo $dane['uzytkownik']->nazwa_uzytkownika; ?></span>
            </div>
            <div class="col-md-8">
                <h2>Posty</h2>
                <p>Nie masz jeszcze żadnych postów. :( 
                    Stwórz swój pierwszy post i niech świat się dowie, co Ci w głowie siedzi!</p>
            </div>
        </div>
    </div>
<?php require KAT_GLOWNY . '/widoki/szablony/stopka.php'; ?>
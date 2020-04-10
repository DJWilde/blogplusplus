<?php require KAT_GLOWNY . '/widoki/szablony/naglowek.php'; ?>
    <div class="container mt-3 text-center">
        <h1>Lista użytkowników</h1>
        <p>Jeśli szukasz swojego ulubionego blogera, możesz go znaleźć właśnie tu!</p>
        <form action="<?php echo URL_GLOWNE; ?>/uzytkownicy/logowanie" method="POST">
            <div class="form-group">
                <input type="email" id="email" name="email" class="form-control" 
                placeholder="Wpisz imię i nazwisko" value="<?php echo $dane['wpisany_uzytkownik']; ?>" />
            </div>
        </form>
    </div>
    <div class="container m-auto">
        <?php foreach ($dane['uzytkownicy'] as $uzytkownik) : ?>
            <hr>
            <img class="images" src="<?php echo KAT_GLOWNY; ?>/public/img/log.png" alt="Awatar" width="100" height="100">
            <h4><?php echo $uzytkownik->imie; ?> <?php echo $uzytkownik->nazwisko; ?></h4>
        <?php endforeach; ?>
    </div>
<?php require KAT_GLOWNY . '/widoki/szablony/stopka.php'; ?>
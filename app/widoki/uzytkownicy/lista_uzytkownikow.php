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
    <div class="container">
        <?php foreach ($dane['uzytkownicy'] as $uzytkownik) : ?>
            <hr>
            <div class="row">
                <div class="col-md-2">
                    <img class="images" src="<?php echo gravatar($uzytkownik->email); ?>" alt="Awatar" width="100" height="100">
                </div>
                <div class="col-md-10 mt-3">
                    <a href="<?php echo URL_GLOWNE; ?>/uzytkownicy/panel_glowny/<?php echo $uzytkownik->id; ?>"><h4><?php echo $uzytkownik->imie; ?> <?php echo $uzytkownik->nazwisko; ?></h4></a>
                    <span id="nazwa_uzytkownika" class="text-center">@<?php echo $uzytkownik->nazwa_uzytkownika; ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php require KAT_GLOWNY . '/widoki/szablony/stopka.php'; ?>
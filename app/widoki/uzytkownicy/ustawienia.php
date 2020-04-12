<?php require KAT_GLOWNY . '/widoki/szablony/naglowek.php'; ?>
<div class="container mt-3 mb-3">
    <div class="row mt-5">
        <div class="col-md-8 m-auto">
            <div class="card card-body">
            <h1 class="text-center mb-3">
                <i class="fa fa-gears"></i> Ustawienia
            </h1>
            <?php wyswietlPowiadomienie('rejestracja_powiadomienie'); ?>
            <form action="<?php echo URL_GLOWNE; ?>/uzytkownicy/ustawienia/<?php echo $dane['id']; ?>" method="POST">
                <div class="form-group">
                    <label for="nazwa_uzytkownika">Nazwa użytkownika</label>
                    <input type="nazwa_uzytkownika" id="nazwa_uzytkownika" name="nazwa_uzytkownika" 
                    class="form-control <?php echo (!empty($dane['blad_nazwa_uzytkownika'])) ? 'is-invalid' : ''; ?>" 
                    placeholder="Wpisz nazwę użytkownika" value="<?php echo $dane['nazwa_uzytkownika']; ?>" />
                    <span class="invalid-feedback"><?php echo $dane['blad_nazwa_uzytkownika']; ?></span>
                </div>
                <div class="form-group">
                    <label for="imie">Imię</label>
                    <input type="imie" id="imie" name="imie" class="form-control <?php echo (!empty($dane['blad_imie'])) ? 'is-invalid' : ''; ?>" 
                    placeholder="Wpisz imię" value="<?php echo $dane['imie']; ?>" />
                    <span class="invalid-feedback"><?php echo $dane['blad_imie']; ?></span>
                </div>
                <div class="form-group">
                    <label for="nazwisko">Nazwisko</label>
                    <input type="nazwisko" id="nazwisko" name="nazwisko" class="form-control <?php echo (!empty($dane['blad_nazwisko'])) ? 'is-invalid' : ''; ?>" 
                    placeholder="Wpisz nazwisko" value="<?php echo $dane['nazwisko']; ?>" />
                    <span class="invalid-feedback"><?php echo $dane['blad_nazwisko']; ?></span>
                </div>
                <div class="form-group">
                    <label for="email">Adres e-mail</label>
                    <input type="email" id="email" name="email" class="form-control <?php echo (!empty($dane['blad_email'])) ? 'is-invalid' : ''; ?>" 
                    placeholder="Wpisz adres e-mail" value="<?php echo $dane['email']; ?>" />
                    <span class="invalid-feedback"><?php echo $dane['blad_email']; ?></span>
                </div>
                <div class="form-group">
                    <label for="haslo">Nowe hasło (opcjonalnie)</label>
                    <input type="password" id="haslo" name="haslo" class="form-control <?php echo (!empty($dane['blad_haslo'])) ? 'is-invalid' : ''; ?>" 
                    placeholder="Wpisz nowe hasło" value="<?php echo $dane['haslo']; ?>" />
                    <span class="invalid-feedback"><?php echo $dane['blad_haslo']; ?></span>
                </div>
                <div class="form-group">
                    <label for="potwierdzenie_hasla">Potwierdź nowe hasło (opcjonalnie)</label>
                    <input type="password" id="potwierdzenie_hasla" name="potwierdzenie_hasla" class="form-control <?php echo (!empty($dane['blad_potwierdzenie_hasla'])) ? 'is-invalid' : ''; ?>" 
                    placeholder="Potwierdź swoje nowe hasło" value="<?php echo $dane['potwierdzenie_hasla']; ?>" />
                    <span class="invalid-feedback"><?php echo $dane['blad_potwierdzenie_hasla']; ?></span>
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                    Aktualizuj ustawienia
                </button>
            </form>
            </div>
        </div>
    </div>
</div>
<?php require KAT_GLOWNY . '/widoki/szablony/stopka.php'; ?>
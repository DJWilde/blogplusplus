<?php require KAT_GLOWNY . '/widoki/szablony/naglowek.php'; ?>
<div class="container mt-3 mb-3">
    <?php wyswietlPowiadomienie('logowanie_powiadomienie'); ?>
    <div class="row mt-5">
        <div class="col-md-8 m-auto">
            <div class="card card-body">
            <h1 class="text-center mb-3">
                <i class="fas fa-sign-in-alt"></i> Zaloguj się
            </h1>
            <?php wyswietlPowiadomienie('logowanie_niepowodzenie'); ?>
            <form action="<?php echo URL_GLOWNE; ?>/uzytkownicy/logowanie" method="POST">
                <div class="form-group">
                    <label for="email">Adres e-mail</label>
                    <input type="email" id="email" name="email" class="form-control <?php echo (!empty($dane['blad_email'])) ? 'is-invalid' : ''; ?>" 
                    placeholder="Wpisz adres e-mail" value="<?php echo $dane['email']; ?>" />
                    <span class="invalid-feedback"><?php echo $dane['blad_email']; ?></span>
                </div>
                <div class="form-group">
                    <label for="haslo">Hasło</label>
                    <input type="password" id="haslo" name="haslo" class="form-control <?php echo (!empty($dane['blad_haslo'])) ? 'is-invalid' : ''; ?>" 
                    placeholder="Wpisz hasło" value="<?php echo $dane['haslo']; ?>" />
                    <span class="invalid-feedback"><?php echo $dane['blad_haslo']; ?></span>
                </div>
                <input type="hidden" name="token_csrf" value="<?php echo generujTokenCsrf('formularz_logowania'); ?>">
                <button type="submit" class="btn btn-primary btn-block">
                    Zaloguj się!
                </button>
            </form>
            <p class="lead mt-4">Nie masz jeszcze konta? <a href="<?php echo URL_GLOWNE; ?>/uzytkownicy/rejestracja">Zarejestruj się!</a></p>
            </div>
        </div>
    </div>
</div>
<?php require KAT_GLOWNY . '/widoki/szablony/stopka.php'; ?>
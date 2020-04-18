<?php require KAT_GLOWNY . '/widoki/szablony/naglowek.php'; ?>
<div class="container mt-3 mb-3">
    <div class="row mt-5">
        <div class="col-md-10 m-auto">
            <div class="card card-body">
            <h1 class="text-center mb-3">
                <i class="fas fa-edit"></i> Dodaj post
            </h1>
            <?php wyswietlPowiadomienie('posty_powiadomienie'); ?>
            <form action="<?php echo URL_GLOWNE; ?>/posty/dodaj" method="POST">
                <div class="form-group">
                    <label for="tytul">Tytuł</label>
                    <input type="text" id="tytul" name="tytul" 
                    class="form-control <?php echo (!empty($dane['blad_tytul'])) ? 'is-invalid' : ''; ?>" 
                    placeholder="Wpisz nazwę użytkownika" value="<?php echo $dane['tytul']; ?>" />
                    <span class="invalid-feedback"><?php echo $dane['blad_tytul']; ?></span>
                </div>
                <div class="form-group">
                    <label for="tekst">Tekst</label>
                    <textarea name="tekst" id="tekst" class="form-control <?php echo (!empty($dane['blad_tekst'])) ? 'is-invalid' : ''; ?>" 
                    cols="30" rows="10"><?php echo $dane['tekst']; ?></textarea>
                    <span class="invalid-feedback"><?php echo $dane['blad_tekst']; ?></span>
                </div>
                <input type="hidden" name="token_csrf" value="<?php echo generujTokenCsrf('formularz_dodanie_postow'); ?>">
                <button type="submit" class="btn btn-primary btn-block">
                    Dodaj post
                </button>
            </form>
            </div>
        </div>
    </div>
</div>
<?php require KAT_GLOWNY . '/widoki/szablony/stopka.php'; ?>
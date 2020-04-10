
    <nav class="navbar navbar-expand-lg navbar-expand-md navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="<?php echo URL_GLOWNE; ?>">Blog++</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URL_GLOWNE; ?>/strony/o_nas">O nas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URL_GLOWNE; ?>/strony/pomoc">Pomoc</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URL_GLOWNE; ?>/strony/kontakt">Kontakt</a>
                    </li>
                    <?php if (isset($_SESSION['id_uzytkownika'])) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL_GLOWNE; ?>/uzytkownicy/lista_uzytkownikow">Użytkownicy</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo $_SESSION['imie'] . ' ' . $_SESSION['nazwisko']; ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="<?php echo URL_GLOWNE; ?>/uzytkownicy/panel_glowny/<?php echo $_SESSION['id_uzytkownika']; ?>">Zobacz profil</a>
                                <a class="dropdown-item" href="#">Ustawienia</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?php echo URL_GLOWNE; ?>/uzytkownicy/wyloguj">Wyloguj się</a>
                            </div>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL_GLOWNE; ?>/uzytkownicy/rejestracja" role="button">Rejestracja</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-light" href="<?php echo URL_GLOWNE; ?>/uzytkownicy/logowanie" role="button">Zaloguj się</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

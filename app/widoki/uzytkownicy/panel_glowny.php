<?php require KAT_GLOWNY . '/widoki/szablony/naglowek.php'; ?>
    <div class="container mt-4 mb-4">
    <?php echo wyswietlPowiadomienie('uzytkownik_powiadomienie'); ?>
        <div class="row">
            <?php if ($dane['uzytkownik']->id === $_SESSION['id_uzytkownika']) : ?>
            <div class="col-md-4 text-center">
                <h2>Twój profil</h2>
                <img class="images" src="<?php echo $dane['gravatar']; ?>" alt="Awatar" width="150" height="150">
                <h4 class="text-center"><?php echo $dane['uzytkownik']->imie; ?> <?php echo $dane['uzytkownik']->nazwisko; ?></h4>
                <span id="nazwa_uzytkownika" class="text-center">@<?php echo $dane['uzytkownik']->nazwa_uzytkownika; ?></span>
            </div>
            <div class="col-md-8">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h2>Posty (<?php echo $dane['ilosc_postow']; ?>)</h2>
                    </div>
                    <div class="col-md-6">
                        <a href="<?php echo URL_GLOWNE; ?>/posty/dodaj" class="btn btn-outline-primary float-right">
                            <i class="fa fa-pencil"></i> Dodaj post
                        </a>
                    </div>
                </div>
                <div class="row mb-3">
                <?php if ($dane['ilosc_postow'] > 0) : ?>
                    <?php foreach ($dane['posty'] as $post) : ?>
                            <div class="card card-body mb-3">
                                <h4 class="card-title"><?php echo $post->tytul; ?></h4>
                                <small><span class="date">Napisano dnia: <?php echo $post->data_utworzenia; ?></span></small>
                                <p class="card-text mb-3"><?php echo $post->tekst; ?></p>
                                <small>0 komentarzy</small>
                                <hr>
                                <?php if ($post->id_uzytkownika === $_SESSION['id_uzytkownika']) : ?>
                                    <div class="row p-3">
                                        <a href="<?php echo URL_GLOWNE; ?>/posty/post/<?php echo $post->id_posta; ?>" class="btn btn-outline-secondary"><i class="far fa-file-alt"></i> Czytaj więcej</a>
                                        <a href="#" class="ml-2 btn btn-outline-secondary"><i class="far fa-edit"></i> Edytuj</a>
                                        <form method="post">
                                            <input type="submit" value="Usuń" class="ml-2 btn btn-outline-danger">
                                        </form>
                                    </div>
                                <?php else : ?>
                                    <div class="row mt-3">
                                        <a href="<?php echo URL_GLOWNE; ?>/posty/post/<?php echo $post->id_posta; ?>" class="ml-3 btn btn-outline-secondary"><i class="far fa-file-alt"></i> Czytaj więcej</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                    <?php endforeach; ?>
                </div>
                <?php else : ?>
                    <p>Nie masz jeszcze żadnych postów. :( Stwórz swój pierwszy post i niech świat się dowie, co Ci w głowie siedzi!</p>
                <?php endif; ?>
            </div>
            <?php else : ?>
            <div class="col-md-4 text-center">
                <h2>Profil użytkownika</h2>
                <img class="images" src="<?php echo $dane['gravatar']; ?>" alt="Awatar" width="150" height="150">
                <h4 class="text-center"><?php echo $dane['uzytkownik']->imie; ?> <?php echo $dane['uzytkownik']->nazwisko; ?></h4>
                <span id="nazwa_uzytkownika" class="text-center">@<?php echo $dane['uzytkownik']->nazwa_uzytkownika; ?></span>
            </div>
            <div class="col-md-8">
                <h2>Posty (<?php echo $dane['ilosc_postow']; ?>)</h2>
                <?php if ($dane['ilosc_postow'] > 0) : ?>
                    <?php foreach ($dane['posty'] as $post) : ?>
                        <div class="card card-body mb-3">
                            <h4 class="card-title"><?php echo $post->tytul; ?></h4>
                            <small><span class="date">Napisano dnia: <?php echo $post->data_utworzenia; ?></span></small>
                            <p class="card-text mb-3"><?php echo $post->tekst; ?></p>
                            <small>0 komentarzy</small>
                            <hr>
                            <?php if ($post->id_uzytkownika === $_SESSION['id_uzytkownika']) : ?>
                                    <div class="row p-3">
                                        <a href="<?php echo URL_GLOWNE; ?>/posty/post/<?php echo $post->id_posta; ?>" class="btn btn-outline-secondary"><i class="far fa-file-alt"></i> Czytaj więcej</a>
                                        <a href="#" class="ml-2 btn btn-outline-secondary"><i class="far fa-edit"></i> Edytuj</a>
                                        <form method="post">
                                            <input type="submit" value="Usuń" class="ml-2 btn btn-outline-danger">
                                        </form>
                                    </div>
                                <?php else : ?>
                                    <div class="row mt-3">
                                        <a href="<?php echo URL_GLOWNE; ?>/posty/post/<?php echo $post->id_posta; ?>" class="ml-3 btn btn-outline-secondary"><i class="far fa-file-alt"></i> Czytaj więcej</a>
                                    </div>
                                <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>Ten użytkownik jeszcze nic nie opublikował.</p>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
<?php require KAT_GLOWNY . '/widoki/szablony/stopka.php'; ?>
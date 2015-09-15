<!-- OFF CANVAS SECTIONS WRAPPING THE MAIN CONTENT -->
<div class="off-canvas-wrap" data-offcanvas>
    <div class="inner-wrap">

        <!-- OFF CANVAS MENU BAR -->
        <nav class="tab-bar hide-for-medium-up">

            <section class="left-small">
                <a class="left-off-canvas-toggle menu-icon" ><span></span></a>
            </section>

            <section class="right tab-bar-section">
                <h1 class="title">Ma Cave</h1>
            </section>

        </nav>

        <!-- OFF CANVAS MENU -->
        <aside class="left-off-canvas-menu">
            <ul class="off-canvas-list">
                <?php
                    if (Session::isConnected())
                    {
                ?>
                        <li><label>jgthibault</label></li>
                        <li><a href="list_vin.html">Mes Vins</a></li>
                        <li><a href="vin.html">Ajouter</a></li>
                        <li><a href="param.html">Paramètres</a></li>
                        <li><a href="param.html">Déconnexion</a></li>
                <?php
                    }
                else
                    {
                ?>
                        <li><label>Ma Cave</label></li>
                        <li><a href="#">Connexion</a></li>
                <?php
                    }
                ?>

            </ul>
        </aside>
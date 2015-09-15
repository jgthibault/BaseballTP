<?php
    if(isset($_POST["username"]))
    {
        $session = new Session("jgthibault", $mySql);
    }
    if (Session::isConnected())
    {
        echo "Vous êtes déjà connecté en tant que jgthibault";
    }
    else
    {
?>
        <form>
            <div class="row">
                <div class="small-12 medium-6 columns">
                    <label>Nom d'utilisateur</label>
                    <input type="text" name="username"/>
                </div>
            </div>
            <div class="row">
                <div class="small-12 medium-6 columns">
                    <label>Mot de passe</label>
                    <input type="password" id="password"/>
                </div>
            </div>
            <div class="row">
                <div class="small-8 medium-3 columns">
                    <input id="chkStayConnected" type="checkbox">
                    <label for="chkStayConnected">Rester connecter</label>
                </div>
                <div class="small-4 medium-3 columns end">
                    <a role="button" aria-label="submit form" href="#" onclick="$(this).closest('form').submit()" class="right button">Connecter</a>
                </div>
            </div>
        </form>
<?php
    }
?>
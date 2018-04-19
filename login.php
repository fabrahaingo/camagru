<!DOCTYPE html>
<div id="general_login">
    <a href="index.php">
        <div id="empty_header">
            <span>Camagru</span>
        </div>
    </a>
    <div id="login_div">
        <div id="login_space">
            <div id="login_form">
                <?php include "./functions/create_account.php"; ?>
                <form>
                    <input type="text" name="login" value="" placeholder="Email ou Identifiant" autofocus></input>
                    <input type="password" name="password" value="" placeholder="Mot de passe"></input>
                    <div id="login_links">
                        <a href="#">Mot de passe oublié</a>
                        <a href="index.php?action=register">Devenir membre</a>
                    </div>
                    <button type="submit" name="submit">SE CONNECTER</button>
                </form>
            </div>
        </div>
    </div>
    <div id="scroll_to_see">
        <span>&darr; &nbsp; &nbsp; &nbsp; Descendez pour admirer la galerie &nbsp; &nbsp; &nbsp; &darr;</span>
    </div>
</div>

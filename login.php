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
                    <input type="text" name="login" value="" placeholder="Email or Username" autofocus></input>
                    <input type="password" name="password" value="" placeholder="Password"></input>
                    <div id="login_links">
                        <a href="#">I forgot my password</a>
                        <a href="index.php?action=register">Register</a>
                    </div>
                    <button type="submit" name="submit">CONNECT</button>
                </form>
            </div>
        </div>
    </div>
    <div id="scroll_to_see">
        <span>&darr; &nbsp; &nbsp; &nbsp; Scroll down to see the gallery &nbsp; &nbsp; &nbsp; &darr;</span>
    </div>
</div>

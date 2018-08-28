<!DOCTYPE html>
<div id="general_login">
    <div id="empty_header">
        <a href="index.php"><span>Camagru</span></a>
    </div>
    <div id="login_div">
        <div id="login_space">
            <div id="login_form">
                <?php include "./functions/create_account.php"; ?>
                <?php include "./functions/login.php"; ?>
                <form action="index.php" method="POST">
                    <input type="text" name="login" value="" placeholder="Email or Username" autofocus required></input>
                    <input type="password" name="password" value="" placeholder="Password" required></input>
                    <div id="login_links">
                        <a href="index.php?action=forgot">I forgot my password</a>
                        <a href="index.php?action=register">Register</a>
                    </div>
                    <button type="submit" name="connect">CONNECT</button>
                </form>
            </div>
        </div>
    </div>
    <div id="scroll_to_see">
        <span>&darr; &nbsp; &nbsp; &nbsp; Scroll down to see the gallery &nbsp; &nbsp; &nbsp; &darr;</span>
    </div>
</div>

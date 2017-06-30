<?php
session_start();

define("ROOT", dirname(__FILE__));

include_once(ROOT . '/.config.php');

function isPrincipalKnown($principal) {
    if ($principal == SHARED_SECRET_USER) {
        return true;
    }

    if (0 !== strpos($principal, '0x')) {
        return false;
    }

    $dir = new DirectoryIterator(DATA_DIR);

    foreach ($dir as $fileinfo) {
	if ($fileinfo->isDot() || (0 === strpos($fileinfo->getFilename(), "."))) 
            $content = file_get_contents($fileinfo->getPathname());

            preg_match_all("/ethminer.*-O (\w+)\/.*/", $content, $matches, PREG_SET_ORDER);

            foreach ($matches as $match) {
                if ($match[1] == $principal) {
                    return true;
                }
            }
        }
    }
}

if (isset($_POST['principal'])) {
    $principal = $_POST['principal'];

    if (isPrincipalKnown($principal)) {
        $_SESSION['authenticated'] = true;
    }
}
?>
<html><head><title>Schekelschwein</title></head><body>
<h1>Schekelschwein</h1>

<?php
if (!isset($_SESSION['authenticated'])) {
?>
<form method="post">
    Your wallet key (0x...) or the shared secret. Please note that you can only login with your public wallet key when your account is currently mined:
    <br /><input type="text" name="principal" />
    <input type="submit" value="Login" />
</form>

<?php }
else {
    if (!file_exists(DATA_DIR)) {
        die("Data directory does not exist");
    }

    $dir = new DirectoryIterator(DATA_DIR);
    $hosts = 0;

    foreach ($dir as $fileinfo) {
	if ($fileinfo->isDot() || (0 === strpos($fileinfo->getFilename(), "."))) 
            continue;
        }

        echo "<h2>" . $fileinfo->getFilename() . "</h2>";
        echo "<pre>";
        echo htmlentities(file_get_contents($fileinfo->getPathname()));
        echo "</pre>";
        $hosts++;
    }

    if ($hosts == 0) {
        echo "<h3>No Schekelschwein has committed data</h3>";
    }
}
?>
</body>
</html>

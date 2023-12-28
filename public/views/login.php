<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="public/css/login.css">
    <title>Login page</title>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="public/img/logo.svg" alt="logo-image">
        </div>
        <div class="login-container">
            <form class="login" action="login" method="POST">
                <div class="messages">
                    <?php if(isset($messages))
                        {
                            foreach ($messages as $message)
                            {
                                echo $message;
                            }
                        }
                        ?>
                </div>
                <input name="email" type="text" placeholder="email@email.com">
                <input name="password" type="password" placeholder="password">
                <button type="submit">Log in</button>
            </form>
        </div>
    </div>
</body>
</html>
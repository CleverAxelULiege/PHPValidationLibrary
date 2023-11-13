

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <form action="./post_form.php" method="post">
        <div>
            <label for="lastname">Entrez votre nom <i>*</i></label>
        </div>
        <div>
            <input type="text" id="lastname" name="lastname">
        </div>
        <hr>
        <div>
            <label for="firstname">Entrez votre prénom <i>*</i></label>
        </div>
        <div>
            <input type="text" id="firstname" name="firstname">
        </div>
        <hr>
        <div>
            <label for="birthdate">Entrez votre date de naissance</label>
        </div>
        <div>
            <input type="text" id="birthdate" name="birthdate" placeholder="aaaa/mm/jj">
        </div>
        <hr>
        <div>
            <label for="phone_number">Entrez votre numéro de téléphone (doit être belge) <i>*</i></label>
        </div>
        <div>
            <input type="text" id="phone_number" name="phone_number">
        </div>
        <div>
            <label for="email">Entrez votre e-mail <i>*</i></label>
        </div>
        <div>
            <input type="text" id="email" name="email">
        </div>
        <hr>
        <div>
            <label for="national_number">Entrez votre numéro de registre national : (ex : 42.01.22.051-81, 85 07 30 033 28, 17 07 30 033 84) <i>*</i></label>
        </div>
        <div>
            <input type="text" id="national_number" name="national_number">
        </div>

        <hr>

        <div>
            <label for="start_time">Votre heure de début (min : 08:00)<i>*</i></label>
        </div>
        <div>
            <input type="text" id="start_time" name="start_time" placeholder="hh:mm">
        </div>

        <div>
            <label for="end_time">Votre heure de fin (max : 17:30) <i>*</i></label>
        </div>
        <div>
            <input type="text" id="end_time" name="end_time" placeholder="hh:mm">
        </div>

        <hr>

        <div>
            <label for="start_date">Votre date de début (max. 2 ans à partir d'aujourd'hui) <i>*</i></label>
        </div>
        <div>
            <input type="text" id="start_date" name="start_date" placeholder="aaaa/mm/dd">
        </div>
        <div>
            <label for="end_date">Votre date de fin (laissez-vide si vous ne savez pas encore, max. 2 ans à partir d'aujourd'hui)</label>
        </div>
        <div>
            <input type="text" id="end_date" name="end_date" placeholder="aaaa/mm/dd">
        </div>

        <hr>
        <input type="submit" value="ENVOYER">

        

    </form>
</body>
</html>
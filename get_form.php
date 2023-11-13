<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire test</title>
</head>

<body>
    <form action="./post_form.php" method="post">
        <div>
            <label for="">Votre nom :</label>
            <input type="text" name="name">
        </div>
        <div>
            <label for="">Votre date de naissance : (année/mois/jour) 1985/07/30</label>
            <input type="text" name="birth_date">
        </div>
        <div>
            <label for="">Votre numéro de téléphone :</label>
            <input type="text" name="phone_number">
        </div>
        <div>
            <label for="">Votre numéro national : (ex : 85 07 30 033 28)</label>
            <input type="text" name="national_number">
        </div>
        <div>
            <label for="">Votre IBAN : ex : (BE68 5390 0754 7034)</label>
            <input type="text" name="IBAN_number">
        </div>
        <div>
            <label for="">Heure de commencement (min 08:00) :</label>
            <input type="text" name="start_time">
        </div>
        <div>
            <label for="">Heure de fin (max 18:00) :</label>
            <input type="text" name="end_time">
        </div>
        <div>
            <input type="submit" value="envoyer">
        </div>
    </form>

</body>

</html>
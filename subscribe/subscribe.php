<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.0/css/mdb.min.css" rel="stylesheet">

    <link href="./css/style.css" rel="stylesheet">

    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>


<!-- Material form register -->
<form method="post" id="subscribe">
    <?php include 'bdd.php';
    ?>
    <p class="h4 text-center mb-4">Inscription</p>

    <!-- Material input text -->
    <div class="md-form">
        <i class="fa fa-user prefix grey-text"></i>
        <input type="text" id="materialFormRegisterNameEx" name="nom" class="form-control">
        <label for="materialFormRegisterNameEx">Nom</label>
    </div>

    <!-- Material input email -->
    <div class="md-form">
        <i class="fa fa-envelope prefix grey-text"></i>
        <input type="email" id="materialFormRegisterFirstname" name="prenom" class="form-control">
        <label for="materialFormRegisterFirstname">Prenom</label>
    </div>

    <!-- Material input email -->
    <div class="md-form">
        <i class="fa fa-exclamation-triangle prefix grey-text"></i>
        <input type="email" id="materialFormRegisterEmail" name="email" class="form-control">
        <label for="materialFormRegisterEmail">Email</label>
    </div>

    <!-- Material input password -->
    <div class="md-form">
        <i class="fa fa-lock prefix grey-text"></i>
        <input type="password" id="materialFormRegisterPasswordEx" name="password" class="form-control">
        <label for="materialFormRegisterPasswordEx">Mot de passe</label>
    </div>

    <!-- Material input Level -->
    <div class="md-form">
        <select class="mdb-select">
            <option value="" disabled selected>Niveau</option>
            <option value="debutant">Débutant</option>
            <option value="intermediaire">Intermédiaire</option>
            <option value="expert">Expert</option>
        </select>
    </div>

    <!-- Material input Ville -->
    <div class="md-form">
        <input type="text" id="recherche" />

        <?php

        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $niveau = $_POST['niveau'];
        $ville = $_POST['ville'];

        if (isset($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['password'], $_POST['niveau'], $_POST['ville'])) {

            if ($nom && $prenom && $email && $password && $niveau && $ville) {

                $query = $bdd->prepare('INSERT INTO joueur ( id,nom,prenom,email,motDePasse,idVille,niveau) VALUES (NULL, :nom, :prenom, :email, :password, :niveau, :ville  ');
                $query->bindValue('nom', $_POST['nom'], PDO::PARAM_STR);
                $query->bindValue('prenom', $_POST['prenom'], PDO::PARAM_STR);
                $query->bindValue('email', $_POST['email'], PDO::PARAM_STR);
                $query->bindValue('password', $_POST['password'], PDO::PARAM_STR);
                $query->bindValue('niveau', $_POST['niveau'], PDO::PARAM_STR);
                $query->bindValue('ville', $_POST['ville'], PDO::PARAM_STR);
                $query->execute();

            }


        } else echo "Veuillez saisir tous les champs";
        $stmt = $bdd->query("SELECT * FROM ville ORDER BY nom");


        while ($row = $stmt->fetch()) {

            //  echo "<option value=".$row["idVille"] .">" . $row["nom"] . "</option>";
            // echo "<option style='display: none' value=" . $row['nom'] . "></option>";

        }

        ?>
        <!-- boucle for ici -->
        </select>
    </div>

    <div class="text-center mt-4">
        <button class="btn btn-primary" type="submit">Envoyer</button>
    </div>
</form>
<!-- Material form register -->

</body>

<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.0/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.0/js/mdb.min.js"></script>

<script
    src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
    integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
    crossorigin="anonymous"></script>

</html>
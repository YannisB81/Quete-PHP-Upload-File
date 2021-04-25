<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <?php 
        if($_SERVER["REQUEST_METHOD"] === "POST" ){
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $age = $_POST['age'];
            $fileName = $_FILES['avatar']['name'];
            $uploadDir = 'uploads/';
            $maxFileSize = 1000000;
            $errors = [];
            $extensions_ok = ['jpg','webp','png'];
            $extension = pathinfo($fileName, PATHINFO_EXTENSION);
            $tmpFile = $_FILES['avatar']['tmp_name'];
            
            
            if ((!in_array($extension, $extensions_ok)))
            {
                $errors[] = 'Veuillez sélectionner une image de type Jpg ou Webp ou Png !';
            }
            if (file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize)
            {
                $errors[] = "Votre fichier doit faire moins de 1M !";
            }
            if (empty($errors)) {
                $uniqFile = uniqid('', true) . '.' . $extension;
                $uploadFile = $uploadDir . $uniqFile;
                move_uploaded_file($tmpFile, $uploadFile);
            } else {
                foreach ($errors As $error) {
                    echo $error;
                }
            }
        }
    
    ?>
    <form method="post" enctype="multipart/form-data">
        <div class="row justify-content-md-center g-0">
            <div class="form col-4">
                <label for="lastName" class="form-label">Nom</label>
                <input type="text" class="form-control" id="lastName" name="lastName" value="<?= $lastName ?>">
            </div>
        </div>
        <div class="row justify-content-md-center g-0">
            <div class="form col-4">
                <br><label for="firstName" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="firstName" name="firstName" value="<?= $firstName ?>">
            </div>
        </div>
        <div class="row justify-content-md-center g-0">
            <div class="form col-4">
                <br><label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" id="age" name="age" value="<?= $age ?>">
            </div>
        </div>
        <div class="row justify-content-md-center g-0">
            <div class="form col-4">
                <br><label for="imageUpload">Charger une photo de profil:</label><br>
                <input type="file" name="avatar" id="imageUpload" /><br>
            </div>
        </div>
        <div class="row justify-content-md-center g-0">
            <div class="col-2">
                <br><button name="send">Send</button>
            </div>
        </div>
    </form>
    <div class="row justify-content-md-center g-0">
        <div class="col-2"
            <?php 
            if (file_exists($uploadFile)) { ?>
                <br>Vous avez saisi :</br>
                <?= $lastName ?><br>
                <?= $firstName ?><br>
                <?= $age ?><br>
                <img src="<?= $uploadFile ?>"><br>
                <?php echo $uploadFile;
            } ?>
        </div>
    </div>
    
</body>
</html>

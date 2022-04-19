<?php
// Je vérifie si le formulaire est soumis comme d'habitude
if($_SERVER['REQUEST_METHOD'] === "POST"){ 
    // Securité en php
    // chemin vers un dossier sur le serveur qui va recevoir les fichiers uploadés (attention ce dossier doit être accessible en écriture)
   $myfile= uniqid().basename($_FILES['avatar']['name']);
  
    $uploadDir = 'public/uploads/';
    // le nom de fichier sur le serveur est ici généré à partir du nom de fichier sur le poste du client (mais d'autre stratégies de nommage sont possibles)
    $uploadFile = $uploadDir . $myfile;
    // Je récupère l'extension du fichier
    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    // Les extensions autorisées
    $authorizedExtensions = ['jpg','png', 'gif', 'webp'];
    // Le poids max géré par PHP par défaut est de 2M
    $maxFileSize = 1000000;
    
    // Je sécurise et effectue mes tests

    /****** Si l'extension est autorisée *************/
    if( (!in_array($extension, $authorizedExtensions))){
        $errors[] = 'Veuillez sélectionner une image de type Jpg ou Jpeg ou Png !';
    }

    /****** On vérifie si l'image existe et si le poids est autorisé en octets *************/
    if( file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize)
    {
    $errors[] = "Votre fichier doit faire moins de 1M !";
    }

    $uploads_dir = './uploads';
    $tmp_name = $_FILES['avatar']['tmp_name'];
    // basename() peut empêcher les attaques de système de fichiers;
    // la validation/assainissement supplémentaire du nom de fichier peut être approprié
   
    move_uploaded_file($tmp_name, "$uploads_dir/$myfile");
    
    echo '<pre>';
    if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile)) {
        echo "le format n'est pas accepté\n";
    }

}

if(isset($_GET['delete'])){
   unlink('./uploads/'.$_GET['delete']);
};

$files1 = scandir('uploads');
foreach($files1 as $file){
    if($file!='.' and $file!='..')echo '<div align="center"><img src="uploads/'.$file.'" alt=""><br/><a href="?delete='.$file.'">delete</a></div>';
}

?>


<hr>
<form method="post" enctype="multipart/form-data">
    <label for="name">Name:</label>
    <input type="text" name="name" placeholder="Enter your name" />
    <label for="age">Age</label>
    <input type="age" name="age" placeholder="Enter your age" />
    <label for="imageUpload">Upload a profile image</label>    
    <input type="file" name="avatar" id="imageUpload" />
    <button name="send">Send</button>
</form>

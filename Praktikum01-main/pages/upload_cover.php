<?php
$isbn=filter_input(INPUT_GET, 'isbn');
$uploadPressed=filter_input(INPUT_POST, 'btnUpload');
if (isset($uploadPressed)){
    $targetDirectory ='upload/';
    $fileExstension=pathinfo($_FILES['txtFile']['name'], PATHINFO_EXTENSION);
    $nama = $isbn.'.'.$fileExstension;
    $fileUploadPath=$targetDirectory.$isbn.'.'.$fileExstension;
    if($_FILES['txtFile']['size']>1024*2048){
        echo '<div>Uploaded file exceed 2MB</div>';
    } else{
        move_uploaded_file($_FILES['txtFile']['tmp_name'],$fileUploadPath);
        $result = uploadCover($isbn, $nama);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="Kelompok">
    <title>BookStudio</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap5.min.css">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
<div style="height:50vh;">


<div class="ms-5 ps-4">
    <h3>Current Cover</h3>
<?php
    $book=fetchOneBook($isbn);
    if ($book['cover'] != ''){
    echo '<img class="rounded-3" src="upload/'.$book['cover'].'" style="width:100%;height:auto;max-width:100px;max-height:150px;">';
    } else {
    echo '<img class="rounded-3" src="upload/defaultCover.png" style="width:100%;height:auto;max-width:100px;max-height:150px;">';
    }
    ?>
</div>
<div class="container">
    <form method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Upload Image</legend>
            <input type="file" name="txtFile" accept="image/jpeg|image/png">
            <input type="submit" name="btnUpload" value="Upload to file Server">
        </fieldset>
    </form>
</div>
</div>
<main>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap5.min.js"></script>

</body>
</html>

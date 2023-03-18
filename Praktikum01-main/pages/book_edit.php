<?php
    $editedISBN = filter_input(INPUT_GET,'isbn');
    if(isset($editedISBN)){
        $book = fetchOneBook($editedISBN);
    }
    $bookAwal = fetchOneBook2();
    $updatePressed = filter_input(INPUT_POST,'btnUpdate');
    if(isset($updatePressed)){
        $ISBN = filter_input(INPUT_POST,'ISBN');
        $title = filter_input(INPUT_POST,'title');
        $author = filter_input(INPUT_POST,'author');
        $publisher = filter_input(INPUT_POST,'publisher');
        $publishYear = filter_input(INPUT_POST,'publishYear');
        $shortDesc = filter_input(INPUT_POST,'shortDesc');
        $idGenre = filter_input(INPUT_POST,'idGenre');
        if(trim($ISBN) == ''||trim($title) == ''||trim($author) == ''||trim($publisher) == ''||trim($shortDesc) == ''||trim($idGenre) == ''){
            echo '
            <div class="text-center">
                Please provide with a valid name
            </div>
            ';}else{
            $results = updateBookToDb($book['ISBN'],$title,$author,$publisher,$publishYear,$shortDesc,$idGenre);
            if($results){
                header('location:index.php?menu=book');
            }else{
                echo '
                <div>
                    Failed to add data
                </div>
            ';
            }
        }
    }

    $uploadPressed=filter_input(INPUT_POST, 'btnUpload');
    if (isset($uploadPressed)){
        $book=fetchOneBook($editedISBN);
        $targetDirectory ='upload/';
        $fileExstension=pathinfo($_FILES['txtFile']['name'], PATHINFO_EXTENSION);
        $nama = $editedISBN.'.'.$fileExstension;
        $fileUploadPath=$targetDirectory.$editedISBN.'.'.$fileExstension;
        if($_FILES['txtFile']['size']>1024*2048){
            echo '<div>Uploaded file exceed 2MB</div>';
        } else{
            move_uploaded_file($_FILES['txtFile']['tmp_name'],$fileUploadPath);
            $result = uploadCover($editedISBN, $nama);
            if($result){
                header('location:index.php?menu=book');
            }else{
                echo '
                <div>
                    Failed to add data
                </div>
            ';
            }
        }
    }
?>

<div class="container" style="height:auto">
   <div class="row d-flex text-start justify-content-center my-3">
        <div class="col-md-6">
            <form method="post">
            <div class="mb-3">
                <label for="ISBNNum" class="form-label">ISBN</label>
                <input type="text" class="form-control" name="ISBN" id="ISBNNum" maxlength="13" readonly value="<?php echo($book['ISBN']); ?>" placeholder="ISBN">
            </div>
            <div class="mb-3">
                <label for="bookTitle" class="form-label">Title</label>
                <input type="text" class="form-control" name="title" id="bookTitle" maxlength="100" required autofocus value="<?php echo($book['title']); ?>" placeholder="Title">
            </div>
            <div class="mb-3">
                <label for="authorBook" class="form-label">Author</label>
                <input type="text" class="form-control" name="author" id="authorBook" maxlength="100" required autofocus value="<?php echo($book['author']); ?>" placeholder="Author">
            </div>
            <div class="mb-3">
                <label for="bookPublisher" class="form-label">Publisher</label>
                <input type="text" class="form-control" name="publisher" id="bookPublisher" maxlength="100" required autofocus value="<?php echo($book['publisher']); ?>" placeholder="Publisher">
            </div>
            <div class="mb-3">
                <label for="pubYear" class="form-label">Publish Year</label>
                <input type="number" class="form-control" name="publishYear" id="pubYear"  required autofocus value="<?php echo($book['publish_year']); ?>" placeholder="Publish Year">
            </div>
            <div class="mb-3">
                <label for="shortDesc" class="form-label">Short Description</label>
                <textarea  rows="4" type="textarea" class="form-control" name="shortDesc" id="shortDesc" maxlength="300" required autofocus >
                <?php echo($book['short_description']); ?>
                </textarea>
            </div>
            <div class="mb-3">
                <!-- <label for="IDgenre" class="form-label">Genre ID</label>
                <input type="number" class="form-control" name="idGenre" id="idGenre" required autofocus value="<?php echo($book['genre_id']); ?>" min="1" max="10" step="1"> -->
                <label for="IDgenre" class="form-label">Genre Name</label>
                <select class="form-select" name="idGenre" aria-label="Default select example">
                <option selected>Open this select menu</option>
                <?php
                    $result = fetchGenreFromDb();
                    foreach($result as $genre ){
                        echo '<option value="'. $genre['id'].'">'.$genre['name'].'</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="btnUpdate">Update Data</button>
            </form>
            <div>
                <h3>Current Cover</h3>
                <?php
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
    </div>
</div>
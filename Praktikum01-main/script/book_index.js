function editBook(isbn) {
  window.location = 'index.php?menu=book_update&isbn=' + isbn;
}
function uploadCover(isbn) {
  window.location = 'index.php?menu=upload_cover&isbn=' + isbn;
}
function deleteBook(idb) {
  let confirmasi = window.confirm("Are you sure want to delete this data?");
  if (confirmasi) {
    window.location = "index.php?menu=book&comd=dele&idb=" + idb;
  }
}
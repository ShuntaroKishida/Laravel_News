function confirmSubmission() {
  var result = confirm("投稿してもよろしいですか？");

  if (result) {
    document.getElementById("myForm").submit();
  } else {

  }
}
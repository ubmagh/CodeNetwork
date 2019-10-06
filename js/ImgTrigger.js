function imgTrigger(imgID) {

  $("#ImgModal").css("display", "block");
  var newsrc = $("#" + imgID).attr("src");
  $("#img01").attr("src", newsrc);

  $("#text-img").innerHTML = $("#" + imgID).attr("alt");

  // When the user clicks on <span> (x), close the modal
  $("#closeTri").click(function () {
    $("#ImgModal").css("display", "none");
  })
}
function terms_GotRedish (boool) {
  if (boool) {
    $('#terms').removeClass('text-light')
    $('#terms').addClass('text-danger')
  } else {
    $('#terms').removeClass('text-danger')
    $('#terms').addClass('text-light')
  }
}

$('#terms').mouseover(function () {
  terms_GotRedish(true)
})

$('#terms').mouseout(function () {
  terms_GotRedish(false)
})

$('#pispis').mouseover(function () {
  terms_GotRedish(true)
})

$('#pispis').mouseout(function () {
  terms_GotRedish(false)
})

$('#RegBut').click(function (event) {
  var flag = false
  $('#modal-body').empty()
  if ($('#fname').val() == '') {
    $('#modal-body').append(
      '<p><i class="fa fa-dashcube" aria-hidden="true"></i> First Name is required ! </p>'
    )
    flag = true
  }

  if ($('#lname').val() == '') {
    $('#modal-body').append(
      '<p><i class="fa fa-dashcube" aria-hidden="true"></i> Last Name is required ! </p>'
    )
    flag = true
  }
  /* Email check */
  if ($('#email').val() == '') {
    $('#modal-body').append(
      '<p><i class="fa fa-dashcube" aria-hidden="true"></i>Email Address Empty ! </p>'
    )
    flag = true
  }

  /* one messing password */
  if ($('#pwd1').val() == '' || $('#pwd2').val() == '') {
    $('#modal-body').append(
      '<p><i class="fa fa-dashcube" aria-hidden="true"></i> Password field is Empty ! </p>'
    )
    flag = true
  } else {
    /* two passwords aren't equal */
    if ($('#pwd1').val() != $('#pwd2').val()) {
      $('#modal-body').append(
        '<p><i class="fa fa-dashcube" aria-hidden="true"></i> Two passwords Are not the Same ! </p> '
      )
      flag = true
    }
  }

    /* age is empty */
    if ($('#age').val() == '') {
      $('#modal-body').append(
        '<p><i class="fa fa-dashcube" aria-hidden="true"></i>Please Enter your age ! </p>'
      )
      flag = true
    }
    
    /* Location is empty */
    if ($('#city').val() == '') {
      $('#modal-body').append(
        '<p><i class="fa fa-dashcube" aria-hidden="true"></i>Please Enter your Location/City ! </p>'
      )
      flag = true
    }

    /* Country is empty */
    if ($('#city').val() == '') {
      $('#modal-body').append(
        '<p><i class="fa fa-dashcube" aria-hidden="true"></i> Select a Country ! </p>'
      )
      flag = true
    }
    
  if (flag) {
    $('#myModal').modal('show')
    event.preventDefault()
  }
})

$('#Messaging').click(function (event) {
  $('#modal-body').empty()
  var flag = false

  if ($('#contactFullName').val() == '') {
    $('#modal-body').append(
      '<p><i class="fa fa-dashcube" aria-hidden="true"></i>The name is required for contact form </p> '
    )
    flag = true
  }

  if ($('#ContactEmail').val() == '') {
    $('#modal-body').append(
      '<p><i class="fa fa-dashcube" aria-hidden="true"></i>Email Address is required for contact form </p> '
    )
    flag = true
  }

  if ($('#Message').val() == '') {
    $('#modal-body').append(
      '<p><i class="fa fa-dashcube" aria-hidden="true"></i>No message is written into contact form !</p> '
    )
    flag = true
  }

  if (flag) {
    $('#myModal').modal('show')
    event.preventDefault()
  }
})

$('#contactFullName').click(function () {
  if ($('#namealert')) {
    $('#namealert').hide();
  }
});

$('#ContactEmail').click(function () {
  if ($('#emailalert')) {
    $('#emailalert').hide();
  }
});

$('#Message').click(function () {
  if ($('#msgalert')) {
    $('#msgalert').hide();
  }
});
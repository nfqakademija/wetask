$(".list-delete-button").on('click',  function (event) {
    event.preventDefault();
    if (confirm("Are you sure you want to delete?")) { window.location = $(this).attr('href');  }
});
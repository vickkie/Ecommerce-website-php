
function deleting{
swal({
  title: "Are you sure?",
  text: "Once deleted, you will not be able to Undo!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    swal("Successfully Deleted!", {
      icon: "success",
    });
  } else {
    swal("Action Aborted!");
  }
});
}

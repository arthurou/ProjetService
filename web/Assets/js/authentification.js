$(document).on("click", ".loginModalShow", function(){
    var htmllogin = $(".myPartial .mylogin").html();
    $(".modalTemplate #modalDefault .modal-body").html("");
    $(".modalTemplate #modalDefault .modal-body").html(htmllogin);
    $(".modalTemplate #modalDefault").modal("show");
})

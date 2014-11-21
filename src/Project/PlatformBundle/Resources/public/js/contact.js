$( document ).ready(function() {

    $(document).on("click", ".targetContact", function(event){
        event.preventDefault();
        var uid = $(event.currentTarget).attr("attr-uid");
        $(event.currentTarget).removeClass("targetContact");
        $("#modalContactView-"+uid).modal("show");
    });

    $('.modalContact').on('hidden.bs.modal', function () {
        $(".contactSelector").addClass("targetContact");
    })

});


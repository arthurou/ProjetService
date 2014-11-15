


$( document ).ready(function() {
    $(document).on("click", ".loginModalShow", function(){/*
        var content = $(".loginContent").html();
        $(".modalTemplate #modalDefault .modal-content").html("");
        $(".modalTemplate #modalDefault .modal-content").html(content);*/
        $(".modalTemplate #modalDefault ").addClass('in');
        $(".modalTemplate #modalDefault").modal("show");
    })

});


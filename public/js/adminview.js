$(document).ready(function(){

    $("#modalMenu .close").click(function(){
        $("#modalMenu").hide();
    })

    $("#table-cont .show").click(function(){
        $("#modalMenu").slideDown();
    })
})
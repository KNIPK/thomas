$(function(){
    $("#kni_thomasbundle_workshoptype_startDate_date").change(function(){
        var endDate = $("#kni_thomasbundle_workshoptype_endDate_date");
        if(endDate.val().length==0){
            endDate.val($(this).val());
        }
    });
    
    $("#kni_thomasbundle_workshoptype_startDate_time").change(function(){
        var endDate = $("#kni_thomasbundle_workshoptype_endDate_time");
        if(endDate.val().length==0){
            endDate.val($(this).val());
        }
    });
    
});
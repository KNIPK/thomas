$(document).ready(function(){
    
    $("#steps").sortable();
    
    $("#stepAdd form button").click(function(){
        var name = $("#stepAdd input[name=stepName]").val();
        var description = $("#stepAdd textarea[name=stepDescription]").val();
        
        if(name!=''){
            $("ul#steps").append("<li class='ui-state-default' description='"+description+"'><span class='ui-icon ui-icon-arrowthick-2-n-s'></span>"+name+"</li>");

            $("#stepAdd input[name=stepName]").val('');
            $("#stepAdd textarea[name=stepDescription]").val('');
        }
        return false;
    });
    
    $("button#next").click(function(){
        
        var form = $("form#stepsForm");
        
        $("ul#steps li").each(function(){
            form.append("<input type='hidden' name='steps[]' value='"+$(this).text()+"'>");
            form.append("<input type='hidden' name='stepsDescriptions[]' value='"+$(this).attr("description")+"'>");
        });
        
        form.submit();
        
        return false;
    });
});
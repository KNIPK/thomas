$(document).ready(function(){
    
    $("#steps").sortable();
    
    $("#stepAdd form#step button").click(function(){
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
        
        var i = 1;
        $("ul#steps li").each(function(){
            if($(this).attr("question")==1){
                //pytanie
                form.append("<input type='hidden' name='questions["+i+"]' value='"+$(this).attr("description")+"'>");
            }else{
                //etap
                form.append("<input type='hidden' name='steps["+i+"]' value='"+$(this).text()+"'>");
                form.append("<input type='hidden' name='stepsDescriptions["+i+"]' value='"+$(this).attr("description")+"'>");
            }
            i++;
        });
        
        form.submit();
        
        return false;
    });
    
    $("#addAnswer").click(function(){
        $("#answers").append('<input type="checkbox" name="corectAnswer[]" class="added" value="1" /><input class="added" type="text" name="answer[]" />');
    });
    
    $("#stepAdd form#question button").click(function(){

        var question = $("input[name=question]").val();
        if(question.length!=0){
            var answersSerialized = $("#answers input[type=text]").serialize();
            var answersCorrectSerialized = $("#answers input[type=checkbox]").serialize();

            var questionSerialized = new Array(question, answersSerialized, answersCorrectSerialized);

            questionSerialized = JSON.stringify(questionSerialized);

            $("#answers .added").remove();

            $("#question input").val('');
            $("#question input[type=checkbox]").prop('checked', false);

            //dodajemy jeszcze do listy w jakiś ciekawy sposób

            $("ul#steps").append("<li class='ui-state-default question' question='1' description='"+questionSerialized+"'><span class='ui-icon ui-icon-arrowthick-2-n-s'></span>"+question+"</li>");
        }
        return false;
    });
    
    $("button#save").click(function(){

        

        var form = $("form#stepsForm");
        
        var i = 1;
        $("ul#steps li").each(function(){
            if($(this).attr("question")==1){
                //pytanie
                form.append("<input type='hidden' name='original_id["+i+"]' value='"+$(this).attr("original_id")+"'>");
                form.append("<input type='hidden' name='questions["+i+"]' value='"+$(this).attr("description")+"'>");
            }else{
                //etap
                form.append("<input type='hidden' name='original_id["+i+"]' value='"+$(this).attr("original_id")+"'>");
                form.append("<input type='hidden' name='steps["+i+"]' value='"+$(this).text()+"'>");
                form.append("<input type='hidden' name='stepsDescriptions["+i+"]' value='"+$(this).attr("description")+"'>");
            }
            i++;
        });
        
        form.submit();
        
        return false;
    });
});
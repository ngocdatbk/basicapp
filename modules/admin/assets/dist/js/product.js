$(document).ready(function () {
    $("#images").change(function(){
        showSelectedImage(this);
    });
    $( document ).on( "click", ".image_product", function() {
        var id = this.id;
        var old_main = $('#main_image').attr('main_id');


        $('#main_image').attr('src', $('#'+id).attr('src'));
        $('#main_image').attr('main_id',id);
        $('#main_'+id).val('1');

        if(old_main)
            $('#main_'+old_main).val('');
    });

    $( document ).on( "click", ".remove_image", function() {
        var row_id = $(this).attr('row_id');
        var old_new = $(this).attr('old_new');
        if(old_new == 'old')
        {
            $(this).parent().parent().css("display",'none');
            $('#status_'+row_id).val('delete');
        }
        else
        {
            $(this).parent().parent().remove();
        }
    });
});

function showSelectedImage(input) {
    if (input.files) {
        for(var x = 0; x < input.files.length; x++){
            var reader = new FileReader();

            reader.onload = (function(index){
                return function(e){
                    var content = '<tr>'
                            +'<td class="bound_image" style="width: 25%">'
                                +'<img src="'+e.target.result+'" id="new_'+index+'" class="img-thumbnail image_product" style=" width: 100%;" >'
                                +'<a class="remove_image" row_id="new_'+index+'" old_new="new" type="button" >'
                                    +'<i class="glyphicon glyphicon-remove"></i>'
                                +'</a>'
                            +'</td>'
                            + '<td>'
                                +'<textarea rows="4" style="width: 100%" name="image_new['+index+'][description]" placeholder="Enter text here..."></textarea>'
                                +'<input type="hidden" name="image_new['+index+'][is_main]" id="main_new_'+index+'" value="">'
                            +'</td>'
                        +'</tr>';
                    $("#image_list").append(content);
                    if(index == 0)
                    {
                        var old_main = $('#main_image').attr('main_id');
                        if(!old_main)
                        {
                            $('#main_image').attr('src', $('#new_'+index).attr('src'));
                            $('#main_image').attr('main_id','new_'+index);
                            $('#main_new_'+index).val('1');
                        }
                    }
                };
            })(x);
            reader.readAsDataURL(input.files[x]);
        }
    }
}
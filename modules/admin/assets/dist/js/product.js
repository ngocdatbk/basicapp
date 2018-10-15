$(document).ready(function () {
    $("#images").change(function(){
        showSelectedImage(this);
    });
    $(".image_product").click(function(){

        var id = this.id;
        console.log(id);
        $('#main_image').attr('src', $('#'+id).attr('src'));
    });
});

function showSelectedImage(input) {
    if (input.files) {
        for(var x = 0; x < input.files.length; x++){
            var reader = new FileReader();

            reader.onload = (function(index){
                return function(e){
                    var content = '<tr>'
                        +'<td style="width: 25%">'
                        +'<img src="'+e.target.result+'" id="new_'+index+'" class="img-thumbnail image_product" style=" width: 100%;" >'
                        +'</td>'
                        + '<td>'
                        +'<textarea rows="4" style="width: 100%" name="image_new['+index+'][description]" placeholder="Enter text here..."></textarea>'
                        +'<input type="hidden" name="image_new['+index+'][is_main]" id="main_new_'+index+'" value="">'
                        +'<input type="hidden" name="image_new['+index+'][status]" id="status_new_'+index+'" value="">'
                        +'</td>'
                        +'</tr>';
                    $("#image_list").append(content);

                    $('#main_image').attr('src', $('#new_'+index).attr('src'));
                };
            })(x);
            reader.readAsDataURL(input.files[x]);
        }
    }
}
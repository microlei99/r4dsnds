$(function(){
    $('#currency').change(function(){
        location.href='/currency/'+$(this).val();
    });

    $('#check_btn').click(function(){
        location.href='/shipping';
    });

    $('.update_qty').click(function(){
        var errorFlage = false;
        $('.table1 tbody tr').each(function(){
            var obj = $(this).children(':eq(1)').children(":text");
            if(isNaN(obj.val())){
                obj.val(obj.prev().val());
                errorFlage = true;
                alert('The quantity is invalid.');
                return false;
            }
            else{
                obj.prev().val(obj.val());
            }
        });
        if(!errorFlage){
            $('#shoppingcart-form').submit();
        }else{
            return false;
        }
    });

    $('.carttr :button').click(function(){
        if(confirm("Are you sure you want to delete this item?")){
            location.href='/shoppingcart/remove?cid='+$(this).attr('id');
        }
    });
    
    $('')
    
});



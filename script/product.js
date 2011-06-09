$(function(){
   // $("#product_info").viTab({tabCss : 'i_d_sel',tabScroll : 0,tabEvent :1});
    $('.p_b_imglist').children().click(function(){
        $(this).siblings().removeClass();
        $(this).addClass('p_b_ilsel');
        var src = $(this).children().attr('src');

        $('#base_img').attr('src',src.slice(0,-10)+'_product.jpg');
        $('#base_img').attr('alt',$(this).children().attr('alt'));
        $('#base_img_lable').html($(this).children().attr('alt'));
        return false;
    });

    $('#qtybox').change(function(){
        var input_qty = parseInt($(this).val());
        if(isNaN(input_qty) || input_qty<1){
            $(this).val($(this).prev().val());
            alert("The product quantity must be a number.");
            return false;
        }else{
            var min_buy = parseInt($('#min_buy').val());
            if(input_qty<min_buy){
                $(this).val($(this).prev().val());
                alert('The quantity must over '+min_buy);
                return false;
            }
            var stock_qty = parseInt($('#total_stock').val());
            if(input_qty>stock_qty){
                $(this).val($(this).prev().val());
                alert('The quantity is more than max stock quantity');
                return false;
            }
        $(this).prev().val(input_qty);
       }
    });

    $('#addtocart').click(function(){
        var product_id = parseInt($('#product_id').val());
        var input_qty = parseInt($('#qtybox').val());
        location.href='/shoppingcart/addtocart?pid='+product_id+'&qty='+input_qty;
    });
});
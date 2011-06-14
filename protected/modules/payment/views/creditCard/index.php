<p style="text-align: center; font-size: 20px; margin-top: 50px;">Please wait, redirecting to payment gateway... Thanks.<br /><a href="javascript:history.go(-1);">Cancel</a></p>
<form action="<?php echo $this->module->getPaymentUrl(); ?>" method="post" id="payment_form">
    <?php
    foreach($data as $key=>$value)
    {
        echo '<input type="hidden" id="'.preg_replace('/(.*)\[(.*)\]/','${1}${2}',$key).'" name="'.$key.'" value="'.$value.'" />';
    }
    ?>
<p style="text-align:center;"><br/><br/>If you are not automatically redirected to payment gateway within 5 seconds...<br/><br/>
<input type="submit" value="Click Here" style="color: #000;"></p>
</form>
<script type="text/javascript">
    document.body.onload=document.forms.payment_form.submit();
</script>
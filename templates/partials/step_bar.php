<?php if($flag_require_dealer){
    ?>
    <ol class="progtrckr" data-progtrckr-steps="4">
        <li data-step="1" class="">BILLING</li>
        <li data-step="2" class="">FFL LOCATOR</li>
        <li data-step="3" class="">NFA AGREEMENTS</li>
        <li data-step="4" class="">PAYMENT</li>
    </ol>

    <?php
}else{
    ?>
    <ol class="progtrckr" data-progtrckr-steps="2">
        <li data-step="1" class="">BILLING</li>
        <li data-step="2" class="">PAYMENT</li>
    </ol>
    <?php
}

?>
<br>
<h5 id="heading_step_checkout" data-steps="<?php echo $flag_require_dealer ? 4 : 2 ?>">STEP 1: BILLING ADDRESS</h5>

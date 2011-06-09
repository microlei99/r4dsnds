<style type="text/css">
    div.addresses {
    background: url("/images/form_bg.jpg") repeat-x scroll left top #D0D1D5;
    border: 1px solid #D0D3D8;
    padding: 0.6em;
    position: relative;
    width: 544px;
    }
    div.addresses ul.item {
    clear: both;
}
    ul.item li.address_title {
    background-image: url("/images/address_alias_left.gif");
    margin-top: 0;
    color: #374853;
    font-size: 1.2em;
    font-weight: bold;
}

ul.alternate_item li.address_title {
    background-image: url("/images/address_alias_right.gif");
    margin-top: 0;
    color: #374853;
    font-size: 1.2em;
    font-weight: bold;
}
    ul.address{
        background-color:white;
        float: left;
        list-style: none outside none;
        margin-bottom: 1em;
        margin-left: 0.25em;
        padding-bottom: 0.6em;
        position: relative;
        width: 268px
    }

    ul.address li {
    margin-top: 0.6em;
    padding-left: 1.4em;
}
li.address_name, li.address_company {
    font-weight: bold;
}

li.address_name, li.address_update a, li.address_delete a {
    color: #DD2A81;
}
li.address_update, li.address_delete {
    background: url("/images/bullet_myaccount.gif") no-repeat scroll 0 0.5em transparent !important;
    margin-left: 1.4em;
}
</style>
<div class="sunmm_box">
    <h2>My addresses</h2><span><a href="/user/newAddress" class="ml_6" style="color:#0066CC;">[New Address]</a></span>
    <div class="addresses">
        <h3>Your addresses are listed below.</h3>
        <p>Be sure to update them if they have changed.</p>
        <?php foreach($addresses as $key=>$address):?>
        <ul class="<?php echo ($key/2) ? 'address alternate_item' : 'address item';?>">
            <li class="address_title"></li>
            <li class="address_name"><?php echo $address->customer_firstname.' '.$address->customer_lastname;?></li>
            <li class="address_phone_mobile"><?php echo $address->address_phonenumber;?></li>
            <li class="address_city"><?php echo $address->address_postcode;?></li>
            <li class="address_address1"><?php echo $address->address_street;?></li>
            <li class="address_country"><?php echo $address->address_city.' '.$address->address_state,' '.$address->country->name;?></li>
            <li class="address_update">
                <a title="Update" href="/user/editAddress/id/<?php echo $address->address_id;?>">Update</a>
            </li>
            <li class="address_delete">
                <a title="Delete" onclick="return confirm('Are you sure?');" href="/user/deleteAddress/id/<?php echo $address->address_id;?>">Delete</a>
            </li>
        </ul>
        <?php endforeach;?>
       <div class="fix"></div>
    </div>
</div>
<div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500"> 
    <ul class="menu-nav">
        <?php 
            if (in_array("dashboard", $data_role)){
        ?>
                <li class="menu-item <?php if ($menu_active == 'dashboard') echo 'menu-item-active'; ?>" aria-haspopup="true">
                    <a href="/dashboard" class="menu-link">
                        <i class="menu-icon flaticon-home"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>  
        <?php 
            } 
            if (in_array("customer-list", $data_role)){
        ?>
                <li class="menu-item <?php if ($menu_active == 'customer_list') echo 'menu-item-active'; ?>" aria-haspopup="true">
                    <a href="/customer-list" class="menu-link">
                        <i class="menu-icon flaticon-user"></i>
                        <span class="menu-text">All Customer</span>
                    </a>
                </li>   
        <?php 
            } 
            if (in_array("user-login-list", $data_role)){   
        ?>
                <li class="menu-item <?php if ($menu_active == 'admin-user-list') echo 'menu-item-active'; ?>" aria-haspopup="true">
                    <a href="/admin-user-list" class="menu-link">
                        <i class="menu-icon flaticon-profile-1"></i>
                        <span class="menu-text">Manage User Login</span>
                    </a>
                </li>   
        <?php }   
            if (in_array("view-online-payment-customer", $data_role)){   
        ?>
                <li class="menu-item <?php if ($menu_active == 'admin-payment-list') echo 'menu-item-active'; ?>" aria-haspopup="true">
                    <a href="/admin-payment-list" class="menu-link">
                        <i class="menu-icon fas fa-money-bill-alt"></i>
                        <span class="menu-text">Online Payment List</span>
                    </a>
                </li>   
        <?php }   
            if (in_array("send-email-blast-customer-list", $data_role)){   
        ?>
                <li class="menu-item <?php if ($menu_active == 'send-email-blast-customer-list') echo 'menu-item-active'; ?>" aria-haspopup="true">
                    <a href="/send-email-blast-customer-list" class="menu-link">
                        <i class="menu-icon flaticon2-send-1"></i>
                        <span class="menu-text">Send Blast Email Customer</span>
                    </a>
                </li>   
        <?php }  
            if(in_array("report-list", $data_role)){
        ?>
        <li class="menu-item <?php if ($menu_active == 'admin_report') echo 'menu-item-active'; ?>" aria-haspopup="true">
            <a href="/admin_report" class="menu-link">
                <i class="menu-icon flaticon-list"></i>
                <span class="menu-text">Admin Report</span>
            </a>
        </li>   
        <?php } 
            if(in_array("domain-list", $data_role)){
        ?>
        <li class="menu-item <?php if ($menu_active == 'admin_domain') echo 'menu-item-active'; ?>" aria-haspopup="true">
            <a href="/admin_domain" class="menu-link">
                <i class="menu-icon flaticon2-world"></i>
                <span class="menu-text">Domain List</span>
            </a>
        </li>  
        <?php } 
            if(in_array("vendor-list", $data_role)){
        ?>
        <li class="menu-item <?php if ($menu_active == 'admin_mv') echo 'menu-item-active'; ?>" aria-haspopup="true">
            <a href="/management-vendor" class="menu-link">
                <i class="menu-icon flaticon2-schedule"></i>
                <span class="menu-text">Management Vendor</span>
            </a>
        </li>  
        <?php }   
        if (in_array("faktur-pajak-indonet-list", $data_role)){
        ?>
        <li class="menu-item <?php if ($menu_active == 'faktur-pajak-indonet') echo 'menu-item-active'; ?>" aria-haspopup="true">
            <a href="/faktur-pajak-indonet-list" class="menu-link">
                <i class="menu-icon flaticon2-list"></i>
                <span class="menu-text">Faktur Pajak</span>
            </a>
        </li>  
        <li class="menu-item <?php if ($menu_active == 'blacklist-billing-pajak') echo 'menu-item-active'; ?>" aria-haspopup="true">
            <a href="/faktur-pajak-black-list" class="menu-link">
                <i class="menu-icon flaticon2-warning"></i>
                <span class="menu-text">Blacklist Billing Pajak</span>
            </a>
        </li>  
        <?php }  
        if (in_array("faktur-pajak-alibaba-list", $data_role)){
            ?>
            <li class="menu-item hide <?php if ($menu_active == 'faktur-pajak-alibaba') echo 'menu-item-active'; ?>" aria-haspopup="true">
                <a href="/faktur-pajak-alibaba-list" class="menu-link">
                    <i class="menu-icon flaticon-statistics"></i>
                    <span class="menu-text">Faktur Pajak Alibaba</span>
                </a>
            </li>  
        <?php } ?>
        <li class="menu-item <?php if ($menu_active == 'account') echo 'menu-item-active'; ?>" aria-haspopup="true">
            <a href="/account" class="menu-link">
                <i class="menu-icon flaticon-user-settings"></i>
                <span class="menu-text">Account</span>
            </a>
        </li>      
        <li class="menu-item" aria-haspopup="true">
            <a href="<?=base_url()?>auth/logout" class="menu-link">
                <i class="menu-icon flaticon-logout"></i>
                <span class="menu-text">Logout</span>
            </a>
        </li>    
    </ul> 
</div>  
<script>
    function under_dev(){ 
        Swal.fire('under maintenance','','error').then((result) => { 
            // location.reload(); 
        });  
    }
</script>
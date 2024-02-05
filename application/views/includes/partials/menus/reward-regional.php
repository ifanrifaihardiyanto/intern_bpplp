<li class="nav-item <?= $sidebar['category_active'] == 'Financial' ? 'active' : '' ?>">
    <a class="nav-link" data-toggle="collapse" href="#financialtreg5" role="button" aria-expanded="<?= $sidebar['category_active'] == 'Financial' ? 'true' : 'false' ?>" aria-controls="financialtreg5">
        <i class="link-icon" data-feather="credit-card"></i>
        <span class="link-title">Financial</span>
        <i class="link-arrow" data-feather="chevron-down"></i>
    </a>
    <div class="<?= $sidebar['category_active'] == 'Financial' ? 'show active' : 'collapse' ?>" id="financialtreg5">
        <ul class="nav sub-menu">
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/financial/financial_cons" class="nav-link <?= $sidebar['item_active'] == 'financial cons' ? 'active' : '' ?>">Financial Cons</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/financial/financial_bges" class="nav-link <?= $sidebar['item_active'] == 'bges' ? 'active' : '' ?>">Financial BGES</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/financial/financial_bs" class="nav-link <?= $sidebar['item_active'] == 'bs' ? 'active' : '' ?>">Financial BS</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/financial/financial_gs" class="nav-link <?= $sidebar['item_active'] == 'gs' ? 'active' : '' ?>">Financial GS</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/financial/financial_es" class="nav-link <?= $sidebar['item_active'] == 'es' ? 'active' : '' ?>">Financial ES</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/financial/market_share_ws" class="nav-link <?= $sidebar['item_active'] == 'best market share ws' ? 'active' : '' ?>">Market Share Wholesale</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/financial/collection" class="nav-link <?= $sidebar['item_active'] == 'best collection' ? 'active' : '' ?>">Collection</a>
            </li>
        </ul>
    </div>
</li>
<li class="nav-item <?= $sidebar['category_active'] == 'Customer' ? 'active' : '' ?>">
    <a class="nav-link" data-toggle="collapse" href="#customerTreg5" role="button" aria-expanded="<?= $sidebar['category_active'] == 'Customer' ? 'true' : 'false' ?>" aria-controls="customerTreg5">
        <i class="link-icon" data-feather="users"></i>
        <span class="link-title">Customer</span>
        <i class="link-arrow" data-feather="chevron-down"></i>
    </a>
    <div class="<?= $sidebar['category_active'] == 'Customer' ? 'show active' : 'collapse' ?>" id="customerTreg5">
        <ul class="nav sub-menu">
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/customer/idh_reward" class="nav-link <?= $sidebar['item_active'] == 'Best Indihome Reward' ? 'active' : '' ?>">Indihome Reward</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/customer/apc" class="nav-link <?= $sidebar['item_active'] == 'Best APC' ? 'active' : '' ?>">APC</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/customer/jawara_wifi" class="nav-link <?= $sidebar['item_active'] == 'Best Jawara Wifi' ? 'active' : '' ?>">Jawara Wifi</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/customer/digital_channel" class="nav-link <?= $sidebar['item_active'] == 'Best Digital Channel' ? 'active' : '' ?>">Digital Channel</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/customer/fmc" class="nav-link <?= $sidebar['item_active'] == 'Best FMC' ? 'active' : '' ?>">FMC</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/customer/sales_bw" class="nav-link <?= $sidebar['item_active'] == 'Best Sales BW' ? 'active' : '' ?>">Sales BW</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/customer/sales_hsi" class="nav-link <?= $sidebar['item_active'] == 'Best Sales HSI' ? 'active' : '' ?>">Sales HSI</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/customer/cnop" class="nav-link <?= $sidebar['item_active'] == 'Best CNOP' ? 'active' : '' ?>">CNOP</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/customer/wifi_revitalization" class="nav-link <?= $sidebar['item_active'] == 'Best Wifi Revitalization' ? 'active' : '' ?>">Wifi Revitalization</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/customer/cust_order_exec" class="nav-link <?= $sidebar['item_active'] == 'Best Cust Order Exec' ? 'active' : '' ?>">Customer Order Exec</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/customer/reduce_churn" class="nav-link <?= $sidebar['item_active'] == 'Best Reduce Churn' ? 'active' : '' ?>">Reduce Churn</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/customer/cust_touch_point" class="nav-link <?= $sidebar['item_active'] == 'Best Cust Touch Point' ? 'active' : '' ?>">Customer Touch Point</a>
            </li>
        </ul>
    </div>
</li>
<li class="nav-item <?= $sidebar['category_active'] == 'Internal Business Process' ? 'active' : '' ?>">
    <a class="nav-link" data-toggle="collapse" href="#internal_businessTreg5" role="button" aria-expanded="<?= $sidebar['category_active'] == 'Internal Business Process' ? 'true' : 'false' ?>" aria-controls="internal_businessTreg5">
        <i class="link-icon" data-feather="briefcase"></i>
        <span class="link-title">Internal Business Process</span>
        <i class="link-arrow" data-feather="chevron-down"></i>
    </a>
    <div class="<?= $sidebar['category_active'] == 'Internal Business Process' ? 'show active' : 'collapse' ?>" id="internal_businessTreg5">
        <ul class="nav sub-menu">
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/internal_business_process/fulfillment_perf" class="nav-link <?= $sidebar['item_active'] == 'fulfillment performance' ? 'active' : '' ?>">Fulfillment Performance</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/internal_business_process/fulfillment_indihome" class="nav-link <?= $sidebar['item_active'] == 'fulfillment indihome' ? 'active' : '' ?>">Fulfillment Indihome</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/internal_business_process/fulfillment_mobile_wib" class="nav-link <?= $sidebar['item_active'] == 'fulfillment mobile & wib' ? 'active' : '' ?>">Fulfillment Mobile & Wib</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/internal_business_process/delivery_bges" class="nav-link <?= $sidebar['item_active'] == 'delivery bges' ? 'active' : '' ?>">Delivery BGES</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/internal_business_process/capex_cons" class="nav-link <?= $sidebar['item_active'] == 'capex cons' ? 'active' : '' ?>">Capex Cons</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/internal_business_process/assurance_indihome" class="nav-link <?= $sidebar['item_active'] == 'assurance indihome' ? 'active' : '' ?>">Assurance Indihome</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/internal_business_process/assurance_bges" class="nav-link <?= $sidebar['item_active'] == 'assurance bges' ? 'active' : '' ?>">Assurance BGES</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/internal_business_process/assurance_mobile_wib" class="nav-link <?= $sidebar['item_active'] == 'assurance mobile & wib' ? 'active' : '' ?>">Assurance Mobile & Wib</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/internal_business_process/customer_experience" class="nav-link <?= $sidebar['item_active'] == 'customer experience' ? 'active' : '' ?>">Customer Experience</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/internal_business_process/collecting_nte" class="nav-link <?= $sidebar['item_active'] == 'collecting nte' ? 'active' : '' ?>">Collecting NTE</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/internal_business_process/access_cx" class="nav-link <?= $sidebar['item_active'] == 'access cx' ? 'active' : '' ?>">Access CX</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/internal_business_process/wifi_operation" class="nav-link <?= $sidebar['item_active'] == 'wifi operation' ? 'active' : '' ?>">Wifi Operation</a>
            </li>
        </ul>
    </div>
</li>
<li class="nav-item <?= $sidebar['category_active'] == 'Learning & Growth' ? 'active' : '' ?>">
    <a class="nav-link" data-toggle="collapse" href="#learning_growthTreg5" role="button" aria-expanded="<?= $sidebar['category_active'] == 'Learning & Growth' ? 'true' : 'false' ?>" aria-controls="learning_growthTreg5">
        <i class="link-icon" data-feather="dollar-sign"></i>
        <span class="link-title">Learning & Growth</span>
        <i class="link-arrow" data-feather="chevron-down"></i>
    </a>
    <div class="<?= $sidebar['category_active'] == 'Learning & Growth' ? 'show active' : 'collapse' ?>" id="learning_growthTreg5">
        <ul class="nav sub-menu">
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/learning_growth/broadband_champion" class="nav-link <?= $sidebar['item_active'] == 'broadband champion' ? 'active' : '' ?>">Broadband Champion</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/learning_growth/add_on" class="nav-link <?= $sidebar['item_active'] == 'add on' ? 'active' : '' ?>">Add On</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/learning_growth/product_digital" class="nav-link <?= $sidebar['item_active'] == 'product digital' ? 'active' : '' ?>">Product Digital</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/learning_growth/ba_cnop" class="nav-link <?= $sidebar['item_active'] == 'ba cnop' ? 'active' : '' ?>">BA CNOP</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/learning_growth/digital_platform_service" class="nav-link <?= $sidebar['item_active'] == 'digital platform & service' ? 'active' : '' ?>">Digital Platform & Service</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/learning_growth/mo_spbu" class="nav-link <?= $sidebar['item_active'] == 'mo spbu' ? 'active' : '' ?>">MO SPBU</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards_regional/data/learning_growth/enom_utilization" class="nav-link <?= $sidebar['item_active'] == 'enom utilization' ? 'active' : '' ?>">ENOM Utilization</a>
            </li>
        </ul>
    </div>
</li>
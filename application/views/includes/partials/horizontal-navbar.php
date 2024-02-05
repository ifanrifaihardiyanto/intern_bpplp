<?php $user = (object) $this->session->userdata('user'); ?>

<div class="horizontal-menu">
    <nav class="navbar top-navbar">
        <div class="container">
            <div class="navbar-content">
                <a href="#" class="navbar-brand">
                    BPP<span>REG5</span>
                </a>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown nav-profile">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="https://via.placeholder.com/30x30" alt="profile">
                        </a>
                        <div class="dropdown-menu" aria-labelledby="profileDropdown">
                            <div class="dropdown-header d-flex flex-column align-items-center">
                                <div class="figure mb-3">
                                    <img src="https://via.placeholder.com/80x80" alt="">
                                </div>
                                <div class="info text-center">
                                    <p class="name font-weight-bold mb-0"><?= $user->full_name ?></p>
                                </div>
                            </div>
                            <div class="dropdown-body">
                                <ul class="profile-nav p-0 pt-3">
                                    <li class="nav-item">
                                        <form action="<?= base_url(); ?>index.php/authenticate/logged_out" id="loggedOut" method="post"></form>
                                        <a href="javascript:;" onclick="doLogout()" class="nav-link">
                                            <i data-feather="log-out"></i>
                                            <span>Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
                    <i data-feather="menu"></i>
                </button>
            </div>
        </div>
    </nav>
    <nav class="bottom-navbar">
        <div class="container">
            <ul class="nav page-navigation">
                <li class="nav-item <?php echo $sidebar['parent_active'] ?? $sidebar['category_active'] == 'dashboard' ? 'active' : '' ?>">
                    <a class="nav-link" href="<?php echo base_url(); ?>index.php/dashboard">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item mega-menu <?php echo $sidebar['parent_active'] ?? $sidebar['category_active'] == 'customer_monetization' ? 'active' : '' ?>">
                    <a href="#" class="nav-link">
                        <i class="link-icon" data-feather="map"></i>
                        <span class="menu-title">Reward Nasional</span>
                        <i class="link-arrow"></i>
                    </a>
                    <div class="submenu">
                        <div class="col-group-wrapper row">
                            <div class="col-group col">
                                <div class="row">
                                    <div class="col-12">
                                        <p class="category-heading">Result</p>
                                        <div class="submenu-item">
                                            <div class="row">
                                                <div class="col">
                                                    <ul>
                                                        <li class="nav-item <?php echo $sidebar['category_active'] == 'summary' ? 'active' : '' ?>">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards/summary" class="nav-link">
                                                                Summary
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <p class="category-heading">Financial</p>
                                        <div class="submenu-item">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <ul>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards/financial/financial" class="nav-link <?php echo $sidebar['item_active'] == 'best_financial' ? 'active' : '' ?>">Best Financial</a>
                                                        </li>
                                                        <!-- <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards/financial/capex" class="nav-link <?php echo $sidebar['item_active'] == 'capex' ? 'active' : '' ?>">Best of CAPEX</a>
                                                        </li> -->
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards/financial/best_capex" class="nav-link <?php echo $sidebar['item_active'] == 'best_capex' ? 'active' : '' ?>">Best of CAPEX</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards/financial/collection" class="nav-link <?php echo $sidebar['item_active'] == 'collection' ? 'active' : '' ?>">Best Collection</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-group col">
                                <div class="row">
                                    <div class="col-12">
                                        <p class="category-heading">Customer Experience</p>
                                        <div class="submenu-item">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <ul>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards/customer_experience/best_quality_assurance" class="nav-link <?php echo $sidebar['item_active'] == 'best_quality_assurance' ? 'active' : '' ?>">Best Assurance</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards/customer_experience/best_customer_experience" class="nav-link <?php echo $sidebar['item_active'] == 'best_customer_experience' ? 'active' : '' ?>">Best Customer Experience</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards/customer_experience/best_digital_channel" class="nav-link <?php echo $sidebar['item_active'] == 'best_digital_channel' ? 'active' : '' ?>">Best Digital Channel</a>
                                                        </li>
                                                        <!-- <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards/customer_experience/best_ttr" class="nav-link <?php echo $sidebar['item_active'] == 'best_ttr' ? 'active' : '' ?>">Best TTR</a>
                                                        </li> -->
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-group col">
                                <div class="row">
                                    <div class="col-12">
                                        <p class="category-heading">Customer Monetization</p>
                                        <div class="submenu-item">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <ul>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards/customer_monetization/best_add_on" class="nav-link <?php echo $sidebar['item_active'] == 'best_add_on' ? 'active' : '' ?>">Best Add On</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards/customer_monetization/best_digital_product" class="nav-link <?php echo $sidebar['item_active'] == 'best_digital_product' ? 'active' : '' ?>">Best Digital Product</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-group col">
                                <div class="row">
                                    <div class="col-12">
                                        <p class="category-heading">Customer Penetration</p>
                                        <div class="submenu-item">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <ul>
                                                        <!-- <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards/customer_penetration/best_3p" class="nav-link <?php echo $sidebar['item_active'] == 'best_3p' ? 'active' : '' ?>">Best 3P Share</a>
                                                        </li> -->
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards/customer_penetration/broadband_champion" class="nav-link <?php echo $sidebar['item_active'] == 'broadband_champion' ? 'active' : '' ?>">Broadband Champion</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards/customer_penetration/best_apc" class="nav-link <?php echo $sidebar['item_active'] == 'best_apc' ? 'active' : '' ?>">Best APC</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards/customer_penetration/best_fulfillment_performance" class="nav-link <?php echo $sidebar['item_active'] == 'best_fulfillment_performance' ? 'active' : '' ?>">Fulfillment Performance</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards/customer_penetration/jawara_wifi" class="nav-link <?php echo $sidebar['item_active'] == 'jawara_wifi' ? 'active' : '' ?>">Jawara Wifi</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards/customer_penetration/indihome_reward" class="nav-link <?php echo $sidebar['item_active'] == 'indihome_reward' ? 'active' : '' ?>">Indihome Reward</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards/customer_penetration/best_fmc_penetration" class="nav-link <?php echo $sidebar['item_active'] == 'best_fmc_penetration' ? 'active' : '' ?>">Best FMC Penetration</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-group col">
                                <div class="row">
                                    <div class="col-12">
                                        <p class="category-heading">Internal Business Process</p>
                                        <div class="submenu-item">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <ul>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards/internal_business/best_loss_management" class="nav-link <?php echo $sidebar['item_active'] == 'best_loss_management' ? 'active' : '' ?>">Best Healthy Customer</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards/internal_business/best_collecting_nte" class="nav-link <?php echo $sidebar['item_active'] == 'best_collecting_nte' ? 'active' : '' ?>">Best Collecting NTE</a>
                                                        </li>
                                                        <!-- <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards/internal_business/best_healthy_customer" class="nav-link <?php echo $sidebar['item_active'] == 'best_healthy_customer' ? 'active' : '' ?>">Best Healthy Customer</a>
                                                        </li> -->
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item mega-menu <?php echo $sidebar['parent_active'] ?? $sidebar['category_active'] == 'rewards_regional' ? 'active' : '' ?>">
                    <a href="#" class="nav-link">
                        <i class="link-icon" data-feather="map-pin"></i>
                        <span class="menu-title">Reward Regional</span>
                        <i class="link-arrow"></i>
                    </a>
                    <div class="submenu">
                        <div class="col-group-wrapper row">
                            <div class="col-group col">
                                <div class="row">
                                    <div class="col-12">
                                        <p class="category-heading">Financial</p>
                                        <div class="submenu-item">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <ul>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/financial/financial_cons" class="nav-link <?php echo $sidebar['item_active'] == 'financial_cons' ? 'active' : '' ?>">Best Financial Cons</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/financial/financial_bges" class="nav-link <?php echo $sidebar['item_active'] == 'financial_bges' ? 'active' : '' ?>">Financial BGES</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/financial/financial_bs" class="nav-link <?php echo $sidebar['item_active'] == 'financial_bs' ? 'active' : '' ?>">Financial BS</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/financial/financial_gs" class="nav-link <?php echo $sidebar['item_active'] == 'financial_gs' ? 'active' : '' ?>">Financial GS</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/financial/financial_es" class="nav-link <?php echo $sidebar['item_active'] == 'financial_es' ? 'active' : '' ?>">Financial ES</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/financial/market_share_ws" class="nav-link <?php echo $sidebar['item_active'] == 'market_share_ws' ? 'active' : '' ?>">Best Market Share Wholesale</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-group col">
                                <div class="row">
                                    <div class="col-12">
                                        <p class="category-heading">Customer</p>
                                        <div class="submenu-item">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <ul>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/customer/idh_reward" class="nav-link <?php echo $sidebar['item_active'] == 'idh_reward' ? 'active' : '' ?>">Best Indihome Reward</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/customer/apc" class="nav-link <?php echo $sidebar['item_active'] == 'apc' ? 'active' : '' ?>">Best APC</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/customer/jawara_wifi" class="nav-link <?php echo $sidebar['item_active'] == 'jawara_wifi' ? 'active' : '' ?>">Best Jawara Wifi</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/customer/digital_channel" class="nav-link <?php echo $sidebar['item_active'] == 'digital_channel' ? 'active' : '' ?>">Best Digital Channel</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/customer/fmc" class="nav-link <?php echo $sidebar['item_active'] == 'fmc' ? 'active' : '' ?>">Best FMC</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/customer/sales_bw" class="nav-link <?php echo $sidebar['item_active'] == 'sales_bw' ? 'active' : '' ?>">Best Sales BW</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/customer/sales_hsi" class="nav-link <?php echo $sidebar['item_active'] == 'sales_hsi' ? 'active' : '' ?>">Best Sales HSI</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/customer/cnop" class="nav-link <?php echo $sidebar['item_active'] == 'cnop' ? 'active' : '' ?>">Best CNOP</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/customer/wifi_revitalization" class="nav-link <?php echo $sidebar['item_active'] == 'wifi_revitalization' ? 'active' : '' ?>">Best Wifi Revitalization</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/customer/cust_order_exec" class="nav-link <?php echo $sidebar['item_active'] == 'cust_order_exec' ? 'active' : '' ?>">Best Customer Order Exec</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/customer/reduce_churn" class="nav-link <?php echo $sidebar['item_active'] == 'reduce_churn' ? 'active' : '' ?>">Best Reduce Churn</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/customer/cust_touch_point" class="nav-link <?php echo $sidebar['item_active'] == 'cust_touch_point' ? 'active' : '' ?>">Best Customer Touch Point</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-group col">
                                <div class="row">
                                    <div class="col-12">
                                        <p class="category-heading">Internal Business Process</p>
                                        <div class="submenu-item">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <ul>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/internal_business_process/fulfillment_perf" class="nav-link <?php echo $sidebar['item_active'] == 'fulfillment_perf' ? 'active' : '' ?>">Best Fulfillment Performance</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/internal_business_process/fulfillment_indihome" class="nav-link <?php echo $sidebar['item_active'] == 'fulfillment_indihome' ? 'active' : '' ?>">Best Fulfillment Indihome</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/internal_business_process/fulfillment_mobile_wib" class="nav-link <?php echo $sidebar['item_active'] == 'fulfillment_mobile_wib' ? 'active' : '' ?>">Best Fulfillment Mobile & Wib</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/internal_business_process/delivery_bges" class="nav-link <?php echo $sidebar['item_active'] == 'delivery_bges' ? 'active' : '' ?>">Best Delivery BGES</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/internal_business_process/capex_cons" class="nav-link <?php echo $sidebar['item_active'] == 'capex_cons' ? 'active' : '' ?>">Best Capex Cons</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/internal_business_process/assurance_indihome" class="nav-link <?php echo $sidebar['item_active'] == 'assurance_indihome' ? 'active' : '' ?>">Best Assurance Indihome</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/internal_business_process/assurance_bges" class="nav-link <?php echo $sidebar['item_active'] == 'assurance_bges' ? 'active' : '' ?>">Best Assurance BGES</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/internal_business_process/assurance_mobile_wib" class="nav-link <?php echo $sidebar['item_active'] == 'assurance_mobile_wib' ? 'active' : '' ?>">Best Assurance Mobile & Wib</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/internal_business_process/customer_experience" class="nav-link <?php echo $sidebar['item_active'] == 'customer_experience' ? 'active' : '' ?>">Best Customer Experience</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/internal_business_process/collecting_nte" class="nav-link <?php echo $sidebar['item_active'] == 'collecting_nte' ? 'active' : '' ?>">Best Collecting NTE</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/internal_business_process/access_cx" class="nav-link <?php echo $sidebar['item_active'] == 'access_cx' ? 'active' : '' ?>">Best Access CX</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/internal_business_process/wifi_operation" class="nav-link <?php echo $sidebar['item_active'] == 'wifi_operation' ? 'active' : '' ?>">Best Wifi Operation</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-group col">
                                <div class="row">
                                    <div class="col-12">
                                        <p class="category-heading">Learning & Growth</p>
                                        <div class="submenu-item">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <ul>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/learning_growth/broadband_champion" class="nav-link <?php echo $sidebar['item_active'] == 'broadband_champion' ? 'active' : '' ?>">Best Broadband Champion</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/learning_growth/add_on" class="nav-link <?php echo $sidebar['item_active'] == 'add_on' ? 'active' : '' ?>">Best Add On</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/learning_growth/product_digital" class="nav-link <?php echo $sidebar['item_active'] == 'product_digital' ? 'active' : '' ?>">Product Digital</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/learning_growth/ba_cnop" class="nav-link <?php echo $sidebar['item_active'] == 'ba_cnop' ? 'active' : '' ?>">BA CNOP</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/learning_growth/digital_platform_service" class="nav-link <?php echo $sidebar['item_active'] == 'digital_platform_service' ? 'active' : '' ?>">Best Digital Platform & Service</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/learning_growth/mo_spbu" class="nav-link <?php echo $sidebar['item_active'] == 'mo_spbu' ? 'active' : '' ?>">MO SPBU</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/learning_growth/enom_utilization" class="nav-link <?php echo $sidebar['item_active'] == 'enom_utilization' ? 'active' : '' ?>">ENOM Utilization</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-group col">
                                <div class="row">
                                    <div class="col-12">
                                        <p class="category-heading">Special Reward</p>
                                        <div class="submenu-item">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <ul>
                                                        <li class="nav-item">
                                                            <a href="<?php echo base_url(); ?>index.php/rewards_regional/data/special_reward/evp_notes" class="nav-link <?php echo $sidebar['item_active'] == 'evp_notes' ? 'active' : '' ?>">EVP Notes</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <?php if (in_array($user->role, ['UPLOADER', 'ADMIN'])) : ?>
                    <li class="nav-item <?php echo $sidebar['parent_active'] ?? $sidebar['category_active'] == 'rewards_regional' ? 'active' : '' ?>">
                        <a href="#" class="nav-link">
                            <i class="link-icon" data-feather="upload"></i>
                            <span class="menu-title">Uploader</span>
                            <i class="link-arrow"></i>
                        </a>
                        <div class="submenu">
                            <div class="col-group-wrapper row">
                                <div class="col-group col">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="submenu-item">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <ul>
                                                            <li class="nav-item">
                                                                <a href="<?php echo base_url(); ?>index.php/rewards_regional/uploader/index" class="nav-link <?php echo $sidebar['parent_active'] ?? $sidebar['category_active'] == 'upload_data' ? 'active' : '' ?>">Upload Data</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a href="<?php echo base_url(); ?>index.php/rewards_regional/uploader/upload_history" class="nav-link <?php echo $sidebar['parent_active'] ?? $sidebar['category_active'] == 'upload_history' ? 'active' : '' ?>">Upload History</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</div>

<script>
    function doLogout() {
        document.getElementById("loggedOut").submit();
    }
</script>
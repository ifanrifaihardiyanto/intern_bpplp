<li class="nav-item <?= $sidebar['category_active'] == 'Summary' ? 'active' : '' ?>">
    <a href="<?= base_url(); ?>index.php/rewards/summary" class="nav-link">
        <i class="link-icon" data-feather="activity"></i>
        <span class="link-title">Summary</span>
    </a>
</li>
<li class="nav-item <?= $sidebar['category_active'] == 'Financial' ? 'active' : '' ?>">
    <a class="nav-link" data-toggle="collapse" href="#financial" role="button" aria-expanded="<?= $sidebar['category_active'] == 'Financial' ? 'true' : 'false' ?>" aria-controls="financial">
        <i class="link-icon" data-feather="credit-card"></i>
        <span class="link-title">Financial</span>
        <i class="link-arrow" data-feather="chevron-down"></i>
    </a>
    <div class="<?= $sidebar['category_active'] == 'Financial' ? 'show active' : 'collapse' ?>" id="financial">
        <ul class="nav sub-menu">
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards/financial/financial" class="nav-link <?= $sidebar['item_active'] == 'best_financial' ? 'active' : '' ?>">Best Financial</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards/financial/best_capex" class="nav-link <?= $sidebar['item_active'] == 'best_capex' ? 'active' : '' ?>">Best of CAPEX</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards/financial/collection" class="nav-link <?= $sidebar['item_active'] == 'collection' ? 'active' : '' ?>">Best Collection</a>
            </li>
        </ul>
    </div>
</li>
<li class="nav-item <?= $sidebar['category_active'] == 'Customer Experience' ? 'active' : '' ?>">
    <a class="nav-link" data-toggle="collapse" href="#customerExperience" role="button" aria-expanded="<?= $sidebar['category_active'] == 'Customer Experience' ? 'true' : 'false' ?>" aria-controls="customerExperience">
        <i class="link-icon" data-feather="users"></i>
        <span class="link-title">Customer Experience</span>
        <i class="link-arrow" data-feather="chevron-down"></i>
    </a>
    <div class="<?= $sidebar['category_active'] == 'Customer Experience' ? 'show active' : 'collapse' ?>" id="customerExperience">
        <ul class="nav sub-menu">
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards/customer_experience/best_quality_assurance" class="nav-link <?= $sidebar['item_active'] == 'best_quality_assurance' ? 'active' : '' ?>">Best Assurance</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards/customer_experience/best_customer_experience" class="nav-link <?= $sidebar['item_active'] == 'best_customer_experience' ? 'active' : '' ?>">Best Customer Experience</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards/customer_experience/best_digital_channel" class="nav-link <?= $sidebar['item_active'] == 'best_digital_channel' ? 'active' : '' ?>">Best Digital Channel</a>
            </li>
        </ul>
    </div>
</li>
<li class="nav-item <?= $sidebar['category_active'] == 'Customer Monetization' ? 'active' : '' ?>">
    <a class="nav-link" data-toggle="collapse" href="#customerMonetization" role="button" aria-expanded="<?= $sidebar['category_active'] == 'Customer Monetization' ? 'true' : 'false' ?>" aria-controls="customerMonetization">
        <i class="link-icon" data-feather="dollar-sign"></i>
        <span class="link-title">Customer Monetization</span>
        <i class="link-arrow" data-feather="chevron-down"></i>
    </a>
    <div class="<?= $sidebar['category_active'] == 'Customer Monetization' ? 'show active' : 'collapse' ?>" id="customerMonetization">
        <ul class="nav sub-menu">
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards/customer_monetization/best_add_on" class="nav-link <?= $sidebar['item_active'] == 'best_add_on' ? 'active' : '' ?>">Best Add On</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards/customer_monetization/best_digital_product" class="nav-link <?= $sidebar['item_active'] == 'best_digital_product' ? 'active' : '' ?>">Best Digital Product</a>
            </li>
        </ul>
    </div>
</li>
<li class="nav-item <?= $sidebar['category_active'] == 'Customer Penetration' ? 'active' : '' ?>">
    <a class="nav-link" data-toggle="collapse" href="#customerPenetration" role="button" aria-expanded="<?= $sidebar['category_active'] == 'Customer Penetration' ? 'true' : 'false' ?>" aria-controls="customerPenetration">
        <i class="link-icon" data-feather="user-check"></i>
        <span class="link-title">Customer Penetration</span>
        <i class="link-arrow" data-feather="chevron-down"></i>
    </a>
    <div class="<?= $sidebar['category_active'] == 'Customer Penetration' ? 'show active' : 'collapse' ?>" id="customerPenetration">
        <ul class="nav sub-menu">
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards/customer_penetration/broadband_champion" class="nav-link <?= $sidebar['item_active'] == 'broadband_champion' ? 'active' : '' ?>">Broadband Champion</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards/customer_penetration/best_apc" class="nav-link <?= $sidebar['item_active'] == 'best_apc' ? 'active' : '' ?>">Best APC</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards/customer_penetration/best_fulfillment_performance" class="nav-link <?= $sidebar['item_active'] == 'best_fulfillment_performance' ? 'active' : '' ?>">Fulfillment Performance</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards/customer_penetration/jawara_wifi" class="nav-link <?= $sidebar['item_active'] == 'jawara_wifi' ? 'active' : '' ?>">Jawara Wifi</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards/customer_penetration/indihome_reward" class="nav-link <?= $sidebar['item_active'] == 'indihome_reward' ? 'active' : '' ?>">Indihome Reward</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards/customer_penetration/best_fmc_penetration" class="nav-link <?= $sidebar['item_active'] == 'best_fmc_penetration' ? 'active' : '' ?>">Best FMC Penetration</a>
            </li>
        </ul>
    </div>
</li>
<li class="nav-item <?= $sidebar['category_active'] == 'Internal Business Process' ? 'active' : '' ?>">
    <a class="nav-link" data-toggle="collapse" href="#internal_business" role="button" aria-expanded="<?= $sidebar['category_active'] == 'Internal Business Process' ? 'true' : 'false' ?>" aria-controls="internal_business">
        <i class="link-icon" data-feather="briefcase"></i>
        <span class="link-title">Internal Business Process</span>
        <i class="link-arrow" data-feather="chevron-down"></i>
    </a>
    <div class="<?= $sidebar['category_active'] == 'Internal Business Process' ? 'show active' : 'collapse' ?>" id="internal_business">
        <ul class="nav sub-menu">
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards/internal_business/best_loss_management" class="nav-link <?= $sidebar['item_active'] == 'best_loss_management' ? 'active' : '' ?>">Best Healthy Customer</a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url(); ?>index.php/rewards/internal_business/best_collecting_nte" class="nav-link <?= $sidebar['item_active'] == 'best_collecting_nte' ? 'active' : '' ?>">Best Collecting NTE</a>
            </li>
        </ul>
    </div>
</li>
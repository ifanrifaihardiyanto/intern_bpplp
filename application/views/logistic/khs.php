<?php
extract($data);
extract($sidebar);
// print('<pre>' . print_r($data, true) . '</pre>');
// exit;
?>

<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?= $parent_active ?></li>
        <li class="breadcrumb-item"><?= $category_active ?></li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <!-- Filter Form -->
                <div class="row">
                    <div class="col-md-12">
                        <form action="#" method="POST">
                            <div class="form-row align-items-end">
                                <div class="form-group mr-3">
                                    <h6 class="card-title">Bulan</h6>
                                    <div class="input-group date datepicker" id="monthPickerExample">
                                        <input type="text" name="month" class="form-control" id="month" value="<?= date('Y-m', strtotime($filter['month'])); ?>">
                                        <span class="input-group-addon"><i data-feather="calendar" class=" text-primary"></i></span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="form-group">
                                        <button id="filterButton" class="btn btn-primary" type="button" onclick="onFilterSubmitted()" style="height: 35px;">FILTER</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <hr>

                <div id="showBtnScrapeButton"></div>

                <hr>

                <!-- Table -->
                <div class="row">
                    <div class="col-12">
                        <h6 class="card-title">DATA KHS</h6>

                        <!-- <div class="table-responsive"> -->
                        <table id="khs_table" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>CERTIFICATE NUMBER</th>
                                    <th>COMPANY NAME</th>
                                    <th>DEVICE NAME</th>
                                    <th>BRAND NAME</th>
                                    <th>MADE IN</th>
                                    <th>TYPE</th>
                                    <th>CAPACITY/SPEED/ASSET NUMBER</th>
                                    <th>TEST REFERENCE</th>
                                    <th>TKDN CERTIFICATE NUMBER</th>
                                    <th>TKDN VALUE</th>
                                    <th>VALID UNTIL</th>
                                </tr>
                            </thead>
                        </table>
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src=" <?= base_url(); ?>assets/js/reward/date.js">
</script>
<script>
    function buttonLoading(isLoading) {
        const buttonSubmit = $('#filterButton');
        if (isLoading) {
            buttonSubmit[0].innerText = null;
            buttonSubmit.prop('disabled', true);
            buttonSubmit.append(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`);
        } else {
            buttonSubmit.prop('disabled', false);
            buttonSubmit[0].innerHTML = 'FILTER';
        }
    }

    function buttonLoadingScraping(isLoading, btnTextVal) {
        const buttonSubmit = $('#scrapeButton');
        if (isLoading) {
            buttonSubmit[0].innerText = null;
            buttonSubmit.prop('disabled', true);
            buttonSubmit.append(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`);
        } else {
            buttonSubmit.prop('disabled', false);
            buttonSubmit[0].innerHTML = `${btnTextVal}`;
        }
    }

    $(document).ready(() => {
        onFilterSubmitted();
    });

    function onFilterSubmitted() {
        let date = $("#month").val();
        // dataBodyLoading(true);
        getData(date);
    }

    function getData(date) {
        // buttonLoading(true);

        $(document).ready(() => {
            // Get button scrape
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() . "index.php/logistic/khs/ajax_post_get_data_filter" ?>',
                data: {
                    "month": date,
                },
                success: (response) => {
                    console.log(response);

                    htmlButton = '';
                    htmlButton += `<button id="scrapeButton" class="btn btn-info" type="button" onclick="onScrapeSubmitted()" style="height: 35px;">${response.btnScrape}</button>`
                    htmlButton += `<input type="text" name="showValBtnScrape" id="showValBtnScrape" value="${response.btnScrape}" hidden>`
                    $('#showBtnScrapeButton')[0].innerHTML = htmlButton;

                    // buttonLoading(false);
                },
                error: (error) => {
                    console.log(error);

                    // buttonLoading(false);
                }
            });

            // Get data view
            $('#khs_table').DataTable().destroy();

            $('#khs_table').DataTable({
                "ajax": {
                    "type": "POST",
                    "url": '<?php echo base_url() . "index.php/logistic/khs/ajax_post_get_data" ?>',
                    "dataSrc": "",
                    "data": {
                        "month": date,
                    },
                    // success: (response) => {

                    //     // console.log(response);
                    // },
                },
                "ordering": false,
                "columns": [{
                        "data": "certificate_number"
                    },
                    {
                        "data": "company_name"
                    },
                    {
                        "data": "device_name"
                    },
                    {
                        "data": "brand_name"
                    },
                    {
                        "data": "made_in"
                    },
                    {
                        "data": "type"
                    },
                    {
                        "data": "details"
                    },
                    {
                        "data": "test_reference"
                    },
                    {
                        "data": "tkdn_certif_num"
                    },
                    {
                        "data": "tkdn_value"
                    },
                    {
                        "data": "valid_until"
                    },
                ],
                "fixedHeader": true,
                "scrollX": true,
                "scrollCollapse": true,
                "scrollY": "500px",
                "fixedColumns": {
                    "left": 1,
                },
                "dom": 'Bfrtip',
                "buttons": [
                    'excel', 'csv'
                ]
            });
        });
    }

    function onScrapeSubmitted() {
        buttonLoadingScraping(true, '');

        let getBtnScrapeTextVal = $("#showValBtnScrape").val();
        let date = $("#month").val();

        $(document).ready(() => {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() . "index.php/scraping/scrape/index" ?>',
                data: {
                    "month": date,
                },
                success: (response) => {
                    console.log(response);

                    onFilterSubmitted();
                    buttonLoadingScraping(false, getBtnScrapeTextVal);
                },
                error: (error) => {
                    console.log(error);

                    buttonLoadingScraping(false, getBtnScrapeTextVal);
                }
            });
        });
    }
</script>
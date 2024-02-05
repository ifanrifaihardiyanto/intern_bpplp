<?php
extract($data);
extract($sidebar);
// print('<pre>' . print_r($data, true) . '</pre>');
// print('<pre>' . print_r($sidebar, true) . '</pre>');
// print('<pre>' . print_r($filter_data->categories, true) . '</pre>');
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
                        <form action="<?= base_url(); ?>index.php/komitmen/komitmen/komitmen_witel" method="POST">
                            <div class="form-row align-items-end">
                                <div class="form-group mr-3">
                                    <h6 class="card-title">Bulan</h6>
                                    <div class="input-group date datepicker" id="monthPickerExample">
                                        <input type="text" name="month" class="form-control" id="month" value="<?= date('Y-m', strtotime($filter['month'])); ?>">
                                        <span class="input-group-addon"><i data-feather="calendar" class=" text-primary"></i></span>
                                    </div>
                                </div>
                                <!-- show or hide Week Number -->
                                <div class="form-group mr-3" id="showOrHideWeekSelection">
                                    <label>Minggu</label>
                                    <select class="form-control" name="week" id="weekSelection">
                                    </select>
                                </div>
                                <div class="form-group mr-3">
                                    <label>Area</label>
                                    <select class="form-control" name="area" id="areaSelection">
                                        <?php foreach ($filter_data->area as $area) : ?>
                                            <option value="<?= $area ?>" <?= $filter['area'] == $area ? 'selected' : '' ?>><?= $area ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group mr-3" id="regionalShowOrHide">
                                    <label>Regional</label>
                                    <select class="form-control" name="regional" id="regionalSelection">
                                        <?php foreach ($filter_data->regional as $regional) : ?>
                                            <option value="<?= $regional ?>" <?= $filter['regional'] == $regional ? 'selected' : '' ?>><?= $regional ?></option>
                                        <?php endforeach; ?>
                                    </select>
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

                <!-- Table -->
                <div class="row">
                    <div class="col-12">
                        <h6 class="card-title">DATA PENDING</h6>

                        <div class="table-responsive">
                            <table id="regional" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th rowspan="3"> SEGMENT</th>
                                        <th colspan="8"> STATUS DOKUMEN</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2"> CLOSED</th>
                                        <th colspan="2"> UNDER REVIEW</th>
                                        <th colspan="2"> NOT CLOSED</th>
                                        <th colspan="2"> TOTAL</th>
                                    </tr>
                                    <tr>
                                        <th>JUMLAH</th>
                                        <th>%</th>
                                        <th>JUMLAH</th>
                                        <th>%</th>
                                        <th>JUMLAH</th>
                                        <th>%</th>
                                        <th>JUMLAH</th>
                                        <th>%</th>
                                    </tr>
                                </thead>
                                <tbody id="dataBodyDataPending"></tbody>
                            </table>
                        </div>

                        <br>

                        <h6 class="card-title">DETAIL KONFIRMASI</h6>

                        <div class="table-responsive">
                            <table id="regional" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th rowspan="3"> SEGMENT</th>
                                        <th colspan="8"> STATUS KONFIRMASI</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2"> CLOSED</th>
                                        <th colspan="2"> UNDER REVIEW</th>
                                        <th colspan="2"> NOT CLOSED</th>
                                        <th colspan="2"> TOTAL</th>
                                    </tr>
                                    <tr>
                                        <th>JUMLAH</th>
                                        <th>%</th>
                                        <th>JUMLAH</th>
                                        <th>%</th>
                                        <th>JUMLAH</th>
                                        <th>%</th>
                                        <th>JUMLAH</th>
                                        <th>%</th>
                                    </tr>
                                </thead>
                                <tbody id="dataBodyConfirmationDetail"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url(); ?>assets/js/reward/date.js"></script>
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

    // function dataBodyLoading(isLoading) {
    //     const dataBody = $('#dataBody');
    //     if (isLoading) {
    //         dataBody[0].innerText = null;
    //         dataBody.prop('disabled', true);
    //         dataBody.append(`<tr>
    //                             <td colspan="100%" class="text-center">
    //                                 <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
    //                             </td>
    //                         </tr>`);
    //     } else {
    //         dataBody.prop('disabled', false);
    //         dataBody[0].innerHTML = '';
    //     }
    // }

    $(document).ready(() => {
        $('#regionalShowOrHide').prop('hidden', true);

        $('#areaSelection').on('change', function() {
            let optionValue = $(this).val();

            if (optionValue == 'REGIONAL') {
                $('#regionalShowOrHide').prop('hidden', true);
            } else {
                $('#regionalShowOrHide').prop('hidden', false);
            }
        });

        let date = $("#month").val();
        getDataWeekOnMonth(date);
        $('#month').on('change', function() {
            let optionValue = $(this).val();
            getDataWeekOnMonth(optionValue);
        });

        onFilterSubmitted();
    });

    function getDataWeekOnMonth(date) {
        $(document).ready(() => {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() . "index.php/revenue_assurance/psak/ajax_post_get_data_week" ?>',
                data: {
                    "month": date,
                    "category": '<?= $item_active ?>',
                },
                success: (response) => {
                    htmlOption = '';

                    let keys = Object.keys(response);

                    if (response.data && keys.length !== 0) {
                        $.each(response.data, (params, paramItems) => {
                            htmlOption += `<option value="${paramItems}">Minggu ke ${paramItems}</option>`
                        });
                    } else {
                        htmlOption += `<option value="" selected disabled>Week not found.</option>`
                    }

                    $('#weekSelection')[0].innerHTML = htmlOption;

                    buttonLoading(false);
                },
                error: (error) => {
                    console.log(error);

                    buttonLoading(false);
                }
            });
        });
    }

    function onFilterSubmitted() {
        let date = $("#month").val();
        let area = $("#areaSelection option:selected").text()
        let regional = $("#regionalSelection option:selected").text()
        let week = $("#weekSelection option:selected").text()
        // dataBodyLoading(true);
        getData(date, area, regional, week);
    }

    function getData(date, area, regional, week) {
        // buttonLoading(true);

        $(document).ready(() => {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() . "index.php/revenue_assurance/psak/ajax_post_get_data" ?>',
                data: {
                    "month": date,
                    "category": '<?= $item_active ?>',
                    "show": area,
                    "regional": regional,
                    "week": week,
                },
                success: (response) => {

                    let textHtmlDataPending = '';
                    let textHtmlConfirmationDetail = '';

                    let keys_data_pending = Object.keys(response.data.data_pending);

                    if (response.data.data_pending && keys_data_pending.length !== 0) {
                        $.each(response.data.data_pending, (witel, dataItems) => {
                            // console.log(dataItems);
                            textHtmlDataPending += `<tr><td>${dataItems.segment_name}</td>`
                            textHtmlDataPending += `<td>${dataItems.total_closed}</td>`
                            textHtmlDataPending += `<td>${dataItems.persentase_closed}</td>`
                            textHtmlDataPending += `<td>${dataItems.total_under_review}</td>`
                            textHtmlDataPending += `<td>${dataItems.persentase_under_review}</td>`
                            textHtmlDataPending += `<td>${dataItems.total_not_closed}</td>`
                            textHtmlDataPending += `<td>${dataItems.persentase_not_closed}</td>`
                            textHtmlDataPending += `<td>${dataItems.total}</td>`
                            textHtmlDataPending += `<td>${dataItems.persentase_total}</td>`
                            textHtmlDataPending += `</tr>`
                        });
                    } else {
                        textHtmlDataPending += `<tr>
                                        <td colspan="100%" class="text-center">No data found.</td>
                                    </tr>`
                    }

                    $('#dataBodyDataPending')[0].innerHTML = textHtmlDataPending;

                    let keys_confirm_detail = Object.keys(response.data.confirmation_detail);

                    if (response.data.confirmation_detail && keys_confirm_detail.length !== 0) {
                        $.each(response.data.confirmation_detail, (witel, dataItems) => {
                            textHtmlConfirmationDetail += `<tr><td>${dataItems.segment_name}</td>`
                            textHtmlConfirmationDetail += `<td>${dataItems.total_closed}</td>`
                            textHtmlConfirmationDetail += `<td>${dataItems.persentase_closed}</td>`
                            textHtmlConfirmationDetail += `<td>${dataItems.total_under_review}</td>`
                            textHtmlConfirmationDetail += `<td>${dataItems.persentase_under_review}</td>`
                            textHtmlConfirmationDetail += `<td>${dataItems.total_not_closed}</td>`
                            textHtmlConfirmationDetail += `<td>${dataItems.persentase_not_closed}</td>`
                            textHtmlConfirmationDetail += `<td>${dataItems.total}</td>`
                            textHtmlConfirmationDetail += `<td>${dataItems.persentase_total}</td>`
                            textHtmlConfirmationDetail += `</tr>`
                        });
                    } else {
                        textHtmlConfirmationDetail += `<tr>
                                        <td colspan="100%" class="text-center">No data found.</td>
                                    </tr>`
                    }

                    $('#dataBodyConfirmationDetail')[0].innerHTML = textHtmlConfirmationDetail;

                    buttonLoading(false);
                },
                error: (error) => {
                    console.log(error);

                    buttonLoading(false);
                }
            });
        });
    }

    // function onExportExcelRealisasiSubmitted() {
    //     let ubis = $("#ubisSelector").val();
    //     let parameter = $("#parameterSelector").val();

    //     let fileName = `${parameter} ${ubis}`

    //     $(".table2excelForRealisasi").table2excel({
    //         exclude: ".excludeThisClass",
    //         name: "Worksheet Name",
    //         filename: "Realisasi " + fileName + ".xls",
    //         preserveColors: false // set to true if you want background colors and font colors preserved
    //     });
    // }
</script>
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
                        <h6 class="card-title">STEP 1-4</h6>

                        <div class="table-responsive">
                            <table id="step1on4" class="table table-bordered table-hover">
                                <thead id="dataHeaderStep1to4"></thead>
                                <tbody id="dataBodyStep1to4"></tbody>
                            </table>
                        </div>

                        <br>

                        <h6 class="card-title">STEP 5</h6>

                        <div class="table-responsive">
                            <table id="step5" class="table table-bordered table-hover">
                                <thead id="dataHeaderStep5"></thead>
                                <tbody id="dataBodyStep5"></tbody>
                            </table>
                        </div>

                        <br>

                        <h6 class="card-title">LIST KONFIRMASI</h6>

                        <div class="table-responsive">
                            <table id="regional" class="table table-bordered table-hover">
                                <thead id="dataHeaderListKonfirmasi"></thead>
                                <tbody id="dataBodyListKonfirmasi"></tbody>
                            </table>
                        </div>

                        <br>

                        <h6 class="card-title">UNIDENTIFIED</h6>

                        <div class="table-responsive">
                            <table id="regional" class="table table-bordered table-hover">
                                <thead id="dataHeaderUnidentified"></thead>
                                <tbody id="dataBodyUnidentified"></tbody>
                            </table>
                        </div>

                        <br>

                        <h6 class="card-title">CR VARIABLE</h6>

                        <div class="table-responsive">
                            <table id="regional" class="table table-bordered table-hover">
                                <thead id="dataHeaderCRVariable"></thead>
                                <tbody id="dataBodyListCRVariable"></tbody>
                            </table>
                        </div>

                        <br>

                        <h6 class="card-title">KONFIRMASI SPLIT BILL</h6>

                        <div class="table-responsive">
                            <table id="regional" class="table table-bordered table-hover">
                                <thead id="dataHeaderKonfirmasiSplitBill"></thead>
                                <tbody id="dataBodyKonfirmasiSplitBill"></tbody>
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
                    let checkCounted = Object.keys(response.data);
                    // console.log(checkCounted.length);
                    console.log(response.data);
                    console.log(response.filter);

                    headerTableBuilder(response.filter);

                    let textHtmlStep1to4 = '';
                    let textHtmlStep5 = '';
                    let textHtmlListKonfirmasi = '';
                    let textHtmlUnidentified = '';
                    let textHtmlCRVariable = '';
                    let textHtmlKonfirmasiSplitBill = '';

                    let keys_step_1_to_4 = Object.keys(response.data.step_1_to_4);

                    if (response.data.step_1_to_4 && keys_step_1_to_4.length !== 0) {
                        $.each(response.data.step_1_to_4, (witel, dataItems) => {
                            textHtmlStep1to4 += `<tr><td>${dataItems.segment_name}</td>`
                            textHtmlStep1to4 += `<td>${dataItems.total_pending}</td>`
                            textHtmlStep1to4 += `<td>${formatter.million(dataItems.total_tibs_value)}</td>`
                            textHtmlStep1to4 += `<td>${dataItems.total_closed}</td>`
                            textHtmlStep1to4 += `<td>${formatter.million(dataItems.closed_tibs_value)}</td>`
                            textHtmlStep1to4 += `<td>${dataItems.total_not_closed}</td>`
                            textHtmlStep1to4 += `<td>${formatter.million(dataItems.not_closed_tibs_value)}</td>`
                            if (response.filter.area == 'REGIONAL') {
                                textHtmlStep1to4 += `<td>${dataItems.total_on_check}</td>`
                                textHtmlStep1to4 += `<td>${formatter.million(dataItems.on_check_tibs_value)}</td>`
                                textHtmlStep1to4 += `<td>${dataItems.persetase_closed}%</td>`
                            } else {
                                textHtmlStep1to4 += `<td>${dataItems.persentase_contract}%</td>`
                                textHtmlStep1to4 += `<td>${dataItems.persentase_rev}%</td>`
                            }
                            textHtmlStep1to4 += `</tr>`
                        });
                    } else {
                        textHtmlStep1to4 += `<tr>
                                        <td colspan="100%" class="text-center">No data found.</td>
                                    </tr>`
                    }

                    $('#dataBodyStep1to4')[0].innerHTML = textHtmlStep1to4;

                    let keys_step_5 = Object.keys(response.data.step_5);

                    if (response.data.step_5 && keys_step_5.length !== 0) {
                        $.each(response.data.step_5, (witel, dataItems) => {
                            textHtmlStep5 += `<tr><td>${dataItems.segment_name}</td>`
                            textHtmlStep5 += `<td>${dataItems.total_pending}</td>`
                            textHtmlStep5 += `<td>${formatter.million(dataItems.total_tibs_value)}</td>`
                            textHtmlStep5 += `<td>${dataItems.total_closed}</td>`
                            textHtmlStep5 += `<td>${formatter.million(dataItems.closed_tibs_value)}</td>`
                            textHtmlStep5 += `<td>${dataItems.total_not_closed}</td>`
                            textHtmlStep5 += `<td>${formatter.million(dataItems.not_closed_tibs_value)}</td>`
                            if (response.filter.area == 'REGIONAL') {
                                textHtmlStep5 += `<td>${dataItems.total_on_check}</td>`
                                textHtmlStep5 += `<td>${formatter.million(dataItems.on_check_tibs_value)}</td>`
                                textHtmlStep5 += `<td>${dataItems.persetase_closed}%</td>`
                            } else {
                                textHtmlStep5 += `<td>${dataItems.persentase_contract}%</td>`
                                textHtmlStep5 += `<td>${dataItems.persentase_rev}%</td>`
                            }
                            textHtmlStep5 += `</tr>`
                        });
                    } else {
                        textHtmlStep5 += `<tr>
                                        <td colspan="100%" class="text-center">No data found.</td>
                                    </tr>`
                    }

                    $('#dataBodyStep5')[0].innerHTML = textHtmlStep5;

                    let keys_confirm_list = Object.keys(response.data.confirmation_list);

                    if (response.data.confirmation_list && keys_confirm_list.length !== 0) {
                        $.each(response.data.confirmation_list, (witel, dataItems) => {
                            textHtmlListKonfirmasi += `<tr><td>${dataItems.segment_name}</td>`
                            textHtmlListKonfirmasi += `<td>${dataItems.total_pending}</td>`
                            textHtmlListKonfirmasi += `<td>${formatter.million(dataItems.total_tibs_value)}</td>`
                            textHtmlListKonfirmasi += `<td>${dataItems.total_closed}</td>`
                            textHtmlListKonfirmasi += `<td>${formatter.million(dataItems.closed_tibs_value)}</td>`
                            textHtmlListKonfirmasi += `<td>${dataItems.total_not_closed}</td>`
                            textHtmlListKonfirmasi += `<td>${formatter.million(dataItems.not_closed_tibs_value)}</td>`
                            if (response.filter.area == 'REGIONAL') {
                                textHtmlListKonfirmasi += `<td>${dataItems.total_on_check}</td>`
                                textHtmlListKonfirmasi += `<td>${formatter.million(dataItems.on_check_tibs_value)}</td>`
                                textHtmlListKonfirmasi += `<td>${dataItems.persetase_closed}%</td>`
                            } else {
                                textHtmlListKonfirmasi += `<td>${dataItems.persentase_contract}%</td>`
                                textHtmlListKonfirmasi += `<td>${dataItems.persentase_rev}%</td>`
                            }
                            textHtmlListKonfirmasi += `</tr>`
                        });
                    } else {
                        textHtmlListKonfirmasi += `<tr>
                                        <td colspan="100%" class="text-center">No data found.</td>
                                    </tr>`
                    }

                    $('#dataBodyListKonfirmasi')[0].innerHTML = textHtmlListKonfirmasi;


                    let keys_unidentified = Object.keys(response.data.unidentified_kb);

                    if (response.data.unidentified_kb && keys_unidentified.length !== 0) {
                        $.each(response.data.unidentified_kb, (witel, dataItems) => {
                            textHtmlUnidentified += `<tr><td>${dataItems.segment_name}</td>`
                            textHtmlUnidentified += `<td>${dataItems.total_pending}</td>`
                            textHtmlUnidentified += `<td>${dataItems.total_closed}</td>`
                            textHtmlUnidentified += `<td>${dataItems.total_not_closed}</td>`
                            // textHtmlUnidentified += `<td>${dataItems.total_on_check}</td>`
                            // textHtmlUnidentified += `<td>${dataItems.on_check_tibs_value}</td>`
                            textHtmlUnidentified += `<td>${dataItems.persetase_closed}%</td>`
                            textHtmlUnidentified += `</tr>`
                        });
                    } else {
                        textHtmlUnidentified += `<tr>
                                        <td colspan="100%" class="text-center">No data found.</td>
                                    </tr>`
                    }

                    $('#dataBodyUnidentified')[0].innerHTML = textHtmlUnidentified;


                    let keys_cr_variable = Object.keys(response.data.cr_variable);

                    if (response.data.cr_variable && keys_cr_variable.length !== 0) {
                        $.each(response.data.cr_variable, (witel, dataItems) => {
                            textHtmlCRVariable += `<tr><td>${dataItems.segment_name}</td>`
                            textHtmlCRVariable += `<td>${dataItems.total_pending}</td>`
                            textHtmlCRVariable += `<td>${dataItems.total_closed}</td>`
                            textHtmlCRVariable += `<td>${dataItems.total_not_closed}</td>`
                            // textHtmlCRVariable += `<td>${dataItems.total_on_check}</td>`
                            // textHtmlCRVariable += `<td>${dataItems.on_check_tibs_value}</td>`
                            textHtmlCRVariable += `<td>${dataItems.persetase_closed}%</td>`
                            textHtmlCRVariable += `</tr>`
                        });
                    } else {
                        textHtmlCRVariable += `<tr>
                                        <td colspan="100%" class="text-center">No data found.</td>
                                    </tr>`
                    }

                    $('#dataBodyListCRVariable')[0].innerHTML = textHtmlCRVariable;


                    let keys_confirm_split_bill = Object.keys(response.data.confirm_split_bill);

                    if (response.data.confirm_split_bill && keys_confirm_split_bill.length !== 0) {
                        $.each(response.data.confirm_split_bill, (witel, dataItems) => {
                            textHtmlKonfirmasiSplitBill += `<tr><td>${dataItems.segment_name}</td>`
                            textHtmlKonfirmasiSplitBill += `<td>${dataItems.total_pending}</td>`
                            textHtmlKonfirmasiSplitBill += `<td>${dataItems.total_closed}</td>`
                            textHtmlKonfirmasiSplitBill += `<td>${dataItems.total_not_closed}</td>`
                            // textHtmlKonfirmasiSplitBill += `<td>${dataItems.total_on_check}</td>`
                            // textHtmlKonfirmasiSplitBill += `<td>${dataItems.on_check_tibs_value}</td>`
                            textHtmlKonfirmasiSplitBill += `<td>${dataItems.persetase_closed}%</td>`
                            textHtmlKonfirmasiSplitBill += `</tr>`
                        });
                    } else {
                        textHtmlKonfirmasiSplitBill += `<tr>
                                        <td colspan="100%" class="text-center">No data found.</td>
                                    </tr>`
                    }

                    $('#dataBodyKonfirmasiSplitBill')[0].innerHTML = textHtmlKonfirmasiSplitBill;

                    buttonLoading(false);
                },
                error: (error) => {
                    console.log(error);

                    buttonLoading(false);
                }
            });
        });
    }

    function headerTableBuilder(filters) {
        let textHtml1 = '';
        let textHtml2 = '';

        let textHtmlStep1to4 = '';
        let textHtmlStep5 = '';
        let textHtmlListKonfirmasi = '';
        let textHtmlUnidentified = '';
        let textHtmlCRVariable = '';
        let textHtmlKonfirmasiSplitBill = '';

        textHtmlStep1to4 += `<tr><th colspan="12">${filters.area} (STEP 1-4) *Satuan Kontrak</th></tr>`
        textHtmlStep5 += `<tr><th colspan="12">${filters.area} (STEP 5) *Satuan Order</th></tr>`
        textHtmlListKonfirmasi += `<tr><th colspan="12">${filters.area} (Konfirmasi) *Satuan Kontrak</th></tr>`
        textHtmlUnidentified += `<tr><th colspan="7">${filters.area} (Unidentified) *Satuan Kontrak</th></tr>`
        textHtmlCRVariable += `<tr><th colspan="7">${filters.area} (CR Variable) *Satuan Kontrak</th></tr>`
        textHtmlKonfirmasiSplitBill += `<tr><th colspan="7">${filters.area} (Konfirmasi Split Bill) *Satuan Kontrak</th></tr>`

        if (filters.area == 'REGIONAL') {
            textHtml1 += `<tr><th>SEGMEN</th>`
            textHtml1 += `<th>TOTAL PENDING</th>`
            textHtml1 += `<th>TOTAL (TIBS VALUE)</th>`
            textHtml1 += `<th>CLOSED</th>`
            textHtml1 += `<th>CLOSED (TIBS VALUE)</th>`
            textHtml1 += `<th>NOT CLOSED</th>`
            textHtml1 += `<th>NOT CLOSED (TIBS VALUE)</th>`
            textHtml1 += `<th>ON CHECK</th>`
            textHtml1 += `<th>ON CHECK (TIBS VALUE)</th>`
            textHtml1 += `<th>% CLOSED</th>`
            textHtml1 += `</tr>`

            textHtml2 += `<tr><th>SEGMEN</th>`
            textHtml2 += `<th>TOTAL PENDING</th>`
            textHtml2 += `<th>CLOSED</th>`
            textHtml2 += `<th>NOT CLOSED</th>`
            textHtml2 += `<th>% CLOSED</th>`
            textHtml2 += `</tr>`
        } else {
            textHtml1 += `<tr><th>SEGMEN</th>`
            textHtml1 += `<th>TOTAL</th>`
            textHtml1 += `<th>TOTAL (TIBS VALUE)</th>`
            textHtml1 += `<th>CLOSED</th>`
            textHtml1 += `<th>CLOSED (TIBS VALUE)</th>`
            textHtml1 += `<th>NOT CLOSED</th>`
            textHtml1 += `<th>NOT CLOSED (TIBS VALUE)</th>`
            textHtml1 += `<th>% CLOSED KONTRAK</th>`
            textHtml1 += `<th>% CLOSED REV</th>`
            textHtml1 += `</tr>`

            textHtml2 += `<tr><th>SEGMEN</th>`
            textHtml2 += `<th>TOTAL PENDING</th>`
            textHtml2 += `<th>CLOSED</th>`
            textHtml2 += `<th>NOT CLOSED</th>`
            textHtml2 += `<th>% CLOSED</th>`
            textHtml2 += `</tr>`
        }

        $('#dataHeaderStep1to4')[0].innerHTML = textHtmlStep1to4 + textHtml1;
        $('#dataHeaderStep5')[0].innerHTML = textHtmlStep5 + textHtml1;
        $('#dataHeaderListKonfirmasi')[0].innerHTML = textHtmlListKonfirmasi + textHtml1;
        $('#dataHeaderUnidentified')[0].innerHTML = textHtmlUnidentified + textHtml2;
        $('#dataHeaderCRVariable')[0].innerHTML = textHtmlCRVariable + textHtml2;
        $('#dataHeaderKonfirmasiSplitBill')[0].innerHTML = textHtmlKonfirmasiSplitBill + textHtml2;
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
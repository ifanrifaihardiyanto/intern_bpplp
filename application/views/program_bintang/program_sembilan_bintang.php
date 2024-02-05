<?php
extract($data);
extract($sidebar);
?>

<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><?= $parent_active ?></li>
        <li class="breadcrumb-item"><?= $item_active ?></li>
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
                                <div class="form-group mr-3">
                                    <label>Area</label>
                                    <select class="form-control" name="area" id="areaSelection">
                                        <?php foreach ($filter_data->area as $area) : ?>
                                            <option value="<?= $area ?>" <?= $filter['area'] == $area ? 'selected' : '' ?>><?= $area ?></option>
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
                        <h6 class="card-title">PROGRAM 9 BINTANG - <?= $item_active ?></h6>

                        <div class="table-responsive">
                            <table id="khs_table" class="table table-bordered table-hover dt-responsive nowrap cellpadding='0' cellspacing='0' width='100%'">
                                <thead id="dataHead"></thead>
                                <tbody id="dataBody"></tbody>
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

    function dataBodyLoading(isLoading) {
        const dataBody = $('#dataBody');
        if (isLoading) {
            dataBody[0].innerText = null;
            dataBody.prop('disabled', true);
            dataBody.append(`<tr>
                                <td colspan="100%" class="text-center">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                                </td>
                            </tr>`);
        } else {
            dataBody.prop('disabled', false);
            dataBody[0].innerHTML = '';
        }
    }

    $(document).ready(() => {
        onFilterSubmitted();
    });

    function onFilterSubmitted() {
        let date = $("#month").val();
        let area = $("#areaSelection option:selected").text()
        dataBodyLoading(true);
        getData(date, area);
    }

    function getData(date, area) {
        buttonLoading(true);

        $(document).ready(() => {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() . "index.php/program_bintang/program_bintang/ajax_post_get_data" ?>',
                data: {
                    "month": date,
                    "category": '<?= $item_active ?>',
                    "show": area,
                },
                success: (response) => {

                    console.log(response);

                    let textHtml = '';
                    let textHtmlHead = '';
                    let number = 1;
                    let categories = response.filter.category;

                    textHtmlHead += `<tr><th>NO</th>`
                    if (response.filter.area == 'WITEL') {
                        textHtmlHead += `<th>WITEL</th>`
                    }

                    if (response.filter.area == 'DATEL') {
                        textHtmlHead += `<th>WITEL</th>`
                        textHtmlHead += `<th>DATEL</th>`
                    }

                    if (response.filter.area == 'HERO') {
                        textHtmlHead += `<th>WITEL</th>`
                        textHtmlHead += `<th>DATEL</th>`
                        textHtmlHead += `<th>HERO</th>`
                    }

                    // Header table
                    textHtmlHead += `<th>TARGET</th>`
                    textHtmlHead += `<th>REALISASI</th>`
                    textHtmlHead += `<th>ACH</th>`
                    textHtmlHead += `</tr>`

                    let keys_data = Object.keys(response.data);

                    if (response.data && keys_data.length !== 0) {
                        $.each(response.data, (witel, dataItems) => {
                            // console.log(dataItems);
                            textHtml += `<tr><td>${number++}</td>`
                            if (response.filter.area == 'WITEL') {
                                textHtml += `<td>${dataItems.viewed}</td>`
                            }

                            if (response.filter.area == 'DATEL') {
                                textHtml += `<td>${dataItems.witel}</td>`
                                textHtml += `<td>${dataItems.viewed}</td>`
                            }

                            if (response.filter.area == 'HERO') {
                                textHtml += `<td>${dataItems.witel}</td>`
                                textHtml += `<td>${dataItems.datel}</td>`
                                textHtml += `<td>${dataItems.viewed}</td>`
                            }

                            if (categories === 'INDIBIZ SALES' || categories === 'VISITING & PROFILING' || categories === 'EKOSISTEM BISNIS') {
                                textHtml += `<td>${dataItems.tgt}</td>`
                                textHtml += `<td>${dataItems.reals}</td>`
                                textHtml += `<td>${dataItems.ach}%</td>`
                            } else {
                                textHtml += `<td>${dataItems.tgt}%</td>`
                                textHtml += `<td>${dataItems.reals}%</td>`
                                textHtml += `<td>${dataItems.ach}%</td>`
                            }
                            textHtml += `</tr>`
                        });
                    } else {
                        textHtml += `<tr>
                                        <td colspan="100%" class="text-center">No data found.</td>
                                    </tr>`
                    }

                    $('#dataBody')[0].innerHTML = textHtml;
                    $('#dataHead')[0].innerHTML = textHtmlHead;

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
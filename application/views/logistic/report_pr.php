<?php
extract($data);
extract($sidebar);
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
                                    <label>Tanggal Posisi Data</label>
                                    <select class="form-control" name="datePosition" id="datePositionSelection">
                                        <?php foreach ($filter['tgl_posisi_data'] as $date_position) : ?>
                                            <option value="<?= $date_position ?>" <?= $filter_data['max_posisi_data'] == $date_position ? 'selected' : '' ?>><?= $date_position ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group mr-3">
                                    <label for="exampleFormControlSelect1">WBS Element</label>
                                    <select class="form-control" id="wbsSelection" name="wbs">
                                    </select>
                                </div>
                                <div class="form-group mr-3">
                                    <label for="exampleFormControlSelect1">PR Date</label>
                                    <select class="form-control" id="prdateSelection" name="prdate">
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
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table2excel">
                                <thead>
                                    <tr>
                                        <th>WITEL</th>
                                        <th>LOP PR</th>
                                        <th>NILAI PR</th>
                                        <th>LOP PO</th>
                                        <th>NILAI PO</th>
                                        <th>LOP GR</th>
                                        <th>NILAI GR</th>
                                        <th>LOP IR</th>
                                        <th>NILAI IR</th>
                                        <th>% PR PO</th>
                                        <th>% PO GR</th>
                                        <th>% GR IR</th>
                                        <th>SISA LOP PO</th>
                                        <th>BELUM GR</th>
                                    </tr>
                                </thead>
                                <tbody id="dataBody"></tbody>
                            </table>
                        </div>
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

        let datePosition = $("#datePositionSelection").val();
        getWBSElementandPRDate(datePosition);

        $('#datePositionSelection').on('change', function() {
            let getDatePosition = $(this).val();
            getWBSElementandPRDate(getDatePosition);
        });

        onFilterSubmitted();
    });

    function getWBSElementandPRDate(getDatePosition) {
        buttonLoading(true);
        $('#wbsSelection').prop('disabled', true);
        $('#prdateSelection').prop('disabled', true);

        $(document).ready(() => {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() . "index.php/logistic/report_pr/ajax_post_get_data_wbs_element" ?>',
                data: {
                    "datePosition": getDatePosition,
                },
                success: (response) => {
                    htmlOptionWBS = '';
                    htmlOptionPRDate = '';

                    // WBS Option
                    let keysWBS = Object.keys(response.responseWBS);

                    if (response.responseWBS && keysWBS.length !== 0) {
                        htmlOptionWBS += `<option value="%">ALL</option>`
                        $.each(response.responseWBS, (params, paramItems) => {
                            htmlOptionWBS += `<option value="${paramItems.wbs_element}">${paramItems.wbs_element}</option>`
                        });
                    } else {
                        htmlOptionWBS += `<option value="" selected disabled>Category not found.</option>`
                    }

                    $('#wbsSelection')[0].innerHTML = htmlOptionWBS;
                    // WBS Option

                    // PR Date Option
                    let keysPRDate = Object.keys(response.responsePRDate);

                    if (response.responsePRDate && keysPRDate.length !== 0) {
                        htmlOptionPRDate += `<option value="%">ALL</option>`
                        $.each(response.responsePRDate, (params, paramItems) => {
                            htmlOptionPRDate += `<option value="${paramItems.pr_date}">${paramItems.pr_date}</option>`
                        });
                    } else {
                        htmlOptionPRDate += `<option value="" selected disabled>Category not found.</option>`
                    }

                    $('#prdateSelection')[0].innerHTML = htmlOptionPRDate;
                    // PR Date Option

                    buttonLoading(false);
                    $('#wbsSelection').prop('disabled', false);
                    $('#prdateSelection').prop('disabled', false);
                }
            });
        });
    }

    function onFilterSubmitted() {
        let datePosition = $("#datePositionSelection").val();
        let wbsSelection = $("#wbsSelection").val();
        let prdateSelection = $("#prdateSelection").val();
        // dataBodyLoading(true);
        getData(datePosition, wbsSelection, prdateSelection);
    }

    function getData(datePosition, wbsSelection, prdateSelection) {
        // buttonLoading(true);

        $(document).ready(() => {
            // Get button scrape
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() . "index.php/logistic/report_pr/ajax_post_get_data" ?>',
                data: {
                    "month": datePosition,
                    "wbsSelection": wbsSelection,
                    "prdateSelection": prdateSelection,
                },
                success: (response) => {
                    console.log(response);
                    textHtml = '';

                    let keys_data = Object.keys(response.result);

                    if (response.result && keys_data.length !== 0) {
                        $.each(response.result, (witel, dataItems) => {
                            console.log(dataItems);
                            textHtml += `<td>${dataItems.witel}</td>`
                            textHtml += `<td>${formatter.million(dataItems.lop_pr)}</td>`
                            textHtml += `<td>${formatter.million(dataItems.nilai_pr)}</td>`
                            textHtml += `<td>${formatter.million(dataItems.lop_po)}</td>`
                            textHtml += `<td>${formatter.million(dataItems.nilai_po)}</td>`
                            textHtml += `<td>${formatter.million(dataItems.lop_gr)}</td>`
                            textHtml += `<td>${formatter.million(dataItems.nilai_gr)}</td>`
                            textHtml += `<td>${formatter.million(dataItems.lop_ir)}</td>`
                            textHtml += `<td>${formatter.million(dataItems.nilai_ir)}</td>`
                            textHtml += `<td>${dataItems.persentase_pr_po}%</td>`
                            textHtml += `<td>${dataItems.persentase_gr_po}%</td>`
                            textHtml += `<td>${dataItems.persentase_gr_ir}%</td>`
                            textHtml += `<td>${formatter.million(dataItems.sisa_lop)}</td>`
                            textHtml += `<td>${formatter.million(dataItems.belum_po)}</td>`
                            textHtml += `</tr>`
                        });
                    } else {
                        textHtml += `<tr>
                                        <td colspan="100%" class="text-center">No data found.</td>
                                    </tr>`
                    }

                    $('#dataBody')[0].innerHTML = textHtml;
                    // buttonLoading(false);
                },
                error: (error) => {
                    console.log(error);

                    // buttonLoading(false);
                }
            });


        });
    }
</script>
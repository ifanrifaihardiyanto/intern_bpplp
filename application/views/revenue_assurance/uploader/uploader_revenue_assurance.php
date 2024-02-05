<?php
extract($data);
foreach ($data['categories'] as $key) {
    // print('<pre>' . print_r($key, true) . '</pre>');
}
// print('<pre>' . print_r($data, true) . '</pre>');
// exit;
?>
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Management Review</li>
        <li class="breadcrumb-item active">Uploader</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Data Table</h6>

                <div id="displayAlert" style="display: none;"></div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- <div class="form-group">
                            <h6 class="card-title">Bulan</h6>
                            <div class="input-group date datepicker" id="monthPickerExample">
                                <input type="text" name="date" class="form-control" id="month" value="<?= date('Y-m'); ?>">
                                <span class="input-group-addon"><i data-feather="calendar" class=" text-primary"></i></span>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label class="control-label">TANGGAL BOOTCAMP</label>
                            <div class="input-group date datepicker mr-2 mb-2 mb-md-0 d-md-none d-xl-flex" id="dashboardDate">
                                <span class="input-group-addon bg-transparent"><i data-feather="calendar" class=" text-primary"></i></span>
                                <input type="text" name="date" class="form-control" id="dateSelection" date-update="<?= date('d-F-Y', strtotime($filter->date)); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>CATEGORY</label>
                            <select class="form-control" name="category" id="categorySelection">
                                <?php foreach ($data['categories'] as $category) : ?>
                                    <option value="<?= $category ?>"><?= $category ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12" id="showOrHideAreaSelection">
                        <div class="form-group">
                            <label>AREA</label>
                            <select class="form-control" name="area" id="areaSelection">
                                <option value="REGIONAL">REGIONAL</option>
                                <option value="WITEL">WITEL</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12" id="showOrHideSubCategorySelection">
                        <div class="form-group">
                            <label>SUB CATEGORY</label>
                            <select class="form-control" id="subCategorySelector" name="subCategorySelector">
                                <option selected disabled>Pilih Sub Kategori</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="card text-bg-warning mb-3">
                                <div class="card-header">Catatan</div>
                                <div class="card-body">
                                    <!-- <div class="card" style="width: 18rem;"> -->
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">1. Pilih opsi kategori terlebih dahulu sebelum download template,
                                            setiap ada perubahan opsi kategori template akan ikut berubah juga.</li>
                                        <li class="list-group-item">2. Download template excel berikut.</li>

                                        <li class="list-group-item">
                                            <div id="templateUploadFile"></div>
                                        </li>
                                    </ul>
                                    <!-- </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="file" accept=".xls,.xlsx" id="excelDropify" class="border" />
                <br>
                <button type="button" id="uploadExcel" class="btn btn-primary">
                    Upload
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/read-excel-file@5.x/bundle/read-excel-file.min.js"></script>
<script>
    function buttonLoading(isLoading) {
        const buttonSubmit = $('#uploadExcel');
        if (isLoading) {
            buttonSubmit[0].innerText = null;
            buttonSubmit.prop('disabled', true);
            buttonSubmit.append(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`);
        } else {
            buttonSubmit.prop('disabled', false);
            buttonSubmit[0].innerHTML = 'Upload';
        }
    }

    function alert(message, type) {
        alertElement = `<div class="alert alert-icon-${type == 'success' ? 'success' : 'danger'}" role="alert">
                    <i data-feather="alert-circle"></i>
                    ${message}
                </div>`;

        const alert = $('#displayAlert');
        alert.children("div.alert").remove();
        alert.append(alertElement);
        alert.show();
    }

    function getParameter(category) {
        // buttonLoadingDetail(true);
        $('#subCategorySelector').prop('disabled', true);

        $(document).ready(() => {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() . "index.php/revenue_assurance/uploader/get_sub_category" ?>',
                data: {
                    "category": category,
                },
                success: (response) => {
                    // console.log(response);
                    htmlOption = '';

                    $.each(response.result, (params, paramItems) => {
                        htmlOption += `<option value="${paramItems}">${paramItems}</option>`
                    });

                    $('#subCategorySelector')[0].innerHTML = htmlOption;

                    // buttonLoadingDetail(false);
                    $('#subCategorySelector').prop('disabled', false);
                }
            });
        });
    }

    $(document).ready(() => {
        const category = $("#categorySelection").val();
        $('#showOrHideAreaSelection').prop('hidden', true);
        $('#showOrHideSubCategorySelection').prop('hidden', false);
        getParameter('PSAK 72 MCT');

        htmlFileMapping1 = '';
        if (category === 'PSAK 72 MCT') {
            htmlFileMapping1 += `<div class="alert alert-success" role="alert">Download Template ${category} : <a href="<?= base_url() . "assets/file/revenue-assurance/Template PSAK 72 MCT.xlsx" ?>"><i data-feather="file"></i> Template Upload ${category}</a></div>`
        }
        $('#templateUploadFile')[0].innerHTML = htmlFileMapping1;

        // Change by Category
        $('#categorySelection').on('change', () => {
            let category = $("#categorySelection option:selected").text()
            htmlFileMapping = '';
            getParameter(category);

            // Start show template file
            if (category === 'PSAK 72 MCT') {
                htmlFileMapping += `<div class="alert alert-success" role="alert">Download Template ${category} : <a href="<?= base_url() . "assets/file/revenue-assurance/Template PSAK 72 MCT.xlsx" ?>"><i data-feather="file"></i> Template Upload ${category}</a></div>`
            }

            if (category === 'PSAK 73') {
                htmlFileMapping += `<div class="alert alert-success" role="alert">Download Template ${category} : <a href="<?= base_url() . "assets/file/revenue-assurance/Template PSAK 73.xlsx" ?>"><i data-feather="file"></i> Template Upload ${category}</a></div>`
            }

            $('#templateUploadFile')[0].innerHTML = htmlFileMapping;
            // End show template file

            if (category === 'PSAK 72 Non MCT') {
                $('#showOrHideAreaSelection').prop('hidden', false);

                htmlFileMapping2 = '';
                htmlFileMapping2 += `<div class="alert alert-success" role="alert">Download Template ${category} : <a href="<?= base_url() . "assets/file/revenue-assurance/Template PSAK 72 Non MCT - Regional.xlsx" ?>"><i data-feather="file"></i> Template Upload ${category}</a></div>`
                $('#templateUploadFile')[0].innerHTML = htmlFileMapping2;

                // Change by Areas
                $('#areaSelection').on('change', () => {
                    let areas = $("#areaSelection option:selected").text()
                    htmlFileMappingNonMCT = '';

                    if (areas === 'REGIONAL') {
                        $('#showOrHideSubCategorySelection').prop('hidden', false);
                        htmlFileMappingNonMCT += `<div class="alert alert-success" role="alert">Download Template ${category} : <a href="<?= base_url() . "assets/file/revenue-assurance/Template PSAK 72 Non MCT - Regional.xlsx" ?>"><i data-feather="file"></i> Template Upload ${category} - Regional</a></div>`
                    } else {
                        $('#showOrHideSubCategorySelection').prop('hidden', true);
                        htmlFileMappingNonMCT += `<div class="alert alert-success" role="alert">Download Template ${category} : <a href="<?= base_url() . "assets/file/revenue-assurance/Template PSAK 72 Non MCT - Witel.xlsx" ?>"><i data-feather="file"></i> Template Upload ${category} - Witel</a></div>`
                    }

                    $('#templateUploadFile')[0].innerHTML = htmlFileMappingNonMCT;
                });
            } else {
                $('#showOrHideAreaSelection').prop('hidden', true);
            }
        });

        const baseUrl = "<?= base_url(); ?>index.php/revenue_assurance/uploader/";
        let categoryId, categoryName;
        let selectedFile;
        let isLoading = false;
        const dropify = $('#excelDropify').dropify();
        const submitButton = $("#uploadExcel");

        dropify.on('change', (event, element) => {
            selectedFile = event.target.files[0];
        })

        submitButton.on("click", () => {
            if (selectedFile) {
                let month = $("#dateSelection").val();
                let category = $("#categorySelection").val();
                let sub_category = $("#subCategorySelector").val();
                let area = $("#areaSelection").val();
                const result = [];
                const bodyTranspose = [];
                buttonLoading(true);

                readXlsxFile(selectedFile).then((rows) => {
                    let headerColumns = rows.shift();
                    let bodyColumns = rows;

                    // console.log(headerColumns);
                    // console.log(bodyColumns);

                    // console.log(month);

                    buttonLoading(false);

                    const xhr = $.ajax({
                        url: baseUrl + 'ajax_upload_post_request',
                        type: 'POST',
                        data: {
                            month: month,
                            category_name: category,
                            sub_category_name: sub_category,
                            area: area,
                            header_columns: headerColumns,
                            body_columns: bodyColumns,
                        },
                        error: (error) => {
                            // console.log(error.status);
                            // buttonLoading(false);

                            // if (error.status == 500) {
                            //     alert("Sorry! something wen't wrong, please try again later", 'error');
                            // } else {
                            //     alert(error.responseJSON.message, 'error');
                            // }
                        },
                        success: (data) => {
                            // buttonLoading(false);
                            // alert("Record added successfully", 'success');

                            // console.log("Record added successfully");
                        },
                    });

                });
            }
        });
    });
</script>
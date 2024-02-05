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
                <!-- <div class="row">
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
                </div> -->

                <button type="button" class="btn btn-primary btn-icon-text mr-3" data-toggle="modal" data-target=".insert-doc-name">
                    <i class="btn-icon-prepend" data-feather="plus"></i>
                    Nama Dokumen</button>

                <hr>

                <div class="row">
                    <div class="col-12">
                        <h6 class="card-title">Data Dokumen</h6>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul Kontrak</th>
                                        <th>Nomor Kontrak</th>
                                        <th>Tanggal Kontrak</th>
                                        <th>Nilai Kontrak</th>
                                        <th>Aksi</th>
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

<!-- Modal Insert Document Name -->
<div class="modal fade insert-doc-name" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title h4" id="myLargeModalLabel">Nama Dokumen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" id="submitFormDocumentName" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Judul Kontrak</label>
                                <input type="text" class="form-control" id="contractTitle" name="contractTitle" placeholder="">
                            </div>
                        </div><!-- Col -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Nomor Kontrak</label>
                                <input type="text" class="form-control" id="contractNum" name="contractNum" placeholder="">
                            </div>
                        </div><!-- Col -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Tanggal Kontrak</label>
                                <div class="input-group date datepicker mr-2 mb-2 mb-md-0 d-md-none d-xl-flex" id="dashboardDate">
                                    <span class="input-group-addon bg-transparent"><i data-feather="calendar" class=" text-primary"></i></span>
                                    <input type="text" name="date" class="form-control" id="contractDate" date-update="<?= date('d-F-Y', strtotime($filter['date'])); ?>">
                                </div>
                            </div>
                        </div><!-- Col -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Nilai Kontrak</label>
                                <input type="number" class="form-control" id="contractAmount" name="contractAmount" placeholder="">
                            </div>
                        </div><!-- Col -->
                        <!-- <div class="col-sm-12">
                            <div class="form-group">
                                <input type="file" name="document_upload" accept=".pdf,.docx,.xlsx,.pptx,.png,.jpg,.jpeg" id="excelDropify" class="border" multiple />
                            </div>
                        </div> -->
                    </div>
                    <button type="button" id="insertButtonDocumentName" class="btn btn-primary" onclick="onInsertSubmittedDocumentofName()">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Insert Document Name -->

<!-- Modal Insert Detail Document Review -->
<div class="modal fade insert-detail-doc-review" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="myLargeModalLabel">Detail Review</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" id="submitFormDetailDocument" enctype="multipart/form-data">
                    <div id="idDocName"></div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Kategori Tanggal</label>
                                <select class="form-control" id="dateCategorySelection" name="dateCategorySelection">
                                    <option selected disabled>Pilih kategori tanggal</option>
                                    <option value="Tanggal Masuk">Tanggal Masuk</option>
                                    <option value="Tanggal Kembali">Tanggal Kembali</option>
                                    <option value="Tanggal Selesai">Tanggal Selesai</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Tanggal</label>
                                <div class="input-group date datepicker mr-2 mb-2 mb-md-0 d-md-none d-xl-flex" id="dashboardLegalEntryDate">
                                    <span class="input-group-addon bg-transparent"><i data-feather="calendar" class=" text-primary"></i></span>
                                    <input type="text" name="entryDate" class="form-control" id="entryDate" date-update="<?= date('d-F-Y', strtotime($filter['date'])); ?>">
                                </div>
                            </div>
                        </div><!-- Col -->
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">PIC</label>
                                <input type="text" class="form-control" id="userPIC" name="userPIC" placeholder="">
                            </div>
                        </div><!-- Col -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea">Keterangan</label>
                                <textarea class="form-control" id="explanation" name="explanation"></textarea>
                            </div>
                        </div><!-- Col -->
                        <div class="col-sm-12" id="showOrHideUploadDocument">
                            <div class="form-group">
                                <input type="file" name="document_upload" accept=".pdf" id="documentDropify" class="border" />
                            </div>
                        </div>
                    </div>
                    <button type="button" id="insertButtonDetailDocumentReview" class="btn btn-primary" onclick="onInsertSubmittedDetailDocumentReview()">Submit</button>
                </form>

                <hr>

                <div class="row">
                    <div class="col-12">
                        <h6 class="card-title">Data Detail Review</h6>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kategori Tanggal</th>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Nama/Unit yang Mengambil</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="dataBodyDetailReview"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Insert Detail Document Review -->

<!-- Modal Detail Review Document -->
<div class="modal fade detail-review-document" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title h4" id="myLargeModalLabel">Detail Review</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div id="contractName"></div>
                                <div id="content">
                                    <ul class="timeline">
                                        <div id="timelineReview"></div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Detail Review Document -->

<!-- Modal Delete Document Confirmation -->
<div class="modal fade" id="delete-doc-name" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="idDocNameForDelete"></div>
                <div id="categoryDelete"></div>
                <p>Apakah anda yakin ingin menghapus data ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-danger" id="onDeleteSubmitted" onclick="onDeleteSubmitted()">Hapus</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Delete Document Confirmation -->

<!-- Modal Delete Detail Review Document Confirmation -->
<div class="modal fade" id="delete-detail-review-doc-name" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="idDetailReviewDocName"></div>
                <p>Apakah anda yakin ingin menghapus data ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-danger" id="onDeleteDetailReviewSubmitted" onclick="onDeleteDetailReviewSubmitted()">Hapus</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Delete Detail Review Document Confirmation -->

<script src="<?php echo base_url(); ?>assets/summernote/summernote-lite.min.js"></script>
<script src="<?= base_url(); ?>assets/js/reward/date.js"></script>
<script>
    // function buttonLoading(isLoading) {
    //     const buttonSubmit = $('#filterButton');
    //     if (isLoading) {
    //         buttonSubmit[0].innerText = null;
    //         buttonSubmit.prop('disabled', true);
    //         buttonSubmit.append(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`);
    //     } else {
    //         buttonSubmit.prop('disabled', false);
    //         buttonSubmit[0].innerHTML = 'FILTER';
    //     }
    // }

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
        const dropify = $('#documentDropify').dropify();

        // Show or Hide Regional
        $('#regionalShowOrHide').prop('hidden', true);

        $('#areaSelection').on('change', function() {
            let optionValue = $(this).val();

            if (optionValue == 'REGIONAL') {
                $('#regionalShowOrHide').prop('hidden', true);
            } else {
                $('#regionalShowOrHide').prop('hidden', false);
            }
        });

        // Show or Hide Upload Document Dropify
        $('#showOrHideUploadDocument').prop('hidden', true);

        $('#dateCategorySelection').on('change', function() {
            let optionValue = $(this).val();

            if (optionValue == 'Tanggal Selesai') {
                $('#showOrHideUploadDocument').prop('hidden', false);
            } else {
                $('#showOrHideUploadDocument').prop('hidden', true);
            }
        });

        onFilterSubmitted();
    });

    // Insert
    function onInsertSubmittedDocumentofName() {
        let contractTitle = $("#contractTitle").val();
        let contractNum = $("#contractNum").val();
        let contractDate = $("#contractDate").val();
        let contractAmount = $("#contractAmount").val();

        $(document).ready(() => {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() . "index.php/legal/document_tracking/insert_doc_name" ?>',
                data: {
                    "contractTitle": contractTitle,
                    "contractNum": contractNum,
                    "contractDate": contractDate,
                    "contractAmount": contractAmount,
                },
                success: (response) => {
                    onFilterSubmitted();
                },
                error: (error) => {
                    console.log(error);
                }
            });
        });
    }

    function onInsertSubmittedDetailDocumentReview() {
        let idDocument = $("#hideidDocName").val();
        let dateCategory = $("#dateCategorySelection").val();
        let entryDate = $("#entryDate").val();
        let userPIC = $("#userPIC").val();
        let explanation = $("#explanation").val();
        let document = $("#document_upload").val();
        console.log(dateCategory);

        let setDatas = null;

        if (dateCategory == 'Tanggal Selesai') {
            setDatas = new FormData($("#submitFormDetailDocument")[0]);
        } else {
            setDatas = {
                "idDocument": idDocument,
                "dateCategory": dateCategory,
                "entryDate": entryDate,
                "userPIC": userPIC,
                "explanation": explanation,
            }
        }

        $(document).ready(() => {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() . "index.php/legal/document_tracking/insert_detail_review" ?>',
                data: setDatas,
                mimeType: "multipart/form-data",
                contentType: false,
                processData: false,
                success: (response) => {
                    onGetDataReviewDetail(response.data.contract_doc_id)
                    // console.log(response.data.contract_doc_id);
                },
                error: (error) => {
                    console.log(error);
                }
            });
        });
    }

    function onDeleteSubmittedDetailDocumentReview() {

    }

    function onSelectedID(idDocName) {
        let textHtmlIdDocName = '';

        textHtmlIdDocName += `<input type="text" name="hideidDocName" id="hideidDocName" value="${idDocName}" hidden>`

        $('#idDocName')[0].innerHTML = textHtmlIdDocName;

        onGetDataReviewDetail(idDocName);
    }

    // Get Data
    function onFilterSubmitted() {
        let contractTitle = $("#contractTitle").val();
        let contractNum = $("#contractNum").val();
        let contractDate = $("#contractDate").val();
        let contractAmount = $("#contractAmount").val();

        dataBodyLoading(true);
        getData();
    }

    function getData() {
        // buttonLoading(true);

        $(document).ready(() => {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() . "index.php/legal/document_tracking/ajax_post_get_data" ?>',
                data: {
                    // "month": date,
                    // "category": '<?= $item_active ?>',
                    // "show": area,
                    // "regional": regional,
                },
                success: (response) => {
                    let textHtml = '';
                    let numberCount = 0;

                    let keys = Object.keys(response.data);

                    if (response.data && keys.length !== 0) {
                        $.each(response.data, (witel, dataItems) => {
                            textHtml += `<tr><td>${++numberCount}</td>`
                            textHtml += `<td>${dataItems.contract_name}</td>`
                            textHtml += `<td>${dataItems.contract_num}</td>`
                            textHtml += `<td>${dataItems.contract_date}</td>`
                            textHtml += `<td>${formatter.million(dataItems.contract_amount)}</td>`
                            textHtml += `<td><button type="button" class="btn btn-info btn-icon-text mr-2" data-toggle="modal" data-target=".detail-review-document" onclick="onGetDataReviewDetailOnTimeline(${dataItems.id})">
                                        Lihat</button>
                                        <button type="button" class="btn btn-warning btn-icon-text mr-2" data-toggle="modal" data-target=".insert-detail-doc-review" onclick="onSelectedID(${dataItems.id})">
                                        Tambah Detail Review</button>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-doc-name" onclick="onShowModalDeleteDocName(${dataItems.id}, 'ajax_delete_document_name')">
                                        Hapus</button>
                                        </td>`
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

    function onGetDataReviewDetailOnTimeline(idDocName) {
        $(document).ready(() => {
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() . "index.php/legal/document_tracking/ajax_get_detail_review" ?>',
                data: {
                    "idDocName": idDocName,
                },
                success: (response) => {
                    let textHtml = '';
                    let textHtmlContractName = '';

                    let keys = Object.keys(response.data);

                    if (response.data && keys.length !== 0) {
                        $.each(response.data, (witel, dataItems) => {
                            textHtml += `<li class="event" data-date="${dataItems.review_date}">`
                            textHtml += `<h3>${dataItems.status}</h3>`
                            textHtml += `<p>${dataItems.explanation}</p>`
                            textHtml += `</li>`

                        });
                    } else {
                        textHtml += `<p>No data found.</p>`
                    }

                    textHtmlContractName += `<h6 class="card-title">${response.doc_name.contract_name}</h6>`

                    $('#timelineReview')[0].innerHTML = textHtml;
                    $('#contractName')[0].innerHTML = textHtmlContractName;
                    // buttonLoading(false);
                },
                error: (error) => {
                    console.log(error);

                    // buttonLoading(false);
                }
            });
        });
    }

    function onGetDataReviewDetail(idDocName) {
        $(document).ready(() => {
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() . "index.php/legal/document_tracking/ajax_get_detail_review" ?>',
                data: {
                    "idDocName": idDocName,
                },
                success: (response) => {
                    console.log(response);
                    let textHtml = '';
                    let numberCount = 0;
                    // let textHtmlContractName = '';

                    let keys = Object.keys(response.data);

                    if (response.data && keys.length !== 0) {
                        $.each(response.data, (witel, dataItems) => {
                            textHtml += `<tr><td>${++numberCount}</td>`
                            textHtml += `<td>${dataItems.status}</td>`
                            textHtml += `<td>${dataItems.review_date}</td>`
                            textHtml += `<td>${dataItems.explanation}</td>`
                            textHtml += `<td>${dataItems.name_of_takes}</td>`
                            textHtml += `<td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-detail-review-doc-name" onclick="onShowModalDeleteDetailReviewDocName(${dataItems.dr_id}, 'ajax_delete_detail_review_document', '${dataItems.status}')">
                                        Hapus</button></td>`
                            textHtml += `</tr>`
                        });
                    } else {
                        textHtml += `<tr>
                                        <td colspan="100%" class="text-center">No data found.</td>
                                    </tr>`
                    }

                    // textHtmlContractName += `<h6 class="card-title">${response.doc_name.contract_name}</h6>`

                    $('#dataBodyDetailReview')[0].innerHTML = textHtml;
                    // $('#contractName')[0].innerHTML = textHtmlContractName;
                    // buttonLoading(false);
                },
                error: (error) => {
                    console.log(error);

                    // buttonLoading(false);
                }
            });
        });
    }

    // Delete
    function onShowModalDeleteDocName(idDocName, categoryName) {
        // console.log(idDocName + ' - ' + categoryName);
        let textHtmlIdDocName = '';

        textHtmlIdDocName += `<input type="text" name="hideidDocNameForDelete" id="hideidDocNameForDelete" value="${idDocName}" hidden>`
        textHtmlIdDocName += `<input type="text" name="hideFunctionDocNameForDelete" id="hideFunctionDocNameForDelete" value="${categoryName}" hidden>`

        $('#idDocName')[0].innerHTML = textHtmlIdDocName;
    }

    function onShowModalDeleteDetailReviewDocName(idDetailReviewDocName, categoryName, status) {
        let textHtmlIdDocName = '';

        textHtmlIdDocName += `<input type="text" name="hideidDetailReviewDocNameForDelete" id="hideidDetailReviewDocNameForDelete" value="${idDetailReviewDocName}" hidden>`
        textHtmlIdDocName += `<input type="text" name="hideFunctionDetailReviewDocNameForDelete" id="hideFunctionDetailReviewDocNameForDelete" value="${categoryName}" hidden>`
        textHtmlIdDocName += `<input type="text" name="hideStatusDetailReviewDocNameForDelete" id="hideStatusDetailReviewDocNameForDelete" value="${status}" hidden>`

        $('#idDetailReviewDocName')[0].innerHTML = textHtmlIdDocName;
    }

    function onDeleteSubmitted() {
        let idDocument = $("#hideidDocNameForDelete").val();
        let functionDelete = $("#hideFunctionDocNameForDelete").val();

        $(document).ready(() => {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() . "index.php/legal/document_tracking/" ?>' + functionDelete,
                data: {
                    "idDocName": idDocument,
                },
                success: (response) => {
                    onFilterSubmitted();
                },
                error: (error) => {
                    console.log(error);

                    // buttonLoading(false);
                }
            });
        });
    }

    function onDeleteDetailReviewSubmitted() {
        let idDocument = $("#hideidDetailReviewDocNameForDelete").val();
        let functionDelete = $("#hideFunctionDetailReviewDocNameForDelete").val();
        let status = $("#hideStatusDetailReviewDocNameForDelete").val();

        $(document).ready(() => {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() . "index.php/legal/document_tracking/" ?>' + functionDelete,
                data: {
                    "idDocName": idDocument,
                },
                success: (response) => {
                    onGetDataReviewDetail(idDocument);
                },
                error: (error) => {
                    console.log(error);

                    // buttonLoading(false);
                }
            });
        });
    }
</script>
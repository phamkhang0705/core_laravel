var disabled_btn_update_status = function () {
    $('.btn_reset_pass').prop('disabled', true);
}
var enabled_btn_update_status = function () {
    $('.btn_reset_pass').prop('disabled', false);
}

$('.btn_reset_pass ').click(function (e) {
    var $this = $(this),
        title = $this.data('title'),
        type = $this.data('type'),
        id = $this.data('id');
    App.showConfirm("Xác nhận", title, function (isconfirm) {
        if (isconfirm) {
            disabled_btn_update_status();
            App.post('/user_manage/change_password', {
                id: id,
                type: type
            }, true, function (response) {
                if (response.status == 1) {
                    Sv.setCookie("window_mgsSuccess", response.message);
                    App.refresh();
                } else {
                    Sv.showMgs(response.message, false);
                    enabled_btn_update_status();
                }
            });
        }
    });
})
$('.btn_update_user').click(function (e) {
    var $this = $(this),
        title = $this.data('title'),
        status = $this.data('status'),
        id = $this.data('id');
    if ($(e.target).hasClass('btn_cancel_acc')) {
        swal({
            title: "",
            text: 'Nhập lý do hủy',
            type: "input",
            showCancelButton: true,
            confirmButtonColor: "#F44336",
            confirmButtonText: "Xác nhận",
            cancelButtonText: "Hủy",
            closeOnConfirm: false,
            inputPlaceholder: "Nhập lý do hủy"
        }, function (inputValue) {
            if (inputValue === false) return false;
            if (inputValue === "") {
                swal.showInputError("Vui lòng nhập lý do hủy");
                return false;
            }
            disabled_btn_update_status();
            App.post('/user_manage/update_status', {
                id: id,
                status: status,
                reason: inputValue
            }, true, function (response) {
                if (response.status == 1) {
                    Sv.setCookie("window_mgsSuccess", response.message);
                    App.refresh();
                } else {
                    Sv.showMgs(response.message, false);
                    enabled_btn_update_status();
                }
            });

        });
    } else {
        App.showConfirm("Xác nhận", title, function (isconfirm) {
            if (isconfirm) {
                disabled_btn_update_status();
                App.post('/user_manage/update_status', {
                    id: id,
                    status: status
                }, true, function (response) {
                    if (response.status == 1) {
                        Sv.setCookie("window_mgsSuccess", response.message);
                        App.refresh();
                    } else {
                        Sv.showMgs(response.message, false);
                        enabled_btn_update_status();
                    }
                });
            }
        });
    }
});

var Trans = function () {
    var base = this;
    this.$table = $('#table');
    this.Columns = [
        {
            title: "STT",
            width: '5%',
            field: 'id',
            align: "center",
            formatter: function (val, row, index) {
                var page = base.$table.bootstrapTable('getOptions').pageNumber;
                var size = base.$table.bootstrapTable('getOptions').pageSize;
                return Sv.numberToString(size * (page - 1) + index + 1);
            },
        }, {
            title: "Mã GD",
            field: 'order_code',
        }, {
            title: "Dịch vụ",
            field: 'parent_service_name',
        }, {
            title: "Loại giao dịch",
            field: 'service_name',
        }, {
            title: "MC/NCC",
            formatter: function (val, row, index) {
                return row.merchant_id > 0 ? row.provider_name + '/' + row.merchant_name : row.provider_name;
            }
        }, {
            title: "Số tiền",
            field: 'total_amount',
            align: 'right',
            formatter: function (val, row, index) {
                return Sv.numberToString(val);
            }
        }, {
            title: "Phí",
            field: 'total_fee',
            align: 'right',
            formatter: function (val, row, index) {
                return Sv.numberToString(val);
            }
        }, {
            title: "Thời gian giao dịch",
            field: 'time',
            formatter: function (val, row, index) {
                return Sv.ConvertTimestampToDateTime(val)
            }
        }, {
            title: "Trạng thái",
            field: 'status'
        }, {
            title: "Hành động",
            align: 'center',
            formatter: function (val, row, index) {
                var str = "";
                str += '<a class="item-tool view" title="Xem thông tin" href="/transaction_manage/' + row.id + '"><i class="material-icons">visibility</i></a>';
                return str;
            }
        },
    ]
    this.Refresh_table = function ($table) {
        $table.bootstrapTable('refreshOptions', {
            responseHandler: function (res) {
                return {
                    rows: res.rows,
                    total: res.total
                }
            }
        });
    };
}
var Logs = function () {
    var base = this;
    this.$table = $('#table_log');
    this.Columns = [
        {
            title: "STT",
            width: '5%',
            field: 'id',
            align: "center",
            formatter: function (val, row, index) {
                var page = base.$table.bootstrapTable('getOptions').pageNumber;
                var size = base.$table.bootstrapTable('getOptions').pageSize;
                return Sv.numberToString(size * (page - 1) + index + 1);
            },
        }, {
            title: "Hành động",
            field: 'action',
            width: '20%'
        }, {
            title: "Thời gian",
            field: 'created_time',
            width: '20%'
        }, {
            title: "Người thực hiện",
            field: 'created_by',
            width: '20%'
        }, {
            title: "Ghi chú",
            field: 'description'
        }
    ]
    this.Refresh_table = function ($table) {
        $table.bootstrapTable('refreshOptions', {
            responseHandler: function (res) {
                return {
                    rows: res.rows,
                    total: res.total
                }
            }
        });
    };
}
var tran;
var log;
$(document).ready(function () {
    tran = new Trans();
    $('#form-filter #btn-search').on('click', function () {
        tran.Refresh_table($('#table'));
    })
    $('#form-filter').on('change', 'select', function (e) {
        tran.Refresh_table($('#table'));
    })
    $('#form-filter').on('keyup', 'input', function (e) {
        tran.Refresh_table($('#table'));
    })
    $('#form-filter').find('#btn-reset').on('click', function () {
        $('#form-filter').find('input').val('');
        $('#form-filter').find("select").val("").selectpicker("refresh");
        tran.Refresh_table($('#table'));
    });
    tran.$table.bootstrapTable({
        search: false,
        searchOnEnterKey: false,
        pagination: true,
        sidePagination: 'server',
        pageSize: 25,
        pageList: [25, 50, 100],
        toggle: 'table',
        cache: false,
        columns: tran.Columns,
        url: "/user_manage/get_order_history",
        queryParams: function (params) {
            return {
                user_id: $('input[name=user_id]').val(),
                date: $('input[name=date]').val(),
                service_id: $('select[name=service_id]').val(),
                parent_service_id: $('select[name=parent_service_id]').val(),
                order_code: $('input[name=order_code]').val(),
                limit: params.limit,
                offset: params.offset
            };
        },
        responseHandler: function (res) {
            return {
                rows: res.rows,
                total: res.total
            }
        },
        onLoadSuccess: function () {
            // App.mask(false);
        },
        formatLoadingMessage: function () {
            // App.mask(true);
        },
    })
    log = new Logs();
    $('#form-filter-log #btn-search-log').on('click', function () {
        log.Refresh_table($('#table_log'));
    })
    $('#form-filter-log').on('change', 'select', function (e) {
        log.Refresh_table($('#table_log'));
    })
    $('#form-filter-log').on('keyup', 'input', function (e) {
        log.Refresh_table($('#table_log'));
    })
    $('#form-filter-log').find('#btn-reset').on('click', function () {
        $('#form-filter-log').find('input').val('');
        $('#form-filter-log').find("select").val("").selectpicker("refresh");
        log.Refresh_table($('#table_log'));
    });
    log.$table.bootstrapTable({
        search: false,
        searchOnEnterKey: false,
        pagination: true,
        sidePagination: 'server',
        pageSize: 25,
        pageList: [25, 50, 100],
        toggle: 'table',
        cache: false,
        columns: log.Columns,
        url: "/user_manage/get_log",
        queryParams: function (params) {
            return {
                user_id: $('input[name=user_id]').val(),
                log_date: $('input[name=log_date]').val(),
                limit: params.limit,
                offset: params.offset
            };
        },
        responseHandler: function (res) {
            return {
                rows: res.rows,
                total: res.total
            }
        },
        onLoadSuccess: function () {
            // App.mask(false);
        },
        formatLoadingMessage: function () {
            // App.mask(true);
        },
    })
});
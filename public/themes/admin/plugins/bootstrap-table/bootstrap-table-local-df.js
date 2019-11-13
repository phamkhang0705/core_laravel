/**
 * Bootstrap Table Vietnamese translation 
 */
(function ($) {
    'use strict'; 
    var sprintf = function (str) {
        var args = arguments,
            flag = true,
            i = 1;

        str = str.replace(/%s/g, function () {
            var arg = args[i++];

            if (typeof arg === 'undefined') {
                flag = false;
                return '';
            }
            return arg;
        });
        return flag ? str : '';
    };

    $.fn.bootstrapTable.locales['en-US'] = {
            formatLoadingMessage: function () {
                return 'Đang tải...';
            },
            formatRecordsPerPage: function (pageNumber) {
                return sprintf('%s bản ghi trên trang', pageNumber);
            },
            formatShowingRows: function (pageFrom, pageTo, totalRows) {
                return sprintf('Hiển thị %s tới %s trên tổng %s bản ghi', pageFrom, pageTo, totalRows);
            },
            formatDetailPagination: function (totalRows) {
                return sprintf('Hiển thị %s bản ghi', totalRows);
            },
            formatSearch: function () {
                return 'Tìm kiếm';
            },
            formatNoMatches: function () {
                return 'Không có dữ liệu';
            },
            formatPaginationSwitch: function () {
                return 'Ẩn/hiện phân trang';
            },
            formatRefresh: function () {
                return 'Làm mới';
            },
            formatToggle: function () {
                return 'Toggle';
            },
            formatFullscreen: function () {
                return 'Toàn màn hình';
            },
            formatColumns: function () {
                return 'Columns';
            },
            formatAllRows: function () {
                return 'Tất cả';
            }
        
    };

    $.extend($.fn.bootstrapTable.defaults, $.fn.bootstrapTable.locales['en-US']);

})(jQuery); 

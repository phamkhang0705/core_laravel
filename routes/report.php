<?php
//lịch sử truy cập
// "Báo cáo doanh thu theo ngày - tổng tất cả các khu vực";
Route::get('report/sale_total', 'SaleTotal@index')->name('sale_total.index');

// "Báo cáo giao dich Tài trợ - Hợp tác";
Route::get('report/transaction_type', 'TransactionType@index')->name('transaction_type.index');

// "Báo cáo công nợ user";
Route::get('report/daily/wallet', 'Daily@wallet')->name('daily.wallet');

// "Báo cáo tiêu dùng cashback";
Route::get('report/daily/casback_trans', 'Daily@casback_trans')->name('daily.casback_trans');

// "Báo cáo doanh thu theo MC 							";
Route::get('report/merchant/sale', 'Merchant@index')->name('merchant.index');


 



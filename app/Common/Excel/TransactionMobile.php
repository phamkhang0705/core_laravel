<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 24/04/2018
 * Time: 11:49 AM
 */

namespace App\Common\Excel;


use App\Common\Adapter\DB;
use App\Common\Utility;
use App\Models\HlGlobal\AdminGlobalUser;
use App\Models\HlGlobal\SaleProductOrderDetail;
use App\Models\HlGlobal\UserRequestCashbackGame;
use App\Models\TopupInput;
use App\Models\TopupPartnerAmount;

class TransactionMobile
{
    public static function export($data, $options = [])
    {
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Transaction_mobile_' . date('Ymd-H:i') . '.xlsx"');

        $from_time = !empty($options['from_time']) ? strtotime($options['from_time']) : strtotime(date('Y-m-d 00:00:00'));
        $to_time = !empty($options['to_time']) ? strtotime($options['to_time']) : strtotime(date('Y-m-d 23:59:59'));

        $objPHPExcel = new \PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A1:K1");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'DANH SÁCH GIAO DỊCH');

        $objPHPExcel->setActiveSheetIndex(0)->getStyle("A1:K1")->getFont()->setBold(true);

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'Thời gian');
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', "{$options['from_time']} - {$options['to_time']}");

        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:K1');
        $objPHPExcel->setActiveSheetIndex(0)->getStyle("A3:K3")->getFont()->setBold(true);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle('A3:K3')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $objPHPExcel->setActiveSheetIndex(0)->getStyle("A4:K4")->getFont()->setBold(true);
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A4', 'STT')
            ->setCellValue('B4', 'Mã GD')
            ->setCellValue('C4', 'User ID')
            ->setCellValue('D4', 'Loại giao dịch')
            ->setCellValue('E4', 'Đối tác')
            ->setCellValue('F4', 'SĐT nạp')
            ->setCellValue('G4', 'Nhà mạng')
            ->setCellValue('H4', 'Số tiền thanh toán')
            ->setCellValue('I4', 'Trạng thái trả/nạp thẻ')
            ->setCellValue('K4', 'Thời gian giao dịch');

        if (!$data->isEmpty()) {
            $row = 5;
            foreach ($data as $key => $item) {
                $userRequestCashbackFirst = null;
                if (isset($item->info->userRequestCashback) && $item->info->userRequestCashback instanceof \Illuminate\Database\Eloquent\Collection) {
                    $userRequestCashback = $item->info->userRequestCashback;
                    $userRequestCashbackFirst = $userRequestCashback->first();

                    $continue = false;
                    switch (request('member_status')) {
                        case 'unknown':
                            if (!$userRequestCashbackFirst->isUndefined()) {
                                $continue = true;
                            }

                            break;
                        case 'success':
                            if (!$userRequestCashbackFirst->isSuccess()) {
                                $continue = true;
                            }

                            break;
                        case 'fail':
                            if (!$userRequestCashbackFirst->isFailure()) {
                                $continue = true;
                            }

                            break;
                    }

                    if ($continue) {
                        continue;
                    }
                }

                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $row, $key + 1)
                    ->setCellValue('B' . $row, $item->order_code)
                    ->setCellValue('C' . $row, $item->user instanceof AdminGlobalUser ? $item->user->global_user_id : '')
                    ->setCellValue('D' . $row, $item->getType())
                    ->setCellValue('E' . $row, $userRequestCashbackFirst instanceof \App\Models\HlGlobal\UserRequestCashbackGame ? $userRequestCashbackFirst->service_name : '')
                    ->setCellValue('F' . $row, $item->receiver_phone)
                    ->setCellValue('G' . $row, $item->info instanceof SaleProductOrderDetail ? $item->info->getTelcoName() : '')
                    ->setCellValue('H' . $row, $item->price_total)
                    ->setCellValue('I' . $row, $userRequestCashbackFirst instanceof \App\Models\HlGlobal\UserRequestCashbackGame ? $userRequestCashbackFirst->getStatus() : '')
                    ->setCellValue('K' . $row, $userRequestCashbackFirst instanceof \App\Models\HlGlobal\UserRequestCashbackGame ? Utility::displayDatetime($userRequestCashbackFirst->insert_time) : '');

                $row += 1;
            }
        }

        $objPHPExcel->setActiveSheetIndex(0)->setTitle('Danh sách giao dịch');

        $date_ranges = Utility::getDatesFromRange(date('Y-m-d', $from_time), date('Y-m-d', $to_time), 'Y-m-d');

        $partner_moneys = [];
        $partner_moneys_tmp = TopupPartnerAmount::query()
            ->where('date', '>=', date('Y-m-d H:i:s', $from_time - 172800))
            ->where('date', '<=', date('Y-m-d H:i:s', $to_time))
            ->get();
        foreach ($partner_moneys_tmp as $item) {
            $partner_moneys[$item->date][$item->partner] = [
                'money' => $item->money,
                'output_topup' => $item->output_topup,
                'output_phone_card' => $item->output_phone_card
            ];
        }

        $topup_input = [];
        $topup_input_tmp = TopupInput::query()
            ->where('date', '>=', date('Y-m-d H:i:s', $from_time))
            ->where('date', '<=', date('Y-m-d H:i:s', $to_time))
            ->get();
        foreach ($topup_input_tmp as $item) {
            $topup_input[$item->date][$item->partner] = $item->money;
        }

        self::exportData(UserRequestCashbackGame::SERVICE_EPAY, $objPHPExcel, 1, $date_ranges, ['partner_moneys' => $partner_moneys, 'data_input' => $topup_input, 'from_time' => $from_time, 'to_time' => $to_time]);
        self::exportData(UserRequestCashbackGame::SERVICE_ZO_POST, $objPHPExcel, 2, $date_ranges, ['partner_moneys' => $partner_moneys, 'data_input' => $topup_input, 'from_time' => $from_time, 'to_time' => $to_time]);
        self::exportData(UserRequestCashbackGame::SERVICE_WHYPAY, $objPHPExcel, 3, $date_ranges, ['partner_moneys' => $partner_moneys, 'data_input' => $topup_input, 'from_time' => $from_time, 'to_time' => $to_time]);

        $objPHPExcel->setActiveSheetIndex(0);


        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        exit;
    }

    public static function exportData($partner, $objPHPExcel, $sheet_index, $date_ranges, $data_extra = [])
    {
        $partner_moneys = !empty($data_extra['partner_moneys']) ? $data_extra['partner_moneys'] : [];
        $data_input = !empty($data_extra['data_input']) ? $data_extra['data_input'] : [];

        $objPHPExcel->createSheet();

        $objPHPExcel->setActiveSheetIndex($sheet_index)->setTitle('Số dư tài khoản topup ' . $partner);
        $objPHPExcel->setActiveSheetIndex($sheet_index)->mergeCells("A1:E1");
        $objPHPExcel->setActiveSheetIndex($sheet_index)->getStyle("A1:E1")->getFont()->setBold(true);
        $objPHPExcel->setActiveSheetIndex($sheet_index)->setCellValue('A1', 'SỐ DƯ TÀI KHOẢN TOPUP ' . $partner);
        $objPHPExcel->setActiveSheetIndex($sheet_index)->getStyle("A3:I3")->getFont()->setBold(true);
        $objPHPExcel->setActiveSheetIndex($sheet_index)->mergeCells("C3:D3");
        $objPHPExcel->setActiveSheetIndex($sheet_index)
            ->setCellValue('A3', 'Ngày')
            ->setCellValue('B3', 'Nhập')
            ->setCellValue('C3', 'Xuất')
            ->setCellValue('E3', 'Số dư tính toán')
            ->setCellValue('F3', 'Số dư thực tế');
        $objPHPExcel->setActiveSheetIndex($sheet_index)
            ->setCellValue('C4', 'Topup')
            ->setCellValue('D4', 'Mua thẻ');
        $objPHPExcel->setActiveSheetIndex($sheet_index)->getStyle("A4:E4")->getFont()->setBold(true);

        foreach ($date_ranges as $key => $item) {
            $row = $key + 5;

            $money_input = !empty($data_input[$item][$partner]) ? $data_input[$item][$partner] : 0;

            $money_topup = !empty($partner_moneys[$item][$partner]['output_topup']) ? $partner_moneys[$item][$partner]['output_topup'] : 0;
            $money_phone_card = !empty($partner_moneys[$item][$partner]['output_phone_card']) ? $partner_moneys[$item][$partner]['output_phone_card'] : 0;
            $money_partner = !empty($partner_moneys[$item][$partner]['money']) ? $partner_moneys[$item][$partner]['money'] : 0;

            $prev_date = date('Y-m-d', strtotime('-1 day', strtotime($item)));
            $money_partner_prev = !empty($partner_moneys[$prev_date][$partner]['money']) ? $partner_moneys[$prev_date][$partner]['money'] : 0;

            $total_input = $money_partner_prev + $money_input;
            $total_output = $money_phone_card + $money_topup;

            $total_money = $total_input - $total_output;

            $objPHPExcel->setActiveSheetIndex($sheet_index)
                ->setCellValue('A' . $row, $item)
                ->setCellValue('B' . $row, $money_input)
                ->setCellValue('C' . $row, $money_topup)
                ->setCellValue('D' . $row, $money_phone_card)
                ->setCellValue('E' . $row, $total_money)
                ->setCellValue('F' . $row, $money_partner);
        }
    }

    public static function exportZopost($objPHPExcel, $sheet_index, $date_ranges, $data_extra = [])
    {
        $partner_moneys = !empty($data_extra['partner_moneys']) ? $data_extra['partner_moneys'] : [];
        $data_input = !empty($data_extra['data_input']) ? $data_extra['data_input'] : [];
        $from_time = !empty($data_extra['from_time']) ? $data_extra['from_time'] : 0;
        $to_time = !empty($data_extra['to_time']) ? $data_extra['to_time'] : 0;

        $query_1 = "SELECT DATE(FROM_UNIXTIME(insert_time)) as date, SUM(money_amount*quantity) as money
            FROM hl_global.user_request_cashback_game
            WHERE request_id in (
                SELECT request_id from (
                    SELECT * FROM hl_global.phone_card_result WHERE order_detail_id in (
                        SELECT order_detail_id from hl_global.sale_product_orders_detail WHERE order_id in (
                          SELECT order_id FROM hl_global.sale_product_orders where ord_type = 4
                        )
                    ) ORDER BY id DESC
                ) as a 
                GROUP BY a.request_id
            ) AND service_name = 'ZO_POST' AND `status` = 1";

        $query_1 .= " AND insert_time >= {$from_time} AND insert_time <= {$to_time} GROUP BY date ORDER BY date";

        $data_phone_card_tmp = DB::select($query_1);

        $data_phone_card = [];

        if (!empty($data_phone_card_tmp)) {
            foreach ($data_phone_card_tmp as $item) {
                $data_phone_card[$item->date] = $item->money;
            }
        }

        $query_2 = "SELECT DATE(FROM_UNIXTIME(insert_time)) as date, SUM(money_amount*quantity) as money
            FROM hl_global.user_request_cashback_game
            WHERE request_id in (
                SELECT request_id from (
                    SELECT * FROM hl_global.phone_card_result WHERE order_detail_id in (
                        SELECT order_detail_id from hl_global.sale_product_orders_detail WHERE order_id in (
                          SELECT order_id FROM hl_global.sale_product_orders where ord_type = 3
                        )
                    ) ORDER BY id DESC
                ) as a 
                GROUP BY a.request_id
            ) AND service_name = 'ZO_POST' AND `status` = 1";

        $query_2 .= " AND insert_time >= {$from_time} AND insert_time <= {$to_time} GROUP BY date ORDER BY date";

        $data_topup_tmp = DB::select($query_2);

        $data_topup = [];

        if (!empty($data_topup_tmp)) {
            foreach ($data_topup_tmp as $item) {
                $data_topup[$item->date] = $item->money;
            }
        }

        $objPHPExcel->createSheet();

        $objPHPExcel->setActiveSheetIndex($sheet_index)->setTitle('Số dư tài khoản topup Zopost');
        $objPHPExcel->setActiveSheetIndex($sheet_index)->mergeCells("A1:E1");
        $objPHPExcel->setActiveSheetIndex($sheet_index)->getStyle("A1:E1")->getFont()->setBold(true);
        $objPHPExcel->setActiveSheetIndex($sheet_index)->setCellValue('A1', 'SỐ DƯ TÀI KHOẢN TOPUP ZOPOST');
        $objPHPExcel->setActiveSheetIndex($sheet_index)->getStyle("A3:I3")->getFont()->setBold(true);
        $objPHPExcel->setActiveSheetIndex($sheet_index)->mergeCells("C3:D3");
        $objPHPExcel->setActiveSheetIndex($sheet_index)
            ->setCellValue('A3', 'Ngày')
            ->setCellValue('B3', 'Nhập')
            ->setCellValue('C3', 'Xuất')
            ->setCellValue('E3', 'Số dư tính toán')
            ->setCellValue('F3', 'Số dư thực tế');
        $objPHPExcel->setActiveSheetIndex($sheet_index)
            ->setCellValue('C4', 'Topup')
            ->setCellValue('D4', 'Mua thẻ');
        $objPHPExcel->setActiveSheetIndex($sheet_index)->getStyle("A4:E4")->getFont()->setBold(true);

        foreach ($date_ranges as $key => $item) {
            $row = $key + 5;

            $money_phone_card = !empty($data_phone_card[$item]) ? $data_phone_card[$item] : 0;
            $money_topup = !empty($data_topup[$item]) ? $data_topup[$item] : 0;

            $prev_date = date('Y-m-d', strtotime('-1 day', strtotime($item)));
            $partner_item_money_prev = !empty($partner_moneys[$prev_date][UserRequestCashbackGame::SERVICE_ZO_POST]) ? $partner_moneys[$prev_date][UserRequestCashbackGame::SERVICE_ZO_POST] : 0;

            $partner_item_money = !empty($partner_moneys[$item][UserRequestCashbackGame::SERVICE_ZO_POST]) ? $partner_moneys[$item][UserRequestCashbackGame::SERVICE_ZO_POST] : 0;
            $money_input = !empty($data_input[$item][UserRequestCashbackGame::SERVICE_ZO_POST]) ? $data_input[$item][UserRequestCashbackGame::SERVICE_ZO_POST] : 0;

            $total_input = $partner_item_money_prev + $money_input;
            $total_output = $money_phone_card + $money_topup;

            $total_money = $total_input - $total_output;

            $objPHPExcel->setActiveSheetIndex($sheet_index)
                ->setCellValue('A' . $row, $item)
                ->setCellValue('B' . $row, $money_input)
                ->setCellValue('C' . $row, $money_phone_card)
                ->setCellValue('D' . $row, $money_topup)
                ->setCellValue('E' . $row, $total_money)
                ->setCellValue('F' . $row, $partner_item_money);
        }
    }

    public static function exportWhypay($objPHPExcel, $sheet_index, $date_ranges, $data_extra = [])
    {
        $partner_moneys = !empty($data_extra['partner_moneys']) ? $data_extra['partner_moneys'] : [];
        $data_input = !empty($data_extra['data_input']) ? $data_extra['data_input'] : [];
        $from_time = !empty($data_extra['from_time']) ? $data_extra['from_time'] : 0;
        $to_time = !empty($data_extra['to_time']) ? $data_extra['to_time'] : 0;

        $query_1 = "SELECT DATE(FROM_UNIXTIME(insert_time)) as date, SUM(money_amount*quantity) as money
            FROM hl_global.user_request_cashback_game
            WHERE request_id in (
                SELECT request_id from (
                    SELECT * FROM hl_global.phone_card_result WHERE order_detail_id in (
                        SELECT order_detail_id from hl_global.sale_product_orders_detail WHERE order_id in (
                          SELECT order_id FROM hl_global.sale_product_orders where ord_type = 4
                        )
                    ) ORDER BY id DESC
                ) as a 
                GROUP BY a.request_id
            ) AND service_name = 'WHYPAY' AND `status` = 1";

        $query_1 .= " AND insert_time >= {$from_time} AND insert_time <= {$to_time} GROUP BY date ORDER BY date";

        $data_phone_card_tmp = DB::select($query_1);

        $data_phone_card = [];

        if (!empty($data_phone_card_tmp)) {
            foreach ($data_phone_card_tmp as $item) {
                $data_phone_card[$item->date] = $item->money;
            }
        }

        $query_2 = "SELECT DATE(FROM_UNIXTIME(insert_time)) as date, SUM(money_amount*quantity) as money
            FROM hl_global.user_request_cashback_game
            WHERE request_id in (
                SELECT request_id from (
                    SELECT * FROM hl_global.phone_card_result WHERE order_detail_id in (
                        SELECT order_detail_id from hl_global.sale_product_orders_detail WHERE order_id in (
                          SELECT order_id FROM hl_global.sale_product_orders where ord_type = 3
                        )
                    ) ORDER BY id DESC
                ) as a 
                GROUP BY a.request_id
            ) AND service_name = 'WHYPAY' AND `status` = 1";

        $query_2 .= " AND insert_time >= {$from_time} AND insert_time <= {$to_time} GROUP BY date ORDER BY date";

        $data_topup_tmp = DB::select($query_2);

        $data_topup = [];

        if (!empty($data_topup_tmp)) {
            foreach ($data_topup_tmp as $item) {
                $data_topup[$item->date] = $item->money;
            }
        }

        $objPHPExcel->createSheet();

        $objPHPExcel->setActiveSheetIndex($sheet_index)->setTitle('Số dư tài khoản topup Whypay');
        $objPHPExcel->setActiveSheetIndex($sheet_index)->mergeCells("A1:E1");
        $objPHPExcel->setActiveSheetIndex($sheet_index)->getStyle("A1:E1")->getFont()->setBold(true);
        $objPHPExcel->setActiveSheetIndex($sheet_index)->setCellValue('A1', 'SỐ DƯ TÀI KHOẢN TOPUP WHYPAY');
        $objPHPExcel->setActiveSheetIndex($sheet_index)->getStyle("A3:I3")->getFont()->setBold(true);
        $objPHPExcel->setActiveSheetIndex($sheet_index)->mergeCells("C3:D3");
        $objPHPExcel->setActiveSheetIndex($sheet_index)
            ->setCellValue('A3', 'Ngày')
            ->setCellValue('B3', 'Nhập')
            ->setCellValue('C3', 'Xuất')
            ->setCellValue('E3', 'Số dư tính toán')
            ->setCellValue('F3', 'Số dư thực tế');
        $objPHPExcel->setActiveSheetIndex($sheet_index)
            ->setCellValue('C4', 'Topup')
            ->setCellValue('D4', 'Mua thẻ');
        $objPHPExcel->setActiveSheetIndex($sheet_index)->getStyle("A4:E4")->getFont()->setBold(true);

        foreach ($date_ranges as $key => $item) {
            $row = $key + 5;

            $money_phone_card = !empty($data_phone_card[$item]) ? $data_phone_card[$item] : 0;
            $money_topup = !empty($data_topup[$item]) ? $data_topup[$item] : 0;

            $prev_date = date('Y-m-d', strtotime('-1 day', strtotime($item)));
            $partner_item_money_prev = !empty($partner_moneys[$prev_date][UserRequestCashbackGame::SERVICE_WHYPAY]) ? $partner_moneys[$prev_date][UserRequestCashbackGame::SERVICE_WHYPAY] : 0;

            $partner_item_money = !empty($partner_moneys[$item][UserRequestCashbackGame::SERVICE_WHYPAY]) ? $partner_moneys[$item][UserRequestCashbackGame::SERVICE_WHYPAY] : 0;
            $money_input = !empty($data_input[$item][UserRequestCashbackGame::SERVICE_WHYPAY]) ? $data_input[$item][UserRequestCashbackGame::SERVICE_WHYPAY] : 0;

            $total_input = $partner_item_money_prev + $money_input;
            $total_output = $money_phone_card + $money_topup;

            $total_money = $total_input - $total_output;

            $objPHPExcel->setActiveSheetIndex($sheet_index)
                ->setCellValue('A' . $row, $item)
                ->setCellValue('B' . $row, $money_input)
                ->setCellValue('C' . $row, $money_phone_card)
                ->setCellValue('D' . $row, $money_topup)
                ->setCellValue('E' . $row, $total_money)
                ->setCellValue('F' . $row, $partner_item_money);
        }
    }
}
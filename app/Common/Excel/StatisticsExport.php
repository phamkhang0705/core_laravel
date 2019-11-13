<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 16/05/2018
 * Time: 16:35 PM
 */

namespace App\Common\Excel;

use App\Common\Adapter\DB;
use App\Common\Utility;
use App\Models\HlGlobal\AdminGlobalUser;
use App\Models\HlGlobal\SaleProductOrderDetail;
use App\Models\HlGlobal\UserRequestCashbackGame;
use App\Models\TopupInput;
use App\Models\TopupPartnerAmount;

class StatisticsExport
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
            ->setCellValue('C4', 'Request ID')
            ->setCellValue('D4', 'User ID')
            ->setCellValue('E4', 'Loại giao dịch')
            ->setCellValue('F4', 'Đối tác')
            ->setCellValue('G4', 'SĐT nạp')
            ->setCellValue('H4', 'Nhà mạng')
            ->setCellValue('I4', 'Số tiền thanh toán')
            ->setCellValue('J4', 'Trạng thái trả/nạp thẻ')
            ->setCellValue('K4', 'Thời gian giao dịch');

        if (!$data->isEmpty()) {
            $index = 1;
            $row = 5;
            foreach ($data as $key => $item) {
                $userRequestCashbackFirst = null;
                if (isset($item->info->userRequestCashback) && $item->info->userRequestCashback instanceof \Illuminate\Database\Eloquent\Collection) {
                    $userRequestCashback = $item->info->userRequestCashback;

                    foreach ($userRequestCashback as $userRequest) {
                        if (!$userRequest->isSuccess()) {
                            continue;
                        }

                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $row, $index)
                            ->setCellValue('B' . $row, $item->order_code)
                            ->setCellValue('C' . $row, $userRequest->request_id)
                            ->setCellValue('D' . $row, $item->user instanceof AdminGlobalUser ? $item->user->global_user_id : '')
                            ->setCellValue('E' . $row, $item->getType())
                            ->setCellValue('F' . $row, $userRequest->service_name)
                            ->setCellValue('G' . $row, $item->receiver_phone)
                            ->setCellValue('H' . $row, $item->info instanceof SaleProductOrderDetail ? $item->info->getTelcoName() : '')
                            ->setCellValue('I' . $row, $item->price_total)
                            ->setCellValue('J' . $row, $userRequest->getStatus())
                            ->setCellValue('K' . $row, Utility::displayDatetime($userRequest->insert_time));

                        ++$index;
                        ++$row;
                    }
                }
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

        TransactionMobile::exportData(UserRequestCashbackGame::SERVICE_EPAY, $objPHPExcel, 1, $date_ranges, ['partner_moneys' => $partner_moneys, 'data_input' => $topup_input, 'from_time' => $from_time, 'to_time' => $to_time]);
        TransactionMobile::exportData(UserRequestCashbackGame::SERVICE_ZO_POST, $objPHPExcel, 2, $date_ranges, ['partner_moneys' => $partner_moneys, 'data_input' => $topup_input, 'from_time' => $from_time, 'to_time' => $to_time]);
        TransactionMobile::exportData(UserRequestCashbackGame::SERVICE_WHYPAY, $objPHPExcel, 3, $date_ranges, ['partner_moneys' => $partner_moneys, 'data_input' => $topup_input, 'from_time' => $from_time, 'to_time' => $to_time]);

        $objPHPExcel->setActiveSheetIndex(0);


        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        exit;
    }
}
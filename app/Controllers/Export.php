<?php

namespace App\Controllers;

use App\Controllers\Core\AuthController;
use CodeIgniter\HTTP\ResponseInterface;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class Export extends AuthController
{
    public function index()
    {
        return view('v_buku');
    }

    public function export_pdf()
    {
        $sales_order = "SELECT * FROM sales_order";
        $sales_order = $this->db->query($sales_order)->getResultArray();
        // print_r($sales_order);
        // die;


        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT);
        $pdf->AddPage('L');
        $html = '<h2 style="text-align: center;">REPORT:</h2>
                <table border="1" cellpadding="1">';
        $html .= '<tr style="text-align: center; font-weight: bold; color: red;">
        <th colspan="2">Status</th>
        <th colspan="2">Product</th>
        <th>Category</th>
        <th>Unit</th>
        <th>Value</th>
        <th>Price</th>
        <th>Customer ID</th>
        <th colspan="2">Date</th>
                </tr>';

        foreach ($sales_order as $key => $value) {
            $date = $value['sales_order_date'];
            $date = date('d/m/Y',strtotime($date));
            $html .=
                '<tr>
        <td style="text-align: center;" colspan="2">' . $value['sales_order_status'] . '</td>
        <td style="text-align: center;" colspan="2">' . $value['sales_order_product_name'] . '</td>
        <td style="text-align: center;">' . $value['sales_order_category'] . '</td>
        <td style="text-align: center;">' . $value['sales_order_unit'] . '</td>
        <td style="text-align: right;">' . $value['sales_order_value'] . '</td>
        <td style="text-align: right;">' . $value['sales_order_price'] . '</td>
        <td style="text-align: right;">' . $value['sales_order_customer_id'] . '</td>
        <td style="text-align: center;" colspan="2">' . $date . '</td>
        </tr>';
        }


        $html .= '</table>';
        $pdf->writeHTML($html);

        $this->response->setContentType('application/pdf');
        $pdf->Output('sales-order.pdf', 'I');
    }

    public function export_excel()
    {
        $sales_order = "SELECT * FROM sales_order";
        $sales_order = $this->db->query($sales_order)->getResultArray();

        $fileName = 'sales_order.xlsx';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $count = count($sales_order);
        $count = $count + 1;

        // SET HEADER EXCEL
        $sheet->setCellValue('A1', 'Status');
        $sheet->setCellValue('B1', 'Product');
        $sheet->setCellValue('C1', 'Category');
        $sheet->setCellValue('D1', 'Unit');
        $sheet->setCellValue('E1', 'Value');
        $sheet->setCellValue('F1', 'Price');
        $sheet->setCellValue('G1', 'Customer ID');
        $sheet->setCellValue('H1', 'Date');

        $i = 2;
        foreach ($sales_order as $key => $value) {

            $date = $value['sales_order_date'];
            $date = date("d/m/Y", strtotime($date));

            // GENERATE PRICE IN RUPIAH
            $price = $value['sales_order_price'];
            $price = strlen($price);
            if ($price >= 3) {
                $price = number_format($value['sales_order_price'], 2, ',', '.');
            }

            // SET CELL VALUE
            $sheet->setCellValue('A' . $i, $value['sales_order_status']);
            $sheet->setCellValue('B' . $i, $value['sales_order_product_name']);
            $sheet->setCellValue('C' . $i, $value['sales_order_category']);
            $sheet->setCellValue('D' . $i, $value['sales_order_unit']);
            $sheet->setCellValue('E' . $i, $value['sales_order_value']);
            $sheet->setCellValue('F' . $i, 'Rp.' . $price . '');
            $sheet->setCellValue('G' . $i, $value['sales_order_customer_id']);
            $sheet->setCellValue('H' . $i, $date);

            $formatDate =
            $spreadsheet->getActiveSheet()
                ->getStyle('H' . $i . '')
                ->getNumberFormat()
                ->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);

            // SET FONT SIZE
            $fontStyle = [
                'font' => [
                    'size' => 15
                ]
            ];
            $sheet->getStyle("A1:H1")
                ->applyFromArray($fontStyle);

            // SET TITTLE AUTO BOLD
            $sheet->getStyle('A1:H1')->getFont()->setBold(true);
            $sheet->getStyle('A1:H1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);

            // SET STATUS COLOR
            $status = $value['sales_order_status'];
            if ($status == 'confirmed') {
                $sheet->getStyle('A' . $i . '')->getFont()->setBold(true);
                $sheet->getStyle('A' . $i . '')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('41f518'); // BACKGORUND COLOR
            }
            if ($status == 'canceled') {
                $sheet->getStyle('A' . $i . '')->getFont()->setBold(true);
                $sheet->getStyle('A' . $i . '')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('d1160d'); // BACKGORUND COLOR
            }
            if ($status == 'customer_canceled') {
                $sheet->getStyle('A' . $i . '')->getFont()->setBold(true);
                $sheet->getStyle('A' . $i . '')->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('d5f505'); // BACKGORUND COLOR
            }

            // SET BORDER
            $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '090a09']
                    ],
                ],
            ];
            $sheet->getStyle('A1:H' . ($count))->applyFromArray($styleArray);

            // AUTO SIZE
            $sheet->getColumnDimension('A')->setAutoSize(true);
            $sheet->getColumnDimension('B')->setAutoSize(true);
            $sheet->getColumnDimension('C')->setAutoSize(true);
            $sheet->getColumnDimension('D')->setAutoSize(true);
            $sheet->getColumnDimension('E')->setAutoSize(true);
            $sheet->getColumnDimension('F')->setAutoSize(true);
            $sheet->getColumnDimension('G')->setAutoSize(true);
            $sheet->getColumnDimension('H')->setAutoSize(true);

            // MAKE CENTER
            $sheet->getStyle('A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('C')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('D')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('E')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle('F')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle('G')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle('H')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $i++;
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=' . $fileName);
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}

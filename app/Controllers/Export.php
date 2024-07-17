<?php

namespace App\Controllers;

use App\Controllers\Core\AuthController;
use CodeIgniter\HTTP\ResponseInterface;
use TCPDF;
use PhpOffice\PhpSpreadsheet;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        $count = count($sales_order);


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
            $html .=
                '<tr>
        <td style="text-align: center;" colspan="2">' . $value['sales_order_status'] . '</td>
        <td style="text-align: center;" colspan="2">' . $value['sales_order_product_name'] . '</td>
        <td style="text-align: center;">' . $value['sales_order_category'] . '</td>
        <td style="text-align: center;">' . $value['sales_order_unit'] . '</td>
        <td style="text-align: center;">' . $value['sales_order_value'] . '</td>
        <td style="text-align: center;">' . $value['sales_order_price'] . '</td>
        <td style="text-align: center;">' . $value['sales_order_customer_id'] . '</td>
        <td style="text-align: center;" colspan="2">' . $value['sales_order_date'] . '</td>
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
        $sheet->mergeCells('A1:B1');
        $sheet->setCellValue('A1', 'Status');
        $sheet->mergeCells('C1:D1');
        $sheet->setCellValue('C1', 'Product');
        $sheet->setCellValue('E1', 'Category');
        $sheet->setCellValue('F1', 'Unit');
        $sheet->setCellValue('G1', 'Value');
        $sheet->setCellValue('H1', 'Price');
        $sheet->setCellValue('I1', 'Customer ID');
        $sheet->mergeCells('J1:K1');
        $sheet->setCellValue('J1', 'Date');

        $rows = 2;
        foreach ($sales_order as $key => $value) {
            $sheet->mergeCells('A'.$rows.':B'.$rows.'');
            $sheet->setCellValue('A' . $rows, $value['sales_order_status']);
            $sheet->mergeCells('C'.$rows.':D'.$rows.'');
            $sheet->setCellValue('C' . $rows, $value['sales_order_product_name']);
            $sheet->setCellValue('E' . $rows, $value['sales_order_category']);
            $sheet->setCellValue('F' . $rows, $value['sales_order_unit']);
            $sheet->setCellValue('G' . $rows, $value['sales_order_value']);
            $sheet->setCellValue('H' . $rows, $value['sales_order_price']);
            $sheet->setCellValue('I' . $rows, $value['sales_order_customer_id']);
            $sheet->mergeCells('J'.$rows.':K'.$rows.'');
            $sheet->setCellValue('J' . $rows, $value['sales_order_date']);
            $rows++;
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=' . $fileName);
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}

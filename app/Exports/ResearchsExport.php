<?php

namespace App\Exports;

use App\Models\Group;
use App\Models\Research;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\WithEvents;

use Maatwebsite\Excel\Events\BeforeExport;

class ResearchsExport implements WithEvents
{
    public function __construct($param = ['status' => 1])
    {
        $this->param = $param;
    }

    public function registerEvents(): array
    {
        return [
            BeforeExport::class => function (BeforeExport $event) {
                $event->writer->reopen(new \Maatwebsite\Excel\Files\LocalTemporaryFile(storage_path('export-researchs-report.xlsx')), Excel::XLSX);
                $data = Research::filter($this->param)->orderBy('key', 'ASC')->get();
                $i = 6;
                $status = ['Thiếu tệp đính kèm', 'Chờ phê duyệt', 'Đạt', 'Chưa đạt', 'Đóng'];
                $titles = ['Ảnh đại diện', 'Tóm tắt đề tài', 'Phụ lục I', 'Phụ lục II'];
                $lfcr = chr(10);
                $event->writer->getSheetByIndex(0);
                // dd($this->param['group_id']);
                if (($this->param['group_id']??0)>0){
                    $group = Group::find( $this->param['group_id']);
                    // dd($group);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('A4', 'NHÓM LĨNH VỰC: ('.$group['key'].') '.$group['name']);
                }
                foreach ($data as $research) {
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('A' . $i, $i - 5);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('B' . $i, str_replace('Sở Giáo dục và Đào tạo ', "", $research->user->name));
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('C' . $i, $research->key);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('D' . $i, $research->name);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('E' . $i, $research->field->name);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('F' . $i, $status[$research->status]);
                    $files = $research->file->where('status', 2)->pluck('comment');
                    $types = $research->file->where('status', 2)->pluck('type');
                    $str = '';
                    foreach ($files as $key => $file) {
                        if ($key == 0) $str = $str . "- " . $file . " (" . $titles[$types[$key]] . ")";
                        else $str = $str . $lfcr . "- " . $file . " (" . $titles[$types[$key]] . ")";
                    }
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('G' . $i,  $str);
                    $i++;
                }
                $event->getWriter()->getSheetByIndex(0)->getStyle('A6:H' . ($i - 1))->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ]
                ]);
                $event->getWriter()->getSheetByIndex(0)->setCellValue('G' . ($i+1), "Người thẩm định");
                $event->getWriter()->getSheetByIndex(0)->setCellValue('G' . ($i+2), "(Ký, ghi rõ họ tên)");
                $event->getWriter()->getSheetByIndex(0)->getStyle('G' . ($i+1) )->applyFromArray([
                    'font' => ['bold' => true, 'size'=> 13],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
                $event->getWriter()->getSheetByIndex(0)->getStyle('G' . ($i+2) )->applyFromArray([
                    'font' => ['italic' => true],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
                return $event->getWriter()->getSheetByIndex(0);
            }
        ];
    }
}

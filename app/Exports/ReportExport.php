<?php

namespace App\Exports;

use App\Models\Examiner;
use App\Models\Field;
use App\Models\Group;
use App\Models\Research;
use App\Models\User;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Excel;

use Maatwebsite\Excel\Events\BeforeExport;

class ReportExport implements WithEvents
{
    public function __construct($type, $param)
    {
        $this->type = $type;
        $this->param = $param;
    }

    public function registerEvents(): array
    {
        //Xuất theo Đơn vị đăng ký
        if ($this->type == 1) return [
            BeforeExport::class => function (BeforeExport $event) {
                $event->writer->reopen(new \Maatwebsite\Excel\Files\LocalTemporaryFile(storage_path('export-DA-HS-report.xlsx')), Excel::XLSX);
                $users = User::whereHas(
                    'roles',
                    function ($q) {
                        $q->where('name', 'Chuyên viên Sở');
                    }
                )->get();
                $i = 6;
                $event->writer->getSheetByIndex(0);
                $event->getWriter()->getSheetByIndex(0)->setCellValue('A2', 'CUỘC THI KHKT CẤP QUỐC GIA NĂM ' . date('Y'));
                $sum = [0, 0, 0, 0, 0, 0, 0, 0];
                foreach ($users as $user) {
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('A' . $i, $i - 5);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('B' . $i, str_replace('Sở Giáo dục và Đào tạo ', "", $user->name));
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('C' . $i, count($user->researchs));
                    $a = 0;
                    $b = 0;
                    $c = 0;
                    $d = 0;
                    $e = 0;
                    $f = 0;
                    foreach ($user->researchs as $r) {
                        if ($r->type == 1) {
                            $a++;
                            if ($r->level == 3) $e++;
                            else $f++;
                        } else {
                            $b++;
                            if ($r->level == 3) $e += 2;
                            else $f += 2;
                        }
                        if ($r->level == 3) $c++;
                        else $d++;
                    }
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('D' . $i, $a);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('E' . $i, $b);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('F' . $i, $c);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('G' . $i, $d);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('H' . $i, $e);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('I' . $i, $f);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('J' . $i, $e + $f);
                    $sum[0] += count($user->researchs);
                    $sum[1] += $a;
                    $sum[2] += $b;
                    $sum[3] += $c;
                    $sum[4] += $d;
                    $sum[5] += $e;
                    $sum[6] += $f;
                    $sum[7] += ($e + $f);
                    $i++;
                }
                $event->getWriter()->getSheetByIndex(0)->setCellValue('B' . $i, "TỔNG SỐ");
                $keys = ['C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
                foreach ($sum as $key => $s) {
                    $event->getWriter()->getSheetByIndex(0)->setCellValue($keys[$key] . $i, $s);
                }
                $event->getWriter()->getSheetByIndex(0)->getStyle('A6:J' . ($i))->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ]
                ]);
                $event->getWriter()->getSheetByIndex(0)->getStyle('B' . $i . ':J' . ($i))->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
                return $event->getWriter()->getSheetByIndex(0);
            }
        ];
        // Xuất theo lĩnh vực
        if ($this->type == 2) return [
            BeforeExport::class => function (BeforeExport $event) {
                $event->writer->reopen(new \Maatwebsite\Excel\Files\LocalTemporaryFile(storage_path('export-LV-DA-report.xlsx')), Excel::XLSX);
                $fields = Field::withCount('researchs');
                $fields = $fields->filter($this->param)->get();
                // dd($fields);
                $i = 6;
                $event->writer->getSheetByIndex(0);
                $event->getWriter()->getSheetByIndex(0)->setCellValue('A2', 'CUỘC THI KHKT CẤP QUỐC GIA NĂM ' . date('Y'));
                $sum = 0;
                foreach ($fields as $field) {
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('D' . $i, $field->researchs_count);
                    $sum += $field->researchs_count;
                    $i++;
                }
                $event->getWriter()->getSheetByIndex(0)->setCellValue('D' . $i, $sum);
                return $event->getWriter()->getSheetByIndex(0);
            }
        ];
        if ($this->type == 3) return [
            BeforeExport::class => function (BeforeExport $event) {
                $event->writer->reopen(new \Maatwebsite\Excel\Files\LocalTemporaryFile(storage_path('export-GK-DA-report.xlsx')), Excel::XLSX);
                // $examiners = Examiner::where('group_id', $id)->orderBy('key', 'ASC')->get();
                // $data = $this->param['group_id'];
                $examiner = Examiner::find($this->param['examiner_id']);
                $s = 0;
                $researchs = $examiner->researchs()->wherePivot('round', $this->param['round'] ?? 1)->orderBy('key', 'ASC')->get();
                $i = 5;
                $event->writer->getSheetByIndex($s);
                $event->getWriter()->getSheetByIndex($s)->setCellValue('A2', 'CUỘC THI KHKT CẤP QUỐC GIA NĂM ' . date('Y'));
                $event->getWriter()->getSheetByIndex($s)->setCellValue('A3', 'Vòng: ' . $this->param['round']);
                $event->getWriter()->getSheetByIndex($s)->setCellValue('C3', 'Giám khảo: 0' . $this->param['round'] . '-' . $examiner->key);
                foreach ($researchs as $research) {
                    $event->getWriter()->getSheetByIndex($s)->setCellValue('A' . $i, $research->key);
                    $event->getWriter()->getSheetByIndex($s)->setCellValue('B' . $i, $research->name);
                    $event->getWriter()->getSheetByIndex($s)->setCellValue('C' . $i, $research->pivot->point);
                    $event->getWriter()->getSheetByIndex($s)->setCellValue('D' . $i, $research->pivot->comment);
                    $i++;
                }
                $event->getWriter()->getSheetByIndex($s)->setCellValue('A' . ($i + 1), '           Thư ký                                        Giám khảo                                      Thanh tra');
                $event->getWriter()->getSheetByIndex($s)->setCellValue('A' . ($i + 2), '  (Kí và ghi rõ họ tên)                       (Kí và ghi rõ họ tên)                       (Kí và ghi rõ họ tên)');
                $event->getWriter()->getSheetByIndex($s)->getStyle('A5:D' . ($i - 1))->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ]
                ]);
                $event->getWriter()->getSheetByIndex(0)->getStyle('A' . ($i + 1))->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                    ],
                ]);
                $event->getWriter()->getSheetByIndex(0)->getStyle('A' . ($i + 2))->applyFromArray([
                    'font' => ['italic' => true],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                    ],
                ]);
                return $event->getWriter()->getSheetByIndex(0);
            }
        ];
        //Xuất giải
        if ($this->type == 4) return [
            BeforeExport::class => function (BeforeExport $event) {
                $event->writer->reopen(new \Maatwebsite\Excel\Files\LocalTemporaryFile(storage_path('export-medals.xlsx')), Excel::XLSX);
                $i = 8;
                $event->writer->getSheetByIndex(0);
                $group = Group::find($this->param[0]->group_id);
                $event->getWriter()->getSheetByIndex(0)->setCellValue('D5', $group->name);
                // dd($this->param);
                foreach ($this->param as $r) {
                    $student_1 = explode(',', $r['student_1']);
                    $student_2 = explode(',', $r['student_2']);
                    $teacher = explode(',', $r['teacher']);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('A' . $i, $i - 7);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('D' . $i, str_replace('Sở Giáo dục và Đào tạo ', "", $r->user->name));
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('G' . $i, $r->field->name);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('L' . $i, $r->name);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('M' . $i, $student_1[0]);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('R' . $i, $r->school->name ?? '');
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('T' . $i, $student_2[0]);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('Y' . $i, $r->school2->name ?? '');
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('Z' . $i, $teacher[0] ?? '');
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('AA' . $i, $teacher[1] ?? '');
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('AD' . $i, $r->point ?? '');
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('AF' . $i, $r->medal->name ?? '');
                    $i++;
                }

                $event->getWriter()->getSheetByIndex(0)->setCellValue('T' . ($i + 1), 'CHỦ TỊCH HỒI ĐỒNG CHẤM THI');
                $event->getWriter()->getSheetByIndex(0)->setCellValue('T' . ($i + 2), '                       (Kí và ghi rõ họ tên)');

                $event->getWriter()->getSheetByIndex(0)->getStyle('T' . ($i + 1))->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
                    ],
                ]);
                $event->getWriter()->getSheetByIndex(0)->getStyle('T' . ($i + 2))
                    ->applyFromArray([
                        'font' => ['italic' => true],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
                        ],
                    ]);
                $event->getWriter()->getSheetByIndex(0)->getStyle('A7:AF' . ($i - 1))->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ]
                ]);
                $event->getWriter()->getSheetByIndex(0)->getStyle('T' . ($i + 1))
                    ->getAlignment()
                    ->setWrapText(false);

                $event->getWriter()->getSheetByIndex(0)->getStyle('T' . ($i + 2))
                    ->getAlignment()
                    ->setWrapText(false);
                // $event->getWriter()->getDelegate()->getSecurity()->setLockWindows(true);
                // $event->getWriter()->getDelegate()->getSecurity()->setLockStructure(true);
                // $event->getWriter()->getDelegate()->getSecurity()->setWorkbookPassword("khkt2021");
                // $protection = $event->getWriter()->getSheetByIndex(0)->getActiveSheet()->getProtection();
                // $protection->setPassword('khkt2021');
                // $protection->setSheet(true);
                // $protection->setSort(true);
                // $protection->setInsertRows(true);
                // $protection->setFormatCells(true);
                return $event->getWriter()->getSheetByIndex(0);
            }
        ];
        //Thông tin đăng ký dự thi
        if ($this->type == 5) return [
            BeforeExport::class => function (BeforeExport $event) {
                $event->writer->reopen(new \Maatwebsite\Excel\Files\LocalTemporaryFile(storage_path('export-researchs.xlsx')), Excel::XLSX);
                $i = 6;
                $genders = ['Nam', 'Nữ', 'Khác'];
                $nations = ['Kinh', 'Tày', 'Thái', 'Mường', 'Khmer', 'Hoa', 'Nùng', 'H\'Mông', 'Dao', 'Gia Rai', 'Ê Đê', 'Ba Na', 'Sán Chay', 'Chăm', 'Cơ Ho', 'Xơ Đăng', 'Sán Dìu', 'Hrê', 'Ra Glai', 'Mnông', 'Thổ', 'Stiêng', 'Khơ mú', 'Bru - Vân Kiều', 'Cơ Tu', 'Giáy', 'Tà Ôi', 'Mạ', 'Giẻ-Triêng', 'Co', 'Chơ Ro', 'Xinh Mun', 'Hà Nhì', 'Chu Ru', 'Lào', 'La Chí', 'Kháng', 'Phù Lá', 'La Hủ', 'La Ha', 'Pà Thẻn', 'Lự', 'Ngái', 'Chứt', 'Lô Lô', 'Mảng', 'Cơ Lao', 'Bố Y', 'Cống', 'Si La', 'Pu Péo', 'Rơ Măm', 'Brâu', 'Ơ Đu'];
                $event->writer->getSheetByIndex(0);
                // $event->getWriter()->getSheetByIndex(0)->setCellValue('A2', 'CUỘC THI KHKT CẤP QUỐC GIA NĂM ' . date('Y'));
                foreach ($this->param as $r) {
                    $student_1 = explode(',', $r['student_1']);
                    $student_2 = explode(',', $r['student_2']);
                    $teacher = explode(',', $r['teacher']);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('A' . $i, $r->user->no ?? '');
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('B' . $i, str_replace('Sở Giáo dục và Đào tạo ', "", $r->user->name));
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('C' . $i, $r->field->name);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('D' . $i, $r->name);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('E' . $i, $student_1[0]);
                    $d = explode('-', $student_1[1] ?? "xxxx-xx-xx");
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('F' . $i, ($d[2] ?? "--") . "/" . ($d[1] ?? "--") . "/" . ($d[0] ?? "--"));
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('G' . $i, $genders[$student_1[2]]);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('H' . $i, $nations[$student_1[4]]);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('I' . $i, $student_1[3]);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('J' . $i, $r->school->name ?? '');
                    if ($student_2[0]) {
                        $event->getWriter()->getSheetByIndex(0)->setCellValue('K' . $i, $student_2[0]);
                        $d = explode('-', $student_2[1] ?? "xxxx-xx-xx");
                        $event->getWriter()->getSheetByIndex(0)->setCellValue('L' . $i, ($d[2] ?? "--") . "/" . ($d[1] ?? "--") . "/" . ($d[0] ?? "--"));
                        $event->getWriter()->getSheetByIndex(0)->setCellValue('M' . $i, $genders[$student_2[2]]);
                        $event->getWriter()->getSheetByIndex(0)->setCellValue('N' . $i, $nations[$student_2[4]]);
                        $event->getWriter()->getSheetByIndex(0)->setCellValue('O' . $i, $student_2[3]);
                        $event->getWriter()->getSheetByIndex(0)->setCellValue('P' . $i, $r->school2->name ?? '');
                    }
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('Q' . $i, $teacher[0]);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('R' . $i, $teacher[1]);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('S' . $i, $r->p1);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('T' . $i, $r->p2);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('U' . $i, $r->point);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('V' . $i, $r->medal->name??'');
                    // $event->getWriter()->getSheetByIndex(0)->setCellValue('N' . $i, $r->school->key ?? '');
                    // $event->getWriter()->getSheetByIndex(0)->setCellValue('N' . $i, $r->school->nameEn ?? '');
                    // $event->getWriter()->getSheetByIndex(0)->setCellValue('Q' . $i, $r->school2->nameEn ?? '');
                    // $event->getWriter()->getSheetByIndex(0)->setCellValue('O' . $i, $r->field->nameEn ?? '');
                    // $event->getWriter()->getSheetByIndex(0)->setCellValue('P' . $i, $r->province->name ?? '');
                    // $event->getWriter()->getSheetByIndex(0)->setCellValue('R' . $i, $r->user->id ?? '');
                    // $event->getWriter()->getSheetByIndex(0)->setCellValue('S' . $i, $r->field->id ?? '');
                    $i++;
                }
                $event->getWriter()->getSheetByIndex(0)->getStyle('A6:W' . ($i - 1))->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ]
                ]);
                return $event->getWriter()->getSheetByIndex(0);
            }
        ];

        // Phiếu kiểm tra điểm
        if ($this->type == 6) return [
            BeforeExport::class => function (BeforeExport $event) {
                $event->writer->reopen(new \Maatwebsite\Excel\Files\LocalTemporaryFile(storage_path('export-point.xlsx')), Excel::XLSX);
                $i = 5;
                $a = ['C', 'D', 'E', 'F', 'G'];
                $event->writer->getSheetByIndex(0);
                $event->getWriter()->getSheetByIndex(0)->setCellValue('B3', 'Nhóm: ' . $this->param['name'] ?? '');
                $event->getWriter()->getSheetByIndex(0)->setCellValue('C3', 'Vòng: ' . $this->param['round'] ?? '');
                foreach ($this->param['rs'] as $r) {
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('A' . $i, $r->key);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('B' . $i, $r->name);
                    $es = $r->examiners()->wherePivot('round', $this->param['round'] ?? 1)->get();
                    foreach ($es as $k => $e) {
                        $event->getWriter()->getSheetByIndex(0)->setCellValue($a[$k] . $i, $e->pivot->point);
                    }
                    $i++;
                }
                $event->getWriter()->getSheetByIndex(0)->getStyle('A5:G' . ($i - 1))->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ]
                ]);
                return $event->getWriter()->getSheetByIndex(0);
            }
        ];

        // Danh sách học sinh
        if ($this->type == 7) return [
            BeforeExport::class => function (BeforeExport $event) {
                $event->writer->reopen(new \Maatwebsite\Excel\Files\LocalTemporaryFile(storage_path('export-DSHS.xlsx')), Excel::XLSX);
                $i = 2;
                $event->writer->getSheetByIndex(0);
                foreach ($this->param as $r) {
                    $student_1 = explode(',', $r['student_1']);
                    $student_2 = explode(',', $r['student_2']);

                    $event->getWriter()->getSheetByIndex(0)->setCellValue('A' . $i, $student_1[0]);
                    $d = explode('-', $student_1[1] ?? "xxxx-xx-xx");
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('B' . $i, ($d[2] ?? "--") . "/" . ($d[1] ?? "--") . "/" . ($d[0] ?? "--"));
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('C' . $i, $r->school->name ?? '');
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('D' . $i, $r->province->name ?? '');
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('E' . $i, $r->field->name ?? '');
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('G' . $i, ($d[1] ?? "--") . "/" . ($d[2] ?? "--") . "/" . ($d[0] ?? "--"));
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('H' . $i, $r->school->nameEn ?? '');
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('J' . $i, $r->field->nameEn ?? '');
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('K' . $i, $r->field->id ?? '');
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('L' . $i, ($i - 1));
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('M' . $i, $r->school->key ?? '');
                    if ($student_2[0]) {
                        $i++;
                        $event->getWriter()->getSheetByIndex(0)->setCellValue('A' . $i, $student_2[0]);
                        $d = explode('-', $student_2[1] ?? "xxxx-xx-xx");
                        $event->getWriter()->getSheetByIndex(0)->setCellValue('B' . $i, ($d[2] ?? "--") . "/" . ($d[1] ?? "--") . "/" . ($d[0] ?? "--"));
                        $event->getWriter()->getSheetByIndex(0)->setCellValue('C' . $i, $r->school2->name ?? '');
                        $event->getWriter()->getSheetByIndex(0)->setCellValue('D' . $i, $r->province->name ?? '');
                        $event->getWriter()->getSheetByIndex(0)->setCellValue('E' . $i, $r->field->name ?? '');
                        $event->getWriter()->getSheetByIndex(0)->setCellValue('G' . $i, ($d[1] ?? "--") . "/" . ($d[2] ?? "--") . "/" . ($d[0] ?? "--"));
                        $event->getWriter()->getSheetByIndex(0)->setCellValue('H' . $i, $r->school2->nameEn ?? '');
                        $event->getWriter()->getSheetByIndex(0)->setCellValue('J' . $i, $r->field->nameEn ?? '');
                        $event->getWriter()->getSheetByIndex(0)->setCellValue('K' . $i, $r->field->id ?? '');
                        $event->getWriter()->getSheetByIndex(0)->setCellValue('L' . $i, ($i - 1));
                        $event->getWriter()->getSheetByIndex(0)->setCellValue('M' . $i, $r->school2->key ?? '');
                    }

                    $i++;
                }
                $event->getWriter()->getSheetByIndex(0)->getStyle('A5:G' . ($i - 1))->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ]
                ]);
                return $event->getWriter()->getSheetByIndex(0);
            }
        ];

        // Danh sách giáo viên
        if ($this->type == 8) return [
            BeforeExport::class => function (BeforeExport $event) {
                $event->writer->reopen(new \Maatwebsite\Excel\Files\LocalTemporaryFile(storage_path('export-DSGV.xlsx')), Excel::XLSX);
                $i = 2;
                $event->writer->getSheetByIndex(0);
                foreach ($this->param as $r) {
                    $student_1 = explode(',', $r['student_1']);
                    $student_2 = explode(',', $r['student_2']);
                    $teacher = explode(',', $r['teacher']);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('B' . $i, $r->province->name ?? '');
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('E' . $i, $teacher[0]);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('F' . $i, $teacher[1]);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('G' . $i, $r->school->name ?? '');
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('H' . $i, $r->id);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('C' . $i, $student_1[0]);
                    if ($student_2[0]) {
                        $event->getWriter()->getSheetByIndex(0)->setCellValue('D' . $i, $student_2[0] ?? '');
                    }

                    $i++;
                }
                $event->getWriter()->getSheetByIndex(0)->getStyle('A2:D' . ($i - 1))->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ]
                ]);
                return $event->getWriter()->getSheetByIndex(0);
            }
        ];
        //export giải
        if ($this->type == 9) return [
            BeforeExport::class => function (BeforeExport $event) {
                $event->writer->reopen(new \Maatwebsite\Excel\Files\LocalTemporaryFile(storage_path('medal-group.xlsx')), Excel::XLSX);
                $i = 5;
                $t = 0;
                $t1 = 0;
                $t2 = 0;
                $t3 = 0;
                $t4 = 0;
                $event->writer->getSheetByIndex(0);
                foreach ($this->param as $g) {
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('A' . $i, $i - 4);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('B' . $i, $g->name);
                    $rs = Research::where('group_id', $g->id)->get();
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('C' . $i, count($rs));
                    $m1 = 0;
                    $m2 = 0;
                    $m3 = 0;
                    $m4 = 0;
                    foreach ($rs as $r) {
                        if ($r->medal_id == 1)  $m1++;
                        if ($r->medal_id == 2)  $m2++;
                        if ($r->medal_id == 3)  $m3++;
                        if ($r->medal_id == 4)  $m4++;
                    }
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('D' . $i, $m1);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('E' . $i, $m1 / count($rs));
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('F' . $i, $m2);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('G' . $i, $m2 / count($rs));
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('H' . $i, $m3);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('I' . $i, $m3 / count($rs));
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('J' . $i, $m4);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('K' . $i, $m4 / count($rs));
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('L' . $i, $m1 + $m2 + $m3 + $m4);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('M' . $i, ($m1 + $m2 + $m3 + $m4) / count($rs));
                    $t += count($rs);
                    $t1 += $m1;
                    $t2 += $m2;
                    $t3 += $m3;
                    $t4 += $m4;
                    $i++;
                }

                $event->getWriter()->getSheetByIndex(0)->setCellValue('B' . $i, 'Tổng');
                $event->getWriter()->getSheetByIndex(0)->setCellValue('C' . $i, $t);
                $event->getWriter()->getSheetByIndex(0)->setCellValue('D' . $i, $t1);
                $event->getWriter()->getSheetByIndex(0)->setCellValue('E' . $i, $t1 / $t);
                $event->getWriter()->getSheetByIndex(0)->setCellValue('F' . $i, $t2);
                $event->getWriter()->getSheetByIndex(0)->setCellValue('G' . $i, $t2 / $t);
                $event->getWriter()->getSheetByIndex(0)->setCellValue('H' . $i, $t3);
                $event->getWriter()->getSheetByIndex(0)->setCellValue('I' . $i, $t3 / $t);
                $event->getWriter()->getSheetByIndex(0)->setCellValue('J' . $i, $t4);
                $event->getWriter()->getSheetByIndex(0)->setCellValue('K' . $i, $t4 / $t);
                $event->getWriter()->getSheetByIndex(0)->setCellValue('L' . $i, $t1 + $t2 + $t3 + $t4);
                $event->getWriter()->getSheetByIndex(0)->setCellValue('M' . $i, ($t1 + $t2 + $t3 + $t4) / $t);

                $event->getWriter()->getSheetByIndex(0)->setCellValue('F' . ($i + 2), "........., ngày \t tháng \t năm ");
                $event->getWriter()->getSheetByIndex(0)->setCellValue('F' . ($i + 3), 'Chủ tịch hội đồng chấm thi');

                $event->getWriter()->getSheetByIndex(0)->getStyle('A' . $i . ':M' . $i)->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12]
                ]);
                $event->getWriter()->getSheetByIndex(0)->getStyle('A5:M' . ($i))->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ]
                ]);
                return $event->getWriter()->getSheetByIndex(0);
            }
        ];
        //export giải
        if ($this->type == 10) return [
            BeforeExport::class => function (BeforeExport $event) {
                $event->writer->reopen(new \Maatwebsite\Excel\Files\LocalTemporaryFile(storage_path('medal-dvdt.xlsx')), Excel::XLSX);
                $i = 5;
                $t = 0;
                $t1 = 0;
                $t2 = 0;
                $t3 = 0;
                $t4 = 0;
                $event->writer->getSheetByIndex(0);
                foreach ($this->param as $u) {
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('A' . $i, $i - 4);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('B' . $i, str_replace('Sở Giáo dục và Đào tạo ', "", $u->name));
                    $rs = Research::where('user_id', $u->id)->get();
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('C' . $i, count($rs));
                    $m1 = 0;
                    $m2 = 0;
                    $m3 = 0;
                    $m4 = 0;
                    foreach ($rs as $r) {
                        if ($r->medal_id == 1)  $m1++;
                        if ($r->medal_id == 2)  $m2++;
                        if ($r->medal_id == 3)  $m3++;
                        if ($r->medal_id == 4)  $m4++;
                    }
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('D' . $i, $m1);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('E' . $i, $m2);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('F' . $i, $m3);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('G' . $i, $m4);
                    $event->getWriter()->getSheetByIndex(0)->setCellValue('H' . $i, $m1 + $m2 + $m3 + $m4);
                    $t += count($rs);
                    $t1 += $m1;
                    $t2 += $m2;
                    $t3 += $m3;
                    $t4 += $m4;
                    $i++;
                }

                $event->getWriter()->getSheetByIndex(0)->setCellValue('B' . $i, 'Tổng');
                $event->getWriter()->getSheetByIndex(0)->setCellValue('C' . $i, $t);
                $event->getWriter()->getSheetByIndex(0)->setCellValue('D' . $i, $t1);
                $event->getWriter()->getSheetByIndex(0)->setCellValue('E' . $i, $t2);
                $event->getWriter()->getSheetByIndex(0)->setCellValue('F' . $i, $t3);
                $event->getWriter()->getSheetByIndex(0)->setCellValue('G' . $i, $t4);
                $event->getWriter()->getSheetByIndex(0)->setCellValue('H' . $i, $t1 + $t2 + $t3 + $t4);

                $event->getWriter()->getSheetByIndex(0)->setCellValue('D' . ($i + 2), "........., ngày \t tháng \t năm ");
                $event->getWriter()->getSheetByIndex(0)->setCellValue('D' . ($i + 3), 'Chủ tịch hội đồng chấm thi');

                $event->getWriter()->getSheetByIndex(0)->getStyle('A' . $i . ':H' . $i)->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12]
                ]);
                $event->getWriter()->getSheetByIndex(0)->getStyle('A5:H' . ($i))->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ]
                ]);
                return $event->getWriter()->getSheetByIndex(0);
            }
        ];
    }
}

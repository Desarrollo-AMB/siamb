<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class FichaExport implements FromView, ShouldAutoSize
{
    public $data;
    public function afterSheet(AfterSheet $event)
    {
        $event->sheet->getStyle('A1:F' . $event->sheet->getHighestRow())
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN)
            ->setColor(\PhpOffice\PhpSpreadsheet\Style\Color::black());
    }
	public function __construct(array $data)
	{
		$this->data = $data;
	}

	public function view() : View
	{
		return view('juntap.reportes.ficha', $this->data);
	}


}


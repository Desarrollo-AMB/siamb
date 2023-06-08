<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class PerosnalubicacionesExport implements FromView
{
    public $data1;

	public function __construct(array $data1)
	{
		$this->data1 = $data1;
	}
    public function view() : View
	{
		return view('excel.personal_militar_ubicaciones', $this->data1);
	}
}

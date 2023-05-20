<?php

namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProgramacionFinExport implements FromView, ShouldAutoSize
{
	public $data;

	public function __construct(array $data)
	{
		$this->data = $data;
	}

	public function view() : View
	{
		return view('dao.operacionesAereas.programacionVuelo.ProgramacionFin', $this->data);
	}
}

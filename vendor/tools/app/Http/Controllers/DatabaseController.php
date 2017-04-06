<?php
namespace Plugins\Tools\App\Http\Controllers;

use Schema, DB;
use PHPExcel, PHPExcel_Style_Border, PHPExcel_Style_Fill, PHPExcel_Style_Alignment;
use Addons\Core\File\Mimes;
use Illuminate\Http\Request;
use Addons\Core\Controllers\Controller;
use Addons\Core\Validation\ValidatesRequests;

class DatabaseController extends Controller {
	use ValidatesRequests;

	protected $addons = false;

	public function export()
	{
		$platform = DB::getDoctrineSchemaManager()->getDatabasePlatform();
		//$platform->registerDoctrineTypeMapping('enum', 'string');
		$database_name = DB::getDatabaseName();

		$excel = new \PHPExcel();
		$write = new \PHPExcel_Writer_Excel2007($excel);
		$sheet = $excel->setActiveSheetIndex(0);
		$sheet->setTitle($database_name);
		$titles = ['字段名', '含义', '类型', '默认', '索引'];

		$tables = DB::select('SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=\''.$database_name.'\'');
		$data = [$titles]; $merges = [];
		foreach($tables as $table)
		{
			$name = $table->TABLE_NAME;
			$data[] = [$name. ' '. $table->TABLE_COMMENT]; // title
			$merges[] = count($data);
			//$cols = DB::getDoctrineSchemaManager()->listTableColumns($name);
			
			$pk = DB::select('select * from INFORMATION_SCHEMA.KEY_COLUMN_USAGE  where TABLE_NAME=\''. $name.'\' AND CONSTRAINT_SCHEMA = \''.$database_name.'\' ');
			$pk_fields = [];
			foreach($pk as $p)
				$pk_fields[$p->COLUMN_NAME] = !empty($p->REFERENCED_TABLE_NAME) ? $p->REFERENCED_TABLE_NAME.'.'.$p->REFERENCED_COLUMN_NAME : $p->CONSTRAINT_NAME . ' ' . $p->ORDINAL_POSITION;
			
			$cols = DB::select('SHOW FULL COLUMNS FROM '. $name);


			foreach ($cols as $col) {
				$data[] = [
					$col->Field,
					$col->Comment,
				 	$col->Type,
					is_null($col->Default) ? ($col->Null == 'YES' ?  'NULL' : '') : $col->Default,
					$col->Key . (isset($pk_fields[$col->Field]) ? ' ' .$pk_fields[$col->Field]  : ''),
					$col->Extra == 'auto_increment' ? 'AI' : '',
				];
			}

		}
		$sheet->fromArray($data);
		$max_col = $sheet->getHighestColumn();
		/**autosize*/
		for ($col = 65; $col <= ord($max_col); $col++)
			$sheet->getColumnDimension(chr($col))->setAutoSize(true);

		$center = [
			'alignment' => [
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			]
		];
		//all border
		$sheet->getStyle('A1:' . $max_col . $sheet->getHighestRow() )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

		//头部
		$sheet->getStyle('A1:'.$max_col.'1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$sheet->getStyle('A1:'.$max_col.'1')->applyFromArray(
			[
				'fill' => [
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => 'BDD7EE'),
				]
			]  + $center
		);
		$sheet->getRowDimension(1)->setRowHeight(30);
		$sheet->freezePane('A2'); //锁第一行
		//合并单元格
		foreach($merges as $row)
		{
			$no = 'A'.$row.':'.$max_col.$row;
			$sheet->mergeCells($no);
			$sheet->getStyle($no)->applyFromArray(
				[
					'fill' => [
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => 'F4B084'),
					]
				] + $center
			);
			$sheet->getRowDimension($row)->setRowHeight(25);
		}

		$filepath = tempnam(storage_path('utils'),'excel');
		@chmod($filepath, 0777);

		$write->save($filepath);

		return response()->download($filepath, date('YmdHis').'.xlsx', ['Content-Type' =>  Mimes::getInstance()->mime_by_ext('xlsx')])->deleteFileAfterSend(TRUE);
	}

}
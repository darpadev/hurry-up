<?php

/**
 * @author          Burhan Mafazi | burhanmafazi@gmail.com
 * @link            https://burhanmafazi.xyz
 */

defined('BASEPATH') OR exit('No direct script access allowed.');

class Presence extends MY_Controller
{
	protected $view = 'contents/employee/presence/';

	public function __construct()
	{
		parent::__construct();
		$this->authorization->employee();
		$this->load->model('presences');
		$this->load->model('reports');
	}

	public function index()
	{
		$nip = $this->db->select('nip')->from('employee_pt')->where('employee_id', $this->session->userdata('employee'))->get()->row()->nip;

		$data['content']	= $this->view.'content';
		$data['css']		= $this->view.'css';
		$data['javascript']	= $this->view.'javascript';
		$data['title']		= 'Presensi';
		$data['sub_title']	= '';
		$data['message']	= '';

		$type = NULL;
		$start = date('Y-m-d');
		$finish = date('Y-m-d');

		if (isset($_GET['type']) && $_GET['type'] != 'Semua') {
			$type = $_GET['type'];
		}

		if (isset($_GET['date'])) {
			$date = explode(' - ', $_GET['date']);
			$start = date('Y-m-d', strtotime($date[0]));
			if (isset($date[1])) {
				$finish = date('Y-m-d', strtotime($date[1]));
			}
		}
		
		$data['data'] = $this->presences->searchEmployeePresence(NULL, $nip, $type, $start, $finish);

		$this->load->view('includes/main', $data);
	}

	public function report()
	{
		// Load plugin PHPExcel nya
	    include APPPATH.'third_party/PHPExcel/PHPExcel.php';
	    
	    // Panggil class PHPExcel nya
	    $excel = new PHPExcel();

	    // Settingan awal fil excel
	    $excel->getProperties()->setCreator('Universitas Pertamina')
	                 ->setLastModifiedBy('Universitas Pertamina')
	                 ->setTitle("Data Presensi Pegawai")
	                 ->setSubject("Data Presensi Pegawai")
	                 ->setDescription("Laporan Data Presensi Pegawai")
	                 ->setKeywords("Data Presensi Pegawai");

	    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
	    $style_col = array(
	      'font' => array('bold' => true), // Set font nya jadi bold
	      'alignment' => array(
	        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
	        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
	      ),
	      'borders' => array(
	        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
	        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
	        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
	        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
	      )
	    );

	    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
	    $style_row = array(
	      'alignment' => array(
	        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
	      ),
	      'borders' => array(
	        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
	        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
	        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
	        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
	      )
	    );

	    //fill
	    $red = array(
	      'fill' => array(
	        'type' => PHPExcel_Style_Fill::FILL_SOLID,
	        'color' => array('rgb'=>'FF0000'),
	      )
	  	);

	    $excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA PRESENSI PEGAWAI"); // Set kolom A1 dengan tulisan "DATA ABSENSI PEGAWAI"
	    $excel->getActiveSheet()->mergeCells('A1:M1'); // Set Merge Cell pada kolom A1 sampai E1
	    $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
	    $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
	    $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

	    // Buat header tabel nya pada baris ke 3
	    $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO");
	    $excel->setActiveSheetIndex(0)->setCellValue('B3', "NIP");
	    $excel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA");
	    $excel->setActiveSheetIndex(0)->setCellValue('D3', "TANGGAL");
	    $excel->setActiveSheetIndex(0)->setCellValue('E3', "WAKTU DATANG");
	    $excel->setActiveSheetIndex(0)->setCellValue('F3', "WAKTU PULANG");
	    $excel->setActiveSheetIndex(0)->setCellValue('G3', "DURASI");
	    $excel->setActiveSheetIndex(0)->setCellValue('H3', "STATUS");
	    $excel->setActiveSheetIndex(0)->setCellValue('I3', "GRUP");
	    $excel->setActiveSheetIndex(0)->setCellValue('J3', "KETERANGAN");
	    $excel->setActiveSheetIndex(0)->setCellValue('K3', "TIPE PRESENSI");
	    $excel->setActiveSheetIndex(0)->setCellValue('L3', "KONDISI KESEHATAN");
	    $excel->setActiveSheetIndex(0)->setCellValue('M3', "CATATAN KESEHATAN");

	    // Apply style header yang telah kita buat tadi ke masing-masing kolom header
	    $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
	    $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
	    $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
	    $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
	    $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
	    $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
	    $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
	    $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
	    $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
	    $excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
	    $excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
	    $excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
	    $excel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);

	    // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
	    $group = NULL;
		$start = NULL;
		$finish = NULL;
		$type = NULL;

		if (isset($_GET['type']) && $_GET['type'] != 'Semua') {
			$type = $_GET['type'];
		}

		if (isset($_GET['date'])) {
			$date = explode(' - ', $_GET['date']);
			$start = date('Y-m-d', strtotime($date[0]));
			if (isset($date[1])) {
				$finish = date('Y-m-d', strtotime($date[1]));
			}
		}
		
	    $data = $this->reports->getPresences($group, $start, $finish, $type, $this->session->userdata('employee_pt'));

	    $no = 1; // Untuk penomoran tabel, di awal set dengan 1
	    $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
	    
	    foreach($data->result() as $data){ // Lakukan looping pada variabel siswa
	      $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
	      $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->nip);
	      $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->name);
	      $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, date('d-m-Y', strtotime($data->date)));
	      if (!$data->checkin) {
		    $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->checkin);
	      } else {
	      	$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, date('H:i:s', strtotime($data->checkin)));
	      }
	      if (!$data->checkout) {
		    $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data->checkout);
	      } else {
	      	$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, date('H:i:s', strtotime($data->checkout)));
	      }
	      $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data->duration);
	      $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data->status);
	      $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data->group);
	      $excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $data->notes);
	      $excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $data->type);
	      $excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $data->condition);
	      $excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $data->notes_condition);
	      
	      // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
	      $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
	      $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
	      $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
	      $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
	      $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
	      $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
	      $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
	      $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
	      $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
	      $excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
	      $excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
	      $excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
	      $excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
	      
	      $dt = $data->date;
	      $dt1 = strtotime($dt);
	      $dt2 = date("l", $dt1);
	      $dt3 = strtolower($dt2);

	      $holiday = $this->db->select('day_off')->from('holiday')->get();
	      $holiday_param = array();

	      foreach ($holiday->result() as $holiday) {
	      	if ($data->date == $holiday->day_off) {
	      		array_push($holiday_param, $holiday->day_off);
	      	}
	      }

	      if (($dt3 == "saturday") || ($dt3 == "sunday") || in_array($data->date, $holiday_param)){
		      $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($red);
		      $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($red);
		      $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($red);
		      $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($red);
		      $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($red);
		      $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($red);
		      $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($red);
		      $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($red);
		      $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($red);
		      $excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($red);
		      $excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($red);
		      $excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($red);
		      $excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($red);
	  	  }

	      $no++; // Tambah 1 setiap kali looping
	      $numrow++; // Tambah 1 setiap kali looping
	    }

	    // Set width kolom
	    $excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	    $excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	    $excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	    $excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	    $excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	    $excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	    $excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
	    $excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
	    $excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
	    $excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
	    $excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
	    $excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
	    $excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
	    
	    // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
	    $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

	    // Set orientasi kertas jadi LANDSCAPE
	    $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

	    // Set judul file excel nya
	    $excel->getActiveSheet(0)->setTitle("Laporan Data Presensi Pegawai");
	    $excel->setActiveSheetIndex(0);

	    // Proses file excel
	    $file = "Data Presensi Pegawai.xlsx";
	    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	    header('Content-Disposition: attachment; filename='. $file); // Set nama file excel nya
	    header('Cache-Control: max-age=0');

	    $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
	    ob_end_clean();
	    $write->save('php://output');
	}
}

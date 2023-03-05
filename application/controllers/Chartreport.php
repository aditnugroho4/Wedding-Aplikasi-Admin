<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Chartreport extends CI_Controller {
private $data;
public function __construct()
	{
		parent::__construct();
			date_default_timezone_set('Asia/Jakarta');
			setlocale(LC_MONETARY, 'en_US');
			$this->load->library(array('Layout'));
			$this->load->helper(array('form', 'url','html'));
			$this->load->helper('cookie');
			$this->load->database();

			$session_data = $this->session->userdata('id');
			$this->data['user'] = $session_data['user'];
			$this->data['unit'] = $session_data['unit'];
			$this->data['subunit'] = $session_data['subunit'];
			$this->data['role'] = $session_data['role'];
	}
	public function index($link=null) {
		
			if($this->session->userdata('id'))
			   {
				 redirect('admin', 'refresh');
			   }
			   else 
			   {
					if($link==null) {
						 $link = 'display-menu-kiosk-html-kiosk';
						
					 }
				  $this->menu_utama($link);
			   }
			
		
	}
	
	public function menu_utama($content=null){
		
		$data=array(
				'title'=>'Chart Report',
				'header'=>'Chart Report Pelayanan RSUD Leuwiliang',
				'content'=>str_replace('-','/',$content),
				'mainChart'=> $this->mainChart()
			);
			$this->layout->dahsboard('display/menu/chart/html/chart_report',$data);
	}
	
	
public function chart_hourly_data($dateStart, $dateEnd)
		{
			$date = R::isoDateTime();
			$data = $this->input->post('data');
			$report = array();
							 $arr = R::getAll("SELECT perjanjian,stsbayar,tindaklanjut FROM p_pendaftaran WHERE tanggal BETWEEN (? AND ?) AND poli_id = ? AND cancelled IS NULL ORDER BY cekin DESC",array($dateStart,$dateEnd,$data));
							$i=0;
							foreach ($arr as $key=> $value) {
								if($value['perjanjian']=='N'){$report['REG'] = $i++;}
								if($value['perjanjian']=='Y'){$report['PER'] = $i++;}
								if($value['stsbayar']=='TUNAI'){$report['TUNAI'] = $i++;}
								if($value['stsbayar']=='BPJS'){$report['BPJS'] =$i++;}
								if($value['tindaklanjut']=='PULANG'){$report['PULANG'] =$i++;}
								if($value['tindaklanjut']=='RUJUK'){$report['RUJUK'] =$i++;}
								if($value['tindaklanjut']=='APS'){$report['APS']=$i++;}
								if($value['tindaklanjut']=='RAWAT'){$report['RAWAT'] =$i++;}
								if($value['tindaklanjut']=='DOA'){$report['DOA'] =$i++;}
								if($value['tindaklanjut']=='MENINGGAL'){$report['MATI'] =$i++;}
								if($value['tindaklanjut']== null){$report['PROSESS'] = $i++;}
							//$report['RM'] = R::count('m_rekammedis','poli_id = ? ',array($data));
							//$report['TRANSAKSI'] = R::count('p_trackingpasien','poli_id = ? ',array($data));
							//$report['BATAL'] = R::count('p_pendaftaran','date BETWEEN ? AND ? AND poli_id = ? AND cancelled="Y"',array($dateStart . ' 00:00:00', $dateEnd . ' 23:59:59',$data));
							}
			echo json_encode($report,JSON_NUMERIC_CHECK);
		}
	function mainChart(){
			$main =array();
			$date = R::isoDateTime();
			$lastD =substr($date,8,-9);
			$lastM =(substr($date,5,-12))." months";
			
			$main['Total'] = R::count('p_pendaftaran','tanggal > ? AND cancelled is null',array(substr($date, 0, 7)."-01"));
			$main['Rajal'] = R::count('p_pendaftaran','layanan= ? AND tanggal > ? AND cancelled is null',array('P',substr($date, 0, 7)."-01"));
			$main['Reguler'] = R::count('p_pendaftaran','layanan= ? AND tanggal = ? AND cancelled is null AND perjanjian IS NULL',array('P',substr($date, 0, 10)));
			$main['Online'] = R::count('p_pendaftaran','layanan= ? AND tanggal = ? AND cancelled is null AND perjanjian IS NULL',array('P',substr($date, 0, 10)));
			$main['Batal'] = R::count('p_pendaftaran','layanan= ? AND tanggal = ? AND cancelled="Y"',array('P',substr($date, 0, 10)));

			return $main;
	}	
/* function Get All Loket */	
public function get_reservasi_kunjungan($start,$end,$poli=null)
	{
		try
			{
			$MySql = 'SELECT p_pendaftaran.*,p_pendaftaran.id as daftar,m_poli.id, m_poli.nama AS poli,m_datapasien.rmlama,m_datapasien.nama as pasien,m_datapasien.alias,m_dokter.id as dokter,m_dokter.nama_dokter,m_unitinstalasi.name FROM 
						p_pendaftaran,
						m_poli,
						m_datapasien,
						m_dokter,m_unitinstalasi';
			$filter = ' m_datapasien.id=p_pendaftaran.pasien_id AND m_poli.id=p_pendaftaran.poli_id AND m_unitinstalasi.id=m_poli.instalasi_id AND m_dokter.id =p_pendaftaran.dokter_id ';		
			$aColumns = explode(',', $this->input->get('columns'));
				$sWhere = "1";
				if ($this->input->get('aSearch') !== false && $this->input->get('aSearch') != "" )
				{
					$sWhere = "(";
					for ( $i=0 ; $i<count($aColumns) ; $i++ )
					{
						if ($aColumns[$i] != "") {
							$sWhere .= "m_datapasien.".$aColumns[$i]." LIKE '%".R::$adapter->escape( $this->input->get('aSearch') )."%' OR ";
						}
					}
					$sWhere = substr_replace( $sWhere, "", -3 );
					$sWhere .= ")";
				
				}	
			if ($aColumns != "") {
			$filter .= " AND ".$sWhere."";
			}	
			if ($poli != 'ALL') {
			$filter .= " AND p_pendaftaran.poli_id='".$poli."'";
			}
			$MySql .= " WHERE ".$filter." AND p_pendaftaran.tanggal BETWEEN '".$start." 00:00:00' AND '".$end." 23:59:59' AND p_pendaftaran.cancelled is NULL AND p_pendaftaran.perjanjian in('Y','L')";
			$data=array();
			//echo ($MySql);
			if(!empty($MySql))
			{
				$query=$MySql;
				$q=mysql_query($query);
						while($arr=mysql_fetch_array($q))
						{
						array_push( $data,$arr);
					}
			}
		}catch (Exception $e)
				{
				 $data['error']=$e->getMessage();
				}	
		echo json_encode($data);
	}
	
	public function get_chart_table_loket($dateStart, $dateEnd,$id)
	{
		$date = R::isoDateTime();
		$data="";
		$fpoli = "";
		try{
			if($id==1){
				if($this->input->post('data') !="ALL"){
					
					$data=" AND instalasi_id=".$this->input->post('data');
				}				
				$select = $this->input->post('select');
				if ($select != "ALL") {
					$poli = R::load('m_poli', $select);
					$fpoli = " AND id=".$poli->id;  
				}
			}
			if($id==2){
					
					if($this->input->get('data') !='ALL'){
					$data=' AND instalasi_id='.$this->input->get('data');
					}
					$select = $this->input->get('select');
					if ($select != "ALL") {
					$poli = R::load('m_poli', $select);
					$fpoli = "AND id=".$poli->id;  
					}
				}
						$report ='<table id="tblPrint" class="table table-striped table-bordered table-hover ">';
						$report .='<thead><tr><th rowspan="2">NO</th><th rowspan="2" class="center"><i class="ace-icon fa fa-stethoscope"></i> LAYANAN</th><th colspan="2" class="center"><i class="ace-icon fa fa-line-chart"></i> KUNJUNGAN PASIEN</th><th colspan="3" class="center"><i class="ace-icon fa fa-credit-card"></i> CARA BAYAR</th><th colspan="3" class="center"><i class="ace-icon fa fa-bar-chart"></i>JUMLAH</th></tr>';
						$report .='<tr><th>BARU</th><th>LAMA</th><th>TUNAI</th><th>BPJS</th><th>GRATIS</th><th>KUNJUNGAN</th><th>BATAL</th><th>TOTAL</th></tr></thead>';
							$arr = R::getAll("SELECT * FROM m_poli WHERE status='Y' ".$fpoli." ".$data."");
							$i=1;
							$report.='<tbody>';
							foreach ($arr as $key=> $value) {
									$total = R::count('p_pendaftaran','tanggal BETWEEN ? AND ? AND poli_id = ?',array($dateStart . ' 00:00:00', $dateEnd . ' 23:59:59',$value['id']));
									$new = R::count('p_pendaftaran','tanggal BETWEEN ? AND ? AND poli_id = ? AND cancelled IS NULL AND stspasien="Baru"',array($dateStart . ' 00:00:00', $dateEnd . ' 23:59:59',$value['id']));
									$old = R::count('p_pendaftaran','tanggal BETWEEN ? AND ? AND poli_id = ?  AND cancelled IS NULL AND stspasien="Lama"',array($dateStart . ' 00:00:00', $dateEnd . ' 23:59:59',$value['id']));
									$tunai = R::count('p_pendaftaran','tanggal BETWEEN ? AND ? AND poli_id = ? AND cancelled IS NULL AND stsbayar="TUNAI"',array($dateStart . ' 00:00:00', $dateEnd . ' 23:59:59',$value['id']));
									$bpjs = R::count('p_pendaftaran','tanggal BETWEEN ? AND ? AND poli_id = ?  AND cancelled IS NULL AND stsbayar="BPJS"',array($dateStart . ' 00:00:00', $dateEnd . ' 23:59:59',$value['id']));
									$batal = R::count('p_pendaftaran','tanggal BETWEEN ? AND ? AND poli_id = ? AND cancelled="Y"',array($dateStart . ' 00:00:00', $dateEnd . ' 23:59:59',$value['id']));
									$report .='<tr><td>'.$i++.'</td><td>'.$value['nama'].'</td><td>'.$new.'</td><td>'.$old.'</td><td>'.$tunai.'</td><td>'.$bpjs.'</td><td></td><td>'.$total.'</td><td>'.$batal.'</td><td>'.($tunai+$bpjs - $batal).'</td></tr>';
								}
							$report .='</tbody>';
							$report .='</table>';
			if($id==1){				
				echo json_encode(base64_encode($report));
			}else if($id==2){
				$this->load->view('pelayanan/print/header_laporan',array('data'=>base64_encode($report),'subject'=>'Rawat Jalan','date'=>$dateStart.' s/d '.$dateEnd));
			}
			}catch (Exception $e)
				{
				 echo $e->getMessage();
				}	
	}
	
	public function load_data_rekammedis($dateStart, $dateEnd,$id)
	{
		$date = R::isoDateTime();
		$filter = 'pd.tanggal BETWEEN ? AND ? ';
		$param = array($dateStart, $dateEnd);
		$poliId = $this->input->post('poli');
		if ($poliId != "0") {
			$poli = R::load('m_poli', $poliId);
			$filter .= 'AND pd.poli_id = ? ';
			$param[] = $poliId;
		}
			$report ='<table id="tblPrint" class="table table-striped table-bordered table-hover ">';
						$report .='<thead><tr><th rowspan="2">NO</th><th colspan="5" class="center"><i class="ace-icon fa fa-stethoscope"></i> IDENTITAS PASIEN</th><th colspan="9" class="center"><i class="ace-icon fa fa-line-chart"></i> KUNJUNGAN PASIEN DAN REKAMMEDIS</th><th colspan="2" class="center"><i class="ace-icon fa fa-credit-card"></i> PEMBAYARAN</th></tr>';
						$report .='<tr><th>NO.RM</th><th>NAMA</th><th>UMUR</th><th>L/P</th><th>ALAMAT</th><th>TGL DAFTAR</th><th>TGL KUNJUNGAN</th><th>ASAL PASIEN</th><th>LAYANAN</th><th>DPJP</th><th>DIAGNOSA</th><th>KODE ICD</th><th>TINDAKLANJUT</th><th>KETERANGAN</th><th>CARA BAYAR</th><th>NO</th></tr></thead>';
							 $arr = R::getAll("SELECT dt.rmlama,dt.nik,dt.nobpjs,dt.nama,dt.alias,dt.jns_klmn,dt.tmpt_lahir,dt.tgl_lahir,dt.alamat,pd.poli_id,pd.stsbayar,pd.stspasien,pd.tanggal,pd.status,pd.date,pd.catatan,pd.tindaklanjut,pd.icdawal,pd.nmapenyakit,
							  pd.id as daftar,pd.umur,pl.nama as poli,dr.nama_dokter FROM
							  m_poli pl INNER JOIN 
							  m_dokter dr INNER JOIN
							  m_datapasien dt 
							  INNER JOIN p_pendaftaran pd on dt.id=pd.pasien_id AND dr.id=pd.dokter_id and pl.id=pd.poli_id WHERE ".$filter."",$param);
							$i=1;
							$report.='<tbody>';
							foreach ($arr as $key=> $value) {
									
									$report .='<tr><td>'.$i++.'</td><td>'.$value['rmlama'].'</td><td>'.$value['nama'].','.$value['alias'].'</td><td>'.explode("-",$value['umur'])[0].' Thn'.'</td><td>'.$value['jns_klmn'].'</td><td>'.$value['alamat'].'</td><td>'.$value['date'].'</td><td>'.$value['tanggal'].'</td><td>'.$value['catatan'].'</td><td>'.$value['poli'].'</td><td>'.$value['nama_dokter'].'</td><td>'.$value['icdawal'].'</td><td>'.$value['nmapenyakit'].'</td><td>'.$value['tindaklanjut'].'</td><td></td><td>'.$value['stsbayar'].'</td><td>'.$value['nobpjs'].'</td></tr>';
								}
							$report .='</tbody>';
							$report .='</table>';
			if($id==1){				
			echo json_encode(base64_encode($report));
			}else if($id==2){
				$this->load->view('pelayanan/print/header_laporan',array('data'=>base64_encode($report),'subject'=>'Rawat Jalan','date'=>$dateStart.' s/d '.$dateEnd));
			}
	}
	// Laporan Kunjungan \\		
public function load_data_pendaftaran($dateStart,$dateEnd,$id=null)
	{
		$date = R::isoDateTime();
		$this->load->helper(array('csv', 'download'));
		$pulang = null;
		$filter = 'pd.tanggal BETWEEN ?  AND ? ';
		$param = array($dateStart. ' 00:00:00', $dateEnd. ' 23:59:59');
		$poliId = $this->input->get('poli');
		$report = array();
			if ($poliId != "ALL") {
							$filter .= 'AND pd.poli_id = ? ';
							$param[] = $poliId;
						}
			$html = "";			
			if($id==1){	
						$html ='<table id="tblPrint" class="table table-striped table-bordered table-hover ">';
						$html .='<thead><tr><th rowspan="2">NO</th><th rowspan="2" class="center"><i class="ace-icon fa fa-stethoscope"></i> LAYANAN</th><th colspan="3" class="center"><i class="ace-icon fa fa-line-chart"></i> KUNJUNGAN PASIEN</th><th colspan="2" class="center"><i class="ace-icon fa fa-credit-card"></i> PENDAFTARAN</th><th colspan="2" rowspan="2" class="center"><i class="ace-icon fa fa-bar-chart"></i>KETERANGAN</th></tr>';
						$html .='<tr><th>TANGGAL</th><th>NO.RM</th><th>NAMA</th><th>CARA BAYAR</th><th>CARA DAFTAR</th></tr></thead>';
							
						$html.='<tbody style="font-size:10px;">';	  
						}
					if($id==2){
							$report[] = array('Laporan Kunjungan Pasien RSUD Leuwiliang');
							$report[] = array('');
							$report[] = array('Tanggal', $dateStart . '-' . $dateEnd);
							$report[] = array('');
							$report[] = array('Cara Daftar Online / Perjanjian');
							//if ($pulangId != "ALL") {
							//	$report[] = array('Loket :', $pulang->code . ' - ' . $pulang->name);
							//}
							//if ($poliId != "ALL") {
							//	$report[] = array('Poli :', $poli->nama);
							//}
							$report[] = array('');
							$report[] = array('NO','NOMR', 'NAMA PASIEN','CARA BAYAR','TANGGAL KUNJUNGAN','POLI','DOKTER','KETERANGAN','USER','LOKET');
							}				
							$arr = R::getAll("SELECT dt.rmlama,dt.nik,dt.nobpjs,dt.nama,dt.alias,dt.jns_klmn,dt.tmpt_lahir,dt.tgl_lahir,dt.alamat,pd.poli_id,pd.stsbayar,pd.stspasien,pd.tanggal,pd.status,pd.date,pd.perjanjian,
							  pd.id as daftar,pl.nama as poli,dr.nama_dokter,pd.dokter_id,pd.user_id,pd.jenis,pd.loket_id FROM
							  m_poli pl INNER JOIN 
							  m_dokter dr INNER JOIN
							  m_datapasien dt 
							  INNER JOIN p_pendaftaran pd on dt.id=pd.pasien_id AND dr.id=pd.dokter_id and pl.id=pd.poli_id WHERE pd.perjanjian is not null AND ".$filter."",$param);
							$i=1;
							foreach ($arr as $key=> $value) {
									$dokter = R::load('m_dokter',$value['dokter_id']);
									$user = R::load('m_user',$value['user_id'])->nama;
									$ket = '';
									$sts = '';
									if ($value['perjanjian'] != null){
										$ket ='PERJANJIAN';
									}
									if ($value['perjanjian'] == 'L'){
										$sts ='BELUM DATANG';
									}else if($value['perjanjian'] == 'Y'){
										$sts  ='DATANG';
									}
									if($id==1){
									$html .='<tr><td>'.$i++.'</td><td>'.$value['poli'].'</td><td>'.$value['tanggal'].'</td><td>'.$value['rmlama'].'</td><td>'.$value['nama'].'</td><td>'.$value['stsbayar'].'</td><td>'.$ket.'</td><td>'.$sts.'</td></tr>';
									}else if($id==2){
											$report[] = array($i++,"'".$value['rmlama']."'", $value['nama'].",".$value['alias'], $value['stsbayar'].' '.$value['jenis'], $value['tanggal'],R::load('m_poli',$value['poli_id'])->nama,$dokter->nama_dokter ,$sts,$user, R::load('m_loket',$value['loket_id'])->name);
										}
								}		
			if($id==1){	
				$html .='</tbody>';
				$html .='</table>';		
				$this->load->view('pelayanan/print/header_laporan',array('data'=>base64_encode($html),'subject'=>'Pendaftaran Rawat Jalan','date'=>$dateStart.' s/d '.$dateEnd));
			}else if($id==2){
				$for = $this->input->get('for');
				$csv = csvFromArray($report,$for);
				force_download('LAPORAN KUNJUNGAN ' . $dateStart . '_' . $dateEnd . '.csv', $csv);	
			}
	}
	
public function load_report_loket($dateStart,$dateEnd,$poliId,$pulangId,$id) 
		{
		$this->load->helper(array('csv', 'download'));
		$pulang = null;
		$poli = null;
		
		$filter = 'tanggal BETWEEN ? AND ? ';
		$param = array($dateStart. ' 00:00:00', $dateEnd. ' 23:59:59');
		if ($pulangId != "ALL") {
			$pulang = R::load('m_loket', $pulangId);
			$filter .= ' AND loket_id = ? ';
			$param[] = $pulangId;
		}
		if ($poliId != "ALL") {
			$poli = R::load('m_poli', $poliId);
			$filter .= 'AND poli_id = ? ';
			$param[] = $poliId;
		}
		$filter .='AND cancelled IS NULL';
		$arrData = R::find('p_pendaftaran',$filter, $param);
		$report = array();
		$html = "";
		if($id==1){
			$html ='<table id="tblPrint" class="table table-striped table-bordered table-hover ">';
						$html .='<thead><tr><th rowspan="2">NO</th><th colspan="4" class="text-center"><i class="ace-icon fa fa-stethoscope"></i> IDENTITAS PASIEN</th><th colspan="10" class="text-center"><i class="ace-icon fa fa-line-chart"></i> PENDAFTARAN</th></tr>';
						$html .='<tr><th>NO.RM</th><th>NAMA</th><th>L/P</th><th>UMUR</th><th>TGL DAFTAR</th><th>TGL KUNJUNGAN</th><th>CARA BAYAR</th><th>STATUS</th><th>LAYANAN</th><th>DPJP</th><th>DIAGNOSA</th><th>KETERANGAN</th><th>USER</th><th>LOKET</th></tr></thead>';
			$html.='<tbody style="font-size:9;">';				
			}
		if($id==2){
				$report[] = array('Laporan Kunjungan Pasien RSUD Leuwiliang');
				$report[] = array('');
				$report[] = array('Tanggal', $dateStart . '-' . $dateEnd);
				$report[] = array('');
				if ($pulangId != "ALL") {
					$report[] = array('Loket :', $pulang->code . ' - ' . $pulang->name);
				}
				if ($poliId != "ALL") {
					$report[] = array('Poli :', $poli->nama);
				}
				$report[] = array('');
				$report[] = array('NO','NOMR', 'NAMA PASIEN', 'KELAMIN','ALAMAT','CARA BAYAR', 'L/B','TANGGAL DAFTAR','TANGGAL KUNJUNGAN','POLI','DOKTER','JENIS KUNJUNGAN','CATATAN','USER','LOKET');
			}
		
		$i = 1;		
		foreach ($arrData as $key => $value) {
			$pasien = R::load('m_datapasien',$value->pasien_id);
			$dokter = R::load('m_dokter',$value->dokter_id);
			$user = R::load('m_user',$value->user_id)->nama;
			$daftar ="";
				if($id==1){
					if($value->perjanjian == null){$daftar='REGULER';}else if($value->perjanjian =='Y'){$daftar='PERJANJIAN';}
					$html .='<tr><td>'.$i++.'</td><td>'.$pasien->rmlama.'</td><td>'.$pasien->nama.",".$pasien->alias.'</td><td>'.$pasien->jns_klmn.'</td><td>'.explode("-",$value['umur'])[0].' Thn'.'</td><td>'.$value->date.'</td><td>'.$value->tanggal.'</td><td>'.$value->stsbayar.'</td><td>'.$value->stspasien.'</td><td>'.R::load('m_poli',$value->poli_id)->nama.'</td><td>'.$dokter->nama_dokter.'</td><td>'.$value->catatan.'</td><td>'.$daftar.'</td><td>'.$user.'</td><td>'.R::load('m_loket',$value->loket_id)->name.'</td></tr>';
				}else if($id==2){
					if($value->perjanjian == null){$daftar='REGULER';}else if($value->perjanjian =='Y'){$daftar='PERJANJIAN';}
					$report[] = array($i++,"'".$pasien->rmlama."'", $pasien->nama.",".$pasien->alias, $pasien->jns_klmn,'-', $value->stsbayar.' '.$value->jenis, $value->stspasien,$value->date,$value->tanggal,R::load('m_poli',$value->poli_id)->nama,$dokter->nama_dokter,$daftar ,$value->catatan,$user, R::load('m_loket',$value->loket_id)->name);
				}
			}
			if($id==1){
				$html .='</tbody>';
				$html .='</table>';
				echo json_encode(base64_encode($html));
			}else if($id==2){
				$for = $this->input->get('for');
				$csv = csvFromArray($report,$for);
				force_download('LAPORAN KUNJUNGAN ' . $dateStart . '_' . $dateEnd . '.csv', $csv);	
			}
	}
	

public function load_report_pendaftaran($dateStart, $dateEnd,$poliId,$pulangId) 
		{
		$this->load->helper(array('csv', 'download'));
		$pulang = null;
		$poli = null;
		
		$filter = 'tanggal BETWEEN ? AND ? ';
		$param = array($dateStart, $dateEnd);
		if ($pulangId != "0") {
			$pulang = R::load('m_loket', $pulangId);
			$filter .= ' AND loket_id = ? ';
			$param[] = $pulangId;
		}
		if ($poliId != "0") {
			$poli = R::load('m_poli', $poliId);
			$filter .= 'AND poli_id = ? ';
			$param[] = $poliId;
		}
		$filter .='AND cancelled IS NULL';
		$arrData = R::find('p_pendaftaran',$filter, $param);
		
		$report = array();
		$report[] = array('Laporan Kunjungan Pasien RSUD Leuwiliang');
		$report[] = array('');
		$report[] = array('Tanggal', $dateStart . '-' . $dateEnd);
		$report[] = array('');
		if ($pulangId != "0") {
			$report[] = array('Loket :', $pulang->code . ' - ' . $pulang->name);
		}
		if ($poliId != "0") {
			$report[] = array('Poli :', $poli->nama);
		}//else{
		//	foreach ($rawData as $key => $value) {
		//		$arrData[$value['poli_id']][] = $value;
		//	}
		//}
		$report[] = array('');
		$report[] = array('NO','NOMR', 'NAMA PASIEN', 'KELAMIN','ALAMAT','CARA BAYAR', 'L/B','TANGGAL DAFTAR','TANGGAL KUNJUNGAN','POLI','DOKTER','JENIS KUNJUNGAN','CATATAN','USER');
		$i = 1;		
		foreach ($arrData as $key => $value) {
			$pasien = R::load('m_datapasien',$value->pasien_id);
			$dokter = R::load('m_dokter',$value->dokter_id);
			$poli = R::load('m_poli',$value->poli_id);
			if($value->perjanjian == null){
				$report[] = array($i++,"'".$pasien->rmlama."'", $pasien->nama.",".$pasien->alias, $pasien->jns_klmn,'-', $value->stsbayar.' '.$value->jenis, $value->stspasien,$value->date,$value->tanggal,$poli->nama,$dokter->nama_dokter,'REGULER',$value->catatan,R::load('m_user',$value->user_id)->nama );
			}else if($value->perjanjian =='Y'){
				$report[] = array($i++,"'".$pasien->rmlama."'", $pasien->nama.",".$pasien->alias, $pasien->jns_klmn,'-', $value->stsbayar.' '.$value->jenis, $value->stspasien,$value->date,substr($value->tanggal, 0, 10),$poli->nama,$dokter->nama_dokter,'PERJANJIAN',$value->catatan,R::load('m_user',$value->user_id)->nama );
			}
		}
		$for = $this->input->get('for');
		$csv = csvFromArray($report,$for);
		echo json_encode($csv);
		//force_download('LAPORAN KUNJUNGAN ' . $dateStart . '_' . $dateEnd . '.csv', $csv);
	}
	
	
	
	public function report_rekammedis($dateStart,$dateEnd,$id) 
		{
			
		$this->load->helper(array('csv', 'download'));
		$dokterId='';
		$poli='';
		$dokter='';
		$poliId = '';
		
		if($id==1){
			$dokterId = $this->input->post('dokter');
			$poliId = $this->input->post('poli');
		}
		if($id==2){
			$dokterId = $this->input->get('dokter');
			$poliId = $this->input->get('poli');
			
		}
	
		$filter = 'pd.tanggal BETWEEN ? AND ? ';
		$param = array($dateStart. ' 00:00:00', $dateEnd. ' 23:59:59');
		
		if ($dokterId != "ALL") {
			$dokter = R::load('m_dokter', $dokterId);
			$filter .= 'AND pd.dokter_id = ? ';
			$param[] = $dokterId;
		}
		if ($poliId != "ALL") {
			$poli = R::load('m_poli', $poliId);
			$filter .= 'AND pd.poli_id = ? ';
			$param[] = $poliId;
		}
		$filter .='AND pd.cancelled IS NULL';
		$arrData = R::getAll("SELECT dt.rmlama,dt.nik,dt.nobpjs,dt.nama,dt.alias,dt.jns_klmn,dt.tmpt_lahir,dt.tgl_lahir,dt.alamat,pd.umur,pd.poli_id,pd.stsbayar,pd.stspasien,pd.asalpasien,pd.tanggal,pd.kamar_id,pd.status,pd.date,pd.catatan,pd.userafter_id,pd.tindaklanjut,pd.icdawal,pd.nmapenyakit,
							  pd.id as daftar,pd.dokter_id,pl.nama as poli,dr.nama_dokter FROM
							  m_poli pl INNER JOIN 
							  m_dokter dr INNER JOIN
							  m_datapasien dt 
							  INNER JOIN p_pendaftaran pd on dt.id=pd.pasien_id AND dr.id=pd.dokter_id and pl.id=pd.poli_id WHERE ".$filter."",$param);
		$report = array();
		$html='';
		if($id==1){
		$html = '<thead><tr><th rowspan="2">NO</th><th colspan="5" class="text-center"><i class="fa fa-address-card"></i> IDENTITAS PASIEN</th><th colspan="3" class="text-center"><i class="fa fa-pencil-square-o"></i> PENDAFTARAN</th><th colspan="3" class="text-center"><i class="fa fa-user-md"></i> REKAMMEDIS</th><th colspan="1" class="text-center"><i class="fa fa-user"></i> PETUGAS</th></tr>
									<tr><th>NO.RM</th><th>NAMA</th><th>L/P</th><th>UMUR</th><th>ALAMAT</th><th>TGL KUNJUNGAN</th><th>CARA BAYAR</th><th>KETERANGAN</th><th>LAYANAN</th><th>DPJP</th><th >DIAGNOSA</th><th>PETUGAS</th></tr></thead><tbody style="font-size:9;">';
		}
		if($id==2){
				$poli = R::load('m_poli', $poliId);
				$report[] = array('Laporan Kunjungan Pasien RSUD Leuwiliang');
				$report[] = array('');
				$report[] = array('Tanggal', $dateStart . ' s/d ' . $dateEnd);
				$report[] = array('');
				if ($dokterId != "ALL") {
					$report[] = array('DPJP :', $dokter->code . ' - ' . $dokter->nama_dokter);
				}
				if ($poliId != "ALL") {
					$report[] = array('LAYANAN :', $poli->nama);
				}
				$report[] = array('');
				$report[] = array('NO','NOMR', 'NAMA PASIEN', 'L/P', 'UMUR','ALAMAT','CARA BAYAR','TANGGAL KUNJUNGAN','KETERANGAN','LAYANAN','DPJP','DIAGNOSA','PETUGAS');
			}
		
		$i = 1;		
		foreach ($arrData as $key => $value) {
				$kamar='';
				$user = R::load('m_user',$value['userafter_id'])->nama;
				$keter ="";
				 if($value['status']=="N"){$keter="PULANG";}else{$keter="BELUM PULANG";}
				if($value['kamar_id']){
					$kamar = R::load('m_ruangan',$value['kamar_id'])->nama;
				}
				
				if($id==1){
					$html .='<tr><td>'.$i++.'</td><td>'.$value['rmlama'].'</td><td>'.$value['nama'].','.$value['alias'].'</td><td>'.$value['jns_klmn'].'</td><td>'.explode("-",$value['umur'])[0].' Thn</td><td>'.$value['alamat'].'</td><td>'.$value['tanggal'].'</td><td>'.$value['stsbayar'].'</td><td>'.$keter.'</td><td>'.$value['poli'].' '.$kamar.'</td><td>'.$value['nama_dokter'].'</td><td>('.$value['icdawal'].') '.$value['nmapenyakit'].'</td><td>'.$user.'</td></tr>';
				}
				if($id==2){
					$report[] = array($i++,"'".$value['rmlama']."'", $value['nama'].",".$value['alias'], $value['jns_klmn'],explode("-",$value['umur'])[0].' Thn', $value['alamat'],$value['stsbayar'], $value['tanggal'],$keter,$value['poli'].' '.$kamar,$value['nama_dokter'],"(".$value['icdawal'].") ".$value['nmapenyakit'],$user);
				}
			}
			if($id==1){
				$html .='</tbody>';
				echo json_encode(base64_encode($html));
			}else if($id==2){
				$for = $this->input->get('for');
				$csv = csvFromArray($report,$for);
				force_download('LAPORAN KUNJUNGAN ' . $dateStart . '_' . $dateEnd . '.csv', $csv);	
			}
	}
	public function report_all_data_pasien($dateStart,$dateEnd,$id) 
		{
			
		$this->load->helper(array('csv', 'download'));
		$dokterId='';
		$poli='';
		$dokter='';
		$poliId = $this->input->post('poli');
		
		if($id==1){
			$dokterId = $this->input->post('dokter');
			$poliId = $this->input->post('poli');
		}
		if($id==2){
			$dokterId = $this->input->get('dokter');
			$poliId = $this->input->get('poli');
		
		}
	
		$filter = 'pd.tanggal BETWEEN ? AND ? ';
		$param = array($dateStart. ' 00:00:00', $dateEnd. ' 23:59:59');
		
		if ($dokterId != "ALL") {
			$dokter = R::load('m_dokter', $dokterId);
			$filter .= 'AND pd.dokter_id = ? ';
			$param[] = $dokterId;
		}
		if ($poliId != "ALL") {
			$poli = R::load('m_poli', $poliId);
			$filter .= 'AND pd.poli_id = ? ';
			$param[] = $poliId;
		}
		$filter .='AND pd.cancelled IS NULL';
		$arrData = R::getAll("SELECT dt.rmlama,dt.nik,dt.nobpjs,dt.nama,dt.alias,dt.jns_klmn,dt.tmpt_lahir,dt.tgl_lahir,dt.alamat,pd.umur,pd.poli_id,pd.stsbayar,pd.stspasien,pd.asalpasien,pd.tanggal,pd.kamar_id,pd.status,pd.date,pd.catatan,pd.userafter_id,pd.tindaklanjut,pd.icdawal,pd.nmapenyakit,
							  pd.id as daftar,pd.dokter_id,pl.nama as poli,dr.nama_dokter FROM
							  m_poli pl INNER JOIN 
							  m_dokter dr INNER JOIN
							  m_datapasien dt 
							  INNER JOIN p_pendaftaran pd on dt.id=pd.pasien_id AND dr.id=pd.dokter_id and pl.id=pd.poli_id WHERE ".$filter."",$param);
		$report = array();
		$html='';
		if($id==1){
		$html = '<thead><tr><th rowspan="2">NO</th><th colspan="5" class="text-center"><i class="fa fa-address-card"></i> IDENTITAS PASIEN</th><th colspan="3" class="text-center"><i class="fa fa-pencil-square-o"></i> PENDAFTARAN</th><th colspan="3" class="text-center"><i class="fa fa-user-md"></i> REKAMMEDIS</th><th colspan="1" class="text-center"><i class="fa fa-user"></i> PETUGAS</th></tr>
									<tr><th>NO.RM</th><th>NAMA</th><th>L/P</th><th>UMUR</th><th>ALAMAT</th><th>TGL KUNJUNGAN</th><th>CARA BAYAR</th><th>KETERANGAN</th><th>LAYANAN</th><th>DPJP</th><th >DIAGNOSA</th><th>PETUGAS</th></tr></thead><tbody style="font-size:9;">';
		}
		if($id==2){
				$poli = R::load('m_poli', $poliId);
				$report[] = array('Laporan Kunjungan Pasien RSUD Leuwiliang');
				$report[] = array('');
				$report[] = array('Tanggal', $dateStart . ' s/d ' . $dateEnd);
				$report[] = array('');
				if ($dokterId != "ALL") {
					$report[] = array('DPJP :', $dokter>code . ' - ' . $dokter->nama_dokter);
				}
				if ($poliId != "ALL") {
					$report[] = array('LAYANAN :', $poli->nama);
				}
				$report[] = array('');
				$report[] = array('NO','NOMR', 'NAMA PASIEN', 'L/P', 'UMUR','ALAMAT','CARA BAYAR','TANGGAL KUNJUNGAN','KETERANGAN','LAYANAN','DPJP','DIAGNOSA','PETUGAS');
			}
		
		$i = 1;		
		foreach ($arrData as $key => $value) {
				$kamar='';
				$user = R::load('m_user',$value['userafter_id'])->nama;
				$keter ="";
				 if($value['status']=="N"){$keter="PULANG";}else{$keter="BELUM PULANG";}
				if($value['kamar_id']){
					$kamar = R::load('m_ruangan',$value['kamar_id'])->nama;
				}
				
				if($id==1){
					$html .='<tr><td>'.$i++.'</td><td>'.$value['rmlama'].'</td><td>'.$value['nama'].','.$value['alias'].'</td><td>'.$value['jns_klmn'].'</td><td>'.explode("-",$value['umur'])[0].' Thn</td><td>'.$value['alamat'].'</td><td>'.$value['tanggal'].'</td><td>'.$value['stsbayar'].'</td><td>'.$keter.'</td><td>'.$value['poli'].' '.$kamar.'</td><td>'.$value['nama_dokter'].'</td><td>('.$value['icdawal'].') '.$value['nmapenyakit'].'</td><td>'.$user.'</td></tr>';
				}
				if($id==2){
					$report[] = array($i++,"'".$value['rmlama']."'", $value['nama'].",".$value['alias'], $value['jns_klmn'],explode("-",$value['umur'])[0].' Thn', $value['alamat'],$value['stsbayar'], $value['tanggal'],$keter,$value['poli'].' '.$kamar,$value['nama_dokter'],"(".$value['icdawal'].") ".$value['nmapenyakit'],$user);
				}
			}
			if($id==1){
				$html .='</tbody>';
				echo json_encode(base64_encode($html));
			}else if($id==2){
				$for = $this->input->get('for');
				$csv = csvFromArray($report,$for);
				force_download('LAPORAN KUNJUNGAN ' . $dateStart . '_' . $dateEnd . '.csv', $csv);	
			}
	}
	public function get_json_rec_pasien($id,$get) 
		{
			try{
				
				$html='';
				if($get == 1){
					$html=' <table class="table table-striped table-bordered" cellpadding="0" width="100%" style="font-size:small"id="tbl-view" >
																				<thead><tr><th rowspan="2">NO</th><th colspan="2" class="text-center"><i class="fa fa-address-card"></i> REKAMMEDIS</th><th colspan="2" class="text-center"><i class="fa fa-user-md"></i>PETUGAS MEDIS</th><th colspan="3" class="text-center"><i class="fa fa-user"></i> LAYANAN</th></tr>
																				<th>DIAGNOSA</th><th>NAMA PENYAKIT</th><th>DPJP</th><th>PETUGAS/PERAWAT</th><th>TANGGAL</th><th>UNIT/INSTALASI</th><th>ACTION</th></tr></thead><tbody style="font-size:9;">';
					$arrData = R::getAll("SELECT pl.nama as namapoli,us.nama as petugas,dr.nama_dokter,rm.* FROM m_rekammedis rm INNER JOIN  m_poli pl INNER JOIN m_dokter dr INNER JOIN m_user us INNER JOIN m_datapasien dt ON us.id=rm.user_id AND dt.id=rm.pasien_id AND dr.id=rm.dokter_id AND pl.id=rm.poli_id WHERE rm.daftar_id=?",array($id));
					$i = 1;		
					foreach ($arrData as $key => $value) {
							$html .='<tr><td>'.$i++.'</td><td>'.$value['diagnosa'].'</td><td>'.$value['nmapenyakit'].'</td><td>'.$value['nama_dokter'].'</td><td>'.$value['petugas'].'</td><td>'.$value['tglperiksa'].'</td><td>'.$value['namapoli'].'</td><td><button class="btn btn-primary btn-xs" onclick="$.get_data_rekammedis('.$value['id'].')"><i class="fa fa-print"></i>&nbsp;E-MR</button></td></tr>';
					}
				$html .='</tbody></table>';
				}
				if($get == 2)
				{
						$html=' <table class="table table-striped table-bordered" cellpadding="0" width="100%" style="font-size:small"id="tbl-view" >
																				<thead><tr><th rowspan="2">NO</th><th colspan="2" class="text-center"><i class="fa fa-address-card"></i> REKAMMEDIS</th><th colspan="2" class="text-center"><i class="fa fa-user-md"></i>PETUGAS MEDIS</th><th colspan="3" class="text-center"><i class="fa fa-user"></i> LAYANAN</th></tr>
																				<th>NO RADIOLOGI</th><th>NAMA TINDAKAN</th><th>DOKTER</th><th>PETUGAS</th><th>TANGGAL</th><th>HASIL FOTO</th><th>ACTION</th></tr></thead><tbody style="font-size:9;">';
					$arrData = R::getAll("SELECT us.nama as petugas,dr.nama_dokter,rm.* FROM m_radiologi rm INNER JOIN m_dokter dr INNER JOIN m_user us INNER JOIN m_datapasien dt ON us.id=rm.user_id AND dt.id=rm.pasien_id AND dr.id=rm.dokter_id WHERE rm.daftar_id=?",array($id));
					$i = 1;		
					foreach ($arrData as $key => $value) {
							$html .='<tr><td >'.$i++.'</td><td>'.$value['noperiksa'].'</td><td>'.$value['klinis'].'</td><td>'.$value['nama_dokter'].'</td><td>'.$value['petugas'].'</td><td>'.$value['tanggal'].'</td><td class="text-center"><button class="btn btn-info btn-xs" onclick=""><i class="fa fa-print"></i>&nbsp;View</button></td><td><button class="btn btn-primary btn-xs" onclick="$.get_data_radiologi('.$value['id'].')"><i class="fa fa-print"></i>&nbsp;E-RAD</button></td></tr>';
					}
				$html .='</tbody></table>';
				}
				echo json_encode(base64_encode($html));
			}catch (Exception $e)
				{
				 $data('error');
				}	
		}
	public function report_hasil_penunjang($dateStart,$dateEnd,$id) 
		{
		$this->load->helper(array('csv', 'download'));
		$dokterId='';
		$dokter='';
	
		if($id==1){
			$dokterId = $this->input->post('dokter');
		}
		
		if($id==2){
			$dokterId = $this->input->get('dokter');
		
		}
	
		$filter = 'rm.tanggal BETWEEN ? AND ? ';
		$param = array($dateStart. ' 00:00:00', $dateEnd. ' 23:59:59');
		
		if ($dokterId != "ALL") {
			$dokter = R::load('m_dokter', $dokterId);
			$filter .= 'AND rm.dokter_id = ? ';
			$param[] = $dokterId;
		}
		
		$arrData = R::getAll("SELECT dt.rmlama,dt.nama,dt.alias,dt.jns_klmn,pd.umur,dt.alamat,rm.tanggal,pl.nama as poli,pd.stsbayar,dj.nama_dokter as dpjp,pd.nmapenyakit,rm.klinis,rm.respontime,dr.nama_dokter,us.nama as petugas FROM m_radiologi rm INNER JOIN m_dokter dr INNER JOIN m_dokter dj INNER JOIN m_user us INNER JOIN m_datapasien dt INNER JOIN p_pendaftaran pd INNER JOIN m_poli pl ON pd.id=rm.daftar_id AND pl.id=pd.poli_id AND us.id=rm.user_id AND dt.id=rm.pasien_id AND dj.id=pd.dokter_id AND dr.id=rm.dokter_id WHERE ".$filter."",$param);
		
		$report = array();
		$html='';
		if($id==1){
		$html = '<thead><tr><th rowspan="2">NO</th><th colspan="4" class="text-center"><i class="fa fa-address-card"></i> IDENTITAS PASIEN</th><th colspan="3" class="text-center"><i class="fa fa-pencil-square-o"></i> PENDAFTARAN</th><th colspan="4" class="text-center"><i class="fa fa-user-md"></i> REKAMMEDIS</th><th colspan="2" class="text-center"><i class="fa fa-user"></i> PETUGAS MEDIS</th></tr>
									<tr><th>NO.RM</th><th>NAMA</th><th>L/P</th><th>UMUR</th><th>TGL ORDER</th><th>ASAL ORDER</th><th>CARA BAYAR</th><th>RESPONTIME</th><th>DPJP</th><th>DIAGNOSA</th><th>TINDAKAN</th><th>DOKTER</th><th>USER</th></tr></thead><tbody style="font-size:9;">';
			}
		if($id==2){
				$report[] = array('LAPORAN KUNJUNGAN UNIT/INSTALASI RSUD LEUWILIANG');
				$report[] = array('');
				$report[] = array('Tanggal', $dateStart . ' s/d ' . $dateEnd);
				$report[] = array('');
				if ($dokterId != "ALL") {
					$report[] = array('DOKTER : ',$dokter->nama_dokter);
				}
				$report[] = array('LAYANAN / INSTALASI :', R::load('m_unitinstalasi', $this->data['subunit'])->name);
				$report[] = array('');
				$report[] = array('NO','NOMR', 'NAMA PASIEN', 'L/P', 'UMUR','ALAMAT','CARA BAYAR','TANGGAL ORDER','ASAL ORDER','DPJP','DIAGNOSA','TINDAKAN','RESPONTIME','PETUGAS MEDIS','USER');
			}
		
		$i = 1;		
		foreach ($arrData as $key => $value) {
				if($id==1){
					$html .='<tr><td>'.$i++.'</td><td>'.$value['rmlama'].'</td><td>'.$value['nama'].','.$value['alias'].'</td><td>'.$value['jns_klmn'].'</td><td>'.explode("-",$value['umur'])[0].' Thn</td><td>'.$value['tanggal'].'</td><td>'.$value['poli'].'</td><td>'.$value['stsbayar'].'</td><td>'.$value['respontime'].'</td><td>'.$value['dpjp'].'</td><td>'.$value['nmapenyakit'].'</td><td>('.$value['klinis'].')</td><td>'.$value['nama_dokter'].'</td><td>'.$value['petugas'].'</td></tr>';
				}
				if($id==2){
					$report[] = array($i++,"'".$value['rmlama']."'", $value['nama'].",".$value['alias'], $value['jns_klmn'],explode("-",$value['umur'])[0].' Thn', $value['alamat'],$value['stsbayar'], $value['tanggal'], $value['poli'],$value['dpjp'],$value['nmapenyakit'],$value['klinis'],$value['respontime'],$value['nama_dokter'],$value['petugas']);
				}
			}
			if($id==1){
				$html.='</tbody>';
				echo json_encode(base64_encode($html));
			}else if($id==2){
				$for = $this->input->get('for');
				$csv = csvFromArray($report,$for);
				force_download('LAPORAN KUNJUNGAN ' . $dateStart . '_' . $dateEnd . '.csv', $csv);	
			}
	}
	
/* Print Out data REKAMMEDIS */	
	public function print_tindakan($id){	
		$Billing='';
		$detail = R::getAll("SELECT dr.nama_dokter,pl.nama as namapoli,pl.instalasi_id,pd.tanggal,pd.poli_id,pd.dokter_id,pd.umur,pd.trxid,pd.stsbayar,pd.poli_id,pd.kamar_id,dp.rmlama,dp.rmbaru,dp.nama,dp.alias,dp.jns_klmn,dp.tmpt_lahir,dp.tgl_lahir,dp.alamat from m_dokter dr INNER JOIN m_poli pl INNER JOIN m_datapasien dp INNER JOIN p_pendaftaran pd ON	dr.id=pd.dokter_id AND pl.id=pd.poli_id AND dp.id=pd.pasien_id WHERE pd.id=? ;",array($id));
				if($detail){
						$data = $detail[0];
						$tindakan = R::getAll("SELECT tk.id,tk.nota,td.kode_tarif,td.nama_tindakan,td.tarif,td.qty,td.total,td.dokter_id,td.kelas_id,td.poli_id FROM p_trackingpasien tk iNNER JOIN p_trackingdetail td ON td.trackid=tk.id WHERE tk.daftar_id=? ",array($id));			
						if($tindakan){		
						$jumlah=0; 
						$Billing ='<label class="col-lg-12"><h4>RINCIAN TINDAKAN</h4></label>';
						$Billing.='<div class="col-lg-12"><table class="table table-sm"><tr>
						<td style="padding:10px; width:5%;">NO</td>
						<td style="padding:10px;width:30%;">NAMA TINDAKAN</td>
						<td style="padding:10px;width:5%;">TARIF</td>
						<td style="padding:10px;width:5%;">JUMLAH</td>
						<td style="padding:10px;width:5%;">TOTAL</td>
						<td style="padding:10px;width:10%;">PETUGAS</td></tr>';
								$i=0;
								foreach ($tindakan as $key=> $value) 
								{	$i +=1;
									$dr = $value['dokter_id'];
									$jumlah = $value['total']*$value['qty'];
									if($dr != null)
										{$dr = R::load('m_dokter',$dr)->nama_dokter;}
									$Billing.='<tr><td style="padding:10px;">'.$i.'</td>
									<td style="padding:10px;">'.$value['nama_tindakan'].'</td>
									<td style="padding:10px;">Rp.'.number_format($value['tarif']).'</td>
									<td style="padding:10px;">x '.$value['qty'].'</td>
									<td style="padding:10px;">Rp.'.number_format($value['total']).'</td>
									<td style="padding:10px;">'.$dr.'</td></tr>';
								}							
							$Billing.='</table></div>';
							$Billing.='<div class="col-lg-12"style ="border-top:1px solid black;"></div>';
							$Billing.='<div class="col-lg-12">';
							$Billing.='<label style="float:right;"><h1>Jumlah =  Rp.'.number_format($jumlah).'</h1></label></div>';
							}
				$this->load->view('admin/menu/admision/print/p_tindakan',array('data'=>$data,'tindakan'=> $Billing));	
			}
		}
	public function status_pembayaran(){	
		try{
			$poli = $this->input->post("poli");
			$filter = ' pd.tanggal BETWEEN ? AND ? ';
			$param = array($this->input->post("start"), $this->input->post("end"));
			
			if($poli){
				$filter .= ' AND pd.poli_id=?';
				$param[] = $this->input->post("poli");
				}
		    $html='<thead><tr><th rowspan="2">NO</th><th colspan="2" class="text-center"><i class="fa fa-address-card"></i> IDENTITAS PASIEN</th><th colspan="4" class="text-center"><i class="fa fa-pencil-square-o"></i> PENDAFTARAN</th><th colspan="4" class="text-center"><i class="fa fa-user-md"></i> TINDAKAN MEDIS</th><th colspan="1" class="text-center"><i class="fa fa-user"></i> Action</th></tr>
					<tr><th>NO.RM</th><th>NAMA</th><th>NO.TRANSAKSI</th><th>LAYANAN</th><th>TGL KUNJUNGAN</th><th>CARA BAYAR</th><th>DPJP</th><th>JUMLAH</th><th>TOTAL Rp.</th><th>STATUS</th><th>#</th></tr></thead>';
			$html .='<tbody style="font-size:9;">';
			$detail = R::getAll("SELECT dp.nama,dp.alias,dp.rmlama,pl.nama as poli,pd.id as daftar,pd.trxid,pd.tanggal,pd.stsbayar,dr.nama_dokter as dokter from m_dokter dr INNER JOIN m_poli pl INNER JOIN m_datapasien dp INNER JOIN p_pendaftaran pd ON	dp.id=pd.pasien_id AND pl.id=pd.poli_id AND dr.id=pd.dokter_id AND pd.cancelled IS NULL WHERE".$filter." ORDER BY dp.rmlama DESC",$param);
				if($detail){
						$i=0;
						foreach ($detail as $key=> $value)
						{
							$qty=0;
							$total=0;
							$status='<button class="btn btn-info btn-xs" onclick=""><i class="fa fa-edit"></i>&nbsp;Belum Input</button>';
							$nota = R::findOne("p_trackingpasien","daftar_id=?",array($value['daftar']));
							  if($nota){
									if($nota->qty !=null){
											$qty = $nota->qty;
											$total = $nota->total;
										}
									if($nota->validasi =="Y"){
										$status='<button class="btn btn-primary btn-xs" onclick=""><i class="fa fa-print"></i>&nbsp;Approval</button>';
									}	
							   
									$html .='<tr><td>'.$i++.'</td><td>'.$value['rmlama'].'</td><td>'.$value['nama'].','.$value['alias'].'</td><td>'.$value['trxid'].'</td><td>'.$value['poli'].'</td><td>'.$value['tanggal'].'</td><td>'.$value['stsbayar'].'</td><td>'.$value['dokter'].'</td><td>'.$qty.'</td><td>Rp.'.number_format($total,2).'</td><td>'.$status.'</td><td><button class="btn btn-primary btn-xs" onclick="$.print_tindakan('.$value['daftar'].')"><i class="fa fa-print"></i>&nbsp;Detail</button></td>';	
								}
							}
						}
				$html.='</tr></tbody>';		
			}catch (Exception $e)
				{
					echo $e->getMessage();
					R::rollback();
				}
			echo json_encode(base64_encode($html));	
		}
	public function cetak_data_inventory(){	
		try{
			$date = R::isoDateTime();
			$id= $this->input->get('id');
			$instalasi='';
			$ruangan='';
		    $html='<thead><tr><th rowspan="2">NO</th><th colspan="3" class="text-center"><i class="fa fa-address-card"></i>Nama Barang</th><th colspan="5" class="text-center"><i class="fa fa-pencil-square-o"></i>Detail</th><th colspan="3" class="text-center"><i class="fa fa-user-md"></i>Keterangan</th>';
					if($id==1){$html .='<th colspan="1" class="text-center"><i class="fa fa-user"></i> Action</th></tr>';}
					$html .='<tr><th>Kode Master</th><th>Nama Barang</th><th>No Serial</th><th>Spesifikasi</th><th>Ukuran</th><th>Bahan</th><th>Tahun Perolehan</th><th>Jumlah</th><th>B(Baik)</th><th>KB(Kurang Baik)</th><th>RB(Rusak Berat)</th>';
					if($id==1){$html .='<th><i class="fa fa-cog"></i></th>';}
					$html .='</tr></thead>';
			$html .='<tbody style="font-size:9;">';
			$detail = R::getAll("SELECT * FROM m_inventory WHERE instalasi_id=?",array($this->input->get("data")));
				if($detail){
							$i=1;
							$kondisi="";
							foreach ($detail as $key=> $value)
							{
								$instalasi=R::load('m_unitinstalasi',$value['instalasi_id'])->name;
								$ruangan=$value['ruangan'];
									if($value['kondisi']=='B')
										{ $kondisi ='<td><i class="fa fa-check fa-green"></i></td><td></td><td></td>';}
											else if($value['kondisi']=='KB')
										{$kondisi='<td></td><td><i class="fa fa-check fa-green"></i></td><td></td>';}
											else if($value['kondisi']=='RB')
										{$kondisi='<td></td><td></td><td><i class="fa fa-check fa-green"></i></td>';}
								$html .='<tr><td>'.$i++.'</td><td>'.$value['code'].'</td><td>'.$value['nama'].'</td><td>'.$value['serialnumber'].'</td><td>'.$value['spesifikasi'].'</td><td>'.$value['ukuran'].'</td><td>'.$value['bahan'].'</td><td>'.$value['thnperolehan'].'</td><td>'.$value['qty'].'</td>'.$kondisi;
								if($id==1){
								$html .='<td><button class="btn btn-primary btn-xs" onclick=""><i class="fa fa-wrench"></i>&nbsp;edit</button></td>';	
								}
									
							}
						}
				$html.='</tr></tbody>';	
				if($id==1){
					echo json_encode(base64_encode($html));	
				}else if($id==2){
					$this->load->view('admin/print/p_data_inventory',array('data'=>base64_encode($html),'subject'=>'Data Inventory Barang','date'=>$date,'instalasi'=>$instalasi,'ruangan'=>$ruangan));
				}		
			}catch (Exception $e)
				{
					echo $e->getMessage();
					R::rollback();
				}
			
			
		}
		
	public function get_pie_chart_bayar(){
		$data = array();
		$id=$this->input->post('data');
		$date = R::isoDateTime();
		R::setStrictTyping(false);
		try 
			{
				$label = array();
				$dataset = array();
				$borderWidth = array("1,1,1");
				$backgroundColor = array("#33b35a","rgba(75,192,192,1)","#FFCE56");
				$hoverBackgroundColor = array("#33b35a","rgba(75,192,192,1)","#FFCE56");	
				$carabayar = array('BPJS','TUNAI','BATAL');
				$Count = ""	;
				if($id){
					$Count = " AND poli_id =".$id;
					$data['initial'] = R::load('m_poli',$id)->nama;
				}
					foreach($carabayar as $val){
						if($val !='BATAL'){
							$dataset[] = R::count('p_pendaftaran','tanggal > ? AND cancelled is null AND stsbayar=? '.$Count,array(substr($date, 0, 7)."-01",$val));
						}
						if($val =='BATAL'){
							$dataset[] .= R::count('p_pendaftaran','tanggal > ? AND cancelled=? '.$Count,array(substr($date, 0, 7)."-01","Y"));
						}
					}
				$data['labels']=$carabayar;
				$data['datasets']=$dataset;
				$data['borderWidth']=$borderWidth;
				$data['backgroundColor']=$backgroundColor;
				$data['hoverBackgroundColor']=$hoverBackgroundColor;
			}
		 catch(Exception $e) 
				{
					echo $e->getMessage();
				}
			echo json_encode($data);
		
	}
	public function get_pie_chart_bor(){
		$data = array();
		$id=$this->input->post('data');
		$date = R::isoDateTime();
		R::setStrictTyping(false);
		try 
			{
				$label = array();
				$dataset = array();
				$borderWidth = array("1,1,1");
				$backgroundColor = array("#33b35a","rgba(75,192,192,1)","#FFCE56");
				$hoverBackgroundColor = array("#33b35a","rgba(75,192,192,1)","#FFCE56");	
				$carabayar = array('BOR','LOS','TOY','BOT');
				$Count = ""	;
				if($id){
					$Count = " AND poli_id =".$id;
					$data['initial'] = R::load('m_poli',$id)->nama;
				}
					foreach($carabayar as $val){
						if($val =='BOR'){
							/* Rumus BOR = (Jumlah hari perawatan rumah sakit / (Jumlah tempat tidur x Jumlah hari dalam satu periode)) X 100% */
								$jmlh = R::count('p_pendaftaran','tanggal > ? AND cancelled is null AND layanan=? AND status NOT null'.$Count,array(substr($date, 0, 7)."-01",'I'));
							 $dataset[]=$jmlh;
						}
						if($val =='LOS'){
							/* Rumus AVLOS = Jumlah lama dirawat / Jumlah pasien keluar (hidup + mati) */
							$dataset[] .= R::count('p_pendaftaran','tanggal > ? AND cancelled=? AND layanan=?'.$Count,array(substr($date, 0, 7)."-01","Y"));
						}
						if($val =='TOY'){
							/* Rumus TOI = ((Jumlah tempat tidur X Periode) – Hari perawatan) / Jumlah pasien keluar (hidup + mati) */
							$dataset[] .= R::count('p_pendaftaran','tanggal > ? AND cancelled=? AND layanan=?'.$Count,array(substr($date, 0, 7)."-01","Y"));
						}
						if($val =='BOT'){
							/* Rumus BTO = Jumlah pasien keluar (hidup + mati) / Jumlah tempat tidur */
							$dataset[] .= R::count('p_pendaftaran','tanggal > ? AND cancelled=? AND layanan=?'.$Count,array(substr($date, 0, 7)."-01","Y"));
						}
					}
				$data['labels']=$carabayar;
				$data['datasets']=$dataset;
				$data['borderWidth']=$borderWidth;
				$data['backgroundColor']=$backgroundColor;
				$data['hoverBackgroundColor']=$hoverBackgroundColor;
			}
		 catch(Exception $e) 
				{
					echo $e->getMessage();
				}
			echo json_encode($data);
		
	}
}

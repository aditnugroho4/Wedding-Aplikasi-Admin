<?php
Class Sendemail extends CI_Model
    {
    function send($to,$name,$judul){
		$arr =array();
		try {
			$txt='';
			$to = $to;
			$subject = $judul;
			$txt .= "<div class='text-center row'><img width='68' height='70' src='".base_url("asset/portal/img/icon/akbar-group.png")."'>";
			$txt .=	"<h5>HALO : ".$name."<h5>";
			$txt .= "<p>Terima Kasih Telah Menghubungi Kami, Tetap Berlanggangan Dengan kami Rekomendasikan kepada Teman Dan Kerabat untuk mendapatkan Harga dan pelayanan Terbaik dari kami</p></div>";
			$config = Array(
					$config['protocol'] = 'smtp',
					$config['smtp_host'] = '',
					$config['smtp_port'] = 587,
					'smtp_user' => '', // change it to yours
					'smtp_pass' => '', // change it to yours
					'mailtype' => 'html',
					'newline'  => "\r\n",
					'charset' => 'iso-8859-1',
					'wordwrap' => TRUE
                    );
            $txt.="<div class='col-12 mt-5'><h4> Ada Paket A RUMAH Hanya 25 Juta </h4><div class='row'><img class='col-6' src='".base_url("asset/images/blog/27396288de21b895e4e8122d0c351045.png")."'><p class='col-6'>Nikah dapat iPhone 12 Pro Max?\n";
            $txt.="Gimana tuh caranya ?! \n Caranya mudah kok, kalian cukup pilih 'Paket Rumah A' yang didalamnya terdapat item super komplitt, ditambah lagi anda berhak mendapatkan \n Dekorasi (bebas request), \n Gown (bebas pilih), \n Peralatan Catering (full + siap pakai), \n serta MUA Profesioanl (dengan produk high-end)\n";
            $txt.="So tunggu apalagi, langsung aja hubungi kami di nomor 085780555092 atau kalian juga bisa mampir ke gallery kami yang beralamat di \n Jl. Karadenan No.30 (depan alfamart karadenan 4).</p></div></div>";
			$message = $txt;
			$this->load->library('email',$config);
			$this->email->from('info@akbargrup.id'); // change it to yours
			$this->email->to($to);// change it to yours
			$this->email->subject('Info Akbar Grup ');
			$this->email->message($message);
			if($this->email->send())
				{
					$arr['error']=true;
					$arr['code']='101';
					$arr['message']="email Send Success...";
				}
			else
				{
					$arr['error']=true;
					$arr['code']='101';
					$arr['message']=show_error($this->email->print_debugger());
				}
			}catch (Exception $e) {
				$arr['error']=true;
				$arr['code']='102';
				$arr['message']='Gagal System ..'.$e->getMessage();
			}
        }
    function email_notif($to,$name,$judul){
            $arr =array();
                try {
                    $txt='';
                    $to = $to;
                    $subject = $judul;
                    $txt .= "<div class='text-center row'><img width='68' height='70' src='".base_url("asset/portal/img/icon/akbar-group.png")."'>";
                    $txt .=	"<h5>HALO : ".$name."<h5>";
                    $txt .= "<p>Ada Pengunjung Website Menghubungi Akbargrup Mohon Segera Di respond ..!</p></div>";
                    $config = Array(
                            $config['protocol'] = 'smtp',
                            $config['smtp_host'] = '',
                            $config['smtp_port'] = 587,
                            'smtp_user' => '', // change it to yours
                            'smtp_pass' => '', // change it to yours
                            'mailtype' => 'html',
                            'newline'  => "\r\n",
                            'charset' => 'iso-8859-1',
                            'wordwrap' => TRUE
                            );
                    $txt .= '<div class="btn btn-primary"><a href="https://akbargrup.id/Admin"> Buka Chatroom..</a></div>';
                    $message = $txt;
                    $this->load->library('email',$config);
                    $this->email->from('info@akbargrup.id'); // change it to yours
                    $this->email->to($to);// change it to yours
                    $this->email->subject('Info Akbar Grup ');
                    $this->email->message($message);
                    if($this->email->send())
                        {
                            $arr['error']=true;
                            $arr['code']='101';
                            $arr['message']="email Send Success...";
                        }
                    else
                        {
                            $arr['error']=true;
                            $arr['code']='101';
                            $arr['message']=show_error($this->email->print_debugger());
                        }
                    }catch (Exception $e) {
                        $arr['error']=true;
                        $arr['code']='102';
                        $arr['message']='Gagal System ..'.$e->getMessage();
                    }
                }

    }
?>

<?php defined('SYSPATH') or die('No direct script access.');
return array(
    // General Page Settings
    'page_title'        => COMPANY_NAME,
    'meta_keywords'     => COMPANY_NAME,
    'meta_description'  => COMPANY_NAME,
    'google_analytics'  => COMPANY_NAME,
    'meta_copyright'    => COMPANY_NAME,
    'system_language'   => array('id'=>'Indonesia', 'en'=>'English'),
    // Label
	'size'				=> 'Besar',
    'language'          => 'Bahasa',
    'title'             => 'Title',
    'label'             => 'Label',
    'short_desc'        => 'Short Description',
    'full_desc'         => 'Full Description',
    'date'              => 'Date',
    'time'              => 'Time',
    'datetime'          => 'Date Time',
    'status'            => 'Status',
    'status_value'      => array(0=>'Unpublish',1=>'Publish'),
	'status_value_user' => array(0=>'Inactive',1=>'Active'),
	'default'           => 'Default',
	'default_value'     => array(0=>'No',1=>'Yes'),
	'delete_value'      => array(0=>'Undelete',1=>'Deleted'),
    'content_listing'   => '%type Listing',
    'content_detail'    => 'View %type Details',
    'content_edit'      => 'Edit %type Details',
    'content_translate' => 'Translate %type Details',
    'content_new'       => 'Add New %type',
	'detail'			=> 'Detil',
    'changed_status'    => 'Changed Status',
    'date_format'       => 'dd-mm-yyyy',
    'title_action'      => 'Click untuk %action item ini',
    'page'              => 'Page',
    'image'             => 'Image',
	'icon'              => 'Ikon',
    'url'               => 'Url',
	'helpdesk'			=> 'Helpdesk Forum',
	'events&csr'		=> 'Events & CSR',
	'event'				=> 'Event',
	'upcoming_event'	=> 'Upcoming Events',
	'reseller'			=> 'Agent Penjual',
	'principal'			=> 'Prinsipal',
	'sitemap'			=> 'Peta Situs',
    'more'              => 'Lihat',
	'learn_more'		=> 'Ketahui Lagi',
	'view_more'			=> 'Lihat Lagi',
	'download'			=> 'Unduh',
	'download_more'		=> 'Unduh Lagi',
	'news'				=> 'Berita',
	'product' 			=> 'Produk',
	'product_not_in' 	=> 'Produk di %data belum tersedia',
	'promo' 			=> 'Promosi',
	'price' 			=> 'Harga',
	'channel' 			=> 'Kanal',
	'distribution'		=> 'Distribusi',
	'about' 			=> 'Tentang Kami',
	'latest'       		=> '%type Terkini',
	'back_to'      		=> 'Kembali ke %type',
	'search'			=> 'Cari',
	'search_keywords'	=> 'Cari Kata Kunci',	
	'language'			=> 'Bahasa',
	'no_detail'			=> 'Tidak ada Detil %type', 
	'here'				=> 'Anda berada di',
	'home'				=> 'Beranda', 
	'contact'			=> 'Hubungi', 	
	'contact_us'		=> 'Hubungi Kami', 	
	'contact_personal'  => 'Form Pribadi',	
	'contact_corporate' => 'Form Perusahaan',
	'support_division'	=> 'Divisi Support',	
	'us'				=> 'Kami',
	'or'				=> 'atau',
	'send_email'		=> 'Kirim sebuah Email. Semua kolom isian dengan tanda <span class="red">*</span> adalah yang di perlukan.',
	'send_message'		=> 'Kirim Pesan',
	'no_content'		=> 'Tidak ada isinya',	
	'our'				=> '%title kami',
	'check_form'		=> '*Periksa lagi form anda',	
	'company_overview'	=> 'Pengenalan Perusahaan',
	'testimonials'		=> 'Testimoni',
	'download_source'	=> 'Tempat Unduh',
	'pick_category'		=> 'Pilih Kategori',
	'category'			=> 'Kategori',	
	'type'				=> 'Tipe',	
	'email_address'		=> 'Alamat Email',	
	'login_first'		=> 'Login terlebih dahulu untuk Mengunduh',
	'register_site'		=> 'Daftar di website kami untuk mendapatkan akses penuh dan akses halaman unduh.',		
	'new_account'		=> 'Buat akun baru mohon <a href="'.URL::site('member/register').'" class="">Daftar</a>',
	'send'				=> 'Kirim',	
	'already_register'	=> 'Sudah punya akun ? <a href="'.URL::site('member/login').'">Login</a> untuk melanjutkan',
	// Validation		
	'not_empty'			=> 'Tidak boleh kosong',	
	'not_valid'			=> 'Tidak valid',
	'unavailable'		=> '%data belum tersedia',
	'already_exists'	=> 'Sudah terdaftar',
	'exact_length'		=> 'Harus berjumlah :param2 karakter',	
	'min_length'		=> 'Harus setidaknya berjumlah :param2 karakter',	
	'valid_url'			=> 'Harus alamat url yang valid',	
	'max_length'		=> 'Tidak boleh melebihi :param2 karakter',
	'regex'				=> 'Tidak memenuhi kriteria format teks',	
	'matches'			=> 'Harus sesuai dengan :param3',
	// Email message
	'register_success'  => 'Silahkan melakukan verifikasi email dengan menggunakan link yang kami kirim ke email Anda. Jika email tidak diterima, mohon untuk memeriksa spam / junk mail Anda.',
	'register_verified' => 'Terima kasih telah melakukan verifikasi, Anda dapat mengakses menu download untuk member.',
	// Member
	'login'				=> 'Login',
	'profile'			=> 'Profil',	
	'free'				=> 'Gratis',
	'register'			=> 'Daftar',
    'username'			=> 'Username',
	'fullname'			=> 'Full Name',
	'password'			=> 'Password',
	'password2'			=> 'Confirm Password',
	'address'			=> 'Alamat',
	'country'			=> 'Negara',
	'church'			=> 'Church',	
	'birthday'			=> 'Birthday',
	'about'				=> 'Tentang',
	'forgot'			=> 'Lupa',
	'forgot_password'	=> 'Isi email anda untuk melanjutkan',
	'gender'			=> 'Jenis Kelamin',
	'confirm'			=> 'Konfirmasi',
	'captcha'			=> 'Kode Captcha',
	'agree'				=> 'Persetujuan',
	'agreement'			=> 'Saya setuju dengan Syarat dan Ketentuan',
	'activating_acc'	=> 'Aktivasi Akun',
	'check_email'		=> 'Cek email anda di %email',
	'update_profile'	=> 'Perbarui Profil',
	'logout'			=> 'Logout',
	'message_password'	=> 'Password anda salah',
	'message_email'		=> 'Email tidak terdaftar',
	'account_free'		=> 'Untuk memiliki account di Offistarindo.com, anda harus melengkapi data-data dibawah ini',
	'captcha_code'		=> 'Captcha',
	'captcha_reload'	=> 'Rubah Kode Captcha',
	'submit'			=> 'Kirim',	
	'reset'				=> 'Hapus',		
	'cancel'			=> 'Batal',		
	'overview'			=> 'Penjelasan',
	'features'			=> 'Fitur',
	'specification'		=> 'Spesifikasi',
	'combo_option'		=> 'Pilihan Kombinasi',
	'upcoming_event'	=> 'Event Terdekat',
	'no_upcoming_event' => 'Tidak ada event terdekat',
	//Search 
	'search_empty'		=> 'Tidak ada hasil pencarian',
	// Admin
	'admin'				=> 'Admin',
	'welcome_admin'		=> 'Welcome %admin',
	'error_login'		=> 'Authentication failed',
	// Error encountered
	'error_enc'			=> 'Beberapa kesalahan yang muncul, silakan memeriksa rincian yang Anda masukkan.',
	'added'				=> 'Added',
	'modified'			=> 'Modified',	
	// Contact Form
	'admin_contact'		=> '<h2>Form hubungi kami</h2>Administrator yang terhormat, ada seseorang yang menghubungi melalui web<br/>
							-------------------------------------------------------------------------------------------------------------<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nama : %name,<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Telpon : %phone,<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email : %email,<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pesan : %message<br/>
							-------------------------------------------------------------------------------------------------------------<br/>
							Terima kasih atas perhatiannya.<br/>
							<!--span style="font-style: italic; color: lightgray; font-size: 11px; margin: 0px">
							<b>%site_name</b><br/>%address<br/>
							Phone : %phone Fax : %fax<br/>
							<span-->',
	
	'admin_contact_co'	=> '<h2>Form hubungi kami</h2>Administrator yang terhormat, ada seseorang yang menghubungi melalui web<br/>
							-------------------------------------------------------------------------------------------------------------<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nama : %name<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mobile : %mobile<br/>							
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Telpon : %phone<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fax : %fax<br/>							
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email : %email<br/>							
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nama Perusahaan : %corporate<br/>	
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Alamat Perusahaan : %address<br/>								
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Website Perusahaan: %website<br/>	
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pesan : %message<br/>
							-------------------------------------------------------------------------------------------------------------<br/>
							Terima kasih atas perhatiannya.<br/>
							<!--span style="font-style: italic; color: lightgray; font-size: 11px; margin: 0px">
							<b>%site_name</b><br/>%address<br/>
							Phone : %phone Fax : %fax<br/>
							<span-->',
	
	'public_contact'	=> '<h2>Form hubungi kami</h2>
							Yang terhormat %name, terima kasih telah menghubungi kami.<br/>
							-------------------------------------------------------------------------------------------------------------<br/>
							Kami akan dengan senang hati merespon pesan email anda secepatnya.<br/>
							-------------------------------------------------------------------------------------------------------------<br/>
							Terima kasih atas perhatiannya.<br/>
							<!--span style="font-style: italic; color: lightgray; font-size: 11px; margin: 0px">
							<b>%site_name</b><br/>%address<br/>
							Phone : %phone Fax : %fax<br/>
							<span-->',	
	'public_contact_co'	=> '<h2>Form hubungi kami</h2>
							Yang terhormat %name, terima kasih telah menghubungi kami.<br/>
							-------------------------------------------------------------------------------------------------------------<br/>
							Kami akan dengan senang hati merespon pesan email anda secepatnya.<br/>
							-------------------------------------------------------------------------------------------------------------<br/>
							Terima kasih atas perhatiannya.<br/>
							<!--span style="font-style: italic; color: lightgray; font-size: 11px; margin: 0px">
							<b>%site_name</b><br/>%address<br/>
							Phone : %phone Fax : %fax<br/>
							<span-->',
	'thanks_email'		=> 'Terima kasih telah menghubungi kami. Pesan Anda telah berhasil dikirim ke tim kami. Kami akan segera menghubungi Anda kembali. ',
	'contact_success'	=> 'Pesan Anda telah terkirim',
	'form_contact_us'	=> 'Form Hubungi Kami',
	// Contact Us
	'name'				=> 'Nama',
	'company'			=> 'Perusahaan',
	'message'			=> 'Pesan',
	'phone'				=> 'Telpon',
	'fax'				=> 'Fax',	
	'email'				=> 'Email',	
	'mobile'			=> 'Mobile',	
	'corporatename'	=> 'Nama Perusahaan',
	'corporateemail'	=> 'Email Perusahaan',
	'corporateaddress'	=> 'Alamat Perusahaan', 	
	'corporatewebsite'	=> 'Website Perusahaan',	
	'corporatephone'	=> 'Telpon Perusahaan',	
	'corporatemobile'	=> 'Telpon Mobile Perusahaan',	
	'corporatefax'		=> 'Fax Perusahaan',	
	'corporatemessage'	=> 'Pesan dari Perusahaan',
	// Career
	'career'			=> 'Karir',
	'no_career'			=> 'Tidak ada lowongan saat ini.',
	// Pagination			
	'first'				=> 'Pertama',
	'previous'       	=> 'Sebelumnya',
	'next'				=> 'Selanjutnya',
	'last'       		=> 'Terakhir',
    //Day 
    'Sunday'            => 'Minggu',
    'Monday'            => 'Senin',
    'Tuesday'           => 'Selasa',
    'Wednesday'         => 'Rabu',
    'Thursday'          => 'Kamis',
    'Friday'            => "Jum'at",
    'Saturday'          => 'Sabtu',    
    //Month 
    'January'           => 'Januari',
    'February'          => 'Februari',
    'March'             => 'Maret',
    'April'             => 'April',
    'May'               => 'Mei',
    'June'              => 'Juni',
    'July'              => 'Juli',
    'August'            => 'Agustus',
    'September'         => 'September',
    'October'           => 'Oktober',
    'November'          => 'November',
    'December'          => 'Desember',
    // Warning
    'warning_delete'    => 'Ingin menghapus item ini ? Item yang dihapus tidak dapat di-restore kembali',

	// Auth Error
	'blocked_id'			=> 'ID Akun anda sudah di blokir oleh Administrator',
	'inactive_id'			=> 'ID Akun anda sudah tidak aktif', 
	'id_level_disabled'		=> 'Level ID Akun anda sudah tidak di aktifkan oleh Administrator',
	'id_default_warning'	=> 'ID Akun dan Password anda salah',

    // Error
    'error_no_data'     => 'Error. No record found',
    'error_no_translate'        => 'Error. No available translate yet',
    'error_no_direct_access'    => 'Error, no direct script access allowed',
    'error_upload_file' => array (
                                '501' => 'Ups. Sistem error, tidak dapat mengunggah file',
                                '503' => 'File yang anda pilih tidak diijinkan',
                                '504' => 'Ukuran gambar yang anda pilih tidak diijinkan',
                            )
);
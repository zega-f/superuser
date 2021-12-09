<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PengajarController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\RombelController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\KursusController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\PartnershipController;


// Route::get('zoom', [AuthController::class, 'Zoom'])->name('zoom');
Route::get('zoom', [KelasController::class, 'mbuh'])->name('zoom');

//login
Route::get('/', [AuthController::class, 'login'])->name('login');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login_post', [AuthController::class,'AuthCheck']);
Route::get('/logout', [AuthController::class,'logout'])->name('logout');
Route::get('lupa_password', [AuthController::class, 'lupa_password']);//view
Route::post('/sendemail',[EmailController::class,'sendemail'])->name('sendemail');//lupa-pass

//profile
Route::get('/profile/{id}', [AdminController::class, 'profile_admin'])->name('profile_admin');
Route::get('changepassword',[AdminController::class,'changePassword']);
Route::post('change_password', [AdminController::class, 'changePassword']);
Route::post('update_profil/{id}', [AdminController::class, 'update_profil'])->name('update_profil');

//dashboard
Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

//Pengajar
Route::get('/pengajar',[PengajarController::class,'index'])->name('pengajar');
Route::post('/pengajar_store',[PengajarController::class,'pengajar_store']);
// Route::get('reset_password/{id}', [PengajarController::class, 'reset_password'])->name('reset_password');
Route::get('del_pengajar',[PengajarController::class, 'delete_pengajar'])->name('del_pengajar');
Route::get('/detail_pengajar/{id}', [PengajarController::class, 'detail_pengajar'])->name('detail_pengajar');


//admin
Route::post('/add_admin', [AdminController::class, 'admin_store'])->name('admin');
Route::get('/data_admin', [AdminController::class, 'index'])->name('data_admin');
Route::get('del_admin',[AdminController::class, 'delete_admin'])->name('del_admin');
Route::get('admin_non_aktif',[AdminController::class, 'admin_non_aktif']);
Route::get('admin_aktif',[AdminController::class, 'admin_aktif'])->name('admin_aktif');
// Route::get('reset_pass_admin/{id}', [AdminController::class, 'reset_password']);

//Siswa
Route::get('/data_siswa',[SiswaController::class,'index'])->name('data_siswa');
Route::get('/detail_siswa/{id}',[SiswaController::class,'detail_siswa'])->name('detail_siswa');
Route::get('table_siswa', [SiswaController::class, 'getKliping']);

Route::get('/siswa_kursus',[SiswaController::class,'siswa_kursus'])->name('siswa_kursus');
Route::post('/filter_siswa_reguler',[SiswaController::class,'filter_siswaReg']);
Route::post('/cetak_siswa_reguler',[SiswaController::class,'cetak_siswaReg']);
Route::post('/filter_siswa_kursus',[SiswaController::class,'filter_siswaKursus']);
Route::post('/cetak_siswa_kursus',[SiswaController::class,'cetak_siswaKursus']);
Route::get('/detail_siswaKursus/{id}',[SiswaController::class,'detail_siswaKursus']);
Route::post('/filter_jadwal_kelas',[SiswaController::class,'filter_jadwal_kelas']);
Route::post('/cetak_jadwal_kelas',[SiswaController::class,'cetak_jadwal_kelas']);


// pembayaran
Route::get('/pembayaran', [PembayaranController::class, 'index']);
Route::get('/verify_pembayaran/{id}/{register_id}', [PembayaranController::class, 'verify']);
Route::get('/detail_pendaftar', [PembayaranController::class, 'detail_pendaftar']);
Route::get('/register_kursus', [PembayaranController::class, 'regis_kursus']);
Route::get('/detail_pendaftar_kursus', [PembayaranController::class, 'detail_pendaftar_kursus']);
Route::get('/verify_kursus/{id}', [PembayaranController::class, 'verify_kursus']);

//reset pass pengguna
Route::post('/pass_siswa',[EmailController::class,'pass_siswa'])->name('pass_siswa');
Route::post('/pass_guru',[EmailController::class,'pass_guru'])->name('pass_guru');
Route::post('/pass_admin',[EmailController::class,'pass_admin'])->name('pass_admin');


//Data Master
//mapel master
Route::get('/mapel',[MasterController::class,'index'])->name('mapel');
Route::post('/mapel_store',[MasterController::class,'mapel_store']);
Route::get('del_mapel',[MasterController::class, 'delete_mapel'])->name('del_mapel');
Route::get('mapel_non_aktif',[MasterController::class, 'mapel_non_aktif']);
Route::get('mapel_aktif',[MasterController::class, 'mapel_aktif'])->name('mapel_aktif');
Route::post('update_mapel/{id}', [MasterController::class, 'update_mapel'])->name('update_mapel');

//setting_jam master
//setting_jam
Route::get('/set_jam', [masterController::class, 'set_jam'])->name('set_jam');
Route::post('/simpanjam', [MasterController::class, 'simpan_jam'])->name('simpanjam');
Route::get('/reset_jam', [MasterController::class, 'reset_jam'])->name('resetjam');
Route::post('/simpanjam2', [MasterController::class, 'simpan_jam2'])->name('simpanjam2');


//AKADEMIK
//mapel
Route::get('/kelola_mapel',[MapelController::class,'kelola_mapel'])->name('kelola_mapel');
Route::get('/mapel_kelas/{jenjang}/{tingkat}', [MapelController::class, 'mapel_kelas'])->name('mapel_kelas');
//kelola Mapel
Route::post('/mapelkelas_store', [MapelController::class, 'mapelkelas_store']);
Route::post('update_mapel_kelas/{id}', [MapelController::class, 'update_mapel_kelas'])->name('update_mapel_kelas');
Route::get('del_mapel_kelas',[MapelController::class, 'delete_mapel_kelas'])->name('del_mapel_kelas');
Route::get('/kelola_mapelkelas/{tingkat}/{mapel}', [MapelController::class, 'kelola_mapel_kelas']);
Route::get('mapel_tingkat_non_aktif',[MapelController::class, 'mapel_tingkat_non_aktif']);
Route::get('mapel_tingkat_aktif',[MapelController::class, 'mapel_tingkat_aktif']);
Route::post('/registrasi_kelas', [MapelController::class, 'registrasi_kelas']);

//BAB
Route::post('add_bab',[MapelController::class, 'bab_store'])->name('add_bab');
Route::get('/delete_bab/{id}',[MapelController::class,'delete_bab']);
Route::post('update_bab',[MapelController::class,'update_bab']);

// kelas
Route::get('/kelas',[KelasController::class,'index'])->name('kelas');
Route::post('/kelas_store',[KelasController::class,'kelas_store']);
Route::get('del_kelas',[KelasController::class, 'delete_kelas'])->name('del_kelas');
Route::get('kelas_non_aktif',[KelasController::class, 'kelas_non_aktif']);
Route::get('kelas_aktif',[KelasController::class, 'kelas_aktif'])->name('kelas_aktif');
Route::get('/detail_kelas/{id}',[KelasController::class,'detail_kelas'])->name('detail_kelas');//siswa


//kelola kelas
Route::get('/kelola_kelas/{id_kelas}/{jenjang}/{tingkat}', [KelasController::class, 'kelola_kelas'])->name('kelola_kelas');
//siswa
Route::get('siswa_into_class',[KelasController::class,'siswaIntoClass']);
Route::get('siswa_aktif',[KelasController::class,'siswa_aktif'])->name('siswa_aktif');
Route::get('siswa_inaktif',[KelasController::class,'siswa_nonaktif'])->name('siswa_nonaktif');
Route::get('remove_siswa',[KelasController::class,'removeSiswaFromClass']);

//jadwal
Route::post('/jadwalkelas_store', [KelasController::class, 'jadwalkelas_store']);
// cek tanggal
Route::get('check_tanggal',[KelasController::class,'cek_tanggal']);
Route::get('change_guru',[KelasController::class, 'change_guru'])->name('change_guru');
Route::get('change_jam',[KelasController::class, 'change_jam'])->name('change_jam');
Route::get('change_jam_kursus',[KelasController::class, 'change_jam_kursus'])->name('change_jam_kursus');
Route::get('del_jadwal',[KelasController::class, 'delete_jadwal'])->name('del_jadwal');

Route::get('/zoom_video',[KelasController::class,'list_video_zoom']);
Route::get('del_zoom_video',[KelasController::class, 'delete_video_zoom']);




//Rombel
Route::get('/rombel', [RombelController::class, 'rombel'])->name('rombel');
Route::get('/pilih_tingkat', [RombelController::class, 'pilih_tingkat'])->name('pilih_tingkat');
Route::get('/pilih_kelas', [RombelController::class, 'pilih_kelas'])->name('pilih_kelas');
Route::get('/reload_pendaftar', [RombelController::class, 'reload_pendaftar'])->name('reload_pendaftar');
Route::get('siswa_into_class1',[RombelController::class,'siswaIntoClass']);
Route::get('siswa_aktif1',[RombelController::class,'siswa_aktif'])->name('siswa_aktif1');
Route::get('siswa_inaktif1',[RombelController::class,'siswa_nonaktif'])->name('siswa_nonaktif1');
Route::get('remove_siswa1',[RombelController::class,'removeSiswaFromClass']);



Route::get('/info', function () {
    return view('info');
});

//pengajar mapel
Route::get('/pengajar_mapel/{id}',[MapelController::class,'pengajar_mapel'])->name('pengajar_mapel');
Route::post('/pengajar_mapel_store',[MapelController::class,'pengajar_mapel_store']);
Route::get('del_mapel_pengajar',[MapelController::class, 'delete_mapel_pengajar'])->name('del_mapel_pengajar');

Route::get('/jadwal_pelajaran',[PengajarController::class,'jadwal_pengajar']);


//////////////KURSUS////////////


//Kursus
Route::get('/kursus',[KursusController::class,'index'])->name('kursus');
Route::post('/kursus_store',[KursusController::class,'kursus_store'])->name('kursus_store');
Route::get('kursus_non_aktif',[KursusController::class, 'kursus_non_aktif']);
Route::get('kursus_aktif',[KursusController::class, 'kursus_aktif'])->name('kursus_aktif');
Route::get('del_kursus',[KursusController::class, 'delete_kursus'])->name('del_kursus');
Route::post('/kursus_update',[KursusController::class,'kursus_update'])->name('kursus_update');
Route::post('/kursus_spv_store',[KursusController::class,'kursus_spv_store']);
Route::get('del_spv',[KursusController::class, 'delete_spv']);


//Kelola_Kursus
Route::get('/kelola_kursus/{room_id}',[KursusController::class,'kelola_kursus'])->name('kelola_kursus');
Route::post('/store_bab_kursus',[KursusController::class,'store_bab_kursus'])->name('store_bab_kursus');
Route::post('update_bab',[MapelController::class,'update_bab']);

//Materi kursus
Route::get('/add_materi/{room_id}/{id_bab}',[kursusController::class,'add_materi']);
Route::get('edit_materi_kursus/{materi_id}/{room_id}/{bab_id}',[KursusController::class,'edit_materi']);
Route::post('update_materi_kursus/{id_materi}/{room_id}',[KursusController::class,'update_materi']);

//Tugas Kursus
Route::get('add_tugas/{room_id}/{id_bab}',[KursusController::class,'add_tugas'])->name('add_tugas');
Route::get('edit_tugas_kursus/{materi_id}/{room_id}/{bab_id}',[KursusController::class,'edit_tugas']);
Route::post('update_tugas_kursus/{id_materi}/{room_id}',[KursusController::class,'update_tugas']);

//Quiz Kursus
Route::get('add_quiz/{room_id}/{id_bab}',[KursusController::class,'add_quiz'])->name('add_quiz');
Route::get('edit_quiz_kursus/{quiz_id}',[KursusController::class,'edit_quiz'])->name('edit_quiz');
Route::post('update_quiz_kursus/{id}',[KursusController::class,'update_quiz']);
Route::get('unpublish_quiz_kursus/{quiz_id}',[KursusController::class,'unpublish_quiz']);


//Jadwal Kursus
Route::post('/jadwalkursus_store', [KursusController::class, 'jadwalkursus_store']);
// Route::get('show/{id}', [KursusController::class, 'show']);
// Route::post('create', [KursusController::class, 'store1']);
Route::get('del_jadwal_kursus',[KursusController::class, 'delete_jadwal'])->name('del_jadwal');
Route::get('/jadwal_kursus/{room_id}', [KursusController::class, 'jadwal_kursus']);


Route::get('edit_jadwal_kursus/{id}',[KursusController::class,'edit_jadwal']);
Route::post('update_jadwal_kursus',[KursusController::class,'update_jadwal']);

//Participant Kursus
Route::get('/participant_kursus/{room_id}', [KursusController::class, 'participant_kursus']);


// Route::get('/test',[KursusController::class,'test'])->name('test');
Route::get('/update_test',[KursusController::class,'update_test'])->name('update_test');//ordering


use App\Http\Controllers\materi\materiController;
use App\Http\Controllers\materi\subMateriController;
use App\Http\Controllers\kelas\CommonController;

use App\Http\Controllers\quiz\quizController;
use App\Http\Controllers\quiz\subQuizController;

use App\Http\Controllers\tugas\tugasController;
use App\Http\Controllers\tugas\subTugasController;



// MATERI
//materi in mapel kelas
Route::get('/materi/{id_kelas}/{id_mapel}/{id_bab}',[materiController::class,'index']);
// store materi
Route::post('coba_sn',[materiController::class,'store']);//tambah materi
Route::get('check_video',[materiController::class,'check_video']);

// show for edit
Route::get('edit_materi/{materi_id}/{tingkat}/{mapel}',[materiController::class,'edit']);
// update materi
Route::post('update_materi/{id_materi}/{tingkat}/{mapel}',[materiController::class,'update']);
// delete materi
Route::get('delete_materi',[materiController::class,'delete_materi']);
// show materi
Route::get('preview_materi/{materi_id}',[subMateriController::class,'show']);
// delete file
Route::get('delete_file',[subMateriController::class,'delete_file']);
// END MATERI



// TUGAS
// index tugas / add tugas
Route::get('tugas/{id_kelas}/{id_mapel}/{id_bab}',[tugasController::class,'index'])->name('tugas');

// store materi
Route::post('store_tugas',[tugasController::class,'store']);
// show tugas for edit
Route::get('edit_tugas/{tugas_id}/{tingkat}/{mapel}',[tugasController::class,'edit']);
// update
Route::post('update_tugas/{tugas_id}/{tingkat}/{mapel}',[tugasController::class,'update']);
// delete tugas
Route::get('delete_tugas',[tugasController::class,'delete']);

// show tugas
Route::get('preview_tugas/{tugas_id}',[subTugasController::class,'preview_tugas']);
// delete file
Route::get('delete_tugas_file',[subTugasController::class,'delete_file']);

Route::get('delete_bab',[MapelController::class,'delete_bab']);




// QUIZ
// quiz index / add quiz
Route::get('quiz',[quizController::class,'index']);
// store quiz
Route::post('store_quiz',[quizController::class,'store']);
// edit quiz
Route::get('edit_quiz/{quiz_id}',[quizController::class,'edit'])->name('edit_quiz');
// update quiz
Route::post('update_quiz/{id}',[quizController::class,'update']);
// unpublish quiz
Route::get('unpublish_quiz/{quiz_id}',[quizController::class,'unpublish']);

Route::get('delete_quiz',[quizController::class,'delete_quiz']);


// quiz component
// store question
Route::post('store_question',[subQuizController::class,'store_question']);
// edit question
Route::get('edit_this_question',[subQuizController::class,'edit_this_question']);
// update question
Route::post('updating_question',[subQuizController::class,'update_this_question']);
// delete question
Route::get('delete_this_question',[subQuizController::class,'delete_this_question']);

// option
// create option
Route::get('create_option',[subQuizController::class,'create_option']);
// store option
Route::post('store_option',[subQuizController::class,'store_option']);
// delete option
Route::get('delete_option',[subQuizController::class,'delete_option']);
// edit option
Route::get('edit_option',[subQuizController::class,'edit_option']);
// update option
Route::post('update_option',[subQuizController::class,'update_option']);
// set as right answer
Route::get('set_as_right_answer',[subQuizController::class,'set_as_right_answer']);
Route::post('delete_question_lampiran',[subQuizController::class,'delete_question_lampiran']);
// delete option attachment
Route::post('delete_this_option_attch',[subQuizController::class,'delete_this_option_attch']);
// END QUIZ



/////////////
Route::get('create',[SettingController::class,'create']);



///Setting
Route::get('setting_cms',[SettingController::class,'index']);//indexinfo
Route::get('setting_cms/#feedback',[SettingController::class,'index']);//indexinfo
Route::post('store',[SettingController::class,'store']);//updateinfo

Route::get('faq',[SettingController::class,'faq_index']);//index faq
Route::post('store_faq',[SettingController::class,'store_faq']);//add faq
Route::post('add_question',[SettingController::class,'add_question']);//add petanyaan
Route::get('del_faqcategory/{category_id}',[SettingController::class,'del_faq']);//del_faq
Route::post('update_faq_category',[SettingController::class,'update_faq']);//update_faq
Route::post('update_answer',[SettingController::class,'update_answer']);//update_answer
Route::get('del_answer/{category_id}',[SettingController::class,'del_answer']);//del_answer

//progam
Route::post('progam_store',[SettingController::class,'progam_store']);//progam
Route::post('progam_update',[SettingController::class,'progam_update']);//progam
Route::get('del_promosi/{id}',[SettingController::class,'del_promosi']);//del_answer
Route::post('promosi_store',[SettingController::class,'promosi_store']);//promosi
Route::post('promosi_update',[SettingController::class,'promosi_update']);//promosi
Route::get('checklist_testi',[SettingController::class,'checklist_testi']);//
Route::get('checklist_read_testi',[SettingController::class,'checklist_read_testi']);//


//feedback
Route::get('feedback',[SettingController::class,'feedback']);//indexinfo
Route::post('feedback_store',[SettingController::class,'feedback_kursus']);//

//artikel
Route::get('artikel',[ArtikelController::class,'index']);//index
Route::get('create_artikel',[ArtikelController::class,'create']);//index
Route::post('store_artikel',[ArtikelController::class,'store']);//index
Route::get('edit_artikel/{id}',[ArtikelController::class,'edit_artikel']);//index
Route::post('update_artikel/{id_artikel}',[ArtikelController::class,'update_artikel']);//index
Route::get('view_artikel/{id}',[ArtikelController::class,'view_artikel']);//index

Route::get('artikel_unpublish',[ArtikelController::class, 'artikel_unpublish']);
Route::get('artikel_publish',[ArtikelController::class, 'artikel_publish']);
Route::get('del_artikel',[ArtikelController::class, 'delete_artikel']);

Route::post('kategori_store',[ArtikelController::class,'kategori_store']);//index
Route::post('kategori_update',[ArtikelController::class,'kategori_update']);//index
Route::get('del_kategori',[ArtikelController::class, 'delete_kategori']);

Route::get('artikel_add_sorotan',[ArtikelController::class,'artikelAddSorotan']);
Route::get('artikel_remove_sorotan',[ArtikelController::class,'artikelRemoveSorotan']);
Route::get('artikel_sorotan',[ArtikelController::class,'artikel_sorotan']);
Route::get('artikel_default',[ArtikelController::class,'artikel_default']);



//notif
Route::get('notif_new_pendaftar',[ArtikelController::class, 'notif']);
Route::get('notif_testi',[ArtikelController::class, 'notif']);


//Parnership
Route::get('/partnership',[PartnershipController::class,'index'])->name('partnership');
Route::get('del_partnership',[PartnershipController::class, 'delete_partnership'])->name('del_partnership');

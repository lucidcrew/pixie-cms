<?php
if (!defined('DIRECT_ACCESS')) { header( 'Location: ../../' ); exit(); }
//*****************************************************************//
// Pixie: The Small, Simple, Site Maker.                           //
// ----------------------------------------------------------------//
// Licence: GNU General Public License v3                   	   //
// Title: Language File (Turkish TR).                              //
// Author: Can KAYA (http://ckaya.name).                           //
//*****************************************************************//
if (!isset($delete)) { $delete = NULL; }
if (!isset($username)) { $username = NULL; }
$lang = array(
	// system
	'skip_to' => 'İçeriğe git',
	'view_site' => 'Siteye bak',
	'logout' => 'Çıkış',
	'license' => 'Lisans:',
	'tag_line' => 'Küçük, Basit, Site Yaratıcısı',
	'latest_referrals' => 'Ziyaretçilerin Geldikleri Adresler',
	'latest_activity' => 'Son Etkinlikler',
	'feed_subscribe' => 'Takip et',
	'rss_feed' => 'RSS Beslemesi',
	'when' => 'Ne zaman?',
	'who' => 'Kim?',
	'what' => 'Ne?',
	'from' => 'Nereden?',
	'switch_to' => 'Değiştir:',
	'a_few_seconds' => 'Birkaç saniye',
	'a_minute' => '1 dakika',
	'minutes' => 'dakika',
	'a_hour' => '1 saat',
	'hours' => 'saat',
	'a_day' => '1 gün',
	'days' => 'gün',
	'ago' => 'önce.',
	'user' => 'Kullanıcı',
	'to' => '',
	'database_backup' => 'Veritabanı Yedeklemesi',
	'database_info' => 'Veritabanının sıklıkla yedeklendiğinden emin olun. Sağdaki butonu kullanarak veritabanını yedekleyebilirsiniz. Yedeklenen dosyalar files/sqlbackups/ dizininde saklanır, aşağıdaki listeden de indirilebilir. En güncel yedeklemeniz sarı renk ile vurgulanmıştır.',
	'database_backups' => 'Yedeklemeler',
	'download' => 'İndir',
	'delete' => 'Sil',
	'delete_file' => 'Dosyayı silmek istediğinizden emin misiniz?',
	'theme_info' => 'Şu an yüklenmiş olan temalar aşağıda listelenmiştir. Yeni temaları admin/themes dizinine kaydederek yükleyebilirsiniz. <a href="http://www.getpixie.co.uk">www.getpixie.co.uk</a> adresinden de yeni temalar indirebilirsiniz. Şu an kullanımda olan tema sarı renk ile vurgulanmıştır.',
	'theme_pick' => 'Siteniz için bir tema seçin',
	'theme_apply' => 'Bu temayı uygula',
	'sure_delete_page' => 'Sayfayı silmek istediğinizden emin misiniz:',
	'sure_empty_page' => 'Sayfanın içeriğini temizlemek istediğinizden emin misiniz:',
	'settings_page' => 'sayfa',
	'settings_plugin' => 'eklenti',
	'plugins' => 'Eklentiler',
	'plugins_info' => 'Eklentiler, sitenizin belirli sayfalarına ek özellikler getirirler.',
	'empty' => 'Boş',
	'oops' => 'Hooppa!',
	'feature_disabled' => 'Bu özellik şu an aktif değildir. Pixie\'nin gelecek versiyonlarında bu durumu halledeceğiz!',
	'pages_in_navigation' => 'Navigasyona dahil sayfalar',
	'pages_in_navigation_info' => 'Bu sayfalar, sitenizin navigasyonunda gözükmektedir; navigasyon sırasını değiştirmek için aşağı ve yukarı ok tuşlarını kullanabilirsiniz. En yukarıdaki sayfa, navigasyonda ilk olarak gözükecektir.', 
	'pages_outside_navigation' => 'Navigasyona dahil olmayan sayfalar',
	'pages_outside_navigation_info' => 'Bu sayfalar genele açıktır; ancak site navigasyonunda gözükmeyeceklerdir.', 
	'pages_disabled' => 'Deaktive edilmiş sayfalar',
	'pages_disabled_info' => 'Bu sayfalar görülebilir değillerdir.',
	'edit_user' => 'Kullanıcı düzenle',
	'create_user' => 'Yeni kullanıcı oluştur',
	'create_user_info' => 'Yeni kullanıcıya siteye giriş bilgilerini ve rastgele yaratılmış şifreyi içeren bir e-posta gönderilecektir.',
	'user_info' => 'Aşağıda Pixie\'ye erişimi olan kullanıcıları görebilirsiniz. Sağ taraftaki formu kullanarak yeni kullanıcılar oluşturabilirsiniz. Yönetici hesabı, sarı renk ile vurgulanmıştır.',
	'user_delete_confirm' => 'Kullanıcıyı silmek istediğinizden emin misiniz:',
	'tags' => 'Etiketler',
	'upload' => 'Dosya yükle',
	'file_manager_info' => 'Maksimum dosya boyutu 100 Mb\'dir. Lütfen büyük dosyalar yüklerken sabırlı olun.',
	'file_manager_latest' => 'Son Yüklenenler',
	'file_manager_tagged' => 'Etiketlenmiş tüm dosyalara bak:',
	'filename' => 'Dosya Adı',
	'filedate' => 'Değiştirilme Tarihi',
	'results_from' => 'Sonuçlar:',
	'sure_delete_entry' => 'Kaydı sil',
	'from_the' => '-',
	'page_settings' => 'Sayfa ayarları',
	'advanced' => 'Gelişmiş',
	'your_site_has' => 'Sitenizde',
	'visitors_online' => 'ziyaretçi çevrimiçi.',	
	'in_the_last' => 'Son',
	'site_visitors' => 'Site Ziyaretçisi.',
	'page_views' => 'Sayfa Görüntüleme.',
	'spam_attacks' => 'Spam Saldırısı.',
	'last_login_on' => 'Son giriş tarihi:',
	'quick' => 'Faydalı',
	'links' => 'Bağlantılar',
	'new_entry' => 'Yeni ',
	'entry' => 'kaydı.',
	'edit' => 'Düzenle:',
	'page' => 'sayfası.',
	'blog' => 'Blog.',
	'search' => 'Ara',
	'forums' => 'Forumları.',
	'downloads' => 'Dosyaları.',
	'create_backup' => 'Yedekle',
	'button_backup' => 'Veritabanını yedekle',
	'page_type' => 'Sayfa Türü',
	'settings_page_new' => 'Yeni oluştur:',
	'total_records' => 'Toplam kayıt',
	'showing_from_record' => 'Gösterilen:',
	'page(s)' => 'sayfa',
	'help' => 'Yardım',
	'statistics' => 'İstatistikler',
	'help_settings_page_type' => 'Yeni sayfa oluştururken aşağıdaki üç sayfa türünden birini seçebilirsiniz:',
	'help_settings_page_dynamic' => 'Dinamik sayfalara; bloglar ve haberler örnek verilebilir. Bu sayfa türür, RSS beslemeleri ve yorumları destekler.',
	'help_settings_page_static' => 'Statik sayfa, bir blok HTML\'den oluşur (tabii isterseniz PHP). Bu sayfa türü, statik ve sık güncellenmeyen içerik için uygundur.',
	'help_settings_page_module' => 'Modül, sitenize belirli bir içerik ekler. Modüller <a href="http://www.getpixie.co.uk">www.getpixie.co.uk</a> adresinden indirilebilir; örneğin, Events modülü. Modüller, eklentiler ile bir arada da gelebilir.',
	'help_settings_user_type' => 'Yeni kullanıcı oluştururken aşağıdaki üç kullanıcı türünden birini seçebilirsiniz:',
	'help_settings_user_admin' => '<b>Yönetici</b> - Yöneticiler; Pixie\'nin tümüne erişebilirler; ayarları değiştirebilir, içerik ekleyebilir, kısacası istedikleri gibi takılabilirler.',
	'help_settings_user_client' => '<b>Editör</b> - Editörler; Pixie\'ye yalnızca içerik ekleyebilirler; sitenin ayarlarını değiştirmeleri mümkün değildir.',
	'help_settings_user_user' => '<b>Kullanıcı</b> - Kullanıcılar; Pixie\'nin yalnızca anasayfasına erişebilirler; bir profilleri vardır ve site istatistiklerini görebilirler.',
	'install_module' => 'Yeni bir modül veya eklenti yükle',
	'select_module' => 'Aktive etmek istediğiniz modül veya eklentiyi seçin',
	'all_installed' => 'Mevcut tüm modül ve eklentiler; yüklü ve aktif durumda.',

	// system messages
	'error_save_settings' => 'Hata: Ayarlar kaydedilemedi.',
	'ok_save_settings' => 'Yeni ayarlarınız kaydedildi ve uygulandı.',
	'comment_spam' => 'Spam yorum engellendi.',
	'failed_login' => 'Başarısız giriş denemesi.',
	'login_exceeded' => 'Pixie\'ye giriş için maksimum deneme sayısını (3) aştınız, lütfen 24 saat içinde tekrar deneyin.',
	'logins_exceeded' => '3 başarısız giriş denemesi tespit edildi. Pixie bu IP\'yi 24 saat süreliğine engelledi.',
	'ok_login' => 'Kullanıcı ' . $username . ' giriş yaptı.',
	'failed_protected_page' => '404 sayfası silinemedi, muhtemel hack denemesi.',
	'ok_delete_page' => 'Başarıyla silindi:',
	'ok_delete_entry' => 'Kayıt (#' . $delete . ') başarıyla silindi -',
	'failed_delete' => 'Kayıt (#' . $delete . ') silinemedi.',
	'login_missing' => 'Lütfen giriş bilgilerini girin.',
	'login_incorrect' => 'Giriş bilgileriniz hatalı.',
	'forgotten_missing' => 'Geçersiz kullanıcı adı veya e-posta adresi.',
	'forgotten_ok' => 'E-posta adresinize yeni bir şifre gönderildi.',
	'forgotten_log_error' => 'Şifre sıfırlama isteği başarısız oldu.',
	'forgotten_log_ok' => 'Yeni şifre gönderildi: ',
	'rss_access_attempt' => 'Özel RSS beslemesine erişilemedi. Beslemeyi, Pixie içinden, yeniden takip etmeye başlamanız gerekebilir.',
	'unknown_error' => 'Bir şeyler ters gitti. Mümkündür ki (küçük bir olasılık da olsa) veritabanı çöktü ya da yatağın ters tarafından kalktınız.',
	'unknown_edit_url' => 'Bu sayfayı düzenlemek için sunulan URL geçerli değil.',
	'unknown_referrer' => 'Gelinen adres bilinmiyor.',
	'profile_name_error' => 'Lütfen adınızı girin.', 
	'profile_email_error' => 'Lütfen geçerli bir e-posta adresi girin..', 
	'profile_web_error' => 'Lütfen geçerli bir web adresi girin.', 
	'profile_ok' => 'Profiliniz güncellendi.',
	'profile_password_error' => 'Pixie yeni şifrenizi maalesef kaydedemedi. Neden tekrar denemeyesiniz?',
	'profile_password_ok' => 'Pixie şifreniz güncellendi. Sonraki girişinizde, yeni şifrenizi kullanın.',
	'profile_password_invalid' => 'Geçersiz şifre.',
	'profile_password_invalid_length' => 'Şifre en az 6 karakterden oluşmalı.',
	'profile_password_match_error' => 'İki şifre eşleşmedi.',
	'profile_password_missing' => 'Lütfen gerekli tüm bilgileri girin.',
	'site_name_error' => 'Sitenizin bir adı olmalı.',
	'site_url_error' =>  'Lütfen geçerli bir URL girin.',
	'backup_ok' => 'Veritabanı yedeği başarıyla oluşturuldu.',
	'backup_delete_ok' => 'Yedek başarıyla silindi:',
	'backup_delete_no' => 'En güncel yedek silinemez.',
	'backup_delete_error' => 'Pixie, yedeği silemedi.',
	'theme_ok' => 'Tema sitenize uygulandı.',
	'theme_error' => 'Pixie, temanızı uygulayamadı.',
	'all_content_deleted' => 'Tüm içerik silindi:',
	'user_delete_ok' => 'Pixie\'den silindi.',
	'user_delete_error' => 'Kullanıcı silinemedi:',
	'user_name_missing' => 'Lütfen bir kullanıcı adı girin.',
	'user_realname_missing' => 'Lütfen adınızı girin.',
	'user_password_missing' => 'Lütfen bir şifre girin.',
	'user_email_error' => 'Lütfen geçerli bir e-posta adresi girin.',
	'user_update_ok' => 'Yeni ayarlar kaydedildi:',
	'user_duplicate' => 'Bu kullanıcı adı kullanılmaktadır; lütfen başka bir kullanıcı adı girin.',
	'user_new_ok' => 'Yeni kullanıcı oluşturuldu:',
	'saved_new_settings_for' => 'Yeni ayarlar kaydedildi:',
	'file_upload_error' => 'Pixie, veritabanına dosya bilgisini yazamadı; dosyanız buna rağmen yüklenmiş olabilir.',
	'file_upload_tag_error' => 'Lütfen dosyalarınızı yüklerken etiketlediğinize emin olun.',
	'file_delete_ok' => 'Dosya başarıyla silindi:',
	'file_delete_fail' => 'Dosya silinemedi:',
	'form_build_fail' => 'Form oluşturulamadı. Modülünüzde doğru tablo bilgilerini sağladığınızdan emin misiniz?',
	'date_error' => 'Geçersiz bir tarih girdiniz.',
	'email_error' => 'Lütfen geçerli bir e-posta adresi girdiğinizden emin olun.',
	'url_error' => 'Lütfen geçerli bir URL girdiğinizden emin olun.',
	'is_required' => 'doldurulması zorunlu bir alandır.',
	'saved_new' => 'Kaydedildi:',
	'in_the' => '-',
	'on_the' => '-',
	'saved_new_page' => 'Yeni sayfa oluşturuldu:',
	'save_update_entry' => 'Kayda güncellemeler eklendi:',
	'bad_cookie' => 'Oturum zaman aşımına uğradı. Lütfen yeniden giriş yapın.',
	'no_module_selected' => 'Yüklenecek modül ya da eklenti seçmediniz, lütfen tekrar deneyin.',
	'install_module_ok' => 'başarıyla yüklendi.',

	// helper
	'helper_plugin' => 'Eklentilerin ayarlarını değiştiremezsiniz; ancak yukarıdaki butonları kullanarak içeriklerini silebilir veya eklentiyi tamamen kaldırabilirsiniz. Örneğin Comments eklentisini sildiğinizde, ziyaretçileriniz dinamik sayfalara yorum bırakamazlar.',
	'helper_nocontent' => 'Bu sayfada içerik yok; yukarıdaki yeşil butonu kullanarak ilk girişi yapabilirsiniz (yeşil buton Comments eklentisinde mevcut değildir).',
	'helper_nopages' => 'Bir bilge; sayfaları olmayan websitesinin, kanatsız bir kuşa benzediğini söyler... ki doğrudur. Sağdaki formu kullanarak sitenize ilk sayfayı ekleyin. İşte o zaman bu mesaj kaybolacaktır.',
	'helper_nopages404' => 'Sitenizde tek bir sayfa var; o da 404 hata sayfası ve aşağıdan düzenlenebilir.',
	'helper_nopagesadmin' => 'Pixie\'nin <a href="?s=settings">Ayarlar bölümünü kullanarak sayfa ekleyebilirsiniz.</a>', 
	'helper_nopagesuser' => 'Lütfen site yöneticisine ulaşarak siteye sayfa eklemesi gerektiğini belirtin.',
	'helper_search' => 'Hiçbir kayıt bulunamadı. Tekrar aramayı deneyin.', 
	
	// navigation
	'nav1_settings' => 'Ayarlar',
	'nav1_publish' => 'Yayınla',
	'nav1_home' => 'Anasayfa',
	'nav2_home' => 'Anasayfa',
	'nav2_profile' => 'Profil',
	'nav2_security' => 'Şifre',
	'nav2_logs' => 'Loglar',
	'nav2_delete' => 'Hesabı Sil',
	'nav2_pages' => 'Sayfalar',
	'nav2_files' => 'Dosya Yöneticisi',
	'nav2_backup' => 'Yedekleme',
	'nav2_users' => 'Kullanıcılar',
	'nav2_blocks' => 'Bloklar',
	'nav2_theme' => 'Tema',
	'nav2_site' => 'Site',
	'nav2_settings' => 'Ayarlar',

	// forms
	'form_login' => 'Giriş',
	'form_username' => 'Kullanıcı Adı',
	'form_password' => 'Şifre',
	'form_rememberme' => 'Bu bilgisayarda oturumu açık tut?',
	'form_forgotten' => 'Şifremi unuttum?',
	'form_returnto' => 'Geri dön: ',
	'form_help_forgotten' => 'Lütfen Pixie kullanıcı adınızı ya da kayıtlı e-posta adresinizi girin. Şifreniz sıfırlanacak ve size e-posta yoluyla gönderilecektir.',
	'form_resetpassword' => 'Şifreyi Sıfırla',
	'form_name' => 'Ad',
	'form_usernameoremail' => 'Kullanıcı Adı ya da E-posta Adresi',
	'form_telephone' => 'Telefon',
	'form_email' => 'E-posta',
	'form_website' => 'Websitesi',
	'form_occupation' => 'Meslek',
	'form_address_street' => 'Adres',
	'form_address_town' => 'İlçe',
	'form_address_county' => 'İl',
	'form_address_pcode' => 'Posta Kodu',
	'form_address_country' => 'Ülke',
	'form_address_biography' => 'Biografi',
	'form_fl1' => 'Favori Bağlantılar',
	'form_button_save' => 'Kaydet',
	'form_button_update' => 'Güncelle',
	'form_button_cancel' => 'İptal',
	'form_button_install' => 'Yükle',
	'form_button_create_page' => 'Sayfa oluştur',
	'form_current_password' => 'Şu anki şifre',
	'form_new_password' => 'Yeni şifre',
	'form_confirm_password' => 'Yeni şifre tekrar',
	'form_tags' => 'Etiketler',
	'form_content' => 'İçerik',
	'form_comments' => 'Yorumlar',
	'form_public' => 'Genele açık',
	'form_optional'=> '(isteğe bağlı)',
	'form_required'=> '*',
	'form_title'=> 'Başlık',
	'form_posted'=> 'Tarih &amp; Zaman',
	'form_date' => 'Tarih &amp; Zaman',
	'form_help_comments' => 'Ziyaretçiler bu yazıya yorum yapabilsinler mi?',
	'form_help_public' => 'Bu sayfa/yazı genele açık olsun mu? (Taslak olarak kaydetmek için Hayır\'ı seçin.)',
	'form_help_tags' => 'Etiketler, tıpkı kategoriler gibi çalışırlar ve bulunabilirliği arttırırlar. Etiketleri boşluklar ile ayırarak girin.',
	'form_help_current_tags' => 'Öneriler:',
	'form_help_current_blocks' => 'Mevcut Bloklar:',
	'form_php_warning' => '(Bu sayfa PHP içerir. Görsel editör, kodun güvenli düzenlenmesini sağlamak için deaktive edilmiştir.)',
	'form_legend_site_settings' => 'Sitenizin ayarlarını değiştirin',
	'form_site_name' => 'Site Adı',
	'form_help_site_name' => 'Sitenizin adı ne olsun?',
	'form_page_name' => 'Slug/URL',
	'form_help_page_name' => 'Sayfanızın URL\'i çağrılırken kullanılacak. (Örnek: http://www.siteniz.com/<b>sayfa-slug</b>/.)',
	'form_page_display_name' => 'Sayfa Adı',
	'form_help_page_display_name' => 'Sayfanızın adı ne olsun?',
	'form_page_description' => 'Sayfa Tanımı',
	'form_help_page_description' => 'Sayfanızın tanımını yazın.',
	'form_page_blocks' => 'Sayfa Blokları',
	'form_help_page_blocks' => 'Bloklar sayfanızda bulunan ekstra içeriktir. Blok adları boşluk ile ayrılmalıdır (blok özelliği Pixie\'nin gelecek versiyonlarında geliştirilecektir).',
	'form_searchable' => 'Aranabilir',
	'form_help_searchable' => 'Bu sayfanın genele açık aramalarda gözükmesini istiyor musunuz?',
	'form_posts_per_page' => 'Bu sayfadaki kayıtlar',
	'form_help_posts_per_page' => 'Bu sayfada kaç kayıt gözükmesini istiyorsunuz?',
	'form_rss' => 'RSS',
	'form_help_rss' => 'Bu sayfanın içeriğinden RSS beslemesi oluşturulmasını istiyor musunuz?',
	'form_in_navigation' => 'Navigasyona dahil',
	'form_help_in_navigation' => 'Bu sayfanın sitenizin navigasyonunda gözükmesini istiyormusunuz?',
	'form_site_url' => 'Site URL',
	'form_help_site_url' => 'Sitenizin URL\'si nedir? (Örnek: http://www.siteniz.com/dizin-adi/.)',
	'form_site_homepage' => 'Anasayfa',
	'form_help_homepage' => 'Ziyaretçilerinizin ilk olarak hangi sayfayı görmesini istiyorsunuz?',
	'form_site_keywords' => 'Anahtar Kelimeler',
	'form_help_site_keywords' => 'Anahtar kelimeleri, virgül ile ayrılmış şekilde girin (Örnek: bu, site, harika).',
	'form_site_author' => 'Site Sahibi',
	'form_site_copyright' => 'Sitenin Telif Hakkı',
	'form_site_curl' => 'Temiz URL Kullanımı?',
	'form_help_site_curl' => 'Siteniz temiz URL\'ler kullanmasını istiyor musunuz? Temiz URL\'ler, www.siteniz.com/?s=temiz aksine, www.siteniz.com/temiz/ şeklinde görünür. Temiz URL\'ler yalnızca Linux sunucularda çalışmaktadır.',
	'form_legend_pixie_settings' => 'Pixie\'nin nasıl davrandığını değiştirin',
	'form_pixie_language' => 'Dil',
	'form_help_pixie_language' => 'Kullanmak istediğiniz dili seçin.',
	'form_pixie_timezone' => 'Zaman Dilimi',
	'form_help_pixie_timezone' => 'Pixie\'nin doğru zamanı göstermesi için bulunduğunuz zaman dilimini seçin.',
	'form_pixie_dst' => 'Yaz/Kış Saati',
	'form_help_pixie_dst' => 'Pixie\'nin yaz/kış saat ayarlarını otomatik yapmasını istiyor musunuz?',
	'form_pixie_date' => 'Tarih &amp; Saat',
	'form_help_pixie_date' => 'Tercih edeceğiniz tarih ve saat biçimini seçin.',
	'form_pixie_rte' => 'Görsel Editör',
	'form_help_pixie_rte' => 'Ckeditor görsel editörünü kullanmak istiyor musunuz? (Sitenizi düzenlemeyi oldukça kolaylaştırır.)',
	'form_pixie_logs' => 'Log Zaman Aşımı',
	'form_help_pixie_logs' => 'Log dosyalarının kaç gün &amp;sonra temizlenmesini istiyorsunuz?',
	'form_pixie_sysmess' => 'Sistem Mesajı',
	'form_help_pixie_sysmess' => 'Bu mesaj, Pixie\'ye giriş yapan  her kullanıcıya gösterilecektir.',
	'form_help_settings_page_type' => 'Ne tür bir sayfa oluşturmak istiyorsunuz?',
	'form_legend_user_settings' => 'Kullanıcı Ayarları',
	'form_user_username' => 'Kullanıcı Adı',
	'form_help_user_username' => 'Kullanıcı adlarında boşluk kullanılamaz.',
	'form_user_realname' => 'İsim',
	'form_help_user_realname' => 'Lütfen tam isminizi girin.',
	'form_user_permissions' => 'Yetkiler',
	'form_help_user_permissions' => 'Bu kullanıcının hangi yetkilere sahip olmasını istiyorsunuz?',
	'form_help_user_permissions_block' => 'Kullanıcının hangi tip olmasını istiyorsunuz?',
	'form_button_create_user' => 'Kullanıcı oluştur',
	'form_upload_file' => 'Dosya',
	'form_help_upload_file' => 'Bilgisayarınızdan yükleyeceğiniz bir dosya seçin.',
	'form_help_upload_tags' => 'Etiketleri boşluk ile ayrılır.',
	'form_upload_replace_files' => 'Üstüne yaz', 
	'form_help_upload_replace_files' => 'Var olan bir dosyayı değiştirmek mi istiyorsunuz?',
	'form_search_words' => 'Anahtar Kelimeler',
	'form_privs' => 'Sayfa Yetkileri',
	'form_help_privs' => 'Bu sayfayı kimlerin düzenleyebilmesini istiyorsunuz?',
	
	//email
	'email_newpassword_subject' => 'Pixie (' . str_replace('http://', "", $site_url) . ') - Yeni şifreniz',
	'email_changepassword_subject' => 'Pixie (' . str_replace('http://', "", $site_url) . ') - Değiştirilen şifreniz',
	'email_newpassword_message' => 'Yeni şifreniz: ',
	'email_account_close_message' => '' . $site_url . ' adresindeki Pixie hesabınız kapatılmıştır. Daha fazla bilgi için site yöneticisine ulaşabilirsiniz.',
	'email_account_close_subject' => 'Pixie (' . str_replace('http://', "", $site_url) . ') - Hesap kapatıldı',
	'email_account_edit_subject' =>	'Pixie (' . str_replace('http://', "", $site_url) . ') - Hesabınız hakkında önemli bilgi',
	'email_account_new_subject' => 'Pixie (' . str_replace('http://', "", $site_url) . ') - Yeni hesap',
	
	//front end
	'continue_reading' => 'Devam...',
	'permalink' => 'Kalıcı Bağlantı',
	'theme' => 'Tema',
	'navigation' => 'Navigasyon',
	'skip_to_content' => 'İçeriğe git &raquo;',
	'skip_to_nav' => 'Navigasyona git &raquo;',
	'by' => '-',
	'on' => '-',
	'view' => 'Bak:',
	'profile' => 'profil',
	'all_posts_tagged' => 'etiketlenmiş tüm kayıtlar',
	'permalink_to' => 'Kalıcı Bağlantı:',
	'comments' => 'Yorum',
	'comment' => 'Yorum',
	'no_comments' => 'Henüz yorum yapılmadı...',
	'comment_closed' => 'Yoruma kapatılmıştır.',
	'comment_thanks' => 'Yorumunuz için teşekkürler.',
	'comment_leave' => 'Yorum bırakın',
	'comment_form_info' => '<a href="http://gravatar.com" title="Bir Gravatar edinin">Gravatar</a> ve <a href="http://www.cocomment.com" title="Yorumlarınızı takip edin &amp; paylaşın">coComment</a>, yorum formunda kullanılabilir.',
	'comment_name' => 'İsim',
	'comment_email' => 'E-posta',
	'comment_web' => 'Websitesi',
	'comment_button_leave' => 'Yorum Gönder',
	'comment_name_error' => 'Lütfen isminizi yazın.',
	'comment_email_error' => 'Lütfen geçerli bir e-posta adresi yazın.',
	'comment_web_error' => 'Lütfen geçerli bir websitesi adresi yazın.',
	'comment_throttle_error' => 'Çok sık yorum yapıyorsunuz, yavaşlayın biraz.',
	'comment_comment_error' => 'Lütfen yorum yapın.',	
	'comment_save_log' => 'yorum tarihi: ',
	'tagged' => 'Etiket:',
	'tag' => 'Etiket',
	'popular' => 'En popüler',
	'archives' => 'Arşiv',
	'posts' => 'yazılar',
	'last_updated' => 'Son güncelleme',
	'edit_post' => 'Bu yazıyı düzenleyin',
	'edit_page' => 'Bu sayfayı düzenleyin',
	'popular_posts' => 'Popüler Yazılar',
	'next_post' => 'Sıradaki yazı',
	'next_page' => 'Sıradaki sayfa',
	'previous_post' => 'Önceki yazı',
	'previous_page' => 'Önceki sayfa',
	'dynamic_page' => 'Sayfa'
);
?>
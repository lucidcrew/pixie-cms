<?php
if (!defined('DIRECT_ACCESS')) {
	header('Location: ../../');
	exit();
}
/**
 * Pixie: The Small, Simple, Site Maker.
 * 
 * Licence: GNU General Public License v3
 * Copyright (C) 2010, Scott Evans
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see http://www.gnu.org/licenses/
 *
 * Title: File di lingua (Italiano IT)
 *
 * @package Pixie
 * @copyright 2008-2010 Scott Evans
 * @author Scott Evans
 * @author Sam Collett
 * @author Tony White
 * @author Isa Worcs
 * @author di Reé Querin - www.q-design.it
 * @link http://www.getpixie.co.uk
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3
 *
 */
if (!isset($delete)) {
	$delete = NULL;
}
if (!isset($username)) {
	$username = NULL;
}
if (!isset($uname)) {
	$uname = NULL;
}
if (!isset($password)) {
	$password = NULL;
}
if (!isset($table_name)) {
	$table_name = NULL;
}
if (!isset($site_url)) {
	$site_url = NULL;
}
$lang = array(
	// system
	'skip_to' => 'Vai al contenuto',
	'view_site' => 'Visualizza sito',
	'logout' => 'Esci',
	'license' => 'Rilasciato in base a',
	'tag_line' => 'Il piccolo e semplice creatore di siti',
	'latest_referrals' => 'Ultimi referenti',
	'latest_activity' => 'Ultime attività',
	'feed_subscribe' => 'Sottoscrivi',
	'rss_feed' => 'RSS Feed',
	'when' => 'Quando?',
	'who' => 'Chi?',
	'what' => 'Cosa?',
	'from' => 'Da dove?',
	'switch_to' => 'Passa a',
	'a_few_seconds' => 'Pochi secondi',
	'a_minute' => '1 minuto',
	'minutes' => 'minuti',
	'a_hour' => '1 ora',
	'hours' => 'ore',
	'a_day' => '1 giorno',
	'days' => 'giorni',
	'ago' => 'fa.',
	'user' => 'Utente',
	'to' => 'a',
	'database_backup' => 'Copia database',
	'database_info' => 'Assicurati che il tuo database sia copiato frequentemente. Utilizza il pulsante a destra per salvare manualmente i dati. Le copie del database sono salvate nella cartella files/sqlbackups/ e possono essere scaricati dalla lista sottostante. Il salvataggio più recente è evidenziato.',
	'database_backups' => 'Copie',
	'download' => 'Scarica',
	'delete' => 'Elimina',
	'delete_file' => 'Eliminare il file?',
	'theme_info' => 'I temi attualmente installati sono indicati qui sotto. Puoi aggiungere altri temi caricando i file all’interno della cartella admin/themes. Altri temi possono essere scaricati da <a href="http://www.getpixie.co.uk">www.getpixie.co.uk</a> oppure puoi crearlo tu stesso utilizzando i CSS. Il tema attualmente in uso è evidenziato.',
	'theme_pick' => 'Scegli un tema per il tuo sito',
	'theme_apply' => 'Applica questo tema',
	'sure_delete_page' => 'Sei sicuro di voler eliminare',
	'sure_empty_page' => 'Sei sicuro di voler vuotare',
	'settings_page' => 'pagina',
	'settings_plugin' => 'plugin',
	'plugins' => 'Plugin',
	'plugins_info' => 'I plugins forniscono funzionalità aggiuntive ad alcune pagine del sito.',
	'empty' => 'Azzera',
	'oops' => 'Ooops!',
	'feature_disabled' => 'Questa funzionalità non è attualmente funzionate. Contiamo di renderla attiva nella prossima versione di Pixie!',
	'pages_in_navigation' => 'Pagine nella barra di navigazione',
	'pages_in_navigation_info' => 'Queste pagine compaiono nella barra di navigazione del sito. Per modificarne l’ordine, spostale per mezzo delle frecce. La pagina in cima all’elenco sarà la prima nella barra di navigazione.',
	'pages_outside_navigation' => 'Pagine escluse dalla barra di navigazione',
	'pages_outside_navigation_info' => 'Queste pagine sono visibili agli utenti, ma non compaiono nella barra di navigazione del sito.',
	'pages_disabled' => 'Disabilita pagine',
	'pages_disabled_info' => 'Queste pagine non sono visibili.',
	'edit_user' => 'Modifica utete',
	'create_user' => 'Crea un nuovo utente',
	'create_user_info' => 'Un’e-mail verrà inviata al nuovo utente con i dettagli per la connessione. La password sarà generata in maniera casuale.',
	'user_info' => 'Qui sotto l’elenco degli utenti con accesso a Pixie. Puoi aggiungere altri utenti utilizzando il modulo a destra. I "super utenti", con possibilità di agire sull’aspetto di Pixie, sono evidenziati.',
	'user_delete_confirm' => 'Sei sicuro di voler eliminare questo utente:',
	'tags' => 'Etichette',
	'upload' => 'Caricamento',
	'file_manager_info' => 'La dimensione massima del file da caricare è 100Mb. Il caricamento di file molto grandi può impiegare molto tempo. Sii paziente!',
	'file_manager_latest' => 'Ultimi caricamenti',
	'file_manager_tagged' => 'Tutti i file etichettati:',
	'filename' => 'Nome file',
	'filedate' => 'Data modifica',
	'results_from' => 'Risultati da',
	'sure_delete_entry' => 'Elimina voce',
	'from_the' => 'da',
	'page_settings' => 'Impostazioni pagina',
	'advanced' => 'Avanzato',
	'your_site_has' => 'Il tuo sito ha',
	'visitors_online' => 'visitatori in linea.',
	'in_the_last' => 'Nell’ultimo',
	'site_visitors' => 'Visitatori sito.',
	'page_views' => 'Pagine visualizzate.',
	'spam_attacks' => 'Attacchi Spam',
	'last_login_on' => 'Ultimo collegamento:',
	'quick' => 'Veloce',
	'links' => 'Link',
	'new_entry' => 'Aggiungi nuovo ',
	'entry' => 'articolo.',
	'edit' => 'Modifica ',
	'page' => 'pagina.',
	'blog' => 'Blog.',
	'search' => 'Ricerca',
	'forums' => 'Forum.',
	'downloads' => 'Download.',
	'create_backup' => 'Crea Backup',
	'button_backup' => 'Copia il database',
	'page_type' => 'Tipo di pagina',
	'settings_page_new' => 'Crea un nuovo',
	'total_records' => 'Elementi totali',
	'showing_from_record' => 'visualizzo da',
	'page(s)' => 'pagina/e',
	'help' => 'Aiuto',
	'statistics' => 'Statistiche',
	'help_settings_page_type' => 'Quando crei una nuova pagina puoi scegliere fra tre diverse tipologie:',
	'help_settings_page_dynamic' => 'Esempi di pagine dinamiche sono i blog e le pagine di notizie. Queste pagine supportano i feed RSS e i commenti.',
	'help_settings_page_static' => 'Una pagina statica è semplicemente un blocco di HTML (e di PHP, se preferisci). Queste pagine solitamente sono statiche e raramente modificano il proprio contenuto.',
	'help_settings_page_module' => 'Una pagina a moduli (module page) aggiunge contenuti specifici al tuo sito. I moduli aggiuntivi possono essere scaricati da <a href="http://www.getpixie.co.uk">www.getpixie.co.uk</a>. Un esempio di pagina a moduli è quella degli eventi. I moduli a volte vengono forniti insieme ai plugin.',
	'help_settings_user_type' => 'Quando aggiungi un nuovo utente, puoi scegliere fra tre diverse tipologie:',
	'help_settings_user_admin' => '<b>Amministratore</b> - Gli Amministratori hanno accesso ad ogni aspetto di Pixie, possono modificare le impostazioni, scrivere articoli e agire con pieni poteri.',
	'help_settings_user_client' => '<b>Cliente</b> - Un Cliente può solo aggiungere contenuti a Pixie. Non hanno accesso al pannello delle impostazioni di questo sito.',
	'help_settings_user_user' => '<b>Utente</b> - Un Utente può solamente accedere alla Bacheca (Dashboard), possiedono un proprio profilo e possono visualizzare le statistiche del sito.',
	'install_module' => 'Installa un nuovo modulo od un plugin',
	'select_module' => 'Seleziona il modulo o il plugin che desideri attivare',
	'all_installed' => 'Tutti i moduli ed i plugin sono attualmente attivi ed installati.',
	// system messages
	'error_save_settings' => 'Errore nel salvataggio delle impostazioni.',
	'ok_save_settings' => 'Le nuove impostazioni sono state salvate ed applicate al sito.',
	'comment_spam' => 'Bloccato commento con spam.',
	'failed_login' => 'Tentativo di accesso fallito.',
	'login_exceeded' => 'Hai superato il numero di tentativi ammessi (3) per accere all’area di amministrazione, per favore riprova tra 24 ore.',
	'logins_exceeded' => 'Tre tentativi di accesso sono falliti. Il sistema ha bloccato questo IP per 24 ore.',
	'ok_login' => 'Accesso utente ' . $username . ' avvenuto.',
	'failed_protected_page' => 'Impossibile eliminare la pagina 404, possibile tentativo di corruzione.',
	'ok_delete_page' => 'Avvenuta eliminazione di',
	'ok_delete_entry' => 'Avvenuta eliminazione di (#' . $delete . ') dal',
	'failed_delete' => 'Impossibile eliminare l’elemento (#' . $delete . ').',
	'login_missing' => 'Per favore inserisci le richieste informazioni per l’accesso.',
	'login_incorrect' => 'I dati inseriti non sono corretti.',
	'forgotten_missing' => 'Non hai inserito un nome utente o un’e-mail corretta.',
	'forgotten_ok' => 'Una nuova password è stata inviata al tuo indirizzo e-mail.',
	'forgotten_log_error' => 'Tentativo fallito di azzerare la password.',
	'forgotten_log_ok' => 'Una nuova password è stata inviata a ',
	'rss_access_attempt' => 'Tentativo non autorizzato di accedere ad un feed Rss privato. Dovresti provare a sottoscrivere nuovamente il feed dal sito.',
	'unknown_error' => 'Qualcosa non funziona correttamente. Probabilente, ma non è certo, il database si è scollegato oppure ti sei svegliato con il piede sbagliato?',
	'unknown_edit_url' => 'L’indirizzo fornito per modificare questa pagina non è valido.',
	'unknown_referrer' => 'Referrer sconosciuto.',
	'profile_name_error' => 'Per favore inserisci il tuo nome completo.',
	'profile_email_error' => 'Per favore inserisci un indirizzo e-mail valido.',
	'profile_web_error' => 'Per favore inserisci l’indirizzo Internet.',
	'profile_ok' => 'Il tuo profilo è stato aggiornato.',
	'profile_password_error' => 'Pixie non ha potuto salvare la tua password. Vuoi provare ancora?',
	'profile_password_ok' => 'La tua password è stata aggiornata. Dovrai utilizzarla al prossimo accesso.',
	'profile_password_invalid' => 'Non hai inserito correttamente la password attuale.',
	'profile_password_invalid_length' => 'La password deve avere almeno 6 caratteri.',
	'profile_password_match_error' => 'Le password inserite non sono identiche.',
	'profile_password_missing' => 'Per favore fornite tutte le informazioni richieste.',
	'site_name_error' => 'Il tuo sito necessita di un nome.',
	'site_url_error' => 'Per favore inserisci un valido indirizzo Internet.',
	'backup_ok' => 'Database duplicato con successo.',
	'backup_delete_ok' => 'Backup eliminato con successo:',
	'backup_delete_no' => 'Non puoi eliminare il backup più recente.',
	'backup_delete_error' => 'Pixie non ha potuto eliminare il backup.',
	'theme_ok' => 'Il tema è stato applicato al tuo sito.',
	'theme_error' => 'Pixie wnon ha potuto cabiare il tema del sito.',
	'all_content_deleted' => 'Tutto il contenuto è stato cancellato dal',
	'user_delete_ok' => 'è stato cancellato da Pixie.',
	'user_delete_error' => 'Non posso cancellare l’utente',
	'user_name_missing' => 'Per favore inserisci un nome utente.',
	'user_realname_missing' => 'Per favore inserisci un nome.',
	'user_password_missing' => 'Per favore inserisci una password.',
	'user_email_error' => 'Per favore inserisci un valido indirizzo e-mail.',
	'user_update_ok' => 'Salvate le nuove impostazioni per',
	'user_duplicate' => 'Esiste già un utente con lo stesso nome, utilizzane un altro.',
	'user_new_ok' => 'Nuovo utente creato:',
	'saved_new_settings_for' => 'Salvate le nuove impostazioni per il',
	'file_upload_error' => 'Pixie ha riscontrato un problema inserendo le informazioni relative al file nel database, il file potrebbe essere ancora caricato online.',
	'file_upload_tag_error' => 'Assicurati di aver inserito l’etichetta per i tuoi caricamenti.',
	'file_delete_ok' => 'File cancellato con successo:',
	'file_delete_fail' => 'Pixie non ha potuto eliminare il file:',
	'form_build_fail' => 'Non riesco a costruire un modulo editabile... hai inserito le informazioni corrette nel modulo?',
	'date_error' => 'Non hai fornito una data corretta.',
	'email_error' => 'Per favore assicurati di aver inserito un indirizzo e-mail valido.',
	'url_error' => 'Per favore assicurati di aver inserito un indirizzo Internet valido.',
	'is_required' => 'è un campo obbligatorio.',
	'saved_new' => 'Nuovo articolo salvato',
	'in_the' => 'nel',
	'on_the' => 'sul',
	'saved_new_page' => 'Creata uova pagina',
	'save_update_entry' => 'Salvati gli aggiornamenti all’articolo',
	'bad_cookie' => 'I tuoi cookies sono scomparsi. Devi collegarti nuovamente.',
	'no_module_selected' => 'Non hai selezionato un modulo o un plugin da installare. Prova di nuovo.',
	'install_module_ok' => 'è stato installato con successo.',
	// helper
	'helper_plugin' => 'Non sei abilitato a modificare le impostazioni dei plugin, ma puoi eliminare i dati di un plugin o rimuoverlo utilizzando i pulsati qui sopra. Se elimini un plugin, ad esempio quello dei commenti, i visitatori non potranno lasciare commenti sulle pagine dinamiche.',
	'helper_nocontent' => 'Questa pagina non ha alcun contenuto. Utilizza il pulsante verde qui sopra per aggiungere un argomento (il pulsante verde non viene mostrato nella pagina dei Commenti).',
	'helper_nopages' => 'Un uomo sagio una volta disse che un sito internet senza pagine è come un uccello senza ali... non va da nessuna parte. Utilizza il modulo a destra per aggiungere la prima pagina del tuo sito. Una volta creata la pagina, questo messaggio non sarà più mostrata.',
	'helper_nopages404' => 'Il tuo sito ha solamente una pagina, quella di errore (404 - per i file non trovati), e puoi modificarla.',
	'helper_nopagesadmin' => 'Puoi <a href="?s=settings">aggiungere altre pagine</a> nella sezione relativa di Pixie.',
	'helper_nopagesuser' => 'Contatta un amministratore e chiedigli di aggiungere altre pagine al tuo sito internet.',
	'helper_search' => 'Nessun articolo trovato. Prova a cercare di nuovo.',
	// navigation
	'nav1_settings' => 'Impostazioni',
	'nav1_publish' => 'Pubblica',
	'nav1_home' => 'Bacheca',
	'nav2_home' => 'Home',
	'nav2_profile' => 'Profilo',
	'nav2_security' => 'Password',
	'nav2_logs' => 'Logs',
	'nav2_delete' => 'Elimina Account',
	'nav2_pages' => 'Pagine',
	'nav2_files' => 'File Manager',
	'nav2_backup' => 'Backup',
	'nav2_users' => 'Utenti',
	'nav2_blocks' => 'Blocchi',
	'nav2_theme' => 'Tema',
	'nav2_site' => 'Sito',
	'nav2_settings' => 'Impostazioni',
	// forms
	'form_login' => 'Accesso',
	'form_username' => 'Nome utente',
	'form_password' => 'Password',
	'form_rememberme' => 'Resto collegato su questo computer?',
	'form_forgotten' => 'Password smarrita?',
	'form_returnto' => 'Ritorna a ',
	'form_help_forgotten' => 'Per favore inserisci la tua e-mail o il nome utente. Verrà creata una nuova password e sarà spedita via e-mail.',
	'form_resetpassword' => 'Cambia password',
	'form_name' => 'Nome completo',
	'form_usernameoremail' => 'Nome utente o indirizzo e-mail',
	'form_telephone' => 'Telefono',
	'form_email' => 'E-mail',
	'form_website' => 'Sito Internet',
	'form_occupation' => 'Occupazione',
	'form_address_street' => 'Indirizzo',
	'form_address_town' => 'Città',
	'form_address_county' => 'Provincia',
	'form_address_pcode' => 'Codice avviamento postale',
	'form_address_country' => 'Paese',
	'form_address_biography' => 'Biografia',
	'form_fl1' => 'Siti preferiti',
	'form_button_save' => 'Salva',
	'form_button_update' => 'Aggiorna',
	'form_button_cancel' => 'Annulla',
	'form_button_install' => 'Installa',
	'form_button_create_page' => 'Crea pagina',
	'form_current_password' => 'Password attuale',
	'form_new_password' => 'Nuova Password',
	'form_confirm_password' => 'Conferma Password',
	'form_tags' => 'Etichette',
	'form_content' => 'Contenuto',
	'form_comments' => 'Commenti',
	'form_public' => 'Pubblico',
	'form_optional' => '(facoltativo)',
	'form_required' => '*',
	'form_title' => 'Titolo',
	'form_posted' => 'Data &amp; Ora',
	'form_date' => 'Data &amp; Ora',
	'form_help_comments' => 'Vuoi permettere agli utenti di commentare questo articolo?',
	'form_help_public' => 'Vuoi rendere questo articolo/pagina visibile a tutti gli utenti? (seleziona No se vuoi salvare una bozza).',
	'form_help_tags' => 'Le etichette funzionano come categorie e rendono le cose più facili da trovare. Inserisci le parole chiave separate da spazi.',
	'form_help_current_tags' => 'Suggerimenti:',
	'form_help_current_blocks' => 'Blocchi disponibili:',
	'form_php_warning' => '(Questa pagina contiene codice PHP. L’editor di testo è stato disattivato per permettere la modifica sicura di questo codice avanzato)',
	'form_legend_site_settings' => 'Sistema le impostazioni del tuo sito',
	'form_site_name' => 'Nome Sito',
	'form_help_site_name' => 'Come vorresti fosse chiamato il tuo sito?',
	'form_page_name' => 'Slug/URL',
	'form_help_page_name' => 'Questo verrà utilizzato per creare l’indirizzo della tua pagina (esempio http://www.tuosito.it/<b>pagina</b>/).',
	'form_page_display_name' => 'Nome della pagina (titolo)',
	'form_help_page_display_name' => 'Come vorresti chiamare questa pagina?',
	'form_page_description' => 'Descrizione della pagina',
	'form_help_page_description' => 'Scrivi una descrizione della pagina.',
	'form_page_blocks' => 'Blocchi pagina (Blocks)',
	'form_help_page_blocks' => 'I blocchi sono contenuti aggiuntivi che vengono mostrati nella tua pagina. I nomi dei blocchi dovrebbero venire separati da spazi. (Una migliore gestione dei blocchi verrà implementata nelle future versioni di Pixie).',
	'form_searchable' => 'Ricerca',
	'form_help_searchable' => 'Vuoi che questa pagina compaia nei risultati delle ricerche?',
	'form_posts_per_page' => 'Articoli in questa pagina',
	'form_help_posts_per_page' => 'Quanti elementi vuoi mostrare in questa pagina?',
	'form_rss' => 'RSS',
	'form_help_rss' => 'Vuoi che questa pagina generi un feed RSS?',
	'form_in_navigation' => 'In Navigazione',
	'form_help_in_navigation' => 'Vuoi che questa pagina venga mostrata nel menu del sito?',
	'form_site_url' => 'URL sito Internet',
	'form_help_site_url' => 'Qual è l’URL del tuo sito? (ad esempio http://www.tuosito.it/cartella/).',
	'form_site_homepage' => 'Homepage',
	'form_help_homepage' => 'Quale pagina desideri mostrare come principale?',
	'form_site_keywords' => 'Parole chiave',
	'form_help_site_keywords' => 'Scrivi una lista di parole chiave, separate da virgole (esempio questo, sito, domina).',
	'form_site_author' => 'Autore sito',
	'form_site_copyright' => 'Copyright sito',
	'form_site_curl' => 'URL puliti?',
	'form_help_site_curl' => 'Desideri utilizzare URL puliti? Un URL pulito sarà scritto come www.tuosito.it/pulito/ invece che www.tuosito.it?s=pulito. Funziona solamente con hosting Linux.',
	'form_legend_pixie_settings' => 'Modifica il comportamento di Pixie',
	'form_pixie_language' => 'Linguaggio',
	'form_help_pixie_language' => 'Seleziona il linguaggio da utilizzare.',
	'form_pixie_timezone' => 'Fuso Orario',
	'form_help_pixie_timezone' => 'Seleziona la tua Time Zone, così Pixie mostrerà correttamente gli orari.',
	'form_pixie_dst' => 'Ora Legale',
	'form_help_pixie_dst' => 'Vuoi modificare automaticamente l’orario per adattarlo all’ora legale?',
	'form_pixie_date' => 'Data &amp; Ora',
	'form_help_pixie_date' => 'Seleziona il formato preferito per data e ora.',
	'form_pixie_rte' => 'Editor Testo Avanzato',
	'form_help_pixie_rte' => 'Desideri utilizzare l’editor di testo Ckeditor? (Rende semplice l’inserimento del testo ma non viene supportato correttamente da tutti i browser).',
	'form_pixie_logs' => 'Scadenza sessione',
	'form_help_pixie_logs' => 'Dopo quanti giorni desideri eliminare i file di collegamento?',
	'form_pixie_sysmess' => 'Messaggio di Sistema',
	'form_help_pixie_sysmess' => 'Questo messaggio verrà mostrato ad ogni utente quando accede a Pixie.',
	'form_help_settings_page_type' => 'Che genere di pagina desideri creare?',
	'form_legend_user_settings' => 'Impostazioni utente',
	'form_user_username' => 'Nome utente',
	'form_help_user_username' => 'Il nome utente non può contenere spazi.',
	'form_user_realname' => 'Nome completo',
	'form_help_user_realname' => 'Inserire il nome comleto.',
	'form_user_permissions' => 'Permessi',
	'form_help_user_permissions' => 'Quale permessi vuoi fornire a questo utente?',
	'form_help_user_permissions_block' => 'Che genere di utente sarà?',
	'form_button_create_user' => 'Crea utente',
	'form_upload_file' => 'File',
	'form_help_upload_file' => 'Seleziona sul tuo computer il file da caricare.',
	'form_help_upload_tags' => 'Parole chiave separate da spazi.',
	'form_upload_replace_files' => 'Sostituisco un file?',
	'form_help_upload_replace_files' => 'Stai cercando di sostituire un file esistente?',
	'form_search_words' => 'Parole chiave',
	'form_privs' => 'Permessi Pagina',
	'form_help_privs' => 'Chi potrà modificare questa pagina?',
	//email
	'email_newpassword_subject' => 'Pixie (' . str_replace('http://', "", $site_url) . ') - Nuova password',
	'email_changepassword_subject' => 'Pixie (' . str_replace('http://', "", $site_url) . ') - Password modificata',
	'email_newpassword_message' => 'Ecco la tua password da utilizzare per accedere al sito: ',
	'email_account_close_message' => 'L’account è stato chiuso @ ' . $site_url . '. Per favore contatta l’amministratore del sito per maggiori informazioni.',
	'email_account_close_subject' => 'Pixie (' . str_replace('http://', "", $site_url) . ') - Account chiuso',
	'email_account_edit_subject' => 'Pixie (' . str_replace('http://', "", $site_url) . ') - Informazione importante riguardo il tuo account',
	'email_account_new_subject' => 'Pixie (' . str_replace('http://', "", $site_url) . ') - Nuovo account',
	//front end
	'continue_reading' => 'Continua a leggere',
	'permalink' => 'Permalink',
	'theme' => 'Tama',
	'navigation' => 'Navigazione',
	'skip_to_content' => 'Vai al contenuto &raquo;',
	'skip_to_nav' => 'Vai al menu &raquo;',
	'by' => 'Di',
	'on' => 'in',
	'view' => 'Visualizza',
	'profile' => 'profilo',
	'all_posts_tagged' => 'tutti gli articoli con etichetta',
	'permalink_to' => 'Link permanente a',
	'comments' => 'Commenti',
	'comment' => 'Commento',
	'no_comments' => 'Ancora nessun commento...',
	'comment_closed' => 'Commenti chiusi.',
	'comment_thanks' => 'Grazie per il tuo commento.',
	'comment_leave' => 'Lascia un commento',
	'comment_form_info' => 'Il modulo di commento supporta <a href="http://gravatar.com" title="Ottieni un Gravatar">Gravatar</a> e <a href="http://www.cocomment.com" title="Traccia e condividi i commenti">coComment</a>.',
	'comment_name' => 'Nome',
	'comment_email' => 'E-mail',
	'comment_web' => 'Sito Internet',
	'comment_button_leave' => 'Invia il commento',
	'comment_name_error' => 'Per favore inserisci il nome.',
	'comment_email_error' => 'Per favore inserisci un indirizzo e-mail valido.',
	'comment_web_error' => 'Per favore inserisci un sito Internet valido.',
	'comment_throttle_error' => 'Stai postando commenti troppo in fretta, rallentare.',
	'comment_comment_error' => 'Per favore lascia il tuo commento.',
	'comment_save_log' => 'Commento su: ',
	'tagged' => 'Etichette',
	'tag' => 'Etichetta',
	'popular' => 'Più popolare',
	'archives' => 'Archivi',
	'posts' => 'articoli',
	'last_updated' => 'Ultimo aggiornamento',
	'edit_post' => 'Modifica questo articolo',
	'edit_page' => 'Modifica questa pagina',
	'popular_posts' => 'Articoli più popolari',
	'next_post' => 'Articolo successivo',
	'next_page' => 'Pagina seguente',
	'previous_post' => 'Articolo precedente',
	'previous_page' => 'Pagina precedente',
	'dynamic_page' => 'Pagina',
	'user_name_dup' => 'Errore di salvataggio del nuovo ' . $table_name . ' Registrazione. Possibile il nome utente duplicato.',
	'user_name_save_ok' => 'Saved nuovo utente ' . $uname . ', una password temporanea è stato creato (<b>' . $password . '</b>).',
	'file_del_filemanager_fail' => 'Elimina file non riuscita. Si prega di eliminare il file manualmente.',
	'upload_filemanager_fail' => 'Caricamento non riuscito. Si prega di verificare che la cartella è scrivibile ed ha le autorizzazioni corrette set.',
	'filemanager_max_upload' => 'Il server host accetterà upload per la dimensione massima del file di : ',
	'ck_select_file' => 'Fare clic su un file con nome per creare un collegamento.',
	'ck_toggle_advanced' => 'Toggle advanced Mode'
);
?>
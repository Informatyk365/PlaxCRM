<?php

//  define('SHOW_VARIABLES', 1);
//  define('DEBUG_LEVEL', 1);

//  error_reporting(E_ALL ^ E_NOTICE);
//  ini_set('display_errors', 'On');

set_include_path('.' . PATH_SEPARATOR . get_include_path());


include_once dirname(__FILE__) . '/' . 'components/utils/system_utils.php';
include_once dirname(__FILE__) . '/' . 'components/mail/mailer.php';
include_once dirname(__FILE__) . '/' . 'components/mail/phpmailer_based_mailer.php';
require_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';

//  SystemUtils::DisableMagicQuotesRuntime();

SystemUtils::SetTimeZoneIfNeed('Europe/Belgrade');

function GetGlobalConnectionOptions()
{
    return
        array(
          'server' => 'localhost',
          'port' => '3306',
          'username' => 'p529437_root',
          'password' => 'test12345',
          'database' => 'p529437_plax_crm',
          'client_encoding' => 'utf8'
        );
}

function HasAdminPage()
{
    return false;
}

function HasHomePage()
{
    return true;
}

function GetHomeURL()
{
    return 'index.php';
}

function GetHomePageBanner()
{
    return '';
}

function GetPageGroups()
{
    $result = array();
    $result[] = array('caption' => 'Default', 'description' => '');
    return $result;
}

function GetPageInfos()
{
    $result = array();
    $result[] = array('caption' => 'Działania', 'short_caption' => 'Dzialania', 'filename' => 'dzialania.php', 'name' => 'dzialania', 'group_name' => 'Default', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Działanie-Użytkownik-Kontakt', 'short_caption' => 'Dzialanie Uzytkownik Kontakt', 'filename' => 'dzialanie_uzytkownik_kontakt.php', 'name' => 'dzialanie_uzytkownik_kontakt', 'group_name' => 'Default', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Firmy', 'short_caption' => 'Firmy', 'filename' => 'firmy.php', 'name' => 'firmy', 'group_name' => 'Default', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Kontakty', 'short_caption' => 'Kontakty', 'filename' => 'kontakty.php', 'name' => 'kontakty', 'group_name' => 'Default', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Kontakt-Firma', 'short_caption' => 'Kontakt Firma', 'filename' => 'kontakt_firma.php', 'name' => 'kontakt_firma', 'group_name' => 'Default', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Notatka-Użytkownik', 'short_caption' => 'Notatka Uzytkownik', 'filename' => 'notatka_uzytkownik.php', 'name' => 'notatka_uzytkownik', 'group_name' => 'Default', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Notatki', 'short_caption' => 'Notatki', 'filename' => 'notatki.php', 'name' => 'notatki', 'group_name' => 'Default', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Umowa-Użytkownik-Kontakt', 'short_caption' => 'Umowa Uzytkownik Kontakt', 'filename' => 'umowa_uzytkownik_kontakt.php', 'name' => 'umowa_uzytkownik_kontakt', 'group_name' => 'Default', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Umowy', 'short_caption' => 'Umowy', 'filename' => 'umowy.php', 'name' => 'umowy', 'group_name' => 'Default', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Użytkownicy', 'short_caption' => 'Uzytkownicy', 'filename' => 'uzytkownicy.php', 'name' => 'uzytkownicy', 'group_name' => 'Default', 'add_separator' => false, 'description' => '');
    return $result;
}

function GetPagesHeader()
{
    return
        '';
}

function GetPagesFooter()
{
    return
        '';
}

function ApplyCommonPageSettings(Page $page, Grid $grid)
{
    $page->SetShowUserAuthBar(false);
    $page->setShowNavigation(true);
    $page->OnCustomHTMLHeader->AddListener('Global_CustomHTMLHeaderHandler');
    $page->OnGetCustomTemplate->AddListener('Global_GetCustomTemplateHandler');
    $page->OnGetCustomExportOptions->AddListener('Global_OnGetCustomExportOptions');
    $page->getDataset()->OnGetFieldValue->AddListener('Global_OnGetFieldValue');
    $page->getDataset()->OnGetFieldValue->AddListener('OnGetFieldValue', $page);
    $grid->BeforeUpdateRecord->AddListener('Global_BeforeUpdateHandler');
    $grid->BeforeDeleteRecord->AddListener('Global_BeforeDeleteHandler');
    $grid->BeforeInsertRecord->AddListener('Global_BeforeInsertHandler');
    $grid->AfterUpdateRecord->AddListener('Global_AfterUpdateHandler');
    $grid->AfterDeleteRecord->AddListener('Global_AfterDeleteHandler');
    $grid->AfterInsertRecord->AddListener('Global_AfterInsertHandler');
}

function GetAnsiEncoding() { return 'windows-1250'; }

function Global_OnGetCustomPagePermissionsHandler(Page $page, PermissionSet &$permissions, &$handled)
{

}

function Global_CustomHTMLHeaderHandler($page, &$customHtmlHeaderText)
{

}

function Global_GetCustomTemplateHandler($type, $part, $mode, &$result, &$params, CommonPage $page = null)
{

}

function Global_OnGetCustomExportOptions($page, $exportType, $rowData, &$options)
{

}

function Global_OnGetFieldValue($fieldName, &$value, $tableName)
{

}

function Global_GetCustomPageList(CommonPage $page, PageList $pageList)
{

}

function Global_BeforeInsertHandler($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
{

}

function Global_BeforeUpdateHandler($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
{

}

function Global_BeforeDeleteHandler($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
{

}

function Global_AfterInsertHandler($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
{

}

function Global_AfterUpdateHandler($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
{

}

function Global_AfterDeleteHandler($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
{

}

function GetDefaultDateFormat()
{
    return 'Y-m-d';
}

function GetFirstDayOfWeek()
{
    return 0;
}

function GetPageListType()
{
    return PageList::TYPE_MENU;
}

function GetNullLabel()
{
    return null;
}

function UseMinifiedJS()
{
    return true;
}

function GetOfflineMode()
{
    return false;
}

function GetInactivityTimeout()
{
    return 0;
}

function GetMailer()
{
    $mailerOptions = new MailerOptions(MailerType::Sendmail, '', '');
    
    return PHPMailerBasedMailer::getInstance($mailerOptions);
}

function sendMailMessage($recipients, $messageSubject, $messageBody, $attachments = '', $cc = '', $bcc = '')
{
    GetMailer()->send($recipients, $messageSubject, $messageBody, $attachments, $cc, $bcc);
}

function createConnection()
{
    $connectionOptions = GetGlobalConnectionOptions();
    $connectionOptions['client_encoding'] = 'utf8';

    $connectionFactory = MyPDOConnectionFactory::getInstance();
    return $connectionFactory->CreateConnection($connectionOptions);
}

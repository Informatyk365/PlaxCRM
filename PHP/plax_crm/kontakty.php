<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *                                   ATTENTION!
 * If you see this message in your browser (Internet Explorer, Mozilla Firefox, Google Chrome, etc.)
 * this means that PHP is not properly installed on your web server. Please refer to the PHP manual
 * for more details: http://php.net/manual/install.php 
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */

    include_once dirname(__FILE__) . '/components/startup.php';
    include_once dirname(__FILE__) . '/components/application.php';


    include_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';
    include_once dirname(__FILE__) . '/' . 'components/page/page.php';
    include_once dirname(__FILE__) . '/' . 'components/page/detail_page.php';
    include_once dirname(__FILE__) . '/' . 'components/page/nested_form_page.php';


    function GetConnectionOptions()
    {
        $result = GetGlobalConnectionOptions();
        $result['client_encoding'] = 'utf8';
        GetApplication()->GetUserAuthentication()->applyIdentityToConnectionOptions($result);
        return $result;
    }

    
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class kontakty_dzialanie_uzytkownik_kontaktPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`dzialanie_uzytkownik_kontakt`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('id_kontakt', true),
                    new IntegerField('id_uzytkownik', true),
                    new IntegerField('id_dzialanie', true)
                )
            );
            $this->dataset->AddLookupField('id_kontakt', 'kontakty', new IntegerField('id'), new StringField('imie', false, false, false, false, 'id_kontakt_imie', 'id_kontakt_imie_kontakty'), 'id_kontakt_imie_kontakty');
            $this->dataset->AddLookupField('id_uzytkownik', 'uzytkownicy', new IntegerField('id'), new StringField('email', false, false, false, false, 'id_uzytkownik_email', 'id_uzytkownik_email_uzytkownicy'), 'id_uzytkownik_email_uzytkownicy');
            $this->dataset->AddLookupField('id_dzialanie', 'dzialania', new IntegerField('id'), new StringField('rodzaj', false, false, false, false, 'id_dzialanie_rodzaj', 'id_dzialanie_rodzaj_dzialania'), 'id_dzialanie_rodzaj_dzialania');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'id', 'id', 'Id'),
                new FilterColumn($this->dataset, 'id_kontakt', 'id_kontakt_imie', 'Id Kontakt'),
                new FilterColumn($this->dataset, 'id_uzytkownik', 'id_uzytkownik_email', 'Id Uzytkownik'),
                new FilterColumn($this->dataset, 'id_dzialanie', 'id_dzialanie_rodzaj', 'Id Dzialanie')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id'])
                ->addColumn($columns['id_kontakt'])
                ->addColumn($columns['id_uzytkownik'])
                ->addColumn($columns['id_dzialanie']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('id_kontakt')
                ->setOptionsFor('id_uzytkownik')
                ->setOptionsFor('id_dzialanie');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_edit');
            
            $filterBuilder->addColumn(
                $columns['id'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('id_kontakt_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_id_kontakt_imie_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('id_kontakt', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_id_kontakt_imie_search');
            
            $text_editor = new TextEdit('id_kontakt');
            
            $filterBuilder->addColumn(
                $columns['id_kontakt'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('id_uzytkownik_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_id_uzytkownik_email_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('id_uzytkownik', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_id_uzytkownik_email_search');
            
            $text_editor = new TextEdit('id_uzytkownik');
            
            $filterBuilder->addColumn(
                $columns['id_uzytkownik'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('id_dzialanie_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_id_dzialanie_rodzaj_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('id_dzialanie', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_id_dzialanie_rodzaj_search');
            
            $text_editor = new TextEdit('id_dzialanie');
            
            $filterBuilder->addColumn(
                $columns['id_dzialanie'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Edit'), OPERATION_EDIT, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for imie field
            //
            $column = new TextViewColumn('id_kontakt', 'id_kontakt_imie', 'Id Kontakt', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.dzialanie_uzytkownik_kontakt_id_kontakt_imie_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('id_uzytkownik', 'id_uzytkownik_email', 'Id Uzytkownik', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.dzialanie_uzytkownik_kontakt_id_uzytkownik_email_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for rodzaj field
            //
            $column = new TextViewColumn('id_dzialanie', 'id_dzialanie_rodzaj', 'Id Dzialanie', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.dzialanie_uzytkownik_kontakt_id_dzialanie_rodzaj_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for imie field
            //
            $column = new TextViewColumn('id_kontakt', 'id_kontakt_imie', 'Id Kontakt', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.dzialanie_uzytkownik_kontakt_id_kontakt_imie_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('id_uzytkownik', 'id_uzytkownik_email', 'Id Uzytkownik', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.dzialanie_uzytkownik_kontakt_id_uzytkownik_email_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for rodzaj field
            //
            $column = new TextViewColumn('id_dzialanie', 'id_dzialanie_rodzaj', 'Id Dzialanie', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.dzialanie_uzytkownik_kontakt_id_dzialanie_rodzaj_handler_view');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for id_kontakt field
            //
            $editor = new DynamicCombobox('id_kontakt_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`kontakty`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('imie', true),
                    new StringField('nazwisko', true),
                    new StringField('email', true),
                    new StringField('telefon', true),
                    new StringField('inne', true)
                )
            );
            $lookupDataset->setOrderByField('imie', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Kontakt', 'id_kontakt', 'id_kontakt_imie', 'edit_id_kontakt_imie_search', $editor, $this->dataset, $lookupDataset, 'id', 'imie', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for id_uzytkownik field
            //
            $editor = new DynamicCombobox('id_uzytkownik_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`uzytkownicy`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('email', true),
                    new StringField('haslo', true),
                    new StringField('imie', true),
                    new IntegerField('nazwisko', true),
                    new StringField('data_dodania', true),
                    new IntegerField('aktywny', true),
                    new IntegerField('uprawnienia', true)
                )
            );
            $lookupDataset->setOrderByField('email', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Uzytkownik', 'id_uzytkownik', 'id_uzytkownik_email', 'edit_id_uzytkownik_email_search', $editor, $this->dataset, $lookupDataset, 'id', 'email', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for id_dzialanie field
            //
            $editor = new DynamicCombobox('id_dzialanie_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`dzialania`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('rodzaj', true),
                    new StringField('czas', true),
                    new StringField('opis', true)
                )
            );
            $lookupDataset->setOrderByField('rodzaj', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Dzialanie', 'id_dzialanie', 'id_dzialanie_rodzaj', 'edit_id_dzialanie_rodzaj_search', $editor, $this->dataset, $lookupDataset, 'id', 'rodzaj', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for id_kontakt field
            //
            $editor = new DynamicCombobox('id_kontakt_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`kontakty`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('imie', true),
                    new StringField('nazwisko', true),
                    new StringField('email', true),
                    new StringField('telefon', true),
                    new StringField('inne', true)
                )
            );
            $lookupDataset->setOrderByField('imie', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Kontakt', 'id_kontakt', 'id_kontakt_imie', 'multi_edit_id_kontakt_imie_search', $editor, $this->dataset, $lookupDataset, 'id', 'imie', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for id_uzytkownik field
            //
            $editor = new DynamicCombobox('id_uzytkownik_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`uzytkownicy`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('email', true),
                    new StringField('haslo', true),
                    new StringField('imie', true),
                    new IntegerField('nazwisko', true),
                    new StringField('data_dodania', true),
                    new IntegerField('aktywny', true),
                    new IntegerField('uprawnienia', true)
                )
            );
            $lookupDataset->setOrderByField('email', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Uzytkownik', 'id_uzytkownik', 'id_uzytkownik_email', 'multi_edit_id_uzytkownik_email_search', $editor, $this->dataset, $lookupDataset, 'id', 'email', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for id_dzialanie field
            //
            $editor = new DynamicCombobox('id_dzialanie_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`dzialania`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('rodzaj', true),
                    new StringField('czas', true),
                    new StringField('opis', true)
                )
            );
            $lookupDataset->setOrderByField('rodzaj', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Dzialanie', 'id_dzialanie', 'id_dzialanie_rodzaj', 'multi_edit_id_dzialanie_rodzaj_search', $editor, $this->dataset, $lookupDataset, 'id', 'rodzaj', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for id_kontakt field
            //
            $editor = new DynamicCombobox('id_kontakt_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`kontakty`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('imie', true),
                    new StringField('nazwisko', true),
                    new StringField('email', true),
                    new StringField('telefon', true),
                    new StringField('inne', true)
                )
            );
            $lookupDataset->setOrderByField('imie', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Kontakt', 'id_kontakt', 'id_kontakt_imie', 'insert_id_kontakt_imie_search', $editor, $this->dataset, $lookupDataset, 'id', 'imie', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for id_uzytkownik field
            //
            $editor = new DynamicCombobox('id_uzytkownik_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`uzytkownicy`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('email', true),
                    new StringField('haslo', true),
                    new StringField('imie', true),
                    new IntegerField('nazwisko', true),
                    new StringField('data_dodania', true),
                    new IntegerField('aktywny', true),
                    new IntegerField('uprawnienia', true)
                )
            );
            $lookupDataset->setOrderByField('email', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Uzytkownik', 'id_uzytkownik', 'id_uzytkownik_email', 'insert_id_uzytkownik_email_search', $editor, $this->dataset, $lookupDataset, 'id', 'email', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for id_dzialanie field
            //
            $editor = new DynamicCombobox('id_dzialanie_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`dzialania`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('rodzaj', true),
                    new StringField('czas', true),
                    new StringField('opis', true)
                )
            );
            $lookupDataset->setOrderByField('rodzaj', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Dzialanie', 'id_dzialanie', 'id_dzialanie_rodzaj', 'insert_id_dzialanie_rodzaj_search', $editor, $this->dataset, $lookupDataset, 'id', 'rodzaj', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for imie field
            //
            $column = new TextViewColumn('id_kontakt', 'id_kontakt_imie', 'Id Kontakt', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.dzialanie_uzytkownik_kontakt_id_kontakt_imie_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('id_uzytkownik', 'id_uzytkownik_email', 'Id Uzytkownik', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.dzialanie_uzytkownik_kontakt_id_uzytkownik_email_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for rodzaj field
            //
            $column = new TextViewColumn('id_dzialanie', 'id_dzialanie_rodzaj', 'Id Dzialanie', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.dzialanie_uzytkownik_kontakt_id_dzialanie_rodzaj_handler_print');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for imie field
            //
            $column = new TextViewColumn('id_kontakt', 'id_kontakt_imie', 'Id Kontakt', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.dzialanie_uzytkownik_kontakt_id_kontakt_imie_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('id_uzytkownik', 'id_uzytkownik_email', 'Id Uzytkownik', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.dzialanie_uzytkownik_kontakt_id_uzytkownik_email_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for rodzaj field
            //
            $column = new TextViewColumn('id_dzialanie', 'id_dzialanie_rodzaj', 'Id Dzialanie', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.dzialanie_uzytkownik_kontakt_id_dzialanie_rodzaj_handler_export');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for imie field
            //
            $column = new TextViewColumn('id_kontakt', 'id_kontakt_imie', 'Id Kontakt', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.dzialanie_uzytkownik_kontakt_id_kontakt_imie_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('id_uzytkownik', 'id_uzytkownik_email', 'Id Uzytkownik', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.dzialanie_uzytkownik_kontakt_id_uzytkownik_email_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for rodzaj field
            //
            $column = new TextViewColumn('id_dzialanie', 'id_dzialanie_rodzaj', 'Id Dzialanie', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.dzialanie_uzytkownik_kontakt_id_dzialanie_rodzaj_handler_compare');
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && true);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            //
            // View column for imie field
            //
            $column = new TextViewColumn('id_kontakt', 'id_kontakt_imie', 'Id Kontakt', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.dzialanie_uzytkownik_kontakt_id_kontakt_imie_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('id_uzytkownik', 'id_uzytkownik_email', 'Id Uzytkownik', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.dzialanie_uzytkownik_kontakt_id_uzytkownik_email_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for rodzaj field
            //
            $column = new TextViewColumn('id_dzialanie', 'id_dzialanie_rodzaj', 'Id Dzialanie', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.dzialanie_uzytkownik_kontakt_id_dzialanie_rodzaj_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for imie field
            //
            $column = new TextViewColumn('id_kontakt', 'id_kontakt_imie', 'Id Kontakt', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.dzialanie_uzytkownik_kontakt_id_kontakt_imie_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('id_uzytkownik', 'id_uzytkownik_email', 'Id Uzytkownik', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.dzialanie_uzytkownik_kontakt_id_uzytkownik_email_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for rodzaj field
            //
            $column = new TextViewColumn('id_dzialanie', 'id_dzialanie_rodzaj', 'Id Dzialanie', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.dzialanie_uzytkownik_kontakt_id_dzialanie_rodzaj_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for imie field
            //
            $column = new TextViewColumn('id_kontakt', 'id_kontakt_imie', 'Id Kontakt', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.dzialanie_uzytkownik_kontakt_id_kontakt_imie_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('id_uzytkownik', 'id_uzytkownik_email', 'Id Uzytkownik', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.dzialanie_uzytkownik_kontakt_id_uzytkownik_email_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for rodzaj field
            //
            $column = new TextViewColumn('id_dzialanie', 'id_dzialanie_rodzaj', 'Id Dzialanie', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.dzialanie_uzytkownik_kontakt_id_dzialanie_rodzaj_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`kontakty`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('imie', true),
                    new StringField('nazwisko', true),
                    new StringField('email', true),
                    new StringField('telefon', true),
                    new StringField('inne', true)
                )
            );
            $lookupDataset->setOrderByField('imie', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_id_kontakt_imie_search', 'id', 'imie', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`uzytkownicy`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('email', true),
                    new StringField('haslo', true),
                    new StringField('imie', true),
                    new IntegerField('nazwisko', true),
                    new StringField('data_dodania', true),
                    new IntegerField('aktywny', true),
                    new IntegerField('uprawnienia', true)
                )
            );
            $lookupDataset->setOrderByField('email', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_id_uzytkownik_email_search', 'id', 'email', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`dzialania`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('rodzaj', true),
                    new StringField('czas', true),
                    new StringField('opis', true)
                )
            );
            $lookupDataset->setOrderByField('rodzaj', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_id_dzialanie_rodzaj_search', 'id', 'rodzaj', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`kontakty`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('imie', true),
                    new StringField('nazwisko', true),
                    new StringField('email', true),
                    new StringField('telefon', true),
                    new StringField('inne', true)
                )
            );
            $lookupDataset->setOrderByField('imie', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_id_kontakt_imie_search', 'id', 'imie', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`uzytkownicy`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('email', true),
                    new StringField('haslo', true),
                    new StringField('imie', true),
                    new IntegerField('nazwisko', true),
                    new StringField('data_dodania', true),
                    new IntegerField('aktywny', true),
                    new IntegerField('uprawnienia', true)
                )
            );
            $lookupDataset->setOrderByField('email', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_id_uzytkownik_email_search', 'id', 'email', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`dzialania`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('rodzaj', true),
                    new StringField('czas', true),
                    new StringField('opis', true)
                )
            );
            $lookupDataset->setOrderByField('rodzaj', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_id_dzialanie_rodzaj_search', 'id', 'rodzaj', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for imie field
            //
            $column = new TextViewColumn('id_kontakt', 'id_kontakt_imie', 'Id Kontakt', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.dzialanie_uzytkownik_kontakt_id_kontakt_imie_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('id_uzytkownik', 'id_uzytkownik_email', 'Id Uzytkownik', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.dzialanie_uzytkownik_kontakt_id_uzytkownik_email_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for rodzaj field
            //
            $column = new TextViewColumn('id_dzialanie', 'id_dzialanie_rodzaj', 'Id Dzialanie', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.dzialanie_uzytkownik_kontakt_id_dzialanie_rodzaj_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`kontakty`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('imie', true),
                    new StringField('nazwisko', true),
                    new StringField('email', true),
                    new StringField('telefon', true),
                    new StringField('inne', true)
                )
            );
            $lookupDataset->setOrderByField('imie', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_id_kontakt_imie_search', 'id', 'imie', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`uzytkownicy`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('email', true),
                    new StringField('haslo', true),
                    new StringField('imie', true),
                    new IntegerField('nazwisko', true),
                    new StringField('data_dodania', true),
                    new IntegerField('aktywny', true),
                    new IntegerField('uprawnienia', true)
                )
            );
            $lookupDataset->setOrderByField('email', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_id_uzytkownik_email_search', 'id', 'email', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`dzialania`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('rodzaj', true),
                    new StringField('czas', true),
                    new StringField('opis', true)
                )
            );
            $lookupDataset->setOrderByField('rodzaj', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_id_dzialanie_rodzaj_search', 'id', 'rodzaj', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`kontakty`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('imie', true),
                    new StringField('nazwisko', true),
                    new StringField('email', true),
                    new StringField('telefon', true),
                    new StringField('inne', true)
                )
            );
            $lookupDataset->setOrderByField('imie', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_id_kontakt_imie_search', 'id', 'imie', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`uzytkownicy`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('email', true),
                    new StringField('haslo', true),
                    new StringField('imie', true),
                    new IntegerField('nazwisko', true),
                    new StringField('data_dodania', true),
                    new IntegerField('aktywny', true),
                    new IntegerField('uprawnienia', true)
                )
            );
            $lookupDataset->setOrderByField('email', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_id_uzytkownik_email_search', 'id', 'email', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`dzialania`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('rodzaj', true),
                    new StringField('czas', true),
                    new StringField('opis', true)
                )
            );
            $lookupDataset->setOrderByField('rodzaj', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_id_dzialanie_rodzaj_search', 'id', 'rodzaj', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        public function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomPagePermissions(Page $page, PermissionSet &$permissions, &$handled)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
    }
    
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class kontakty_kontakt_firmaPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`kontakt_firma`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('id_kontakt', true),
                    new IntegerField('id_firma', true)
                )
            );
            $this->dataset->AddLookupField('id_kontakt', 'kontakty', new IntegerField('id'), new StringField('imie', false, false, false, false, 'id_kontakt_imie', 'id_kontakt_imie_kontakty'), 'id_kontakt_imie_kontakty');
            $this->dataset->AddLookupField('id_firma', 'firmy', new IntegerField('id'), new StringField('nazwa', false, false, false, false, 'id_firma_nazwa', 'id_firma_nazwa_firmy'), 'id_firma_nazwa_firmy');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'id', 'id', 'Id'),
                new FilterColumn($this->dataset, 'id_kontakt', 'id_kontakt_imie', 'Id Kontakt'),
                new FilterColumn($this->dataset, 'id_firma', 'id_firma_nazwa', 'Id Firma')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id'])
                ->addColumn($columns['id_kontakt'])
                ->addColumn($columns['id_firma']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('id_kontakt')
                ->setOptionsFor('id_firma');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_edit');
            
            $filterBuilder->addColumn(
                $columns['id'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('id_kontakt_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_id_kontakt_imie_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('id_kontakt', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_id_kontakt_imie_search');
            
            $text_editor = new TextEdit('id_kontakt');
            
            $filterBuilder->addColumn(
                $columns['id_kontakt'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('id_firma_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_id_firma_nazwa_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('id_firma', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_id_firma_nazwa_search');
            
            $text_editor = new TextEdit('id_firma');
            
            $filterBuilder->addColumn(
                $columns['id_firma'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Edit'), OPERATION_EDIT, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for imie field
            //
            $column = new TextViewColumn('id_kontakt', 'id_kontakt_imie', 'Id Kontakt', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.kontakt_firma_id_kontakt_imie_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for nazwa field
            //
            $column = new TextViewColumn('id_firma', 'id_firma_nazwa', 'Id Firma', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.kontakt_firma_id_firma_nazwa_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for imie field
            //
            $column = new TextViewColumn('id_kontakt', 'id_kontakt_imie', 'Id Kontakt', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.kontakt_firma_id_kontakt_imie_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nazwa field
            //
            $column = new TextViewColumn('id_firma', 'id_firma_nazwa', 'Id Firma', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.kontakt_firma_id_firma_nazwa_handler_view');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for id_kontakt field
            //
            $editor = new DynamicCombobox('id_kontakt_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`kontakty`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('imie', true),
                    new StringField('nazwisko', true),
                    new StringField('email', true),
                    new StringField('telefon', true),
                    new StringField('inne', true)
                )
            );
            $lookupDataset->setOrderByField('imie', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Kontakt', 'id_kontakt', 'id_kontakt_imie', 'edit_id_kontakt_imie_search', $editor, $this->dataset, $lookupDataset, 'id', 'imie', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for id_firma field
            //
            $editor = new DynamicCombobox('id_firma_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`firmy`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('nazwa', true),
                    new StringField('opis', true)
                )
            );
            $lookupDataset->setOrderByField('nazwa', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Firma', 'id_firma', 'id_firma_nazwa', 'edit_id_firma_nazwa_search', $editor, $this->dataset, $lookupDataset, 'id', 'nazwa', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for id_kontakt field
            //
            $editor = new DynamicCombobox('id_kontakt_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`kontakty`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('imie', true),
                    new StringField('nazwisko', true),
                    new StringField('email', true),
                    new StringField('telefon', true),
                    new StringField('inne', true)
                )
            );
            $lookupDataset->setOrderByField('imie', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Kontakt', 'id_kontakt', 'id_kontakt_imie', 'multi_edit_id_kontakt_imie_search', $editor, $this->dataset, $lookupDataset, 'id', 'imie', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for id_firma field
            //
            $editor = new DynamicCombobox('id_firma_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`firmy`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('nazwa', true),
                    new StringField('opis', true)
                )
            );
            $lookupDataset->setOrderByField('nazwa', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Firma', 'id_firma', 'id_firma_nazwa', 'multi_edit_id_firma_nazwa_search', $editor, $this->dataset, $lookupDataset, 'id', 'nazwa', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for id_kontakt field
            //
            $editor = new DynamicCombobox('id_kontakt_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`kontakty`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('imie', true),
                    new StringField('nazwisko', true),
                    new StringField('email', true),
                    new StringField('telefon', true),
                    new StringField('inne', true)
                )
            );
            $lookupDataset->setOrderByField('imie', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Kontakt', 'id_kontakt', 'id_kontakt_imie', 'insert_id_kontakt_imie_search', $editor, $this->dataset, $lookupDataset, 'id', 'imie', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for id_firma field
            //
            $editor = new DynamicCombobox('id_firma_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`firmy`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('nazwa', true),
                    new StringField('opis', true)
                )
            );
            $lookupDataset->setOrderByField('nazwa', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Firma', 'id_firma', 'id_firma_nazwa', 'insert_id_firma_nazwa_search', $editor, $this->dataset, $lookupDataset, 'id', 'nazwa', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for imie field
            //
            $column = new TextViewColumn('id_kontakt', 'id_kontakt_imie', 'Id Kontakt', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.kontakt_firma_id_kontakt_imie_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for nazwa field
            //
            $column = new TextViewColumn('id_firma', 'id_firma_nazwa', 'Id Firma', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.kontakt_firma_id_firma_nazwa_handler_print');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for imie field
            //
            $column = new TextViewColumn('id_kontakt', 'id_kontakt_imie', 'Id Kontakt', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.kontakt_firma_id_kontakt_imie_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for nazwa field
            //
            $column = new TextViewColumn('id_firma', 'id_firma_nazwa', 'Id Firma', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.kontakt_firma_id_firma_nazwa_handler_export');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for imie field
            //
            $column = new TextViewColumn('id_kontakt', 'id_kontakt_imie', 'Id Kontakt', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.kontakt_firma_id_kontakt_imie_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for nazwa field
            //
            $column = new TextViewColumn('id_firma', 'id_firma_nazwa', 'Id Firma', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.kontakt_firma_id_firma_nazwa_handler_compare');
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && true);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            //
            // View column for imie field
            //
            $column = new TextViewColumn('id_kontakt', 'id_kontakt_imie', 'Id Kontakt', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.kontakt_firma_id_kontakt_imie_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for nazwa field
            //
            $column = new TextViewColumn('id_firma', 'id_firma_nazwa', 'Id Firma', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.kontakt_firma_id_firma_nazwa_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for imie field
            //
            $column = new TextViewColumn('id_kontakt', 'id_kontakt_imie', 'Id Kontakt', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.kontakt_firma_id_kontakt_imie_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for nazwa field
            //
            $column = new TextViewColumn('id_firma', 'id_firma_nazwa', 'Id Firma', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.kontakt_firma_id_firma_nazwa_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for imie field
            //
            $column = new TextViewColumn('id_kontakt', 'id_kontakt_imie', 'Id Kontakt', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.kontakt_firma_id_kontakt_imie_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for nazwa field
            //
            $column = new TextViewColumn('id_firma', 'id_firma_nazwa', 'Id Firma', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.kontakt_firma_id_firma_nazwa_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`kontakty`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('imie', true),
                    new StringField('nazwisko', true),
                    new StringField('email', true),
                    new StringField('telefon', true),
                    new StringField('inne', true)
                )
            );
            $lookupDataset->setOrderByField('imie', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_id_kontakt_imie_search', 'id', 'imie', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`firmy`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('nazwa', true),
                    new StringField('opis', true)
                )
            );
            $lookupDataset->setOrderByField('nazwa', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_id_firma_nazwa_search', 'id', 'nazwa', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`kontakty`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('imie', true),
                    new StringField('nazwisko', true),
                    new StringField('email', true),
                    new StringField('telefon', true),
                    new StringField('inne', true)
                )
            );
            $lookupDataset->setOrderByField('imie', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_id_kontakt_imie_search', 'id', 'imie', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`firmy`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('nazwa', true),
                    new StringField('opis', true)
                )
            );
            $lookupDataset->setOrderByField('nazwa', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_id_firma_nazwa_search', 'id', 'nazwa', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for imie field
            //
            $column = new TextViewColumn('id_kontakt', 'id_kontakt_imie', 'Id Kontakt', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.kontakt_firma_id_kontakt_imie_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for nazwa field
            //
            $column = new TextViewColumn('id_firma', 'id_firma_nazwa', 'Id Firma', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.kontakt_firma_id_firma_nazwa_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`kontakty`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('imie', true),
                    new StringField('nazwisko', true),
                    new StringField('email', true),
                    new StringField('telefon', true),
                    new StringField('inne', true)
                )
            );
            $lookupDataset->setOrderByField('imie', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_id_kontakt_imie_search', 'id', 'imie', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`firmy`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('nazwa', true),
                    new StringField('opis', true)
                )
            );
            $lookupDataset->setOrderByField('nazwa', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_id_firma_nazwa_search', 'id', 'nazwa', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`kontakty`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('imie', true),
                    new StringField('nazwisko', true),
                    new StringField('email', true),
                    new StringField('telefon', true),
                    new StringField('inne', true)
                )
            );
            $lookupDataset->setOrderByField('imie', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_id_kontakt_imie_search', 'id', 'imie', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`firmy`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('nazwa', true),
                    new StringField('opis', true)
                )
            );
            $lookupDataset->setOrderByField('nazwa', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_id_firma_nazwa_search', 'id', 'nazwa', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        public function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomPagePermissions(Page $page, PermissionSet &$permissions, &$handled)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
    }
    
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class kontakty_umowa_uzytkownik_kontaktPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`umowa_uzytkownik_kontakt`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new IntegerField('id_kontakt', true),
                    new IntegerField('id_uzytkownik', true),
                    new IntegerField('id_umowa', true)
                )
            );
            $this->dataset->AddLookupField('id_kontakt', 'kontakty', new IntegerField('id'), new StringField('imie', false, false, false, false, 'id_kontakt_imie', 'id_kontakt_imie_kontakty'), 'id_kontakt_imie_kontakty');
            $this->dataset->AddLookupField('id_uzytkownik', 'uzytkownicy', new IntegerField('id'), new StringField('email', false, false, false, false, 'id_uzytkownik_email', 'id_uzytkownik_email_uzytkownicy'), 'id_uzytkownik_email_uzytkownicy');
            $this->dataset->AddLookupField('id_umowa', 'umowy', new IntegerField('id'), new StringField('czas', false, false, false, false, 'id_umowa_czas', 'id_umowa_czas_umowy'), 'id_umowa_czas_umowy');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'id', 'id', 'Id'),
                new FilterColumn($this->dataset, 'id_kontakt', 'id_kontakt_imie', 'Id Kontakt'),
                new FilterColumn($this->dataset, 'id_uzytkownik', 'id_uzytkownik_email', 'Id Uzytkownik'),
                new FilterColumn($this->dataset, 'id_umowa', 'id_umowa_czas', 'Id Umowa')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id'])
                ->addColumn($columns['id_kontakt'])
                ->addColumn($columns['id_uzytkownik'])
                ->addColumn($columns['id_umowa']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('id_kontakt')
                ->setOptionsFor('id_uzytkownik')
                ->setOptionsFor('id_umowa');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_edit');
            
            $filterBuilder->addColumn(
                $columns['id'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('id_kontakt_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_id_kontakt_imie_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('id_kontakt', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_id_kontakt_imie_search');
            
            $text_editor = new TextEdit('id_kontakt');
            
            $filterBuilder->addColumn(
                $columns['id_kontakt'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('id_uzytkownik_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_id_uzytkownik_email_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('id_uzytkownik', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_id_uzytkownik_email_search');
            
            $text_editor = new TextEdit('id_uzytkownik');
            
            $filterBuilder->addColumn(
                $columns['id_uzytkownik'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('id_umowa_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_id_umowa_czas_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('id_umowa', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_id_umowa_czas_search');
            
            $text_editor = new TextEdit('id_umowa');
            
            $filterBuilder->addColumn(
                $columns['id_umowa'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Edit'), OPERATION_EDIT, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for imie field
            //
            $column = new TextViewColumn('id_kontakt', 'id_kontakt_imie', 'Id Kontakt', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.umowa_uzytkownik_kontakt_id_kontakt_imie_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('id_uzytkownik', 'id_uzytkownik_email', 'Id Uzytkownik', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.umowa_uzytkownik_kontakt_id_uzytkownik_email_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for czas field
            //
            $column = new TextViewColumn('id_umowa', 'id_umowa_czas', 'Id Umowa', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.umowa_uzytkownik_kontakt_id_umowa_czas_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for imie field
            //
            $column = new TextViewColumn('id_kontakt', 'id_kontakt_imie', 'Id Kontakt', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.umowa_uzytkownik_kontakt_id_kontakt_imie_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('id_uzytkownik', 'id_uzytkownik_email', 'Id Uzytkownik', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.umowa_uzytkownik_kontakt_id_uzytkownik_email_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for czas field
            //
            $column = new TextViewColumn('id_umowa', 'id_umowa_czas', 'Id Umowa', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.umowa_uzytkownik_kontakt_id_umowa_czas_handler_view');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for id_kontakt field
            //
            $editor = new DynamicCombobox('id_kontakt_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`kontakty`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('imie', true),
                    new StringField('nazwisko', true),
                    new StringField('email', true),
                    new StringField('telefon', true),
                    new StringField('inne', true)
                )
            );
            $lookupDataset->setOrderByField('imie', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Kontakt', 'id_kontakt', 'id_kontakt_imie', 'edit_id_kontakt_imie_search', $editor, $this->dataset, $lookupDataset, 'id', 'imie', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for id_uzytkownik field
            //
            $editor = new DynamicCombobox('id_uzytkownik_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`uzytkownicy`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('email', true),
                    new StringField('haslo', true),
                    new StringField('imie', true),
                    new IntegerField('nazwisko', true),
                    new StringField('data_dodania', true),
                    new IntegerField('aktywny', true),
                    new IntegerField('uprawnienia', true)
                )
            );
            $lookupDataset->setOrderByField('email', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Uzytkownik', 'id_uzytkownik', 'id_uzytkownik_email', 'edit_id_uzytkownik_email_search', $editor, $this->dataset, $lookupDataset, 'id', 'email', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for id_umowa field
            //
            $editor = new DynamicCombobox('id_umowa_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`umowy`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new BlobField('fotografia', true),
                    new StringField('czas', true),
                    new StringField('opis', true)
                )
            );
            $lookupDataset->setOrderByField('czas', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Umowa', 'id_umowa', 'id_umowa_czas', 'edit_id_umowa_czas_search', $editor, $this->dataset, $lookupDataset, 'id', 'czas', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for id_kontakt field
            //
            $editor = new DynamicCombobox('id_kontakt_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`kontakty`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('imie', true),
                    new StringField('nazwisko', true),
                    new StringField('email', true),
                    new StringField('telefon', true),
                    new StringField('inne', true)
                )
            );
            $lookupDataset->setOrderByField('imie', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Kontakt', 'id_kontakt', 'id_kontakt_imie', 'multi_edit_id_kontakt_imie_search', $editor, $this->dataset, $lookupDataset, 'id', 'imie', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for id_uzytkownik field
            //
            $editor = new DynamicCombobox('id_uzytkownik_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`uzytkownicy`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('email', true),
                    new StringField('haslo', true),
                    new StringField('imie', true),
                    new IntegerField('nazwisko', true),
                    new StringField('data_dodania', true),
                    new IntegerField('aktywny', true),
                    new IntegerField('uprawnienia', true)
                )
            );
            $lookupDataset->setOrderByField('email', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Uzytkownik', 'id_uzytkownik', 'id_uzytkownik_email', 'multi_edit_id_uzytkownik_email_search', $editor, $this->dataset, $lookupDataset, 'id', 'email', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for id_umowa field
            //
            $editor = new DynamicCombobox('id_umowa_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`umowy`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new BlobField('fotografia', true),
                    new StringField('czas', true),
                    new StringField('opis', true)
                )
            );
            $lookupDataset->setOrderByField('czas', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Umowa', 'id_umowa', 'id_umowa_czas', 'multi_edit_id_umowa_czas_search', $editor, $this->dataset, $lookupDataset, 'id', 'czas', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for id_kontakt field
            //
            $editor = new DynamicCombobox('id_kontakt_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`kontakty`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('imie', true),
                    new StringField('nazwisko', true),
                    new StringField('email', true),
                    new StringField('telefon', true),
                    new StringField('inne', true)
                )
            );
            $lookupDataset->setOrderByField('imie', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Kontakt', 'id_kontakt', 'id_kontakt_imie', 'insert_id_kontakt_imie_search', $editor, $this->dataset, $lookupDataset, 'id', 'imie', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for id_uzytkownik field
            //
            $editor = new DynamicCombobox('id_uzytkownik_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`uzytkownicy`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('email', true),
                    new StringField('haslo', true),
                    new StringField('imie', true),
                    new IntegerField('nazwisko', true),
                    new StringField('data_dodania', true),
                    new IntegerField('aktywny', true),
                    new IntegerField('uprawnienia', true)
                )
            );
            $lookupDataset->setOrderByField('email', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Uzytkownik', 'id_uzytkownik', 'id_uzytkownik_email', 'insert_id_uzytkownik_email_search', $editor, $this->dataset, $lookupDataset, 'id', 'email', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for id_umowa field
            //
            $editor = new DynamicCombobox('id_umowa_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`umowy`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new BlobField('fotografia', true),
                    new StringField('czas', true),
                    new StringField('opis', true)
                )
            );
            $lookupDataset->setOrderByField('czas', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Umowa', 'id_umowa', 'id_umowa_czas', 'insert_id_umowa_czas_search', $editor, $this->dataset, $lookupDataset, 'id', 'czas', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for imie field
            //
            $column = new TextViewColumn('id_kontakt', 'id_kontakt_imie', 'Id Kontakt', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.umowa_uzytkownik_kontakt_id_kontakt_imie_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('id_uzytkownik', 'id_uzytkownik_email', 'Id Uzytkownik', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.umowa_uzytkownik_kontakt_id_uzytkownik_email_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for czas field
            //
            $column = new TextViewColumn('id_umowa', 'id_umowa_czas', 'Id Umowa', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.umowa_uzytkownik_kontakt_id_umowa_czas_handler_print');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for imie field
            //
            $column = new TextViewColumn('id_kontakt', 'id_kontakt_imie', 'Id Kontakt', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.umowa_uzytkownik_kontakt_id_kontakt_imie_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('id_uzytkownik', 'id_uzytkownik_email', 'Id Uzytkownik', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.umowa_uzytkownik_kontakt_id_uzytkownik_email_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for czas field
            //
            $column = new TextViewColumn('id_umowa', 'id_umowa_czas', 'Id Umowa', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.umowa_uzytkownik_kontakt_id_umowa_czas_handler_export');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for imie field
            //
            $column = new TextViewColumn('id_kontakt', 'id_kontakt_imie', 'Id Kontakt', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.umowa_uzytkownik_kontakt_id_kontakt_imie_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('id_uzytkownik', 'id_uzytkownik_email', 'Id Uzytkownik', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.umowa_uzytkownik_kontakt_id_uzytkownik_email_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for czas field
            //
            $column = new TextViewColumn('id_umowa', 'id_umowa_czas', 'Id Umowa', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('DetailGridkontakty.umowa_uzytkownik_kontakt_id_umowa_czas_handler_compare');
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && true);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            //
            // View column for imie field
            //
            $column = new TextViewColumn('id_kontakt', 'id_kontakt_imie', 'Id Kontakt', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.umowa_uzytkownik_kontakt_id_kontakt_imie_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('id_uzytkownik', 'id_uzytkownik_email', 'Id Uzytkownik', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.umowa_uzytkownik_kontakt_id_uzytkownik_email_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for czas field
            //
            $column = new TextViewColumn('id_umowa', 'id_umowa_czas', 'Id Umowa', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.umowa_uzytkownik_kontakt_id_umowa_czas_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for imie field
            //
            $column = new TextViewColumn('id_kontakt', 'id_kontakt_imie', 'Id Kontakt', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.umowa_uzytkownik_kontakt_id_kontakt_imie_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('id_uzytkownik', 'id_uzytkownik_email', 'Id Uzytkownik', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.umowa_uzytkownik_kontakt_id_uzytkownik_email_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for czas field
            //
            $column = new TextViewColumn('id_umowa', 'id_umowa_czas', 'Id Umowa', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.umowa_uzytkownik_kontakt_id_umowa_czas_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for imie field
            //
            $column = new TextViewColumn('id_kontakt', 'id_kontakt_imie', 'Id Kontakt', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.umowa_uzytkownik_kontakt_id_kontakt_imie_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('id_uzytkownik', 'id_uzytkownik_email', 'Id Uzytkownik', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.umowa_uzytkownik_kontakt_id_uzytkownik_email_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for czas field
            //
            $column = new TextViewColumn('id_umowa', 'id_umowa_czas', 'Id Umowa', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.umowa_uzytkownik_kontakt_id_umowa_czas_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`kontakty`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('imie', true),
                    new StringField('nazwisko', true),
                    new StringField('email', true),
                    new StringField('telefon', true),
                    new StringField('inne', true)
                )
            );
            $lookupDataset->setOrderByField('imie', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_id_kontakt_imie_search', 'id', 'imie', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`uzytkownicy`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('email', true),
                    new StringField('haslo', true),
                    new StringField('imie', true),
                    new IntegerField('nazwisko', true),
                    new StringField('data_dodania', true),
                    new IntegerField('aktywny', true),
                    new IntegerField('uprawnienia', true)
                )
            );
            $lookupDataset->setOrderByField('email', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_id_uzytkownik_email_search', 'id', 'email', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`umowy`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new BlobField('fotografia', true),
                    new StringField('czas', true),
                    new StringField('opis', true)
                )
            );
            $lookupDataset->setOrderByField('czas', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'insert_id_umowa_czas_search', 'id', 'czas', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`kontakty`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('imie', true),
                    new StringField('nazwisko', true),
                    new StringField('email', true),
                    new StringField('telefon', true),
                    new StringField('inne', true)
                )
            );
            $lookupDataset->setOrderByField('imie', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_id_kontakt_imie_search', 'id', 'imie', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`uzytkownicy`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('email', true),
                    new StringField('haslo', true),
                    new StringField('imie', true),
                    new IntegerField('nazwisko', true),
                    new StringField('data_dodania', true),
                    new IntegerField('aktywny', true),
                    new IntegerField('uprawnienia', true)
                )
            );
            $lookupDataset->setOrderByField('email', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_id_uzytkownik_email_search', 'id', 'email', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`umowy`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new BlobField('fotografia', true),
                    new StringField('czas', true),
                    new StringField('opis', true)
                )
            );
            $lookupDataset->setOrderByField('czas', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'filter_builder_id_umowa_czas_search', 'id', 'czas', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for imie field
            //
            $column = new TextViewColumn('id_kontakt', 'id_kontakt_imie', 'Id Kontakt', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.umowa_uzytkownik_kontakt_id_kontakt_imie_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('id_uzytkownik', 'id_uzytkownik_email', 'Id Uzytkownik', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.umowa_uzytkownik_kontakt_id_uzytkownik_email_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for czas field
            //
            $column = new TextViewColumn('id_umowa', 'id_umowa_czas', 'Id Umowa', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'DetailGridkontakty.umowa_uzytkownik_kontakt_id_umowa_czas_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`kontakty`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('imie', true),
                    new StringField('nazwisko', true),
                    new StringField('email', true),
                    new StringField('telefon', true),
                    new StringField('inne', true)
                )
            );
            $lookupDataset->setOrderByField('imie', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_id_kontakt_imie_search', 'id', 'imie', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`uzytkownicy`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('email', true),
                    new StringField('haslo', true),
                    new StringField('imie', true),
                    new IntegerField('nazwisko', true),
                    new StringField('data_dodania', true),
                    new IntegerField('aktywny', true),
                    new IntegerField('uprawnienia', true)
                )
            );
            $lookupDataset->setOrderByField('email', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_id_uzytkownik_email_search', 'id', 'email', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`umowy`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new BlobField('fotografia', true),
                    new StringField('czas', true),
                    new StringField('opis', true)
                )
            );
            $lookupDataset->setOrderByField('czas', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'edit_id_umowa_czas_search', 'id', 'czas', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`kontakty`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('imie', true),
                    new StringField('nazwisko', true),
                    new StringField('email', true),
                    new StringField('telefon', true),
                    new StringField('inne', true)
                )
            );
            $lookupDataset->setOrderByField('imie', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_id_kontakt_imie_search', 'id', 'imie', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`uzytkownicy`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('email', true),
                    new StringField('haslo', true),
                    new StringField('imie', true),
                    new IntegerField('nazwisko', true),
                    new StringField('data_dodania', true),
                    new IntegerField('aktywny', true),
                    new IntegerField('uprawnienia', true)
                )
            );
            $lookupDataset->setOrderByField('email', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_id_uzytkownik_email_search', 'id', 'email', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`umowy`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new BlobField('fotografia', true),
                    new StringField('czas', true),
                    new StringField('opis', true)
                )
            );
            $lookupDataset->setOrderByField('czas', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, $this, 'multi_edit_id_umowa_czas_search', 'id', 'czas', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        public function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomPagePermissions(Page $page, PermissionSet &$permissions, &$handled)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
    }
    
    // OnBeforePageExecute event handler
    
    
    
    class kontaktyPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`kontakty`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id', true, true, true),
                    new StringField('imie', true),
                    new StringField('nazwisko', true),
                    new StringField('email', true),
                    new StringField('telefon', true),
                    new StringField('inne', true)
                )
            );
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'id', 'id', 'Id'),
                new FilterColumn($this->dataset, 'imie', 'imie', 'Imie'),
                new FilterColumn($this->dataset, 'nazwisko', 'nazwisko', 'Nazwisko'),
                new FilterColumn($this->dataset, 'email', 'email', 'Email'),
                new FilterColumn($this->dataset, 'telefon', 'telefon', 'Telefon'),
                new FilterColumn($this->dataset, 'inne', 'inne', 'Inne')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id'])
                ->addColumn($columns['imie'])
                ->addColumn($columns['nazwisko'])
                ->addColumn($columns['email'])
                ->addColumn($columns['telefon'])
                ->addColumn($columns['inne']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_edit');
            
            $filterBuilder->addColumn(
                $columns['id'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('imie');
            
            $filterBuilder->addColumn(
                $columns['imie'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('nazwisko');
            
            $filterBuilder->addColumn(
                $columns['nazwisko'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('email');
            
            $filterBuilder->addColumn(
                $columns['email'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('telefon');
            
            $filterBuilder->addColumn(
                $columns['telefon'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('inne');
            
            $filterBuilder->addColumn(
                $columns['inne'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Edit'), OPERATION_EDIT, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->GetSecurityInfo()->HasDeleteGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Delete'), OPERATION_DELETE, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
                $operation->SetAdditionalAttribute('data-modal-operation', 'delete');
                $operation->SetAdditionalAttribute('data-delete-handler-name', $this->GetModalGridDeleteHandler());
            }
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            if (GetCurrentUserPermissionSetForDataSource('kontakty.dzialanie_uzytkownik_kontakt')->HasViewGrant() && $withDetails)
            {
            //
            // View column for kontakty_dzialanie_uzytkownik_kontakt detail
            //
            $column = new DetailColumn(array('id'), 'kontakty.dzialanie_uzytkownik_kontakt', 'kontakty_dzialanie_uzytkownik_kontakt_handler', $this->dataset, 'Dzialanie Uzytkownik Kontakt');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            if (GetCurrentUserPermissionSetForDataSource('kontakty.kontakt_firma')->HasViewGrant() && $withDetails)
            {
            //
            // View column for kontakty_kontakt_firma detail
            //
            $column = new DetailColumn(array('id'), 'kontakty.kontakt_firma', 'kontakty_kontakt_firma_handler', $this->dataset, 'Kontakt Firma');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            if (GetCurrentUserPermissionSetForDataSource('kontakty.umowa_uzytkownik_kontakt')->HasViewGrant() && $withDetails)
            {
            //
            // View column for kontakty_umowa_uzytkownik_kontakt detail
            //
            $column = new DetailColumn(array('id'), 'kontakty.umowa_uzytkownik_kontakt', 'kontakty_umowa_uzytkownik_kontakt_handler', $this->dataset, 'Umowa Uzytkownik Kontakt');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for imie field
            //
            $column = new TextViewColumn('imie', 'imie', 'Imie', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('kontaktyGrid_imie_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for nazwisko field
            //
            $column = new TextViewColumn('nazwisko', 'nazwisko', 'Nazwisko', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('kontaktyGrid_nazwisko_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('email', 'email', 'Email', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('kontaktyGrid_email_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for telefon field
            //
            $column = new TextViewColumn('telefon', 'telefon', 'Telefon', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('kontaktyGrid_telefon_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
            
            //
            // View column for inne field
            //
            $column = new TextViewColumn('inne', 'inne', 'Inne', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('kontaktyGrid_inne_handler_list');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $column->SetDescription('');
            $column->SetFixedWidth(null);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for imie field
            //
            $column = new TextViewColumn('imie', 'imie', 'Imie', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('kontaktyGrid_imie_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nazwisko field
            //
            $column = new TextViewColumn('nazwisko', 'nazwisko', 'Nazwisko', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('kontaktyGrid_nazwisko_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('email', 'email', 'Email', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('kontaktyGrid_email_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for telefon field
            //
            $column = new TextViewColumn('telefon', 'telefon', 'Telefon', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('kontaktyGrid_telefon_handler_view');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for inne field
            //
            $column = new TextViewColumn('inne', 'inne', 'Inne', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('kontaktyGrid_inne_handler_view');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for imie field
            //
            $editor = new TextAreaEdit('imie_edit', 50, 8);
            $editColumn = new CustomEditColumn('Imie', 'imie', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for nazwisko field
            //
            $editor = new TextAreaEdit('nazwisko_edit', 50, 8);
            $editColumn = new CustomEditColumn('Nazwisko', 'nazwisko', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for email field
            //
            $editor = new TextAreaEdit('email_edit', 50, 8);
            $editColumn = new CustomEditColumn('Email', 'email', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for telefon field
            //
            $editor = new TextAreaEdit('telefon_edit', 50, 8);
            $editColumn = new CustomEditColumn('Telefon', 'telefon', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for inne field
            //
            $editor = new TextAreaEdit('inne_edit', 50, 8);
            $editColumn = new CustomEditColumn('Inne', 'inne', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for imie field
            //
            $editor = new TextAreaEdit('imie_edit', 50, 8);
            $editColumn = new CustomEditColumn('Imie', 'imie', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for nazwisko field
            //
            $editor = new TextAreaEdit('nazwisko_edit', 50, 8);
            $editColumn = new CustomEditColumn('Nazwisko', 'nazwisko', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for email field
            //
            $editor = new TextAreaEdit('email_edit', 50, 8);
            $editColumn = new CustomEditColumn('Email', 'email', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for telefon field
            //
            $editor = new TextAreaEdit('telefon_edit', 50, 8);
            $editColumn = new CustomEditColumn('Telefon', 'telefon', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for inne field
            //
            $editor = new TextAreaEdit('inne_edit', 50, 8);
            $editColumn = new CustomEditColumn('Inne', 'inne', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for imie field
            //
            $editor = new TextAreaEdit('imie_edit', 50, 8);
            $editColumn = new CustomEditColumn('Imie', 'imie', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for nazwisko field
            //
            $editor = new TextAreaEdit('nazwisko_edit', 50, 8);
            $editColumn = new CustomEditColumn('Nazwisko', 'nazwisko', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for email field
            //
            $editor = new TextAreaEdit('email_edit', 50, 8);
            $editColumn = new CustomEditColumn('Email', 'email', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for telefon field
            //
            $editor = new TextAreaEdit('telefon_edit', 50, 8);
            $editColumn = new CustomEditColumn('Telefon', 'telefon', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for inne field
            //
            $editor = new TextAreaEdit('inne_edit', 50, 8);
            $editColumn = new CustomEditColumn('Inne', 'inne', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for imie field
            //
            $column = new TextViewColumn('imie', 'imie', 'Imie', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('kontaktyGrid_imie_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for nazwisko field
            //
            $column = new TextViewColumn('nazwisko', 'nazwisko', 'Nazwisko', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('kontaktyGrid_nazwisko_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('email', 'email', 'Email', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('kontaktyGrid_email_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for telefon field
            //
            $column = new TextViewColumn('telefon', 'telefon', 'Telefon', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('kontaktyGrid_telefon_handler_print');
            $grid->AddPrintColumn($column);
            
            //
            // View column for inne field
            //
            $column = new TextViewColumn('inne', 'inne', 'Inne', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('kontaktyGrid_inne_handler_print');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for id field
            //
            $column = new NumberViewColumn('id', 'id', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for imie field
            //
            $column = new TextViewColumn('imie', 'imie', 'Imie', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('kontaktyGrid_imie_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for nazwisko field
            //
            $column = new TextViewColumn('nazwisko', 'nazwisko', 'Nazwisko', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('kontaktyGrid_nazwisko_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('email', 'email', 'Email', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('kontaktyGrid_email_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for telefon field
            //
            $column = new TextViewColumn('telefon', 'telefon', 'Telefon', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('kontaktyGrid_telefon_handler_export');
            $grid->AddExportColumn($column);
            
            //
            // View column for inne field
            //
            $column = new TextViewColumn('inne', 'inne', 'Inne', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('kontaktyGrid_inne_handler_export');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for imie field
            //
            $column = new TextViewColumn('imie', 'imie', 'Imie', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('kontaktyGrid_imie_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for nazwisko field
            //
            $column = new TextViewColumn('nazwisko', 'nazwisko', 'Nazwisko', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('kontaktyGrid_nazwisko_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('email', 'email', 'Email', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('kontaktyGrid_email_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for telefon field
            //
            $column = new TextViewColumn('telefon', 'telefon', 'Telefon', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('kontaktyGrid_telefon_handler_compare');
            $grid->AddCompareColumn($column);
            
            //
            // View column for inne field
            //
            $column = new TextViewColumn('inne', 'inne', 'Inne', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->SetFullTextWindowHandlerName('kontaktyGrid_inne_handler_compare');
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function CreateMasterDetailRecordGrid()
        {
            $result = new Grid($this, $this->dataset);
            
            $this->AddFieldColumns($result, false);
            $this->AddPrintColumns($result);
            
            $result->SetAllowDeleteSelected(false);
            $result->SetShowUpdateLink(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(false);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $this->setupGridColumnGroup($result);
            $this->attachGridEventHandlers($result);
            
            return $result;
        }
        
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        protected function GetEnableModalGridDelete() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && true);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $detailPage = new kontakty_dzialanie_uzytkownik_kontaktPage('kontakty_dzialanie_uzytkownik_kontakt', $this, array('id_kontakt'), array('id'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionSetForDataSource('kontakty.dzialanie_uzytkownik_kontakt'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('kontakty.dzialanie_uzytkownik_kontakt'));
            $detailPage->SetTitle('Dzialanie Uzytkownik Kontakt');
            $detailPage->SetMenuLabel('Dzialanie Uzytkownik Kontakt');
            $detailPage->SetHeader(GetPagesHeader());
            $detailPage->SetFooter(GetPagesFooter());
            $detailPage->SetHttpHandlerName('kontakty_dzialanie_uzytkownik_kontakt_handler');
            $handler = new PageHTTPHandler('kontakty_dzialanie_uzytkownik_kontakt_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $detailPage = new kontakty_kontakt_firmaPage('kontakty_kontakt_firma', $this, array('id_kontakt'), array('id'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionSetForDataSource('kontakty.kontakt_firma'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('kontakty.kontakt_firma'));
            $detailPage->SetTitle('Kontakt Firma');
            $detailPage->SetMenuLabel('Kontakt Firma');
            $detailPage->SetHeader(GetPagesHeader());
            $detailPage->SetFooter(GetPagesFooter());
            $detailPage->SetHttpHandlerName('kontakty_kontakt_firma_handler');
            $handler = new PageHTTPHandler('kontakty_kontakt_firma_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $detailPage = new kontakty_umowa_uzytkownik_kontaktPage('kontakty_umowa_uzytkownik_kontakt', $this, array('id_kontakt'), array('id'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionSetForDataSource('kontakty.umowa_uzytkownik_kontakt'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('kontakty.umowa_uzytkownik_kontakt'));
            $detailPage->SetTitle('Umowa Uzytkownik Kontakt');
            $detailPage->SetMenuLabel('Umowa Uzytkownik Kontakt');
            $detailPage->SetHeader(GetPagesHeader());
            $detailPage->SetFooter(GetPagesFooter());
            $detailPage->SetHttpHandlerName('kontakty_umowa_uzytkownik_kontakt_handler');
            $handler = new PageHTTPHandler('kontakty_umowa_uzytkownik_kontakt_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for imie field
            //
            $column = new TextViewColumn('imie', 'imie', 'Imie', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'kontaktyGrid_imie_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for nazwisko field
            //
            $column = new TextViewColumn('nazwisko', 'nazwisko', 'Nazwisko', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'kontaktyGrid_nazwisko_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('email', 'email', 'Email', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'kontaktyGrid_email_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for telefon field
            //
            $column = new TextViewColumn('telefon', 'telefon', 'Telefon', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'kontaktyGrid_telefon_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for inne field
            //
            $column = new TextViewColumn('inne', 'inne', 'Inne', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'kontaktyGrid_inne_handler_list', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for imie field
            //
            $column = new TextViewColumn('imie', 'imie', 'Imie', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'kontaktyGrid_imie_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for nazwisko field
            //
            $column = new TextViewColumn('nazwisko', 'nazwisko', 'Nazwisko', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'kontaktyGrid_nazwisko_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('email', 'email', 'Email', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'kontaktyGrid_email_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for telefon field
            //
            $column = new TextViewColumn('telefon', 'telefon', 'Telefon', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'kontaktyGrid_telefon_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for inne field
            //
            $column = new TextViewColumn('inne', 'inne', 'Inne', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'kontaktyGrid_inne_handler_print', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for imie field
            //
            $column = new TextViewColumn('imie', 'imie', 'Imie', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'kontaktyGrid_imie_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for nazwisko field
            //
            $column = new TextViewColumn('nazwisko', 'nazwisko', 'Nazwisko', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'kontaktyGrid_nazwisko_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('email', 'email', 'Email', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'kontaktyGrid_email_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for telefon field
            //
            $column = new TextViewColumn('telefon', 'telefon', 'Telefon', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'kontaktyGrid_telefon_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for inne field
            //
            $column = new TextViewColumn('inne', 'inne', 'Inne', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'kontaktyGrid_inne_handler_compare', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for imie field
            //
            $column = new TextViewColumn('imie', 'imie', 'Imie', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'kontaktyGrid_imie_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for nazwisko field
            //
            $column = new TextViewColumn('nazwisko', 'nazwisko', 'Nazwisko', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'kontaktyGrid_nazwisko_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for email field
            //
            $column = new TextViewColumn('email', 'email', 'Email', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'kontaktyGrid_email_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for telefon field
            //
            $column = new TextViewColumn('telefon', 'telefon', 'Telefon', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'kontaktyGrid_telefon_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
            
            //
            // View column for inne field
            //
            $column = new TextViewColumn('inne', 'inne', 'Inne', $this->dataset);
            $column->SetOrderable(true);
            $handler = new ShowTextBlobHandler($this->dataset, $this, 'kontaktyGrid_inne_handler_view', $column);
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        public function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomPagePermissions(Page $page, PermissionSet &$permissions, &$handled)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
    }



    try
    {
        $Page = new kontaktyPage("kontakty", "kontakty.php", GetCurrentUserPermissionSetForDataSource("kontakty"), 'UTF-8');
        $Page->SetTitle('Kontakty');
        $Page->SetMenuLabel('Kontakty');
        $Page->SetHeader(GetPagesHeader());
        $Page->SetFooter(GetPagesFooter());
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("kontakty"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	

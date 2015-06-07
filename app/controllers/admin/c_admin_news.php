<?php

class controller_admin_news extends admin_controller
{
  public function __construct($registry)
  {
    parent::__construct($registry);
    $this->select_menu('news');
  }

  function index()
  {
     $this->redirect("admin_news", "manage");
  }

  function add()
  {
    if (isset($_POST['cancel']))
      $this->redirect("admin_news", "manage");

    $form_checker = new checker;
    if (isset($_POST['save']) && $form_checker->check_security_token())
    {
      $news_item = new news_item();

      $news_item->language_id = (int)$form_checker->post('language_id');
      $news_item->title = $form_checker->post('title');
      $news_item->slug = $form_checker->post('slug');
      $news_item->body = $form_checker->post('body');
      $news_item->description = $form_checker->post('description');
      $news_item->preview_image = $form_checker->post('preview_image');
      
      $form_checker->save_entity($news_item);
      if ($form_checker->is_entity_saved())
      {
        $news_item->set_categories($form_checker->post('categories'));
        $this->redirect("admin_news", "manage");        
      }
    }

    $this->ta('news_categories', $this->news_categories->get_all());
    $this->ta('form_checker', $form_checker);
  }

  function edit()
  {
    $item_id = (int)$this->gp(0,0);

    if (isset($_POST['cancel']) || !$item_id || !($news_item = $this->news_items->get_by_id($item_id)))
      $this->redirect("admin_news", "manage");

    $form_checker = new checker;
    if (isset($_POST['save']) && $form_checker->check_security_token())
    {
      $news_item->language_id = (int)$form_checker->post('language_id');
      $news_item->title = $form_checker->post('title');
      $news_item->slug = $form_checker->post('slug');
      $news_item->body = $form_checker->post('body');
      $news_item->description = $form_checker->post('description');
      $news_item->preview_image = $form_checker->post('preview_image');
      
      $form_checker->save_entity($news_item);
      if ($form_checker->is_entity_saved())
      {
        $news_item->set_categories($form_checker->post('categories'));
        $this->redirect("admin_news", "manage");        
      }
    }

    $this->ta('item', $news_item);
    $this->ta('news_categories', $this->news_categories->get_all());
    $this->ta('form_checker', $form_checker);
  }

  function manage()
  {
    $languages = $this->i18n_languages->get_all();
    $is_multilingual = false; if (count($languages) > 1) $is_multilingual = true;

    $this->ta('is_multilingual', $is_multilingual);

    $search = $this->table_helper->proccess_search_parameters("admin_news_items_");
    $order = $this->table_helper->proccess_order_parameters("admin_news_items_");

    if (isset($_POST['delete']))
    {
      $item_id = false; if (isset($_POST['item_id'])) $item_id = (int)$_POST['item_id'];
      $news_item = $this->news_items->get_by_id($item_id);
      if ($news_item)
      {
        $news_item->delete();
      }
    }

    if (!empty($_POST))
     $this->refresh();

    $search_fields = array("title", "body", "slug", "description");
    $joins = array(array('table'=>'i18n_languages', 'field'=>'language_id'));

    $pagination = $this->table_helper->proccess_paging_parameters($this->table_helper->get_count("news_items", $search, $search_fields, $joins), 20);

    $this->ta("pages", $pagination);
    $items = $this->table_helper->get_items("news_items", $order, $pagination['cur_offset'], 20, $search, $search_fields, $joins);

    $this->ta("order", $order);
    $this->ta("search", $search);
    $this->ta("items", $items);
  }

  function categorytranslations()
  {
    $item_id = (int)$this->gp(0,0);
    $news_category = $this->news_categories->get_by_id($item_id);

    if (!$news_category)
      $this->redirect("admin_news", "categories");
    
    $i18n_string = $this->i18n_strings->get_by_string($news_category->name);
    if ($i18n_string)
    {
      $this->redirect('admin_i18n', 'editstring', false, $i18n_string->id);
    } else
      $this->redirect("admin_news", "categories");    
  }

  function categories()
  {
    $search = $this->table_helper->proccess_search_parameters("admin_news_categories_");
    $order = $this->table_helper->proccess_order_parameters("admin_news_categories_");

    if (isset($_POST['delete']))
    {
      $item_id = false; if (isset($_POST['item_id'])) $item_id = (int)$_POST['item_id'];
      $news_category = $this->news_categories->get_by_id($item_id);
      if ($news_category)
      {
        $news_category->delete();
      }
    }

    if (!empty($_POST))
     $this->refresh();

    $search_fields = array("name");
    $joins = array();

    $pagination = $this->table_helper->proccess_paging_parameters($this->table_helper->get_count("news_categories", $search, $search_fields, $joins), 20);

    $this->ta("pages", $pagination);
    $items = $this->table_helper->get_items("news_categories", $order, $pagination['cur_offset'], 20, $search, $search_fields);

    $this->ta("order", $order);
    $this->ta("search", $search);
    $this->ta("items", $items);
  }

  function addcategory()
  {
    if (isset($_POST['cancel']))
      $this->redirect("admin_news", "categories");  

    $form_checker = new checker;
    if (isset($_POST['save']) && $form_checker->check_security_token())
    {
      $news_category = new news_category();
      $news_category->name = $form_checker->post('name');

      $form_checker->save_entity($news_category);
      if ($form_checker->is_entity_saved())
      {
        $this->redirect("admin_news", "categories");        
      }
    }

    $this->ta("form_checker", $form_checker);
  }

  function editcategory()
  {
    $item_id = (int)$this->gp(0,0);

    if (isset($_POST['cancel']) || !$item_id || !($news_category = $this->news_categories->get_by_id($item_id)))
      $this->redirect("admin_news", "categories");

    $form_checker = new checker;
    if (isset($_POST['save']) && $form_checker->check_security_token())
    {
      $news_category->name = $form_checker->post('name');

      $form_checker->save_entity($news_category);
      if ($form_checker->is_entity_saved())
      {
        $this->redirect("admin_news", "categories");        
      }
    }

    $this->ta('item', $news_category);
    $this->ta("form_checker", $form_checker);
  }


}
<?php

class controller_admin_static extends admin_controller
{
  public function __construct($registry)
  {
    parent::__construct($registry);
    $this->select_menu('pages');
  }
  
  function index()
  {
     $this->redirect("admin_static", "manage");
  }

  function add()
  {
    if (isset($_POST['cancel']))
      $this->redirect("admin_static", "manage");

    $form_checker = new checker;
    if (isset($_POST['save']) && $form_checker->check_security_token())
    {
      $static_page = new static_page();

      $static_page->language_id = (int)$form_checker->post('language_id');
      $static_page->title = $form_checker->post('title');
      $static_page->slug = $form_checker->post('slug');
      $static_page->body = $form_checker->post('body');
      
      $form_checker->save_entity($static_page);
      if ($form_checker->is_entity_saved())
      {
        $this->redirect("admin_static", "manage");        
      }
    }

    $this->ta('form_checker', $form_checker);
  }

  function edit()
  {
    $item_id = (int)$this->gp(0,0);

    if (isset($_POST['cancel']) || !$item_id || !($static_page = $this->static_pages->get_by_id($item_id)))
      $this->redirect("admin_static", "manage");

    $form_checker = new checker;
    if (isset($_POST['save']) && $form_checker->check_security_token())
    {
      $static_page->language_id = (int)$form_checker->post('language_id');
      $static_page->title = $form_checker->post('title');
      $static_page->slug = $form_checker->post('slug');
      $static_page->body = $form_checker->post('body');
      
      $form_checker->save_entity($static_page);
      if ($form_checker->is_entity_saved())
      {
        $this->redirect("admin_static", "manage");        
      }
    }

    $this->ta('item', $static_page);
    $this->ta('form_checker', $form_checker);   
  }

  function manage()
  {
    $search = $this->table_helper->proccess_search_parameters("admin_static_pages_");
    $order = $this->table_helper->proccess_order_parameters("admin_static_pages_");

    if (isset($_POST['delete']))
    {
      $item_id = false; if (isset($_POST['item_id'])) $item_id = (int)$_POST['item_id'];
      $page = $this->static_pages->get_by_id($item_id);
      if ($page)
      {
        $page->delete();
      }
    }

    if (!empty($_POST))
     $this->refresh();

    $search_fields = array("title", "body", "slug");
    $joins = array(array('table'=>'i18n_languages', 'field'=>'language_id'));

    $pagination = $this->table_helper->proccess_paging_parameters($this->table_helper->get_count("static_pages", $search, $search_fields, $joins), 20);

    $this->ta("pages", $pagination);
    $items = $this->table_helper->get_items("static_pages", $order, $pagination['cur_offset'], 20, $search, $search_fields, $joins);

    $this->ta("order", $order);
    $this->ta("search", $search);
    $this->ta("items", $items);
  }


}